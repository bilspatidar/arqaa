<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<?php $superadmindetails = $this->Internal_model->get_superadmin_details();

?>


<main class="main">

<!-- Page Title -->
<div class="page-title" data-aos="fade" style="background-image: url(<?php echo base_url();?>webassets/img/page-title-bg.jpg);">
  <div class="container position-relative">
    <h1>Contact</h1>
    <nav class="breadcrumbs">
      <ol>
        <li><a href="<?php echo base_url();?>web">Home</a></li>
        <li class="current">Contact</li>
      </ol>
    </nav>
  </div>
</div><!-- End Page Title -->

<!-- Contact Section -->
<section id="contact" class="contact section">

  <div class="container" data-aos="fade-up" data-aos-delay="100">

    <div class="row gy-4">

      <div class="col-lg-6">
        <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="200">
          <i class="bi bi-geo-alt"></i>
          <h3>Address</h3>
          <p><?php echo $superadmindetails[0]->address;?></p>
        </div>
      </div><!-- End Info Item -->

      <div class="col-lg-3 col-md-6">
        <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="300">
          <i class="bi bi-telephone"></i>
          <h3>Call Us</h3>
          <p><?php echo $superadmindetails[0]->mobile;?></p>
        </div>
      </div><!-- End Info Item -->

      <div class="col-lg-3 col-md-6">
        <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="400">
          <i class="bi bi-envelope"></i>
          <h3>Email Us</h3>
          <p><?php echo $superadmindetails[0]->email;?></p>
        </div>
      </div><!-- End Info Item -->

    </div>

    <div class="row gy-4 mt-1">
      <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
        <!-- <iframe 
        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d48389.78314118045!2d-74.006138!3d40.
        710059!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a22a3bda30d%3A0xb89d1fe6bc499443!2sDowntown%20Conference
        %20Center!5e0!3m2!1sen!2sus!4v1676961268712!5m2!1sen!2sus" frameborder="0" 
        style="border:0; width: 100%; height: 400px;" allowfullscreen="" loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade"></iframe> -->
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3647.786942838559!2d74.96794109999999!3d23.8971726!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39642760219090ff%3A0x7d603ecb262de406!2sAnjana%20Borwells%20Company%20Karju!5e0!3m2!1sen!2sin!4v1716276230384!5m2!1sen!2sin" width="550" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>  
      </div><!-- End Google Maps -->
      
      <div class="col-lg-6">
        <form id="contact_form" action="<?php echo base_url();?>web/add_contact" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="400">
          <div class="row gy-4">

            <div class="col-md-6">
              <input type="text" name="name" class="form-control" placeholder="Your Name">
            </div>

            <div class="col-md-6 ">
              <input type="number" class="form-control" name="phone" placeholder="Your Mobile">
            </div>

            <div class="col-md-12">
              <input type="text" class="form-control" name="address" placeholder="Address">
            </div>

            <div class="col-md-12">
              <textarea class="form-control" name="message" rows="6" placeholder="Message"></textarea>
            </div>

            <div class="col-md-12 text-center">
              <div class="sent-message" style="display:none;">Your message has been sent. Thank you!</div>
              <div class="error-message" style="display:none;">An error occurred while processing your request.</div>

              <button type="submit">Submit</button>
            </div>

          </div>
        </form>
      </div><!-- End Contact Form -->

    </div>

  </div>

</section><!-- /Contact Section -->

</main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
                    $(document).ready(function() {
                        $("#contact_form").on('submit', function(e) {
                            e.preventDefault();

                            var post_link = "<?php echo base_url('web/add_contact'); ?>";
                            console.log("Post link: " + post_link); // Log the URL

                            var formData = $(this).serialize();
                            console.log("Form data: " + formData); // Log form data

                            $.ajax({
                                url: post_link,
                                type: 'POST',
                                data: formData,
                                success: function(response) {
                                    console.log("Server Response: ", response); // Debugging line
                                    try {
                                        var json = $.parseJSON(response);
                                        if (json.status == 1) {
                                            $('.sent-message').show();
                                            $('.error-message').hide();
                                            toastr.success(json.msg);
                                            $("#contact_form")[0].reset(); 
                                        } else {
                                            $('.error-message').text(json.msg).show();
                                            $('.sent-message').hide();
                                            toastr.error(json.msg);
                                        }
                                    } catch (e) {
                                        console.error("Error parsing JSON response: ", e);
                                        $('.error-message').text('An error occurred while processing your request.').show();
                                        $('.sent-message').hide();
                                        toastr.error('An error occurred while processing your request.');
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error("AJAX Error: ", xhr.responseText);
                                    $('.error-message').text('An error occurred while processing your request.').show();
                                    $('.sent-message').hide();
                                    toastr.error('An error occurred while processing your request.');
                                }
                            });
                        });
                    });
</script>
