<div class="container-fluid">

  <div class="row">

  
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h3 class="card-title"><?php echo $page_title; ?> <?php $user_details = $this->session->userdata('user_details'); if (!empty($user_details) && isset($user_details['country_id'])) { echo $this->Common->get_col_by_key('countries','id',$user_details['country_id'],'name');  } ?> <?php $this->load->view('includes/collapseFilterForm'); ?></h3>
        <p class="texth2">Here we find all the data including incomes, revenue, expense and taxes...</p>

        <div class="collapse show" id="collapseExampleFilter">
          <form id="filterForm">
            <div class="row">
              <!-- Year Dropdown -->
              <input type="hidden" id="filterCountry" value="<?php echo $user_details['country_id']; ?>">
              <div class="col-md-2 form-group">
                  <?php $app_years = $this->Common->get_app_years(); 
                   $current_year  = date('Y');
                  ?>
                <div class="yearDropdown position-relative">
                  <select id="filterYear" class="form-control select2">
                    <option value="" disabled selected>Select Year</option>
                    <?php foreach($app_years as $year){ 
                     ?>
                     <option value="<?php echo $year->year; ?>" <?php if($year->year==$current_year){ echo'selected'; }?>><?php echo $year->year; ?></option>
                     <?php 
                    }?>
                  </select>
                </div>
              </div>

              <!-- Month Dropdown -->
              <?php $current_month = date('m');?>
              <div class="col-md-2 form-group">
                <div class="monthDropdown position-relative">
                  <select id="filterMonth" class="form-control select2">
                    <option value="" disabled selected>Select Month</option>
                    <option value="01" <?php if($current_month=='01'){ echo'selected';} ?>>January</option>
                    <option value="02" <?php if($current_month=='02'){ echo'selected';} ?>>February</option>
                    <option value="03" <?php if($current_month=='03'){ echo'selected';} ?>>March</option>
                    <option value="04" <?php if($current_month=='04'){ echo'selected';} ?>>April</option>
                    <option value="05" <?php if($current_month=='05'){ echo'selected';} ?>>May</option>
                    <option value="06" <?php if($current_month=='06'){ echo'selected';} ?>>June</option>
                    <option value="07" <?php if($current_month=='07'){ echo'selected';} ?>>July</option>
                    <option value="08" <?php if($current_month=='08'){ echo'selected';} ?>>August</option>
                    <option value="09" <?php if($current_month=='09'){ echo'selected';} ?>>September</option>
                    <option value="10" <?php if($current_month=='10'){ echo'selected';} ?>>October</option>
                    <option value="11" <?php if($current_month=='11'){ echo'selected';} ?>>November</option>
                    <option value="12" <?php if($current_month=='12'){ echo'selected';} ?>>December</option>
                  </select>
                </div>
              </div>

              <!-- Filter Button -->
              <div class="col-md-3 form-group">
                 <button type="button" class="btn btn-primary btn-continue" onclick="get_monthly_summury()">Submit</button>
              </div>
            </div>
          </form>
        </div>

<style scoped>


.normal-button {
  padding: 10px 20px;
  font-size: 16px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}
.icon-eye {
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 40px;  /* Adjust the icon size as needed */
}
.normal-button:hover {
  background-color: #0056b3;
}
</style>
        <style>

/* Modal Background */
.modal {
    display: none; 
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: auto;
    overflow: auto;
    padding-top: 60px;
    background-color: rgba(0, 0, 0, 0.5); /* Slightly darkened background */
}

/* Modal Content */
.modal-content {
    background-color: #22252a;
    margin: 5% auto;
    padding: 30px;
    border: 1px solid #22252a;
    width: 80%;
    max-width: 600px;
    border-radius: 10px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    animation: fadeIn 0.3s ease-out;
}

/* Fade-in Animation */
@keyframes fadeIn {
    0% { opacity: 0; }
    100% { opacity: 1; }
}

/* Close Button */
.close {
    color: #aaa;
    font-size: 30px;
    font-weight: bold;
    position: absolute;
    top: 15px;
    right: 20px;
}

.close:hover,
.close:focus {
    color: #000;
    cursor: pointer;
}

