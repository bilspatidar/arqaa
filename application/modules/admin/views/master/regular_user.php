<div class="row">
 
  <?php $this->load->view('includes/collapseAddForm'); ?>
  
  <div class="col-12 grid-margin collapse show " id="collapseExample">
    <div class="card">
      <div class="card-body">
        <h3 class="card-title"><?php echo $page_title; ?></h3>
        <form class="form-sample" id="crudFormAddApiData" action="<?php echo API_DOMAIN; ?>api/user/company_user/add" method="POST">
          <p class="card-description texth2">Here we add new users and set permits.</p>
          <style>
  .image-upload {
    position: relative;
    display: inline-block;
    text-align: center;
  }

  .profile-image {
    width: 105px;
height: 99px;

gap: 0px;
border-radius: 24px 0px 0px 0px !important;
opacity: 0px;
    border-radius: 50%;
    object-fit: cover;
  }

  .upload-label {
    position: absolute;
    bottom: -20px;
    
    transform: translateX(-50%);
    background-color: #2d79e6;
    color: white;
    padding: 10px;
    border-radius: 20px;
    cursor: pointer;
  }

  .upload-input {
    display: none;
  }

  .upload-label:hover {
    background-color: #1a5ba0;
  }
</style>
          <div class="image-upload">
  <img src="https://s3-alpha-sig.figma.com/img/9228/9e8f/500399fc590c34f44efe20fdedc977ea?Expires=1733097600&Key-Pair-Id=APKAQ4GOSFWCVNEHN3O4&Signature=C4jIA-~NPYHTVLjsEMrfVS340NpyJSIMwZYLU6sa4nzaaU3sgjseCrYJ1a1DSxJRhyYvdAyO~idcr8FjtQks6wArcEX9DHf6DpZOrSeIBxrKlT6joq1pQTK3uf~oa68T8WfoWkQvTtQTjHZOF1HNYfgiIDU4wbTvYT7KnPpprC-zWBE68uSNY180Ya5L1W852mvQmW-RIKuhMbpBr1JPQc9WOkPNfweSXu-5ZLChsprOjyYKtA5MqMNKAZiPWejMhfoSpfUQwNfV7iIMdsApjfOJ3yhZb~a1Z0bnUNSJZY4jOi4LsaTM6MIyzdjc9h0IrtcTuUN59OiT0Pi6oZNebg__" alt="Profile Image" class="profile-image">
  <label for="image-upload" class="upload-label">
    <input type="file" id="image-upload" class="upload-input" />
    <span><i class="icon-note"></i></span>
  </label>
