<?php
//session_start();
if (!isset($_SESSION['user_details'])) {
    header("Location: " . base_url() . 'admin/login');
    exit();
}

// Check session expiry
if (isset($_SESSION['last_activity'])) {
    $current_time = time();
    $session_expiry_time = $_SESSION['last_activity'] + 7200; // Session expiry time (7200 sceonds = 2 hours)
    if ($current_time > $session_expiry_time) { // Check if current time exceeds session expiry time
        redirectToLogin();
    } else {
        $_SESSION['last_activity'] = $current_time;
    }
}

// Check CSRF token expiry
if (isset($_SESSION['csrf_token_time'])) {
    $current_time = time();
    $csrf_token_expiry_time = $_SESSION['csrf_token_time'] + 7200; // CSRF token expiry time (7200 seconds = 2 hours)
    if ($current_time > $csrf_token_expiry_time) { // Check if current time exceeds CSRF token expiry time
        redirectToLogin();
    }
}

$user_type = $_SESSION['user_details']['user_type'];
$users_id = $_SESSION['user_details']['id'];
$token = $_SESSION['user_details']['access_token'];

?>

<script>
    function redirectToLogin() {
        window.location.href = "<?php echo base_url() . 'admin/login'; ?>";
    }

    setTimeout(function() {
        redirectToLogin(); // Redirect to login page after 2 hours (session expiry time)
    }, 7200 * 1000);

    setTimeout(function() {
        redirectToLogin(); // Redirect to login page after 2 hours (CSRF token expiry time)
    }, 7200 * 1000);
</script>






<!doctype html>
<html lang="en">

<head>
<title><?php echo BRAND_NAME; ?></title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="Osam Bootstrap 4x admin is super flexible, powerful, clean &amp; modern responsive admin dashboard with unlimited possibilities.">
<meta name="keywords" content="admin template, Osam admin template, dashboard template, flat admin template, responsive admin template, web app, Light Dark version">
<meta name="author" content="GetBootstrap, design by: puffintheme.com">

<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- VENDOR CSS -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/vendor/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/vendor/animate-css/vivify.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/vendor/c3/c3.min.css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/vendor/chartist/css/chartist.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/vendor/toastr/toastr.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/vendor/jvectormap/jquery-jvectormap-2.0.3.css"/>

<!-- MAIN CSS -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/css/site.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/vendor/jquery-datatable/dataTables.bootstrap4.min.css">
<
  <!-- Menu link -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">

  <!-- Menu link -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/vendor/summernote/dist/summernote.css"/>
<style>

.select2-container .select2-selection--single {
    height: 36px !important;

}

  /* Select2 container background for single selection */
.select2-container--default .select2-selection--single {
  background-color: #22252a; /* Dark background color */
  color: #fd7e14; /* Text color */
  border-color: #555; /* Border color */
  
}

/* Select2 container background for multiple selection */
.select2-container--default .select2-selection--multiple {
  background-color: #22252a; /* Dark background color for multiple selection */
  color: #fd7e14; /* Text color */
}

/* Selected options background color in multiple selection */
.select2-container--default .select2-selection--multiple .select2-selection__choice {
  background-color: #22252a; /* Darker background for selected options */
  color: #fd7e14; /* Text color for selected options */
}

/* Select2 dropdown background */
.select2-container--default .select2-results__option {
  background-color: #22252a; /* Dark background color for options */
  color: #fd7e14; /* Text color for options */
}

/* Hover effect for options */
.select2-container--default .select2-results__option--highlighted {
  background-color: #444; /* Darker background on hover */
  color: #fd7e14; /* Text color on hover */
}



    .dataTables_info{
        color:#fff !important;
    }
    label {
        color:#fff !important;
   }

  .loading {
	display:none;
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    background: url('loader.gif') 50% 50% no-repeat rgb(249,249,249);

	background-size: 200px 300px;
    opacity: .8;
}

