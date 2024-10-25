<main class="main">

<!-- Page Title -->
<div class="page-title" data-aos="fade" style="background-image: url(<?php echo base_url();?>webassets/img/page-title-bg.jpg);">
  <div class="container position-relative">
    <h1>Blog</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="index.html">Home</a></li>
        <li class="current">Blog</li>
      </ol>
    </nav>
  </div>
</div><!-- End Page Title -->
<style>
 .imgs{
  width: 350px !important;
 }
</style>
<!-- Blog Posts Section -->
<section id="blog-posts" class="blog-posts section">

  <div class="container">
    <div class="row gy-4">
    <?php 
    $this->db->select('*');
    $this->db->from('blog');
    $this->db->where('status','Active');
    if(!empty($blog_cat_id)){
      $this->db->where('category_id',$blog_cat_id);
    }
    $this->db->where('image !=','');
    $query = $this->db->get();
    if($query->num_rows()>0){ 
    $result = $query->result();
    foreach($result as $row){
      $blog_id = $row->id;
      ?>
      <div class="col-lg-4">
        <article class="position-relative h-100">
          <div class="post-img position-relative overflow-hidden">
            <img class="imgs" src="<?php echo $row->image ;?>" class="img-fluid only_media_img" alt="">
            <span class="post-date"><?php $date = date_create($row->added); 
                  $formatted_date = date_format($date, 'F j, Y'); 
                  echo $formatted_date; ?></span>
          </div>
          <div class="post-content d-flex flex-column">

            <h3 class="post-title"><?php echo $row->title ;?></h3>

            <div class="meta d-flex align-items-center">
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">
                <?php echo $this->Internal_model->get_col_by_key('users','id',$row->addedBy,'first_name') ;?>
                </span>
              </div>
              <!-- <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> 
                <span class="ps-2">Politics</span>
              </div> -->
            </div>

            <p><?php echo $row->description;?></p>
            <hr>
            <a href="<?php echo base_url();?>web/blog_details/<?php echo $blog_id;?>" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
       </div>

        </article>
      </div><!-- End post list item -->
      <?php } } ?>
    </div>
  </div>

</section><!-- /Blog Posts Section -->

<!-- Pagination 2 Section -->
<section id="pagination-2" class="pagination-2 section">

  <div class="container">
    <div class="d-flex justify-content-center">
      <ul>
        <li><a href="#">1</a></li>
        <li class="active"><a href="#">2</a></li>
        <li><a href="#">3</a></li>
      </ul>
    </div>
  </div>

</section><!-- /Pagination 2 Section -->

</main>