</div>
<br><br>
          <div class="row">
            
          <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('name');?></label>
                  <input type="text" class="form-control" name="name" />
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('last_name');?></label>
                  <input type="text" class="form-control" name="last_name" />
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('role');?></label>
				  <select name="guy" class="form-control select2" >
				  <option value=""><?php echo $this->lang->line('select_option');?></option>
				  <?php $get_types = $this->Common->getUserRole('internal');
				  foreach($get_types as $get_type) { ?>
				  <option value="<?php echo $get_type->slug;?>"><?php echo $get_type->name;?></option>
				  <?php } ?>
				  </select>
                </div>
              </div>
            </div>
            <!-- <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('date_of_birth');?></label>
                  <input data-provide="datepicker" name="date_of_birth" data-date-autoclose="true" class="form-control">

                </div>
              </div>
            </div> -->

            <!-- <div class="col-md-4">
               <div class="form-group row">
        <div class="col-sm-12">
            <label class="col-form-label"><?php echo $this->lang->line('country'); ?></label>
            <select name="country_id" id="country_id" class="form-control select2" onchange="getStates(this.value)">
                <option value=""><?php echo $this->lang->line('select_option'); ?></option>
                <?php $countrys = $this->Internal_model->get_country();
                foreach ($countrys as $country) { ?>
                    <option value="<?php echo $country->id; ?>"><?php echo $country->name; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
</div> -->

<!-- <div class="col-md-4">
    <div class="form-group row">
        <div class="col-sm-12">
            <label class="col-form-label"><?php echo $this->lang->line('state'); ?></label>
            <select name="state_id" id="state_id" class="form-control select2">
                <option value=""><?php echo $this->lang->line('select_option'); ?></option>
            </select>
        </div>
    </div>
</div> -->

            
            <!-- <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('cologne');?></label>
                  <input type="text" class="form-control" name="cologne" />
                </div>
              </div>
            </div> -->
            <!-- <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('street');?></label>
                  <input type="text" class="form-control" name="street" />
                </div>
              </div>
            </div> -->
            <!-- <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('crossings');?></label>
                  <input type="text" class="form-control" name="crossings" />
                </div>
              </div>
            </div> -->

            <!-- <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('external_number');?></label>
                  <input type="text" class="form-control" name="external_number" />
                </div>
              </div>
            </div> -->
            <!-- <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('interior_number');?></label>
                  <input type="text" class="form-control" name="interior_number" />
                </div>
              </div>
            </div> -->
            <!-- <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('zip_code');?></label>
                  <input type="text" class="form-control" name="zip_code" />
                </div>
              </div>
            </div> -->
            <!-- <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('email');?></label>
                  <input type="email" class="form-control" name="email" />
                </div>
              </div>
            </div> -->

            <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('password');?></label>
                  <input type="text" class="form-control" name="password" />
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('confirm_password');?></label>
                  <input type="text" class="form-control" name="confirm_password" />
                </div>
              </div>
            </div>

            <!-- <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('mobile');?></label>
                  <input type="number" class="form-control" name="mobile" />
                </div>
              </div>
            </div>   -->

            <!-- <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('guy');?></label>
				  <select name="guy" class="form-control select2" >
				  <option value=""><?php echo $this->lang->line('select_option');?></option>
				  <?php $get_types = $this->Common->getUserRole('internal');
				  foreach($get_types as $get_type) { ?>
				  <option value="<?php echo $get_type->slug;?>"><?php echo $get_type->name;?></option>
				  <?php } ?>
				  </select>
                </div>
              </div>
            </div> -->

            <!-- <div class="col-md-4">
    <div class="form-group row">
        <div class="col-sm-12">
            <label class="col-form-label"><?php echo $this->lang->line('radius');?> (In Km)</label>
            <div class="form-control d-flex align-items-center justify-content-between">
                <button type="button" onclick="decrement()" class="btn">
                  
                </button>
                <output id="spinValue" role="spinbutton" aria-valuenow="2" class="mx-2">2</output>
                <input type="hidden" name="radius" id="value_of_spin" role="spinbutton" aria-valuenow="2" class="mx-2" value="2">
                <button type="button" onclick="increment()" class="btn">
                 
                </button>
            </div>
        </div>
    </div>
</div> -->

<!-- <div class="col-md-4">
        <div class="form-group row">
            <div class="col-sm-12">
                <label class="col-form-label"><?php echo $this->lang->line('languages');?></label><br>
                <select name="languages[]" class="form-control select2"  multiple>
                    <option  value=""><?php echo $this->lang->line('select_option');?></option>
                    <?php 
                    $get_languages = $this->Internal_model->get_languages();
                    foreach($get_languages as $get_language) { ?>
                        <option value="<?php echo $get_language->value;?>"><?php echo $get_language->value;?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div> -->
    <div class="col-md-4">
  <div class="form-group row">
    <div class="col-sm-12">
      <button type="button" class="btn btn-primary btn-continue d-flex justify-content-between align-items-center w-100" onclick="openPopup()">
        Set Permits
        <svg width="16" height="16" fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
          <path d="M12.146 7.854a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L10.293 8H3.5a.5.5 0 0 1 0-1h6.793L7.438 4.146a.5.5 0 1 1 .708-.708l4 4z"/>
        </svg>
      </button>
    </div>
  </div>
</div>

            

    </div>

          <div class="row ml-1">
            <div class="col-md-12">
              <div class="form-group row">
                <div class="col-sm-12">
                  <?php $this->load->view('includes/form_button'); ?>
                </div>
              </div>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
</div>

<div id="popup" class="popup">
    <div class="popup-content">
      <span class="close-btn" onclick="closePopup()">&times;</span>
      <h4 style="font-size:40px;">Set Permits</h4>
      <p class="text-white">Here we set permits of user.</p>
     

      <div class="permit-item">
  <label for="statistics">
    <span class="icon">📊</span>
    <div>
      <h4>Statistics</h4>
      <p class="ptext">See the analytics of user</p>
    </div>
  </label>
  <input type="checkbox" id="statistics" class="toggle-switch">
</div>

<div class="permit-item">
  <label for="price-control">
    <span class="icon">💰</span>
    <div>
      <h4>Price Control</h4>
      <p class="ptext">See the analytics of user</p>
    </div>
  </label>
  <input type="checkbox" id="price-control" class="toggle-switch">
</div>

<div class="permit-item">
  <label for="create-remove">
    <span class="icon">👤</span>
    <div>
      <h4>Create / Remove Profile</h4>
      <p class="ptext">See the analytics of user</p>
    </div>
  </label>
  <input type="checkbox" id="create-remove" class="toggle-switch">
</div>

<div class="permit-item">
  <label for="reported-profiles">
    <span class="icon">🚨</span>
    <div>
      <h4>Reported Profiles</h4>
      <p class="ptext">See the analytics of user</p>
    </div>
  </label>
  <input type="checkbox" id="reported-profiles" class="toggle-switch">
</div>

<div class="permit-item">
  <label for="manage-categories">
    <span class="icon">📂</span>
    <div>
      <h4>Manage Categories / Subcategories</h4>
      <p class="ptext">See the analytics of user</p>
    </div>
  </label>
  <input type="checkbox" id="manage-categories" class="toggle-switch">
</div>

<div class="permit-item">
  <label for="edit-country">
    <span class="icon">🌍</span>
    <div>
      <h4>Edit Country / Delete</h4>
      <p class="ptext">See the analytics of user</p>
    </div>
  </label>
  <input type="checkbox" id="edit-country" class="toggle-switch">
</div>

<div class="permit-item">
  <label for="open-country">
    <span class="icon">🌏</span>
    <div>
      <h4>Open a Country</h4>
      <p class="ptext">See the analytics of user</p>
    </div>
  </label>
  <input type="checkbox" id="open-country" class="toggle-switch">
</div>
<div class="permit-item">
  <label for="open-country">
    <span class="icon">🌏</span>
    <div>
      <h4>Manage News</h4>
      <p class="ptext">See the analytics of user</p>
    </div>
  </label>
  <input type="checkbox" id="open-country" class="toggle-switch">
</div>

<div class="permit-item">
  <label for="remove-reviews">
    <span class="icon">📝</span>
    <div>
      <h4>Remove Reviews</h4>
      <p class="ptext">See the analytics of user</p>
    </div>
  </label>
  <input type="checkbox" id="remove-reviews" class="toggle-switch">
</div>

<div class="permit-item">
  <label for="edit-subscribers">
    <span class="icon">👥</span>
    <div>
      <h4>Edit Subscribers Profile</h4>
      <p class="ptext">See the analytics of user</p>
    </div>
  </label>
  <input type="checkbox" id="edit-subscribers" class="toggle-switch">
</div>

<div class="permit-item">
  <label for="income-report">
    <span class="icon">📈</span>
    <div>
      <h4>Income Report</h4>
      <p class="ptext">See the analytics of user</p>
    </div>
  </label>
  <input type="checkbox" id="income-report" class="toggle-switch">
</div>

    </div>
  </div>
 
           
    

</div>
</div>
<style>

    /* Popup styling */
    .popup {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

    .popup-content {
      background-color: #22252a;
      padding: 20px 30px;
      border-radius: 8px;
      overflow-y: auto;
      max-height: 500px; /* Set the max height for the permit items container */

      max-width: 800px;
      width: 90%;
      position: relative;
      color: #fff;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
    }

    .popup-content h3 {
      margin: 0 0 15px;
      font-size: 24px;
      color: #fff;
    }

    .popup-content p {
      font-size: 14px;
      color: #bbb;
      margin-bottom: 20px;
    }

    /* Close button */
    .close-btn {
      position: absolute;
      top: 10px;
      right: 15px;
      font-size: 20px;
      color: #fff;
      cursor: pointer;
    }

    /* Permit item styling */
    .permit-item {
      display: flex;
      justify-content: space-between;
    }

    .permit-item label {
      display: flex;
      align-items: center;
      gap: 10px;
      cursor: pointer;
    }

    .permit-item h4 {
      margin: 0;
      font-size: 16px;
      color: #fff;
    }

    .permit-item .ptext {
      font-size: 12px;
      color: #aaa;
    }

    .icon {
      font-size: 20px;
      color: #4caf50;
    }

    /* Toggle switch styling */
    .toggle-switch {
      width: 40px;
      height: 20px;
      -webkit-appearance: none;
      appearance: none;
      background-color: #555;
      border-radius: 50px;
      position: relative;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .toggle-switch:checked {
      background-color: #2D79E6;
    }

    .toggle-switch:before {
      content: '';
      position: absolute;
      top: 2px;
      left: 2px;
      width: 16px;
      height: 16px;
      background-color: white;
      border-radius: 50%;
      transition: left 0.3s;
    }

    .toggle-switch:checked:before {
      left: 22px;
    }

    /* Continue button */
    .btn-continue {
      display: inline-block;
      color: #fff;
      border: none;
      padding: 7px 20px;
      margin-top: 35px;
      font-size: 14px;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

   
  </style>
<!-- JavaScript -->


<div class="row">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/user/company_user_list/<?php echo $role;?>" id="list_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/user/company_user/" id="delete_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/user/company_user_details" id="show_endpoint">
  <input type="hidden" value="admin/master/company_user_edit" id="edit_page_name">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card"style="display:none;">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?> <?php $this->load->view('includes/collapseFilterForm'); ?></h4>
        

         <div class="collapse show" id="collapseExampleFilter">
        <form id="filterForm">
          <div class="row">
            <div class="col-md-3 form-group">
            <input type="text" id="filterName" name="name" placeholder="<?php echo $this->lang->line('name');?>" class="form-control">
            </div>
            <!--<div class="col-md-3 form-group">
            <select id="filterStatus" name="status" class="form-control">
            <option value=""><?php echo $this->lang->line('select_status');?></option>
            <option value="Active"><?php echo $this->lang->line('active');?></option>
            <option value="Deactive"><?php echo $this->lang->line('inactive');?></option>
            </select>
            </div>-->
            <div class="col-md-3 form-group">
            <?php $this->load->view('includes/filter_form_btn'); ?>
            </div>
           </div>
       </form> 
       </div>

        <div class="table-responsive">
        <table class="table table-hover js-basic-example dataTable table-custom spacing5 " id="api_response_table">

            <thead>
              <tr>
                <th>#</th>
                <th><?php echo $this->lang->line('name');?></th>
                <th><?php echo $this->lang->line('last_name');?></th>
                <th><?php echo $this->lang->line('email');?></th>
                <th><?php echo $this->lang->line('cellular');?></th>
                <th><?php echo $this->lang->line('status');?></th>
                <th><?php echo $this->lang->line('Action');?></th>
              </tr>
            </thead>
            <tbody id="api_response_table_body dataTables_paginate">
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function renderTableData(){
    return [
      {
        "data": null,
        "render": function(data, type, row, meta) {
          return meta.row + 1;
        }
      },
      { "data": "name", "orderable": true },
      { "data": "last_name", "orderable": true },
      { "data": "email", "orderable": true },
      { "data": "mobile", "orderable": true },
      {
        "data": "status",
        "orderable": true,
        "render": function(data, type, row) {
          return renderStatusBtn(data, type, row);
        }
      },
     
      {
        "data": null,
        "render": function(data, type, row) {
          return renderOptionBtn(data, type, row);
        }
      }
    ];
  }
</script>
<script>
    let currentValue = 2; // Initial value

    function updateOutput() {
        document.getElementById('spinValue').textContent = currentValue;
		$("#value_of_spin").val(currentValue);
    }

    function increment() {
        if (currentValue < 1000) {
            currentValue++;
            updateOutput();
        }
    }

    function decrement() {
        if (currentValue > 1) {
            currentValue--;
            updateOutput();
        }
    }
    function increment() {
    let spinValue = document.getElementById('spinValue');
    let hiddenInput = document.getElementById('value_of_spin');
    let currentValue = parseInt(spinValue.innerText);
    spinValue.innerText = currentValue + 1;
    hiddenInput.value = currentValue + 1; // Update the hidden input
}

function decrement() {
    let spinValue = document.getElementById('spinValue');
    let hiddenInput = document.getElementById('value_of_spin');
    let currentValue = parseInt(spinValue.innerText);
    if (currentValue > 1) { // Prevent decrementing below 1
        spinValue.innerText = currentValue - 1;
        hiddenInput.value = currentValue - 1; // Update the hidden input
    }
}

</script>
<script>
    // Function to open the popup
    function openPopup() {
        document.getElementById("popup").style.display = "flex"; // Use 'flex' to center the content
    }

    // Function to close the popup
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