.note-editor.note-frame {
    border: 1px solid #282b2f !important;
    background: #f4f7f6;
}
    .note-editor.note-frame .note-statusbar {
    background-color: #282b2f!important;
    border-bottom-right-radius: 4px;
    border-bottom-left-radius: 4px;
}
.panel-heading{
    background-color: #282b2f!important;
}
.note-editor.note-frame .note-editing-area .note-editable {
    padding: 10px;
    overflow: auto;
    color: #FFA117 !important;
    background-color: #282b2f !important;
}

.note-editor.note-frame .note-editing-area .note-editable[contenteditable="false"] {
    background-color: #282b2f !important;
}
</style>

</head>
<body class="theme-orange">
<!-- <div class="loading"></div> -->
<input type="hidden" value="<?php echo $token; ?>" id="api_access_token">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img src="<?php echo base_url(); ?>assets/assets/images/icon.svg" width="40" height="40" alt="Osam"></div>
        <p>Please wait...</p>        
    </div>
</div>

<!-- Theme Setting -->
<!-- <div class="themesetting">
    <a href="javascript:void(0);" class="theme_btn"><i class="icon-magic-wand"></i></a>
    <ul class="choose-skin list-unstyled mb-0">
        <li data-theme="green"><div class="green"></div></li>
        <li data-theme="orange" class="active"><div class="orange"></div></li>
        <li data-theme="blush"><div class="blush"></div></li>
        <li data-theme="cyan"><div class="cyan"></div></li>
    </ul>
</div> -->

<!-- Overlay For Sidebars -->
<div class="overlay"></div>

