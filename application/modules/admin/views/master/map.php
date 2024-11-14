<link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/css/site.min.css">

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/vendor/jvectormap/jquery-jvectormap-2.0.3.css"/>
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/assets/css/site.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<style>

.form-container {
        display: flex;
       
        margin-left: 50px; /* Adds margin from the left */
        margin-top: 20px; /* Optional: Add some margin from the top */
    }

    .col-md-4 {
        flex: 1;
    }

.select2-container .select2-selection--single {
    height: 36px !important;

}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #fd7e14;
    line-height: 28px;
}
  /* Select2 container background for single selection */
.select2-container--default .select2-selection--single {
  background-color: #22252a; /* Dark background color */
  color: #fd7e14; /* Text color */
  border-color: #555; /* Border color */
  
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
}/* Pop-up styling */
.popup {
    display: none; /* Hidden by default */
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);  /* Centering the pop-up */
    background-color: #000; /* White background */
    border-radius: 5px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 80%;  /* Responsive width, 80% of the viewport */
    max-width: 400px;  /* Maximum width */
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

/* Responsive Design for Smaller Screens */
@media (max-width: 576px) {
    .popup {
        width: 90%;  /* More width on small screens */
        max-width: 300px;  /* Set a smaller max width */
    }

    .popup-content {
        font-size: 12px;  /* Smaller text on small screens */
    }
}
/* Additional form styling */


.popup .form-group {
    margin-bottom: 20px;
}
.popup .form-lable {
    margin-bottom: 20px;
}

.popup input[type="password"] {
    width: 100%; /* Full-width input */
    padding: 10px;
    border: 1px solid #fff;
    border-radius: 3px;
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

<?php 
 $users_id = getUser('id');
 $UserDetails = $this->Internal_model->getUserDetails($users_id) ;?>
<body class="theme-orange">
    

    
    <div class="sidebar-scroll">
        <!-- User Account Section -->
        <div class="user-account text-center">
            <div class="user_div">
                <img src="<?php echo $UserDetails[0]->profile_pic;?>" class="user-photo img-fluid rounded-circle" alt="User Profile Picture">
            </div>
            <div class="dropdown mt-3">
                <span>Welcome,</span>
                <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong><?php echo $UserDetails[0]->name;?></strong></a>
                
            </div>
            <a href="<?php echo base_url();?>admin/master/add_user" class="btn btn-sm btn-block btn-primary btn-round mt-3" title=""><i class="icon-plus mr-1"></i> Create New</a>
        </div>
<div class="container-fluid">
    <div class="row clearfix">
        <!-- Custom form container with flexbox and space between columns -->
        <div class="form-container">
        <div class="col-md-4">
                <div class="form-group row">
                    <label class="col-form-label">Delete A <?php echo $this->lang->line('country'); ?></label>

                    <div class="col-sm-12 mt-2">
                        <select name="country_id" id="country_id_delete" class="form-control select2" onchange="getStates(this.value)">
                            <option value=""><?php echo $this->lang->line('select_option'); ?></option>
                            <?php 
                            $countrys = $this->Internal_model->get_country();
                            foreach ($countrys as $country) { ?>
                                <option value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

        <div class="col-md-4">
    <div class="form-group row">
        <label class="col-form-label">Open A <?php echo $this->lang->line('country'); ?></label>
        
        <div class="col-sm-12 mt-2">
            <select name="country_id" id="country_id_open" class="form-control select2" onchange="openPopup()">
                <option value=""><?php echo $this->lang->line('select_option'); ?></option>
                <?php 
                $countrys = $this->Internal_model->get_country();
                foreach ($countrys as $country) { ?>
                    <option value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>

<!-- Pop-up (Initially hidden) -->
<div id="popup" class="popup">
        <span class="close-btn" onclick="closePopup()">&times;</span>
 
        
        <!-- Form inside the pop-up -->
        <form id="popup-form">
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control mt-2" placeholder="Enter password" required>
            </div>
            
            <button type="submit" class="btn btn-primary mt-3">Submit</button>
        </form>
</div>


<!-- Small pop-up next to the dropdown -->


          
        </div>

        <!-- Map Section -->
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card" style="height: 88%;">
                <div class="header">
                    <h2>World Map</h2>
                </div>
                <div class="body">
                    <div id="world-map-markers" class="jvector-map"></div>
                </div>
            </div>
        </div>
    </div>
</div>
    
<!-- Javascript -->

<script>
    // Function to open the pop-up
function openPopup() {
    document.getElementById("popup").style.display = "block";
}

// Function to close the pop-up
function closePopup() {
    document.getElementById("popup").style.display = "none";
}

</script>
<script src="<?php echo base_url(); ?>assets/assets/bundles/libscripts.bundle.js"></script>
<script src="<?php echo base_url(); ?>assets/assets/bundles/jvectormap.bundle.js"></script> <!-- JVectorMap Plugin Js -->
<script src="<?php echo base_url(); ?>assets/assets/js/pages/maps/jvectormap.js"></script><!-- Custom Js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
    // Initialize select2 for both dropdowns
    $('#country_id_open').select2({
      placeholder: "<?php echo $this->lang->line('select_option'); ?>", // Placeholder for the dropdown
      allowClear: true // Allows clearing the selection
    });

    $('#country_id_delete').select2({
      placeholder: "<?php echo $this->lang->line('select_option'); ?>", // Placeholder for the dropdown
      allowClear: true // Allows clearing the selection
    });
  });
</script>
</body>
