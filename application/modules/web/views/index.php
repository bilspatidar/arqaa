<style>

.hero .carousel-item::before {
  background-color: #0000007d; /* This replicates the effect of transparency */
  /* height: 60px; */ /* Uncomment if you need to set height */
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 1; /* Ensure it is on top */
}

</style>
  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">

      <div class="info d-flex align-items-center carousel-item active">
        <div class="container">
          <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="100">
            <div class="col-lg-6 text-center">
              <h2 class="">Welcome to Jpinfra</h2>
              <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
              <a href="#get-started" class="btn-get-started">Get Started</a> -->
            </div>
          </div>
        </div>
      </div>

      <div id="section-fqREP4OWmC-carousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">

      <?php  $git_services = $this->Internal_model->git_services();
        foreach($git_services as $row){ ?>
        <div class="carousel-item active">
          <img src="<?php echo $row->image;?>" alt="">
        </div>
      <?php } ?>


        <a class="carousel-control-prev" href="#section-fqREP4OWmC-carousel" role="button" data-bs-slide="prev">
          <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
        </a>

        <a class="carousel-control-next" href="#section-fqREP4OWmC-carousel" role="button" data-bs-slide="next">
          <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
        </a>

      </div>

    </section><!-- /Hero Section -->
<style>
  /* Services Section */
.services {
  padding-top: 1rem !important;
  padding-bottom: 1rem !important;
  background-color: #f3f4f6; /* Light gray background */
}

/* Service Item */
.service-item {
  background-color: #ffffff;
  border-radius: 0.75rem; /* Rounded corners */
  box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1), 0 4px 6px rgba(0, 0, 0, 0.05); /* Soft shadow */
  overflow: hidden; /* Ensure content stays within border */
  transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth scaling and shadow transition */
}

/* Service Image */
.service-item img {
  width: 100% !important;
  height: 250px !important;
  object-fit: cover; /* Ensures image covers container without stretching */
  transition: transform 0.3s ease; /* Smooth zoom effect */
}

/* Hover effect only on the image */
.service-item:hover img {
  transform: scale(1.1); /* Slight zoom on hover */
}

/* Service Content */
.service-item h3 {
  font-size: 1rem !; /* Font size for heading */
  font-weight: 700 !; /* Semi-bold font */
  color: #1f2937; /* Dark gray text color */
  /* margin-top: 10px; */
  display:block !important ;/* Margin for spacing */
  margin: 20px!important;
}

.service-item p {
  font-size: 1rem; /* Font size for paragraph */
  color: #6b7280; /* Medium gray text color */
  padding-top: 0px !important; /* Padding at the bottom */
}
.imgss{
  width: 350px !important;
}
</style>

    <!-- Services Section -->
    <section id="services" class="services section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Services</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">
        <?php  $services = $this->Internal_model->git_services();
        foreach($services as $rowService){ ?>
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item  position-relative">
       
          <img class="image_services imgss" src="<?php echo $rowService->image;?>" alt="">

              <h3><?php echo $rowService->title;?></h3>
              <p><?php echo $rowService->description;?></p>
              <!-- <a href="#" class="readmore stretched-link">Read more <i class="bi bi-arrow-right"></i></a> -->
            </div>
          </div>
            <?php } ?>
        </div>

      </div>

    </section><!-- /Services Section -->
<style>
 .imgs{
  width: 350px !important;
 }
</style>
    <!-- Projects Section -->
    <section id="projects" class="projects section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2 class="">Projects</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

          <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
            <li data-filter="*" class="filter-active"></li>
          </ul><!-- End Portfolio Filters -->

          <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
          <?php 
                  $projects = $this->Internal_model->git_projects();
                  foreach($projects as $row){  ?>
            <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-remodeling">
              <div class="portfolio-content h-100">
                <img class="imgs" src="<?php echo $row->image;?>" class="img-fluid" alt="">
                <div class="portfolio-info">
                  <h4><?php echo $row->title;?></h4>
                  <p><?php echo $row->description;?></p>
                  <a href="<?php echo $row->image;?>" title="<?php echo $row->title;?>" data-gallery="portfolio-gallery-app" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                  <a href="<?php echo base_url();?>web/project_details/<?php echo $project_id ;?>" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
                </div>
              </div>
            </div><!-- End Portfolio Item -->
                  <?php } ?>

          </div><!-- End Portfolio Container -->

        </div>

      </div>

    </section><!-- /Projects Section -->


    <!-- Recent Blog Posts Section -->
    <section id="recent-blog-posts" class="recent-blog-posts section">

      <!-- Section Title -->
     <!-- <div class="container section-title" data-aos="fade-up">
        <h2 class="">Recent Blog Posts</h2>
        <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
      </div>--><!-- End Section Title -->
<!--
      <div class="container">

        <div class="row gy-5">
        < ?php $git_blog = $this->Internal_model->git_blog(); 
          foreach($git_blog as $blog){ 
            $blog_id = $blog->id;
            ?>
          <div class="col-xl-4 col-md-6">
            <div class="post-item position-relative h-100" data-aos="fade-up" data-aos-delay="100">

              <div class="post-img position-relative overflow-hidden">
                <img class="imgs" src="< ?php echo $blog->image ;?>" class="img-fluid" alt="">
                <span class="post-date">< ?php $date = date_create($blog->added); 
                  $formatted_date = date_format($date, 'F j, Y'); 
                  echo $formatted_date; ?></span>
              </div>

              <div class="post-content d-flex flex-column">

                <h3 class="post-title">< ?php echo $blog->title ;?></h3>

                <div class="meta d-flex align-items-center">
                  <div class="d-flex align-items-center">
                    <i class="bi bi-person"></i> <span class="ps-2">< ?php echo $this->Internal_model->get_col_by_key('users','id',$blog->addedBy,'first_name') ;?></span>
                  </div>
                  <!-- <span class="px-3 text-black-50">/</span>
                  <div class="d-flex align-items-center">
                    <i class="bi bi-folder2"></i> <span class="ps-2">Politics</span>
                  </div> -->
              <!--  </div>

                <hr>

                <a href="< ?php echo base_url();?>web/blog_details/< ?php echo $blog_id;?>" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>

              </div>

            </div>
          </div><!-- End post item -->
    <!--      < ?php } ?>

        </div>

      </div>
-->
    </section><!-- /Recent Blog Posts Section -->

  </main>
