

<style>
  /* General Styles */
.main {
  font-family: Arial, sans-serif;
  color: #333;
}

.page-title {
  padding: 60px 0;
  text-align: center;
  color: #fff;
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

/* About Section */
.about {
  padding: 60px 0 !important;
}

.about-img {
  margin-bottom: 1.5rem !important;
}

.about-img img {
  width: 100% !important;
  height: auto !important;
  object-fit: cover !important;
  border-radius: 8px !important;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2) !important;
  transition: transform 0.3s !important;
}

.about-img img:hover {
  transform: scale(1.05) !important;
}

.inner-title {
  font-size: 2rem !important;
  margin-bottom: 1rem !important;
  color: #333 !important;
}

.our-story {
  line-height: 1.6 !important;
}

@media (min-width: 992px) {
  .col-lg-5 {
    flex: 0 0 41.66667% !important;
    max-width: 41.66667% !important;
  }

  .col-lg-9 {
    flex: 0 0 58.33333% !important;
    max-width: 58.33333% !important;
  }
}

</style>
<main class="main">

<div class="page-title" data-aos="fade" style="background-image: url(<?php echo base_url();?>webassets/img/page-title-bg.jpg);">
  <div class="container position-relative">
    <h1>About</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="index.html">Home</a></li>
        <li class="current">About</li>
      </ol>
    </nav>
  </div>
</div>

<!-- About Section -->
<section id="about" class="about section">

  <div class="container">

    <div class="row position-relative">
    <?php 
    $this->db->select('*');
    $this->db->from('about');
    $this->db->where('status','Active');
    $query = $this->db->get();
    if($query->num_rows()>0){ 
    $result = $query->result();
    foreach($result as $row){ ?>
      <div class="col-lg-5 about-img" data-aos="zoom-out" data-aos-delay="100">
        <img class="about_img" src="<?php echo $row->image; ?>"></div>
 
      <div class="col-lg-9" data-aos="fade-up" data-aos-delay="100">
        <h2 class="inner-title"><?php echo $row->title;?></h2>
        <div class="our-story">
          <!-- <h4>Est 1988</h4>
          <h3>Our Story</h3> -->
          <p><?php echo $row->description;?></p>
          
        </div>
      </div>
      </div>
<?php } } ?>
    

  </div>
</section><!-- /About Section -->


</main>
    </br>