/* Form Styles */
.form-sample {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.col-form-label {
    font-weight: 600;
    color: #333;
}








</style>

      <style>
      .table.table-custom tbody tr {
            background: #383b3f !important;
            /* border-radius: .1875rem; */
      }
         
        .row-gap {
        margin-bottom: 8px; /* Row spacing if needed */
      }
          .card2{
      height: 150px;
      background-color:#383b3f;

          }
        .yearDropdown, .monthDropdown {
          display: flex;
          align-items: center;
          cursor: pointer;
          position: relative;
        }

        #yearInput {
          cursor: pointer;
          width: 100%;
        }

        .dropdownMenu {
          display: none;
          flex-direction: column;
          background-color: #fff;
          border: 1px solid #ddd;
          border-radius: 5px;
          padding: 10px;
          position: absolute;
          top: 100%;
          left: 0;
          z-index: 10;
          width: 100%;
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .dropdownMenu p {
          margin: 0;
          padding: 5px;
          cursor: pointer;
          font-size: 14px;
        }

        .dropdownMenu p:hover {
          background-color: #f0f0f0;
        }

        .btn-secendory {
          background-color: #383b3f;
          color: white;  /* Ensures the button text is white */
          border: 1px solid #383b3f;
        }

        .btn-secendory:hover {
          background-color: #2c2f33;
          border-color: #2c2f33;
        }
   

.card-section {
  background-color: #007bff; /* Primary Blue */
  border-radius: 10px;
  text-align: left;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

.card-section h3 {
  font-size: 1.5rem;
  font-weight: bold;
  margin-bottom: 10px;
}

.card-section h1 {
  font-size: 2.5rem;
  font-weight: bold;
}

@media (max-width: 768px) {
  .row {
    flex-direction: column;
  }
  .card-section {
    margin-bottom: 15px;
  }
}
    
</style>



        <div id="monthly_summury">
        </div>



<script>
  // Function to open the popup
function openPopup() {
    $("#costModalType").val('Fixed');
    document.getElementById("myModal").style.display = "flex";
}

// Function to close the popup
function closePopup() {
    document.getElementById("myModal").style.display = "none";
}

// Function to handle removal confirmation
function confirmRemoval() {
    alert("Item removed!");
    closePopup(); // Close the popup after confirmation
}

function openPopup1() {
    $("#costModalType").val('Variable');
    document.getElementById("myModal").style.display = "flex";
}

// Function to close the popup
function closePopup1() {
    document.getElementById("myModal").style.display = "none";
}

// Function to handle removal confirmation
function confirmRemoval1() {
    alert("Item removed!1");
    closePopup(); // Close the popup after confirmation
}

    function renderTableData() {
      return [
        { "data": "concept", "orderable": true },
        { "data": "cost", "orderable": true },
        { "data": "%", "orderable": true },
        { "data": "tax_concept", "orderable": true },
        { "data": "tax", "orderable": true },
      ];
    }

    function toggleDropdown() {
      const dropdownMenu = document.getElementById('dropdownMenu');
      dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    }

    function selectYear(year) {
      document.getElementById('yearInput').value = year;
      document.getElementById('dropdownMenu').style.display = 'none';
    }

    function filterDropdown() {
      const input = document.getElementById('yearInput').value.toUpperCase();
      const dropdownMenu = document.getElementById('dropdownMenu');
      const options = dropdownMenu.getElementsByTagName('p');

      for (let i = 0; i < options.length; i++) {
        const year = options[i].textContent || options[i].innerText;
        options[i].style.display = year.toUpperCase().indexOf(input) > -1 ? '' : 'none';
      }
    }
</script>

</div>

<!-- Modal Structure -->
<div id="myModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closePopup()">&times;</span>
        <h3 class="card-title">Add New</h3>
        <p class="texth2">Here you can fill up your monthly cost</p>

        <form class="form-sample" id="monthlyFixedCostForm" action="<?php echo API_DOMAIN; ?>api/expense/expense/add" method="POST">

            <input type="hidden" id="costModalType" name="cost_type" value="Fixed">
            <input type="hidden" name="country_id" value="<?php echo $user_details['country_id']; ?>">
            <input type="hidden" name="currency" value="<?php echo $this->Common->get_currency_by_country_user($user_details['country_id'],'country'); ?>">
            <input type="hidden" id="costMonth" name="month" value="<?php echo date('m');?>">
            <input type="hidden" id="costYear" name="year" value="<?php echo date('Y');?>">


            <!-- <h4 class="card-description"><?php echo $this->lang->line('add_new');?> </h4> -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $this->lang->line('concept');?></label>
                        <input type="text" class="form-control" name="concept" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $this->lang->line('cost');?> (<?php echo $this->Common->get_currency_by_country_user( $user_details['country_id'],'country');; ?>)</label>
                        <input type="number" step="any" class="form-control" name="amount" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $this->lang->line('%');?></label>
                        <input type="number" step="any" class="form-control" name="tax" value="<?php echo $this->Common->get_tax_by_country( $user_details['country_id'],'country'); ?>" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $this->lang->line('tax_concept');?></label>
                        <input type="text" class="form-control" name="tax_concept" />
                    </div>
                </div>
            </div>
            
            <div class="form-group">
            <button type="submit" class="btn btn-primary mr-2"><?php echo $this->lang->line('submit');?></button>
            <button class="btn btn-danger mr-2" type="reset"onclick="closePopup()"><?php echo $this->lang->line('cancel');?></button>
            </div>
        </form>
        <br>
    </div>
</div>

<div id="myModal1" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="close" onclick="closePopup1()">&times;</span>
        <h3 class="card-title">Add New</h3>
        <p class="texth2">Here you can fill up your monthly cost</p>

        <form class="form-sample" id="crudFormAddApiData" action="<?php echo API_DOMAIN; ?>api/category/category/add" method="POST">
            <!-- <h4 class="card-description"><?php echo $this->lang->line('add_new');?> </h4> -->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $this->lang->line('concept');?></label>
                        <input type="text" class="form-control" name="name"  />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $this->lang->line('cost');?></label>
                        <input type="text" class="form-control" name="Cost" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $this->lang->line('%');?></label>
                        <input type="text" class="form-control" name="%"  />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-form-label"><?php echo $this->lang->line('tax_concept');?></label>
                        <input type="text" class="form-control" name="tax_concept" />
                    </div>
                </div>
            </div>
            
            <div class="form-group">
            <button type="submit" class="btn btn-primary mr-2"><?php echo $this->lang->line('submit');?></button>
            <button class="btn btn-danger mr-2" type="reset"onclick="closePopup1()"><?php echo $this->lang->line('cancel');?></button>
            </div>
        </form>
        <br>
    </div>
</div>