<div id="wrapper">

    <nav class="navbar navbar-fixed-top">
        <div class="container-fluid">

            <div class="navbar-left">
                <div class="navbar-btn">
                    <a href="#"><img src="<?php echo base_url(); ?>assets/assets/images/icon.svg" alt="Osam Logo" class="img-fluid logo"></a>
                    <button type="button" class="btn-toggle-offcanvas"><i class="lnr lnr-menu fa fa-bars"></i></button>
                </div>
				
                <form id="navbar-search" class="navbar-form search-form">
                    <input value="" class="form-control" placeholder="Search here..." type="text">
                    <button type="button" class="btn btn-default"><i class="icon-magnifier"></i></button>
                </form>
            </div>
            
            <div class="navbar-right">
                <div id="navbar-menu">
                    <ul class="nav navbar-nav">
                        <li><a href="<?php echo base_url();?>admin/master/news" class="news icon-menu" title="News">News</a></li>

                          <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Language <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url('Internal/switch_lang/english'); ?>">English</a></li>
                                <li><a href="<?php echo base_url('Internal/switch_lang/spanish'); ?>">Spanish</a></li>
                            </ul>
                        </li>
                      
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle icon-menu" data-toggle="dropdown">
                                <i class="icon-bell"></i>
                                <span class="notification-dot bg-azura">4</span>
                            </a>
                            <ul class="dropdown-menu feeds_widget vivify fadeIn">
                                <li class="header blue">You have 4 New Notifications</li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="feeds-left bg-red"><i class="fa fa-check"></i></div>
                                        <div class="feeds-body">
                                            <h4 class="title text-danger">Issue Fixed <small class="float-right text-muted">9:10 AM</small></h4>
                                            <small>WE have fix all Design bug with Responsive</small>
                                        </div>
                                    </a>
                                </li>                               
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="feeds-left bg-info"><i class="fa fa-user"></i></div>
                                        <div class="feeds-body">
                                            <h4 class="title text-info">New User <small class="float-right text-muted">9:15 AM</small></h4>
                                            <small>I feel great! Thanks team</small>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="feeds-left bg-orange"><i class="fa fa-question-circle"></i></div>
                                        <div class="feeds-body">
                                            <h4 class="title text-warning">Server Warning <small class="float-right text-muted">9:17 AM</small></h4>
                                            <small>Your connection is not private</small>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">
                                        <div class="feeds-left bg-green"><i class="fa fa-thumbs-o-up"></i></div>
                                        <div class="feeds-body">
                                            <h4 class="title text-success">2 New Feedback <small class="float-right text-muted">9:22 AM</small></h4>
                                            <small>It will give a smart finishing to your site</small>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li><a href="javascript:void(0);" class="right_toggle icon-menu" title="Right Menu"><i class="icon-bubbles"></i></a></li>
                        <li><a href="<?php echo base_url();?>admin/admin/logout" class="icon-menu"><i class="icon-power"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- <div id="megamenu" class="megamenu particles_js">
        <a href="javascript:void(0);" class="megamenu_toggle btn btn-danger"><i class="icon-close"></i></a>
        <div class="container">            
            <div class="row clearfix">
                <div class="col-12">
                    <ul class="q_links">
                        <li><a href="app-inbox.html"><i class="icon-envelope"></i><span>Inbox</span></a></li>
                        <li><a href="app-chat.html"><i class="icon-bubbles"></i><span>Messenger</span></a></li>
                        <li><a href="app-calendar.html"><i class="icon-calendar"></i><span>Event</span></a></li>
                        <li><a href="page-profile.html"><i class="icon-user"></i><span>Profile</span></a></li>
                        <li><a href="page-invoices.html"><i class="icon-printer"></i><span>Invoice</span></a></li>
                        <li><a href="page-timeline.html"><i class="icon-list"></i><span>Timeline</span></a></li>
                    </ul>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="card w_card3">
                        <div class="body">
                            <div class="text-center"><i class="icon-picture text-info"></i>
                                <h4 class="m-t-25 mb-0">104 Picture</h4>
                                <p>Your gallery download complete</p>
                                <a href="javascript:void(0);" class="btn btn-info btn-round">Download now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="card w_card3">
                        <div class="body">
                            <div class="text-center"><i class="icon-diamond text-success"></i>
                                <h4 class="m-t-25 mb-0">813 Point</h4>
                                <p>You are doing great job!</p>
                                <a href="javascript:void(0);" class="btn btn-success btn-round">Read now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="card w_card3">
                        <div class="body">
                            <div class="text-center"><i class="icon-social-twitter text-primary"></i>
                                <h4 class="m-t-25 mb-0">3,756</h4>
                                <p>New Followers on Twitter</p>
                                <a href="javascript:void(0);" class="btn btn-primary btn-round">Find more</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <ul class="list-group">
                        <li class="list-group-item">
                            Anyone send me a message
                            <div class="float-right">
                                <label class="switch">
                                    <input type="checkbox" checked="">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            Anyone seeing my profile page
                            <div class="float-right">
                                <label class="switch">
                                    <input type="checkbox" checked="">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </li>
                        <li class="list-group-item">
                            Anyone posts a comment on my post
                            <div class="float-right">
                                <label class="switch">
                                    <input type="checkbox">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="particles-js"></div>
    </div> -->

    <div id="rightbar" class="rightbar">
        <div class="slim_scroll">
            <div class="chat_detail vivify fadeIn delay-100">
                <a href="javascript:void(0);" class="btn btn-sm btn-block btn-primary btn-round mb-4 back_btn" title=""><i class="icon-control-rewind mr-1"></i> Back</a>
                <ul class="chat-widget clearfix">
                    <li class="left float-left">
                        <div class="avtar-pic w35 bg-pink"><span>KG</span></div>
                        <div class="chat-info">       
                            <span class="message">Hello, John<br>What is the update on Project X?</span>
                        </div>
                    </li>
                    <li class="right">
                        <img src="<?php echo base_url(); ?>assets/assets/images/xs/avatar1.jpg" class="rounded" alt="">
                        <div class="chat-info">
                            <span class="message">Hi, Alizee<br> It is almost completed. I will send you an email later today.</span>
                        </div>
                    </li>
                    <li class="left float-left">
                        <div class="avtar-pic w35 bg-pink"><span>KG</span></div>
                        <div class="chat-info">
                            <span class="message">That's great. Will catch you in evening.</span>
                        </div>
                    </li>
                    <li class="right">
                        <img src="<?php echo base_url(); ?>assets/assets/images/xs/avatar1.jpg" class="rounded" alt="">
                        <div class="chat-info">
                            <span class="message">Sure we'will have a blast today.</span>
                        </div>
                    </li>
                </ul>
                <div class="input-group p-t-15">
                    <textarea type="text" rows="3" class="form-control" placeholder="Enter text here..."></textarea>
                </div>
            </div>
            <div class="chat_list">
                <form>
                    <div class="input-group m-b-20">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="icon-magnifier"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Search...">
                    </div>
                </form>
                <ul class="right_chat list-unstyled mb-0">
                    <li class="online">
                        <a href="javascript:void(0);">
                            <div class="media">
                                <div class="avtar-pic w35 bg-pink"><span>KG</span></div>
                                <div class="media-body">
                                    <span class="name">Louis Henry</span>
                                    <span class="message">Just now</span>
                                    <span class="badge badge-outline status"></span>
                                </div>
                            </div>
                        </a>                            
                    </li>
                    <li class="online">
                        <a href="javascript:void(0);">
                            <div class="media">
                                <img class="media-object " src="<?php echo base_url(); ?>assets/assets/images/xs/avatar5.jpg" alt="">
                                <div class="media-body">
                                    <span class="name">Debra Stewart</span>
                                    <span class="message">38min ago</span>
                                    <span class="badge badge-outline status"></span>
                                </div>
                            </div>
                        </a>                            
                    </li>
                    <li class="offline">
                        <a href="javascript:void(0);">
                            <div class="media">
                                <img class="media-object " src="<?php echo base_url(); ?>assets/assets/images/xs/avatar2.jpg" alt="">
                                <div class="media-body">
                                    <span class="name">Lisa Garett</span>
                                    <span class="message">2hr ago</span>
                                    <span class="badge badge-outline status"></span>
                                </div>
                            </div>
                        </a>                            
                    </li>
                    <li class="offline">
                        <a href="javascript:void(0);">
                            <div class="media">
                                <div class="avtar-pic w35 bg-indigo"><span>FC</span></div>
                                <div class="media-body">
                                    <span class="name">Folisise Chosielie</span>
                                    <span class="message">2hr ago</span>
                                    <span class="badge badge-outline status"></span>
                                </div>
                            </div>
                        </a>                            
                    </li>
                    <li class="online">
                        <a href="javascript:void(0);">
                            <div class="media">
                                <img class="media-object " src="<?php echo base_url(); ?>assets/assets/images/xs/avatar3.jpg" alt="">
                                <div class="media-body">
                                    <span class="name">Marshall Nichols</span>
                                    <span class="message">1day ago</span>
                                    <span class="badge badge-outline status"></span>
                                </div>
                            </div>
                        </a>                            
                    </li>
                    <li class="online">
                        <a href="javascript:void(0);">
                            <div class="media">
                                <img class="media-object " src="<?php echo base_url(); ?>assets/assets/images/xs/avatar5.jpg" alt="">
                                <div class="media-body">
                                    <span class="name">Debra Stewart</span>
                                    <span class="message">38min ago</span>
                                    <span class="badge badge-outline status"></span>
                                </div>
                            </div>
                        </a>                            
                    </li>
                    <li class="offline">
                        <a href="javascript:void(0);">
                            <div class="media">
                                <img class="media-object " src="<?php echo base_url(); ?>assets/assets/images/xs/avatar2.jpg" alt="">
                                <div class="media-body">
                                    <span class="name">Lisa Garett</span>
                                    <span class="message">2hr ago</span>
                                    <span class="badge badge-outline status"></span>
                                </div>
                            </div>
                        </a>                            
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <?php
	include($user_type.'_menu.php');
	?>
    
    <div id="main-content">
        

    

