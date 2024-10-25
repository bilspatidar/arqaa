<main class="main">

<!-- Page Title -->
<div class="page-title" data-aos="fade" style="background-image: url(<?php echo base_url();?>webassets/img/page-title-bg.jpg);">
  <div class="container position-relative">
    <h1>Projects</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="<?php echo base_url();?>web">Home</a></li>
        <li class="current">Projects</li>
      </ol>
    </nav>
  </div>
</div><!-- End Page Title -->
<style>
 .imgs{
  width: 350px !important;
 }
</style>
<!-- Projects Section -->
<section id="projects" class="projects section">

  <div class="container">

    <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

      <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
        <li data-filter="*" class="filter-active"></li>
      </ul>

      <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
      <?php 
    $projects = $this->Internal_model->git_projects();
    foreach($projects as $row){ 
      $project_id = $row->id;
      ?>
        <div class="col-lg-4 col-md-6 portfolio-item isotope-item filter-remodeling">
          <div class="portfolio-content h-100">
            <img class="imgs" src="<?php echo $row->image;?>" class="img-fluid only_media_img" alt="">
            <div class="portfolio-info">
              <h4><?php echo $row->title;?></h4>
              <p><?php echo $row->description;?></p>
              <a href="<?php echo $row->image;?>" title="<?php echo $row->title;?>" data-gallery="portfolio-gallery-app" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
              <a href="<?php echo base_url();?>web/project_details/<?php echo $project_id ;?>" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>
            </div>
          </div>
        </div>
<?php }  ?>
      </div>

    </div>

  </div>

</section>

</main>
