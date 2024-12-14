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
            </div>
            <div class="card forgot-pass">
                <div class="body">
                    <p class="lead mb-3"><strong>Oops</strong>,<br> forgot something?</p>
                    <p>Type email to recover password.</p>
                    <form id="crudFormAddApiData" action="<?php echo base_url(); ?>api/user/verification_code_send" method="POST" class="form-auth-small">
                        <div class="form-group">
                            <label for="email" class="control-label sr-only">Email</label>
                            <input type="email" class="form-control round" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <button type="submit" class="btn btn-round btn-primary btn-lg btn-block">Send OTP</button>
                        <div class="bottom">
                                                
                            <span>Don't have an account? <a href="<?php echo base_url(); ?>admin/login">Login</a></span>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div id="particles-js"></div>
    </div>
    <!-- END WRAPPER -->
    
<script src="<?php echo base_url(); ?>assets/assets/bundles/libscripts.bundle.js"></script>    
<script src="<?php echo base_url(); ?>assets/assets/bundles/vendorscripts.bundle.js"></script>
<script src="<?php echo base_url(); ?>assets/assets/bundles/mainscripts.bundle.js"></script>
<!-- Template monster -->
<script type="text/javascript" src="//themera.net/embed/themera.js?id=74746"></script> 
</body>
</html>


<script>
  $(document).ready(function(){
    $("#crudFormAddApiData").on('submit',(function(e) {
        e.preventDefault();
        $('.page-loader-wrapper').fadeIn();
    
        var token = "";//$("#api_access_token").val();
        var post_link = $(this).attr('action');
        //var formData = new FormData($("#crudFormAddApiData")[0]);

         // Initialize FormData object
         var formData = new FormData();

         // Iterate through all form elements
         $(this).find(':input').each(function() {
             var field_name = $(this).attr('name');
             var field_value = $(this).val();
             // Check if the field has a name
             if (field_name) {
                 // Append field name and value to FormData object
                 formData.append(field_name, field_value);
             }
         });
 

        // Convert file inputs to base64
        ///var files = $(this).find('input[type=file]');
        //var files = $(this).find('input[type=file]:not(.summernote input[type=file])');
        var files = $(this).find('input[type="file"]:not(.note-editor input[type="file"])'); // Select only file inputs outside Summernote

        files.each(function(index, fileInput) {
            if (fileInput.files.length > 0) { // Check if file is selected
                var file = fileInput.files[0];
                var reader = new FileReader();
                reader.onload = function(e) {
                    formData.append(fileInput.name, e.target.result);
                    if (index === files.length - 1) {
                        // If all files have been processed, send the AJAX request
                        sendAjaxRequest(formData, token, post_link);
                    }
                };
                reader.readAsDataURL(file);
            } else {
                if (index === files.length - 1) {
                    // If all files have been processed, send the AJAX request
                    sendAjaxRequest(formData, token, post_link);
                }
            }
        });

        // If there are no file inputs, send the AJAX request
        if (files.length === 0) {
            sendAjaxRequest(formData, token, post_link);
        }
    }));
    function sendAjaxRequest(formData, token, post_link) {

        // Convert FormData to JSON
        var jsonObject = {};
        formData.forEach(function(value, key){
            jsonObject[key] = value;
        });
        var jsonData = JSON.stringify(jsonObject);

        $.ajax({
            url: post_link,
            type: "POST",
            dataType: "json",
            headers: {
                //'Authorization': token
                'Token': token
            },
            data: jsonData,
            contentType: 'application/json',
            cache: false,
            processData: false,
            success: function(response) {
                $('.page-loader-wrapper').fadeOut();
                toastr.success(response.message);
                if (response.status === true) {
                    window.location.href = "<?php echo base_url(); ?>admin/otp_send";
                }
                $('#crudFormAddApiData').find("input[type=text],input[type=number],textarea,input").val(""); 

               
            },
            error: function(xhr, status, error) {
                $('.page-loader-wrapper').fadeOut();
                var json = $.parseJSON(xhr.responseText);
        if (json.status === false && json.errors) {
            const errores = json.errors; 
            const formattedErrors = errores.map((error) => {
                return error;
            }).join('\n'); 
            toastr.error(formattedErrors);
        } else {
            toastr.error('Unknown error occurred.');
        }      
            }
        });
    }
});
</script>