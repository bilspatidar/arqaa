<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?php echo BRAND_NAME ;?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo base_url();?>webassets/img/favicon.png" rel="icon">
  <link href="<?php echo base_url();?>webassets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <!-- Toaster -->


 <!-- Toaster -->

  <!-- Vendor CSS Files -->
  <link href="<?php echo base_url();?>webassets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>webassets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?php echo base_url();?>webassets/vendor/aos/aos.css" rel="stylesheet">
  <link href="<?php echo base_url();?>webassets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>webassets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>webassets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="<?php echo base_url();?>webassets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: < ?php echo BRAND_NAME ;?>
  * Template URL: https://bootstrapmade.com/upconstruction-bootstrap-construction-website-template/
  * Updated: May 10 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->

  <style>
.about_img {
  position: absolute;
  inset: 0;
  display: block;
  width: 65% !important;
  height: 45% !important;
  object-fit: cover;
  object-position: center;
  z-index: 1;
}
.project_details {
  width: 65% !important;
  height: auto !important;
}
.image_services {
  width: 85% !important;
  height: auto !important;
}
.navmenu{
  color:#FFF;
}
@media only screen and (max-width: 768px) {
  .about_img {
    width: calc(100% - 20px) !important; 
    height: auto !important;
    margin: 0 10px; 
  }
  .only_media_img {
    width: calc(100% - 20px) !important; 
    height: auto !important;
    margin: 0 10px; 
  }
}
.header .logo img {
    max-height: 50px;
    margin-right: 8px;
}
    </style>
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="<?php echo base_url();?>web" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="<?php echo base_url();?>webassets/img/logo1.png" alt="" >
        <!-- <h1 class="sitename"><?php echo BRAND_NAME ;?></h1> <span>.</span> -->
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="<?php echo base_url();?>web" class="active">Home</a></li>
          <li><a href="<?php echo base_url();?>web/about">About</a></li>
          <li><a href="<?php echo base_url();?>web/services">Services</a></li>
          <li><a href="<?php echo base_url();?>web/projects">Projects</a></li>
          <!--<li><a href="< ?php echo base_url();?>web/blog">Blog</a></li>-->
          <!-- <li class="dropdown"><a href="#"><span>Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a> -->
            <!--<ul>
              <li><a href="#">Dropdown 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                <ul>
                  <li><a href="#">Deep Dropdown 1</a></li>
                  <li><a href="#">Deep Dropdown 2</a></li>
                  <li><a href="#">Deep Dropdown 3</a></li>
                  <li><a href="#">Deep Dropdown 4</a></li>
                  <li><a href="#">Deep Dropdown 5</a></li>
                </ul>
              </li>
              <li><a href="#">Dropdown 2</a></li>
              <li><a href="#">Dropdown 3</a></li>
              <li><a href="#">Dropdown 4</a></li>
            </ul>
          </li>-->
          <li><a href="<?php echo base_url();?>web/contact">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>
