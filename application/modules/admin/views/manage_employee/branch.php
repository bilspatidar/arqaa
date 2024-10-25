


<div class="row">
  <?php $this->load->view('includes/collapseAddForm'); ?>
  
  <div class="col-12 grid-margin collapse show" id="collapseExample">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?></h4>
        <form class="form-sample" id="crudFormAddApiData" action="<?php echo API_DOMAIN; ?>api/branch/branch/add" method="POST">
          <p class="card-description">Add new</p>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Name</label>
                  <input type="text" class="form-control" name="name" />
                </div>
              </div>
            </div>
			<div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Site Phone</label>
                  <input type="text" class="form-control" name="branch_phone" />
                </div>
              </div>
            </div>
          </div>
		  <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Site Email</label>
                  <input type="text" class="form-control" name="branch_email" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Site Code</label>
                  <input type="text" class="form-control" name="side_code" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label">Country Name</label>
                  <select class="form-control select2" name="country_id" onchange="get_state(this.value)">
                    <option value="">Select Country</option>
                    <?php $get_country = $this->Internal_model->get_country();
                        foreach($get_country as $country) { ?> 
                        <option value="<?php echo $country->id;?>"><?php echo $country->name ;?></option>
                    <?php } ?>
                </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label">State Name</label>
                  <select class="form-control select2" name="state_id" id="state" onchange="get_city(this.value)">
                <option value="">Select Country First</option>
            </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label">City Name</label>
                  <select class="form-control select2" name="city_id" id="city">
                <option value="">Select State First</option>
            </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label">Area Name</label>
                  <input type="text" class="form-control" name="area_name" />
                </div>
              </div>
            </div>
			<div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Site Address</label>
                  <input type="text" class="form-control" name="branch_address" />
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Site Latt</label>
                  <input type="text" class="form-control" name="latt" />
                </div>
              </div>
            </div>
			<div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label">Site Lang</label>
                  <input type="text" class="form-control" name="lang" />
                </div>
              </div>
            </div>
          </div>
		  <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Site Location</label>
                  <input type="text" class="form-control" name="branch_location" />
                </div>
              </div>
            </div>
			<div class="col-md-6 mt-2">
              <div class="form-group">
                <label>File upload</label>
                <input type="file" name="branch_image" class="file-upload-default">
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control file-upload-info" name="branch_image" disabled placeholder="Upload Image">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
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

<div class="row">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/branch/branch_list" id="list_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/branch/branch/" id="delete_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/branch/branch_details" id="show_endpoint">
  <input type="hidden" value="admin/manage_employee/branch_edit" id="edit_page_name">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?> <?php $this->load->view('includes/collapseFilterForm'); ?></h4>
        

         <div class="collapse show" id="collapseExampleFilter">
        <form id="filterForm">
          <div class="row">
            <div class="col-md-3 form-group">
            <input type="text" id="filterName" name="name" placeholder="Name" class="form-control">
            </div>
            <div class="col-md-3 form-group">
            <select id="filterStatus" name="status" class="form-control">
            <option value="">Select Status</option>
            <option value="Active">Active</option>
            <option value="Deactive">Inactive</option>
            </select>
            </div>
            <div class="col-md-3 form-group">
            <?php $this->load->view('includes/filter_form_btn'); ?>
            </div>
           </div>
       </form> 
       </div>

        <div class="table-responsive">
          <table class="table table-dark  table-striped" id="api_response_table">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
				<th>Branch Phone</th>
				<th>Image</th>
                <th>Status</th>
                <th>Option</th>
              </tr>
            </thead>
            <tbody id="api_response_table_body">
            </tbody>
          </table>
        </div>
      
	  </div>
    </div>
  </div>
</div>


<script>
  function renderTableData(){
	 // alert('aaa');
    return [
                { "data": null, "render": function(data, type, row, meta) {
                    return meta.row + 1; // Adding 1 to meta.row to start from 1 instead of 0
                }},
                { "data": "name", "orderable": true  },
				{ "data": "branch_phone", "orderable": true  },
                { 
                    "data": "branch_image",
                    "render": function(data, type, row) {
                        return '<img src="' + data + '" alt="Image">';
                    }
                },
				{ 
                    "data": "status", "orderable": true,
                    "render": function(data, type, row) {
                        return renderStatusBtn(data, type, row)
                    }
                },
                { 
                    "data": null, 
                    "render": function(data, type, row) {
                      return renderOptionBtn(data, type, row)
                    }
                }
            ]
  }
</script> 