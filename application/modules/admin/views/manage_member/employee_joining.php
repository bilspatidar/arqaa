<div class="row">
  <?php $this->load->view('includes/collapseAddForm'); ?>
  
  <div class="col-12 grid-margin collapse show" id="collapseExample">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?></h4>
        <form class="form-sample" id="crudFormAddApiData" action="<?php echo API_DOMAIN; ?>api/employee/employee_joining/add" method="POST">
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
                   <label class="col-form-label">Blood Group</label>
                   <select class="form-control" name="blood_group">
                       <option value="A+">A+</option>
                       <option value="A-">A-</option>
                       <option value="B+">B+</option>
                       <option value="B-">B-</option>
                       <option value="AB+">AB+</option>
                       <option value="AB-">AB-</option>
                       <option value="O+">O+</option>
                       <option value="O-">O-</option>
                   </select>
             </div>
           </div>
         </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Identification Mark</label>
                  <input type="text" class="form-control" name="identification_mark" />
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
                  <label class="col-form-label">Email Id</label>
                  <input type="email" class="form-control" name="email" />
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
                <label> Profile </label>
                <input type="file" name="profile_pic" class="file-upload-default">
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control file-upload-info" name="profile_pic" disabled placeholder="Upload Copy">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label">Aadhar Card No</label>
                  <input type="number" class="form-control" name="aadhar_no" />
                </div>
              </div>
            </div>
            <div class="col-md-6 mt-2">
              <div class="form-group">
                <label>Aadhar Card Front</label>
                <input type="file" name="aadhar_front" class="file-upload-default">
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control file-upload-info" name="aadhar_front" disabled placeholder="Photo Upload Aadhar Card">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-md-6 mt-2">
              <div class="form-group">
                <label>Aadhar Card Back</label>
                <input type="file" name="aadhar_back" class="file-upload-default">
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control file-upload-info" name="aadhar_back" disabled placeholder="Photo Upload Aadhar Card">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label">Any Other Identity</label>
                  <select class="form-control" name="id_proof">
                     <option value="voter_id">Voter Id</option>
                     <option value="Pan_card">Pan Card</option>
                     <option value="passport">Passport</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label">Permanent Address</label>
                  <input type="text" class="form-control" name="permanent_address" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label">District</label>
                  <input type="text" class="form-control" name="district" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                   <label class="col-form-label">Country</label>
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
                   <label class="col-form-label">State</label>
                  <select name="state_id" class="form-control state_html">
                  <option value="">Select Country First</option>
                    </select>
             </div>
          </div>
        </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Pincode</label>
                  <input type="number" class="form-control" name="pincode" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Present Address</label>
                  <input type="text" class="form-control" name="present_address"/>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> District</label>
                  <input type="text" class="form-control" name="present_district" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                   <label class="col-form-label">State</label>
                   <select name="present_state_id" class="form-control state_html">
                    <option value="">Select Country First</option>
                    </select>
             </div>
          </div>
        </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Pincode</label>
                  <input type="number" class="form-control" name="present_pincode" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Bank Name</label>
                  <input type="text" class="form-control" name="bank_name" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Branch Name</label>
                  <input type="text" class="form-control" name="branch_name" />
                </div>
              </div>
            </div>  
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Account No</label>
                  <input type="number" class="form-control" name="account_no" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> IFSC Code</label>
                  <input type="text" class="form-control" name="ifsc_code" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Height</label>
                  <input type="text" class="form-control" name="height" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Weight</label>
                  <input type="text" class="form-control" name="weight" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Detail Of Arm</label>
                  <input type="text" class="form-control" name="detail_of_arm" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Arm Code</label>
                  <input type="text" class="form-control" name="arm_code" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> License No</label>
                  <input type="text" class="form-control" name="license_no" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Issue Date</label>
                  <input type="date" class="form-control" name="issue_date" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Expiry Date </label>
                  <input type="date" class="form-control" name="expiry_date" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Issue State</label>
                  <select name="issue_state_id" class="form-control select2 state_html">
                  <option value="">Select Country First</option>
                    </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Issue District</label>
                  <input type="text" class="form-control" name="issue_district" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Police Station</label>
                  <input type="text" class="form-control" name="police_station" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Case of Year</label>
                  <input type="text" class="form-control" name="case_of_year" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label">Court Name</label>
                  <input type="text" class="form-control" name="court_name" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Crime</label>
                  <input type="text" class="form-control" name="crime" />
                </div>
              </div>
            </div>
            <div class="col-md-6 mt-2">
              <div class="form-group">
                <label> Upload Copy</label>
                <input type="file" name="image" class="file-upload-default">
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control file-upload-info" name="image" disabled placeholder="Upload Copy">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Issue Date</label>
                  <input type="date" class="form-control" name="PV_issue_date" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Police Station</label>
                  <input type="text" class="form-control" name="PV_police_station" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> District</label>
                  <input type="text" class="form-control" name="PV_district" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label">State</label>
                  <select name="PV_state_id" class="form-control state_html select2">
                    <option value="">Select Country First</option>
                    </select>
                </div>
              </div>
            </div>
            <div class="col-md-6 mt-2">
              <div class="form-group">
                <label> Upload Copy</label>
                <input type="file" name="image" class="file-upload-default">
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control file-upload-info" name="image" disabled placeholder="Upload Copy">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                  </span>
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
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/employee/employee_joining_list" id="list_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/employee/employee_joining/" id="delete_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/employee/employee_joining_details" id="show_endpoint">
  <input type="hidden" value="admin/manage_member/employee_joining_edit" id="edit_page_name">
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
                <th>Gender</th>
                <th>DOB</th>
                <th>Mobile NO</th>
                <th>Email</th>
                <th>District</th>
                <th>State</th>
                <th>Pincode</th>
                <th>Image</th>
                <th>Status</th>
                <th>Option</th>
                <th>Print</th>
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
                { "data": "gender", "orderable": true  },
                { "data": "dob", "orderable": true },
                { "data": "mobile", "orderable": true },
                { "data": "email", "orderable": true },
                { "data": "district", "orderable": true  },
                { "data": "state_name", "orderable": true },
                { "data": "pincode", "orderable": true  }, 
                
                { 
                    "data": "image",
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
                },
                { 
                    "data": null, 
                    "render": function(data, type, row) {
                      return renderPrintButton(data, type, row)
                    }
                }
            ]
  }
  
  function renderPrintButton(data, type, row) {
    var userId = row.users_id; 
    return '<a href="<?php echo base_url();?>admin/manage_member/employee/' + userId + '">Print</a>';
}
 

  </script>