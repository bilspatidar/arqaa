<?php 
    $this->db->select('*');
    $this->db->from('services');
    $this->db->where('status','Active');
    $this->db->where('id',$service_id);
    $query = $this->db->get();
    if($query->num_rows()>0){ 
      $result = $query->result();
    }
      ?>

      <style>
/* General Styles */
.main {
  font-family: Arial, sans-serif !important;
  color: #333 !important;
}

/* Page Title */
.page-title {
  padding: 60px 0 !important;
  text-align: center !important;
  color: #fff !important;
  background-size: cover !important;
  background-position: center !important;
  background-repeat: no-repeat !important;
}

.page-title h1 {
  font-size: 3rem !important;
  margin-bottom: 0.5rem !important;
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
}

/* Service Details Section */
.service-details {
  padding: 60px 0 !important;
  background-color: #f9f9f9 !important; /* Light background for contrast */
}

.container {
  max-width: 1140px !important;
  margin: 0 auto !important;
}

/* Service List */
.services-list {
  padding: 0 !important;
  margin-bottom: 1.5rem !important;
}

.services-list a {
  display: block !important;
  padding: 10px 15px !important;
  color: #333 !important;
  text-decoration: none !important;
  border-radius: 4px !important;
  margin-bottom: 5px !important;
  transition: background-color 0.3s ease !important, color 0.3s ease !important;
}

.services-list a.active, .services-list a:hover {
  background-color: #ffcc00 !important;
  color: #fff !important;
}

/* Service Image */
.services-img {
  width: 100% !important;
  height: 300px !important; /* Set a fixed height for consistency */
  object-fit: cover !important; /* Ensure image covers container without stretching */
  border-radius: 8px !important;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2) !important;
  margin-bottom: 1rem !important;
}

/* Service Content */
h3 {
  font-size: 2rem !important;
  margin: 1rem 0 !important;
  color: #333 !important;
}

p {
  line-height: 1.6 !important;
  font-size: 1rem !important;
  color: #6b7280 !important; /* Medium gray text color */
  margin-bottom: 1rem !important;
}

/* Responsive Design */
@media (min-width: 992px) {
  .col-lg-4, .col-lg-8 {
    display: flex !important;
    flex-direction: column !important;
  }

  .col-lg-4 {
    flex: 0 0 33.33333% !important;
    max-width: 33.33333% !important;
  }

  .col-lg-8 {
    flex: 0 0 66.66667% !important;
    max-width: 66.66667% !important;
  }
}
</style>


<main class="main">

<!-- Page Title -->
<div class="page-title" data-aos="fade" style="background-image: url(<?php echo base_url();?>webassets/img/page-title-bg.jpg);">
  <div class="container position-relative">
    <h1>Service Details</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="<?php echo base_url();?>">Home</a></li>
        <li class="current">Service Details</li>
      </ol>
    </nav>
  </div>
</div><!-- End Page Title -->

<!-- Service Details Section -->
<section id="service-details" class="service-details section">

  <div class="container">

    <div class="row gy-4">

      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
        <div class="services-list">
          <a href="#" class="active">Web Design</a>
          <?php $services = $this->Internal_model->git_services();
            foreach($services as $row){
              $service_id = $row->id;
              ?>
              <a href="<?php echo base_url();?>web/service_details/<?php echo $service_id;?>"><?php echo $row->title;?></a>
           <?php } ?>
        </div>

        <!-- <h4>Enim qui eos rerum in delectus</h4> -->
        <!-- <p>Nam voluptatem quasi numquam quas fugiat ex temporibus quo est. Quia aut quam quod facere ut non occaecati ut aut. Nesciunt mollitia illum tempore corrupti sed eum reiciendis. Maxime modi rerum.</p> -->
      </div>

      <div class="col-lg-8" data-aos="fade-up" data-aos-delay="200">
        <img src="<?php echo $result[0]->image;?>" alt="" class="img-fluid services-img" style="height: 150px; width: auto;">
        <h3><?php echo $result[0]->title;?></h3>
        <p>
        <?php echo $result[0]->description;?>
        </p>
        
      </div>

    </div>

  </div>

</section><!-- /Service Details Section -->

</main>
