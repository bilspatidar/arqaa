<style>
    .card2{
height: 173px;
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
</style>

<div class="row">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/user/company_user_list/<?php echo $role;?>" id="list_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/user/company_user/" id="delete_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/user/company_user_details" id="show_endpoint">
  <input type="hidden" value="admin/master/company_user_edit" id="edit_page_name">
  
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h3 class="card-title"><?php echo $page_title; ?> <?php $this->load->view('includes/collapseFilterForm'); ?></h3>
        <p class="texth2">Here we find all the data including incomes, revenue, expense and taxes...</p>

        <div class="collapse show" id="collapseExampleFilter">
          <form id="filterForm">
            <div class="row">
              <!-- Year Dropdown -->
              <div class="col-md-2 form-group">
                <div class="yearDropdown position-relative">
                  <select id="yearSelect" class="form-control select2">
                    <option value="" disabled selected>Select Year</option>
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                    <option value="2022">2022</option>
                    <option value="2021">2021</option>
                    <option value="2020">2020</option>
                    <option value="2019">2019</option>
                    <option value="2018">2018</option>
                    <option value="2017">2017</option>
                    <option value="2016">2016</option>
                    <option value="2015">2015</option>
                  </select>
                </div>
              </div>

              <!-- Month Dropdown -->
              <div class="col-md-2 form-group">
                <div class="monthDropdown position-relative">
                  <select id="monthSelect" class="form-control select2">
                    <option value="" disabled selected>Select Month</option>
                    <option value="January">January</option>
                    <option value="February">February</option>
                    <option value="March">March</option>
                    <option value="April">April</option>
                    <option value="May">May</option>
                    <option value="June">June</option>
                    <option value="July">July</option>
                    <option value="August">August</option>
                    <option value="September">September</option>
                    <option value="October">October</option>
                    <option value="November">November</option>
                    <option value="December">December</option>
                  </select>
                </div>
              </div>

              <!-- Filter Button -->
              <div class="col-md-3 form-group">
                <?php $this->load->view('includes/filter_form_btn'); ?>
              </div>
            </div>
          </form>
        </div>

        <!-- Table and Content Section -->
        <div class="row">
          <!-- First Column (Table) -->
          <div class="col-md-5">
            <div class="table-responsive">
              <table class="table table-hover js-basic-example dataTable table-custom spacing5">
                <thead>
                  <tr>
                    <th><?php echo $this->lang->line('concept1'); ?></th>
                    <th><?php echo $this->lang->line('cost'); ?></th>
                    <th><?php echo $this->lang->line('%'); ?></th>
                    <th><?php echo $this->lang->line('tax_concept'); ?></th>
                    <th><?php echo $this->lang->line('tax'); ?></th>
                  </tr>
                </thead>
                <tbody id="api_response_table_body dataTables_paginate">
                  <!-- Data will be dynamically inserted here -->
                </tbody>
              </table>
              <button class="btn btn-secendory">+ Add New</button>
            </div>
          </div>

          <!-- Second Column (Empty) -->
          <div class="col-md-1">
            <!-- Empty or other content can go here -->
          </div>
          <!-- Third Column (Currency Dropdown) -->
          <div class="col-md-2 mt-3">
            
                <h5 class=""><?php echo $this->lang->line('currency'); ?></h5>
                <select name="currency" class="form-control select2">
                  <option value=""><?php echo $this->lang->line('select_option'); ?></option>
                  <?php
                    $get_currencys = $this->Internal_model->get_currency();
                    foreach ($get_currencys as $get_currency) { ?>
                      <option value="<?php echo $get_currency->symbol; ?>"><?php echo $get_currency->name; ?> (<?php echo $get_currency->symbol; ?>)</option>
                  <?php } ?>
                </select>
              
          </div>
          <div class="col-md-1">
            <!-- Empty or other content can go here -->
          </div>
          <div class="col-md-3 mt-3">
  <h5 class="texth2 fs-2"><?php echo $this->lang->line('total'); ?></h5>
  <div class="card card2">
    <div class="table-responsive">
      <table class="table  table-striped texth2 text-bold">
        
        <tbody>
          <!-- Static Data -->
          <tr class="text-primary ">
            <td>Subtotal</td>
            <td>$500</td>
          </tr>
          <tr>
            <td>Total without taxes</td>
            <td>$450</td>
          </tr>
          <tr>
            <td>Tax (21%) Non food</td>
            <td>$50</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>


        </div>

      </div>
    </div>
  </div>
</div>

<script>
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
