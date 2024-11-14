<div class="row">
  
  <div class="col-12 grid-margin collapse show" id="collapseExample">
    <div class="card"style="display:none;">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?></h4>
        <form class="form-sample" id="crudFormAddApiData" action="<?php echo API_DOMAIN; ?>api/user/company_user/add" method="POST">
          <p class="card-description"><?php echo $this->lang->line('add_new');?></p>
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
                  <label class="col-form-label"><?php echo $this->lang->line('date_of_birth');?></label>
                  <input data-provide="datepicker" name="date_of_birth" data-date-autoclose="true" class="form-control">

                </div>
              </div>
            </div>


            

            <div class="col-md-4">
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
</div>

<div class="col-md-4">
    <div class="form-group row">
        <div class="col-sm-12">
            <label class="col-form-label"><?php echo $this->lang->line('state'); ?></label>
            <select name="state_id" id="state_id" class="form-control select2">
                <option value=""><?php echo $this->lang->line('select_option'); ?></option>
            </select>
        </div>
    </div>
</div>

            
            <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('cologne');?></label>
                  <input type="text" class="form-control" name="cologne" />
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('street');?></label>
                  <input type="text" class="form-control" name="street" />
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('crossings');?></label>
                  <input type="text" class="form-control" name="crossings" />
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('external_number');?></label>
                  <input type="text" class="form-control" name="external_number" />
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('interior_number');?></label>
                  <input type="text" class="form-control" name="interior_number" />
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('zip_code');?></label>
                  <input type="text" class="form-control" name="zip_code" />
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('email');?></label>
                  <input type="email" class="form-control" name="email" />
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('password');?></label>
                  <input type="password" class="form-control" name="password" />
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('confirm_password');?></label>
                  <input type="password" class="form-control" name="confirm_password" />
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('mobile');?></label>
                  <input type="number" class="form-control" name="mobile" />
                </div>
              </div>
            </div>  

            <div class="col-md-4">
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
            </div>

            <div class="col-md-4">
    <div class="form-group row">
        <div class="col-sm-12">
            <label class="col-form-label"><?php echo $this->lang->line('radius');?> (In Km)</label>
            <div class="form-control d-flex align-items-center justify-content-between">
                <button type="button" onclick="decrement()" class="btn">
                    <!-- SVG for decrement -->
                </button>
                <output id="spinValue" role="spinbutton" aria-valuenow="2" class="mx-2">2</output>
                <input type="hidden" name="radius" id="value_of_spin" role="spinbutton" aria-valuenow="2" class="mx-2" value="2">
                <button type="button" onclick="increment()" class="btn">
                    <!-- SVG for increment -->
                </button>
            </div>
        </div>
    </div>
</div>

<div class="col-md-4">
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

<div class="row">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/user/company_user_list/<?php echo $role;?>" id="list_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/user/company_user/" id="delete_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/user/company_user_details" id="show_endpoint">
  <input type="hidden" value="admin/master/company_user_edit" id="edit_page_name">
  <input type="hidden" value="admin/master/user_permission" id="permission_page_name">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
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
                <th><?php echo $this->lang->line('permision');?></th>
                <th><?php echo $this->lang->line('profile_details');?></th>
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
          return renderPermisionBtn(data, type, row);
        }
      },
      {
        "data": null,
        "render": function(data, type, row) {
          return renderviewBtn(data, type, row);
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
