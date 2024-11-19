
<!-- VENDOR CSS -->
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/vendor/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/vendor/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/vendor/animate-css/vivify.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

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
    margin: 25px 40px 0 40px ;
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
/* Heading styling */
.texth2{
    color:#fff;
}
/* Paragraph styling (smaller size) */
.textp {
    font-size: 12px; /* Make the paragraph text smaller */
    color: #fff;
    margin-top: 5px;
    line-height: 1.5;
}

.select2-container .select2-selection--single {
    height: 36px !important;

}

  /* Select2 container background for single selection */
.select2-container--default .select2-selection--single {
  background-color: #22252a; /* Dark background color */
  color: #fd7e14; /* Text color */
  border-color: #555; /* Border color */
  border-radius: 25px;
  
}

/* Select2 container background for multiple selection */
.select2-container--default .select2-selection--multiple {
  background-color: #22252a; /* Dark background color for multiple selection */
  color: #fd7e14; /* Text color */
}

/* Selected options background color in multiple selection */
.select2-container--default .select2-selection--multiple .select2-selection__choice {
  background-color: #22252a; /* Darker background for selected options */
  color: #fd7e14; /* Text color for selected options */
}

/* Select2 dropdown background */
.select2-container--default .select2-results__option {
  background-color: #22252a; /* Dark background color for options */
  color: #fd7e14; /* Text color for options */
}

/* Hover effect for options */
.select2-container--default .select2-results__option--highlighted {
  background-color: #444; /* Darker background on hover */
  color: #fd7e14; /* Text color on hover */
}

.btn-continue{
    padding-left:30px ;
    padding-right:30px ;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #fd7e14;
   
}
</style>
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
/* Pop-up styling */
.popup {
    display: none; /* Hidden by default */
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #22252a;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 80%;
    max-width: 400px;
    padding: 20px;
    z-index: 1000;
    box-sizing: border-box;
}

.popup-content {
    font-size: 14px;
}

.close-btn {
    font-size: 20px;
    color: #aaa;
    float: right;
    cursor: pointer;
}

.close-btn:hover {
    color: #000;
}

/* Additional form styling */
.popup form {
    margin-top: 10px;
}

.popup .form-group {
    margin-bottom: 15px;
}

.popup input[type="password"] {
    width: 100%; /* Full-width input */
    padding: 8px;
    /* border: 1px solid #ccc; */
    border-radius: 4px;
}

.popup button {
    width: 100%; /* Full-width submit button */
    padding: 10px;
    background-color: #007bff; /* Bootstrap primary color */
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.popup button:hover {
    background-color: #0056b3; /* Darker shade on hover */
}

       </style>
<body class="theme-orange">
<?php 
 $users_id = getUser('id');
 $UserDetails = $this->Internal_model->getUserDetails($users_id) ;?>
<!-- Page Loader -->

<!-- Overlay For Sidebars -->
<div class="overlay"></div>

<div id="wrapper">

    
    <div class="row clearfix">
    <div class="header">
    <div class="">
    <h3 class="texth2">Remove Country</h3>
<p class="textp">Which country do you want to remove from the map?</p>

</div>
  


<div class="col-md-5 dark-mode">
<form class="" id="crudFormAddApiData" action="<?php echo API_DOMAIN; ?>api/user/company_user/add" method="POST">

    <div class="form-group row">
        <div class="col-sm-6">
            <label class="col-form-label"><?php echo $this->lang->line('select_country'); ?></label>
            <select name="country_id" id="country_id" class="form-control select2 dark-select" onchange="getStates(this.value)">
                <option value=""><?php echo $this->lang->line('select_option'); ?></option>
                <?php $countrys = $this->Internal_model->get_country();
                foreach ($countrys as $country) { ?>
                    <option value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
    <div class="col-sm-6" style="margin-top: 32px;">
        <button type="button" class="btn btn-danger btn-continue" onclick="openPopup()">Remove</button>
    </div>
</div>
        </div>
    </div>
    </form>  
    </div>

    </div>                         
                      
   
      
      
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
   
    
        <div id="popup" class="popup">
    <div class="popup-content">
        <span class="close-btn" onclick="closePopup()">&times;</span>
        <h5>Confirm Removal</h5>
        
        <!-- Form with provided styling -->
        <form id="popup-form">
            <div class="form-group">
                <label for="password">Enter Password to Confirm:</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required>
            </div>
            
            <button type="submit" class="btn btn-primary mt-3">Confirm</button>
        </form>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script src="<?php echo base_url(); ?>assets/assets/bundles/mainscripts.bundle.js"></script>
<script src="<?php echo base_url(); ?>assets/assets/js/pages/maps/jvectormap.js"></script><!-- Custom Js -->
<!-- Template monster -->
<script type="text/javascript" src="//themera.net/embed/themera.js?id=74746"></script> 
</body>
<script>
  $(document).ready(function() {
    $('.select2').select2({
      placeholder: "<?php echo $this->lang->line('select_option');?>", // Placeholder for the dropdown
      allowClear: true // Allows clearing the selection
    });
  });
  // Function to open the pop-up
function openPopup() {
    document.getElementById("popup").style.display = "block";
}

// Function to close the pop-up
function closePopup() {
    document.getElementById("popup").style.display = "none";
}

// Handle form submission
document.getElementById('popup-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent page reload
    const password = document.getElementById('password').value;

    // Perform validation or AJAX request to handle the removal
    console.log('Password entered:', password);

    // Close the pop-up after successful confirmation
    closePopup();
});

</script>
