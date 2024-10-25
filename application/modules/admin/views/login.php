<!doctype html>
<html lang="en">

<head>
<!-- <title>< ?php echo BRAND_NAME;  ?></title> -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="Osam Bootstrap 4x admin is super flexible, powerful, clean &amp; modern responsive admin dashboard with unlimited possibilities.">
<meta name="author" content="GetBootstrap, design by: puffintheme.com">

<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- VENDOR CSS -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/vendor/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/vendor/animate-css/vivify.min.css">

<!-- MAIN CSS -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/css/site.min.css">


<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">
<!-- End layout styles -->
<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/favicon.png" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<style>
.logo_size {
height: 120px !important;
}

@media (max-width: 768px) {
.logo_size {
  height: 80px !important;
}
}
</style>

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
                <a class="navbar-brand" href="javascript:void(0);"><img src="<?php echo base_url(); ?>assets/assets/images/icon.svg" width="30" height="30" class="d-inline-block align-top mr-2" alt="">Osam</a>                                                
            </div>
            <div class="card">
                <div class="body">
                    <p class="lead">Login to your account</p>
                    <!-- <form id="loginForm" action="<?php echo base_url(); ?>api/v.1/login/post" class="form-auth-small m-t-20"> -->
                    <form id="loginForm" action="<?php echo base_url(); ?>login" class="form-auth-small m-t-20" method="POST">
                    
                        <div class="form-group">
                            <label for="signin-email" class="control-label sr-only">Email</label>
                            <input type="text" class="form-control round" id="signin-email" name="email" placeholder="Email">

                        </div>
                        <div class="form-group">
                            <label for="signin-password" class="control-label sr-only">Password</label>
                            <input type="password" class="form-control round" id="signin-password" name="password" placeholder="Password">
                        </div>
                        <div class="form-group clearfix">
                            <label class="fancy-checkbox element-left">
                                <input type="checkbox">
                                <span>Remember me</span>
                            </label>								
                        </div>
                        <button type="submit" class="btn btn-primary btn-round btn-block">LOGIN</button>
                       
                        <div class="bottom">
                            <span class="helper-text m-b-10"><i class="fa fa-lock"></i> <a href="page-forgot-password.html">Forgot password?</a></span>
                            <span>Don't have an account? <a href="page-register.html">Register</a></span>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</body>
</html>
<script>

$("#loginForm").on('submit',(function(e) {
 	$(".loading").show();
	var post_link = $(this).attr('action');
	var formData = new FormData($("#loginForm")[0]);
    // Convert FormData to JSON
    var jsonObject = {};
    formData.forEach(function(value, key){
        jsonObject[key] = value;
    });
    var jsonData = JSON.stringify(jsonObject);
   
	e.preventDefault();
	$.ajax({
        url: post_link,
        type: "POST",
        dataType: "json",
		data:jsonData,
		contentType: 'application/json',
		cache: false,
		processData:false,
        success: function(response) {
			$(".loading").hide();
			toastr.success(response.message);
			$('#loginForm').find("input[type=text],input[type=number],textarea,input").val(""); 
           window.location.href = "<?php echo base_url(); ?>admin/index"
        },
        error: function(xhr, status, error) {
			$(".loading").hide();
            // Handle errors
			var json = $.parseJSON(xhr.responseText);
			
			if(json.errors){
				if(json.errors.length>1){
					// Assuming json.errors is an array of error messages
					var formattedErrors = json.errors.map(function(error) {
						// Set your desired line length, for example, 80 characters
						var lineLength = 100;

						// Use a regex to insert newlines at your specified line length
						var regex = new RegExp('.{1,' + lineLength + '}', 'g');
						var formattedError = error.replace(regex, function(match) {
							return match + '\n';
						});

						return formattedError;
					});

					// Join the formatted errors into a single string with newlines
					var errorsString = formattedErrors.join('.\n');

					// Now, errorsString contains the formatted error messages with newlines and increased line length
					//console.log(errorsString);
					toastr.error(errorsString);
				}else{
					toastr.error(json.errors);
				}
			}else{
				toastr.error(json.message);
			}
			
			//console.log(xhr);
        }
    });
}));


</script>