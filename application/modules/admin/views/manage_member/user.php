<div class="row">
  <?php $this->load->view('includes/collapseAddForm'); ?>
  
  <div class="col-12 grid-margin collapse show" id="collapseExample">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?></h4>
        <form class="form-sample" id="crudFormAddApiData" action="<?php echo API_DOMAIN; ?>api/employee/user/add" method="POST">
          <p class="card-description">Add new</p>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label">Employee First Name</label>
                  <input type="text" class="form-control" name="first_name" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Employee Last Name</label>
                  <input type="text" class="form-control" name="last_name" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                <label class="col-form-label">Gender</label>
                  <select class="form-control" name="gender">
                     <option value="male">Male</option>
                     <option value="female">Female</option>
                     <option value="other">Other</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                <label class="col-form-label">User Type</label>
                  <select class="form-control" name="user_type">
                    <?php $getUserRole = $this->Internal_model->getUserRole();
                    foreach ($getUserRole as $user) { ?>
                     <option value="<?php echo $user->slug ;?>"><?php echo $user->name ;?></option>
                     <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> DOB (As per Aadhar Card )</label>
                  <input type="date" class="form-control" name="dob" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Mobile No</label>
                  <input type="number" class="form-control" name="mobile" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Alternate Mob No</label>
                  <input type="number" class="form-control" name="alt_mobile" />
                </div>
              </div>
            </div>
           
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label">Password</label>
                  <input type="password" class="form-control" name="password" />
                </div>
              </div>
            </div>
            <div class="col-md-6 mt-2">
              <div class="form-group">
                <label>Passport Photo</label>
                <input type="file" name="passport_photo" class="file-upload-default">
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control file-upload-info" name="passport_photo" disabled placeholder="Upload Copy">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-md-6 mt-2">
              <div class="form-group">
                <label>Resume</label>
                <input type="file" name="resume" class="file-upload-default">
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control file-upload-info" name="resume" disabled placeholder="Upload Copy">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                  </span>
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
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/employee/employee_joining_list" id="list_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/employee/employee_joining/" id="delete_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/employee/employee_joining_details" id="show_endpoint">
  <input type="hidden" value="admin/manage_member/user_edit" id="edit_page_name">
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
                <th>Employee Name</th>
                <th>Employee Code</th>
                <th>Gender</th>
                <th>DOB</th>
                <th>Mobile NO</th>
                <th>Email</th>
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
    var dpsCode = <?php echo json_encode($this->Internal_model->getDPSCode()); ?>;
    return [
                { "data": null, "render": function(data, type, row, meta) {
                    return meta.row + 1; // Adding 1 to meta.row to start from 1 instead of 0
                }},
                { "data": "first_name", "orderable": true  },
                {  "data": "employee_code",  "orderable": true, 
                  "render": function(data, type, row) { return dpsCode + ' ' + data; } },
                { "data": "gender", "orderable": true  },
                { "data": "dob", "orderable": true },
                { "data": "mobile", "orderable": true },
                { "data": "email", "orderable": true },
                // { 
                    // "data": "image",
                    // "render": function(data, type, row) {
                        // return '<img src="' + data + '" alt="Image">';
                    // }
                // },
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