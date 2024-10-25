<style>
 

  .swiper-slide {
    display: flex;
    justify-content: center;
    align-items: center;
  }
</style>

<style>
/* General Styles */
.main {
  font-family: Arial, sans-serif !important;
  color: #333 !important;
}

/* Page Title */
.page-title {
  padding: 80px 0 !important;
  text-align: center !important;
  color: #fff !important;
  background-size: cover !important;
  background-position: center !important;
  background-repeat: no-repeat !important;
}

.page-title h1 {
  font-size: 3.5rem !important;
  font-weight: bold !important;
  margin: 0 !important;
}

.breadcrumbs {
  margin-top: 1rem !important;
}

.breadcrumbs ol {
  list-style: none !important;
  padding: 0 !important;
  display: inline-flex !important;
}

.breadcrumbs ol li {
  margin: 0 0.5rem !important;
}

.breadcrumbs ol li a {
  color: #fff !important;
  text-decoration: none !important;
}

.breadcrumbs ol li.current {
  color: #ffcc00 !important;
  font-weight: bold !important;
}

/* Project Details Section */
.project-details {
  padding: 80px 0 !important;
  background-color: #f9f9f9 !important; /* Light gray background */
}

.portfolio-details-slider {
  position: relative !important;
  margin-bottom: 2rem !important;
}

.swiper-wrapper {
  display: flex !important;
}

.swiper-slide {
  display: flex !important;
  justify-content: center !important;
  align-items: center !important;
}

.project_details {
  width: 100% !important;
  height: auto !important;
  border-radius: 12px !important;
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2) !important;
}

/* Slider Navigation */
.swiper-button-next,
.swiper-button-prev {
  color: #333 !important;
  width: 50px !important;
  height: 50px !important;
  background-color: rgba(255, 255, 255, 0.9) !important;
  border-radius: 50% !important;
  display: flex !important;
  justify-content: center !important;
  align-items: center !important;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
}

.swiper-button-next:hover,
.swiper-button-prev:hover {
  background-color: #ffcc00 !important;
  color: #fff !important;
}

.swiper-pagination-bullet {
  background: #ffcc00 !important;
}

.swiper-pagination-bullet-active {
  background: #333 !important;
}

/* Portfolio Description */
.portfolio-description {
  background: #fff !important;
  padding: 2rem !important;
  border-radius: 12px !important;
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1) !important;
  max-width: 100% !important;
}

.portfolio-description h2 {
  font-size: 2.5rem !important;
  font-weight: bold !important;
  margin-bottom: 1rem !important;
  color: #333 !important;
}

.portfolio-description p {
  font-size: 1rem !important;
  line-height: 1.8 !important;
  color: #6b7280 !important; /* Medium gray text color */
  margin-bottom: 1.5rem !important;
}

.testimonial-img {
  width: 120px !important;
  height: 120px !important;
  border-radius: 50% !important;
  object-fit: cover !important;
  margin-top: 1.5rem !important;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2) !important;
}

.portfolio-description h3 {
  font-size: 1.75rem !important;
  margin-top: 0.5rem !important;
  color: #333 !important;
}

/* Responsive Design */
@media (max-width: 992px) {
  .project-details {
    padding: 40px 0 !important;
  }

  .swiper-button-next,
  .swiper-button-prev {
    width: 40px !important;
    height: 40px !important;
  }

  .portfolio-description h2 {
    font-size: 2rem !important;
  }

  .portfolio-description h3 {
    font-size: 1.5rem !important;
  }

  .testimonial-img {
    width: 100px !important;
    height: 100px !important;
  }
}
</style>

<?php 
$this->db->select('*');
$this->db->from('pms_project');
$this->db->where('id',$project_id);
$query = $this->db->get();
if($query->num_rows() > 0) { 
  $result = $query->result(); 
  $project_id = $result[0]->id; 
?>

<main class="main">

<div class="page-title" data-aos="fade" style="background-image: url(<?php echo base_url();?>webassets/img/page-title-bg.jpg);">
  <div class="container position-relative">
    <h1>Project Details</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="<?php echo base_url();?>web">Home</a></li>
        <li class="current">Project Details</li>
      </ol>
    </nav>
  </div>
</div><!-- End Page Title -->

<!-- Project Details Section -->
<section id="project-details" class="project-details section">

  <div class="container" data-aos="fade-up">

    <div class="portfolio-details-slider swiper">
      <script type="application/json" class="swiper-config">
        {
          "loop": true,
          "speed": 600,
          "autoplay": {
            "delay": 5000
          },
          "slidesPerView": "auto",
          "navigation": {
            "nextEl": ".swiper-button-next",
            "prevEl": ".swiper-button-prev"
          },
          "pagination": {
            "el": ".swiper-pagination",
            "type": "bullets",
            "clickable": true
          }
        }
      </script>
      <div class="swiper-wrapper align-items-center">

        <div class="swiper-slide">
          <img src="<?php echo $result[0]->image;?>" class="project_details" alt="">
        </div>

      </div>
    </div>

    <div class="row justify-content-between gy-4 mt-4">

      <div class="col-lg-8" data-aos="fade-up">
        <div class="portfolio-description">
          <h2><?php echo $result[0]->title;?></h2>
          <p>
          <?php echo $result[0]->description;?>
          </p>
         
          <img src="<?php echo $this->Internal_model->get_col_by_key('users','id',$result[0]->added_by,'profile_pic');?>" class="testimonial-img" alt="">
          <h3><?php echo $this->Internal_model->get_col_by_key('users','id',$result[0]->added_by,'first_name');?></h3>
          <!-- <h4>Designer</h4> -->
        </div>
      </div>
    </div>
  </div>
</section><!-- /Project Details Section -->

</main>
<?php } ?>
