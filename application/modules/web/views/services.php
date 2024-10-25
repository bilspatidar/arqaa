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
<main class="main">

<div class="page-title" data-aos="fade" style="background-image: url(<?php echo base_url();?>webassets/img/page-title-bg.jpg);">
  <div class="container position-relative">
    <h1>Services</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="<?php echo base_url();?>web">Home</a></li>
        <li class="current">Services</li>
      </ol>
    </nav>
  </div>
</div>

<!-- Services Section -->
<section id="services" class="services section">

  <div class="container">

    <div class="row gy-4">
          <?php 
$git_services = $this->Internal_model->git_services();
    foreach($git_services as $row){
      $service_id = $row->id;
      ?>

<div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="service-item  position-relative">
    <img src="<?php echo $row->image;?>" style="height: 150px; width: auto;">
          <h3><?php echo $row->title;?></h3>
          <p><?php echo $row->description;?></p>
          <a href="<?php echo base_url();?>web/service_details/<?php echo $service_id;?>" class="readmore stretched-link">Read more <i class="bi bi-arrow-right"></i></a>
        </div>
      </div>

    <?php } ?>
  
</div>

  </div>

</section>

</main>