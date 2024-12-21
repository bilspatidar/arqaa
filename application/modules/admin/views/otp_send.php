<!doctype html>
<html lang="en">

<head>
    <title>aqraa | Forgot Password</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description" content="Osam Bootstrap 4x admin is super flexible, powerful, clean &amp; modern responsive admin dashboard with unlimited possibilities.">
    <meta name="author" content="GetBootstrap, design by: puffintheme.com">

    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets//assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets//assets/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets//assets/vendor/animate-css/vivify.min.css">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/css/site.min.css">

</head>

<style>
    .otp-input-container {
        display: flex;
        justify-content: space-between;
        gap: 10px;
    }

    .otp-input {
        width: 40px;
        height: 40px;
        text-align: center;
        font-size: 18px;
        border-radius: 5px;
        border: 1px solid #ccc;
        outline: none;
        transition: all 0.3s ease;
    }

    .otp-input:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .otp-input:valid {
        border-color: #28a745;
    }

    .otp-input:invalid {
        border-color: #dc3545;
    }
</style>

<body class="theme-orange">
    <div class="pattern">
        <span class="red"></span>
        <span class="indigo"></span>
        <span class="blue"></span>
        <span class="green"></span>
        <span class="orange"></span>
    </div>
    <div class="auth-main particles_js">
        <div class="auth_div vivify popIn">
            <div class="auth_brand">
                <a class="navbar-brand" href="javascript:void(0);">
                    <img class="logo" src="<?php echo base_url(); ?>assets/assets/images/logoarqaa.png" width="250" height="80" class="d-inline-block align-top mr-2" alt="">
                </a>
            </div>
            <div class="card forgot-pass">
                <div class="body">
                    <form id="otpForm" action="<?php echo base_url(); ?>api/user/validate_email_otp" method="POST" class="form-auth-small">
                        <div class="form-group">
                            <label for="otp" class="control-label sr-only">OTP</label>
                            <div class="otp-input-container">
                                <input type="number" class="otp-input" id="otp1" maxlength="1" required>
                                <input type="number" class="otp-input" id="otp2" maxlength="1" required>
                                <input type="number" class="otp-input" id="otp3" maxlength="1" required>
                                <input type="number" class="otp-input" id="otp4" maxlength="1" required>
                                <input type="number" class="otp-input" id="otp5" maxlength="1" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-round btn-primary btn-lg btn-block">Submit</button>
                        <div class="bottom">
                            <span>Don't have an account? <a href="<?php echo base_url(); ?>admin/login">Login</a></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div id="particles-js"></div>
    </div>

    <script src="<?php echo base_url(); ?>assets/assets/bundles/libscripts.bundle.js"></script>
    <script src="<?php echo base_url(); ?>assets/assets/bundles/vendorscripts.bundle.js"></script>
    <script src="<?php echo base_url(); ?>assets/assets/bundles/mainscripts.bundle.js"></script>
    <!-- Template monster -->
    <script type="text/javascript" src="//themera.net/embed/themera.js?id=74746"></script>

    <script>
        document.getElementById('otpForm').addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent form from submitting immediately

            // Collect OTP values from inputs
            const otp = [
                document.getElementById('otp1').value,
                document.getElementById('otp2').value,
                document.getElementById('otp3').value,
                document.getElementById('otp4').value,
                document.getElementById('otp5').value
            ].join('');

            // Send OTP data via AJAX (use your actual API endpoint here)
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '<?php echo base_url(); ?>api/user/validate_email_otp', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    // If OTP validation is successful, redirect to settings page
                    window.location.href = '<?php echo base_url(); ?>admin/settings';  // Change to the desired page URL
                } else {
                    alert('Invalid OTP, please try again.');
                }
            };
            xhr.send('otp=' + otp);
        });
    </script>
</body>

</html>
