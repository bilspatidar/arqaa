<!doctype html>
<html lang="en">

<head>
<title>Osam | Map JVector Map</title>
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

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/vendor/jvectormap/jquery-jvectormap-2.0.3.css"/>

<!-- MAIN CSS -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/css/site.min.css">

</head>
<style>
    .map{
        width: 100%;
height: 500px;
top: 203px;
gap: 0px;
border: 1px 0px 0px 0px;
opacity: 0px;

    }
.imgheader{
    width: 48px;
height: 45px;
top: 27px;
left: 43px;
gap: 0px;
border-radius: 3px 0px 0px 0px;
opacity: 0px;

}
.headerlogo{
    width: 185px;
height: 55px;
top: 14px;
left: 868px;
gap: 0px;
opacity: 0px;

}
.navbar-fixed-top {
   
    width: 100% !important;
   
}
.user-account{
    margin: 0px;
    
}
.container-fluid{
    padding-left:20px !important;
}
.header{
    margin: 80px 40px 0 40px ;
    display: flex;
    align-items:center;
    width: 100%;
    justify-content: space-between;
}


.buttons button{
    
  outline: none;
  border: none; 
border-radius: 8px;
color: #fff;
background: #2D79E6;
padding: 8px 10px; 
font-size: 14px;
margin-right: 6px;

}
</style>

<body class="theme-orange">
<?php 
 $users_id = getUser('id');
 $UserDetails = $this->Internal_model->getUserDetails($users_id) ;?>
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img src="<?php echo base_url(); ?>assets/assets/images/logoarqaa.png" width="40" height="40" alt="Osam"></div>
        <p>Please wait...</p>        
    </div>
</div>
<!-- Overlay For Sidebars -->
<div class="overlay"></div>

<div id="wrapper">

    <nav class="navbar navbar-fixed-top">
        <div class="container-fluid">
        <div class="user-account">

<div class="user_div">
    <img class="imgheader"src="<?php echo $UserDetails[0]->profile_pic;?>" class="user-photo" alt="User Profile Picture">
</div>
<div class="dropdown">
    <span>Welcome,</span>
    <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong><?php echo $UserDetails[0]->name;?></strong></a>
    <ul class="dropdown-menu dropdown-menu-right account vivify flipInY">
        <li><a href="<?php echo base_url();?>admin/master/my_profile"><i class="icon-user"></i>My Profile</a></li>
        <!-- <li><a href="app-inbox.html"><i class="icon-envelope-open"></i>Messages</a></li> -->
        <li><a href="<?php echo base_url();?>admin/master/setting"><i class="icon-settings"></i><?php echo $this->lang->line('change_password') ?: 'Change Password';?></a></li>
       
        <li><a href="<?php echo base_url();?>admin/admin/logout"><i class="icon-power"></i>Logout</a></li>
    </ul>
</div>
</div>
         
            <a href="index.html">
                    <img class="headerlogo"src="<?php echo base_url(); ?>assets/assets/images/logoarqaa.png" alt="Osam Logo" class="img-fluid logo"></a>

            <div class="navbar-right">
           
                <div id="navbar-menu">
                    <ul class="nav navbar-nav">
                    <li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        Language <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        <li><a href="<?php echo base_url('Internal/switch_lang/english'); ?>"> English</a></li>
        <li><a href="<?php echo base_url('Internal/switch_lang/spanish'); ?>"> Spanish</a></li>
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
                        <li><a href="page-login.html" class="icon-menu"><i class="icon-power"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="row clearfix">

              <div class="header">
                            <h2 class="texth2">What would you like to do today?</h2>
                            <div class="buttons">
                            <button>Open a Country</button> 
                            <button>Manage Country</button>
                             <button>Remove Country</button> 
                             <button>Global Dashboard</button>
                        </div>
                       
                        </div>
                        </div>
                       
                               
                            
   
      
       <style>
.texth2{
    font-family: Montserrat;
font-size: 32px;
font-weight: 600;
line-height: 45px;
text-align: left;
text-underline-position: from-font;
text-decoration-skip-ink: none;


}

       </style>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        
                        <div class="body">
                            <div class="map" id="world-map-markers" class="jvector-map"></div>
                        </div>
                    </div>
                </div>
            </div>

           
        </div>
   
    


<!-- Javascript -->
<script src="<?php echo base_url(); ?>assets/assets/bundles/libscripts.bundle.js"></script>    
<script src="<?php echo base_url(); ?>assets/assets/bundles/vendorscripts.bundle.js"></script>

<script src="<?php echo base_url(); ?>assets/assets/bundles/jvectormap.bundle.js"></script><!-- JVectorMap Plugin Js -->
<script src="<?php echo base_url(); ?>assets/assets/vendor/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="<?php echo base_url(); ?>assets/assets/vendor/jvectormap/jquery-jvectormap-in-mill.js"></script>       <!-- India Map Js -->
<script src="<?php echo base_url(); ?>assets/assets/vendor/jvectormap/jquery-jvectormap-us-aea-en.js"></script>     <!-- USA Map Js -->
<script src="<?php echo base_url(); ?>assets/assets/vendor/jvectormap/jquery-jvectormap-uk-mill-en.js"></script>    <!-- UK Map Js -->
<script src="<?php echo base_url(); ?>assets/assets/vendor/jvectormap/jquery-jvectormap-au-mill.js"></script>       <!-- Australia Map Js -->

<script src="<?php echo base_url(); ?>assets/assets/bundles/mainscripts.bundle.js"></script>
<script src="<?php echo base_url(); ?>assets/assets/js/pages/maps/jvectormap.js"></script><!-- Custom Js -->
<!-- Template monster -->
<script type="text/javascript" src="//themera.net/embed/themera.js?id=74746"></script> 
</body>
</html>
