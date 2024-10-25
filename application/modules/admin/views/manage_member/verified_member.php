<div class="row">
  <?php $this->load->view('includes/collapseAddForm'); ?>
  
  <div class="col-12 grid-margin collapse show" id="collapseExample">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?></h4>
        <form class="form-sample" id="crudFormAddApiData" action="<?php echo API_DOMAIN; ?>api/employee/employee/add" method="POST">
          <p class="card-description">Add new</p>
          <div class="row">
          <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> First Name</label>
                  <input type="text" class="form-control" name="first_name"/>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Last Name</label>
                  <input type="text" class="form-control" name="last_name"/>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Email</label>
                  <input type="text" class="form-control" name="email" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Mobile</label>
                  <input type="text" class="form-control" name="mobile" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Alt Mobile</label>
                  <input type="text" class="form-control" name="alt_mobile" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Password</label>
                  <input type="text" class="form-control" name="password" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> User Type</label>
                  <input type="text" class="form-control" name="user_type" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Father Name</label>
                  <input type="text" class="form-control" name="father_name" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Mother Name</label>
                  <input type="text" class="form-control" name="mother_name" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Dob</label>
                  <input type="date" class="form-control" name="dob" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Doj</label>
                  <input type="text" class="form-control" name="doj" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Country Id</label>
                  <input type="text" class="form-control" name="country_id" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> State Id</label>
                  <input type="text" class="form-control" name="state_id" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> City Id</label>
                  <input type="text" class="form-control" name="city_id" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Street Address</label>
                  <input type="text" class="form-control" name="street_address" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Street Address2</label>
                  <input type="text" class="form-control" name="street_address2" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Profile Pic</label>
                <input type="file" name="profile_pic" class="file-upload-default">
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control file-upload-info" name="profile_pic" disabled placeholder="Upload Image">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Address Proof</label>
                <input type="file" name="address_proof" class="file-upload-default">
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control file-upload-info" name="address_proof" disabled placeholder="Upload Image">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Id Proof</label>
                <input type="file" name="id_proof" class="file-upload-default">
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control file-upload-info" name="id_proof" disabled placeholder="Upload Image">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Business Signature</label>
                <input type="file" name="businessSignature" class="file-upload-default">
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control file-upload-info" name="businessSignature" disabled placeholder="Upload Image">
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
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/employee/employee_list" id="list_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/employee/employee/" id="delete_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/employee/employee_details" id="show_endpoint">
  <input type="hidden" value="admin/manage_member/verified_member_edit" id="edit_page_name">
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
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Alt Mobile</th>
                <th>User Type</th>
                <th>Father Name</th>
                <th>Mother Name</th>
                <th>Dob</th>
                <th>Doj</th>
                <th>Country Id</th>
                <th>State Id</th>
                <th>City Id</th>
                <th>Street Address</th>
                <th>Street Address2</th>
                <th>Profile Pic</th>
                <th>Address Proof</th>
                <th>Id Proof</th>
                <th>Business Signature</th>
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
    return [
                { "data": null, "render": function(data, type, row, meta) {
                    return meta.row + 1; // Adding 1 to meta.row to start from 1 instead of 0
                }},
                { "data": "first_name", "orderable": true  },
                { "data": "last_name", "orderable": true },
                { "data": "email", "orderable": true },
                { "data": "mobile", "orderable": true },
                { "data": "alt_mobile", "orderable": true },
                { "data": "user_type", "orderable": true },
                { "data": "father_name", "orderable": true },
                { "data": "mother_name", "orderable": true },
                { "data": "dob", "orderable": true },
                { "data": "doj", "orderable": true },
                { "data": "country_id", "orderable": true },
                { "data": "state_id", "orderable": true },
                { "data": "city_id", "orderable": true },
                { "data": "street_address", "orderable": true },
                { "data": "street_address2", "orderable": true },
                { 
                    "data": "profile_pic",
                    "render": function(data, type, row) {
                        return '<img src="' + data + '" alt="profile_pic">';
                    }
                },
                { 
                    "data": "address_proof",
                    "render": function(data, type, row) {
                        return '<img src="' + data + '" alt="address_proof">';
                    }
                },
                { 
                    "data": "id_proof",
                    "render": function(data, type, row) {
                        return '<img src="' + data + '" alt="id_proof">';
                    }
                },
                { 
                    "data": "businessSignature",
                    "render": function(data, type, row) {
                        return '<img src="' + data + '" alt="businessSignature">';
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