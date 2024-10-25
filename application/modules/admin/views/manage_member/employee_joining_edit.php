<div class="modal_title_details"><h4>Edit Employee Joining </h4></div>
<form id="crudFormUpdateApiData" action="<?php echo API_DOMAIN; ?>api/employee/employee_joining/update" method="POST" class="row g-3">
	<input type="hidden" name="id" class="form-control" value="<?php echo $data['id']; ?>"> 
	<input type="hidden" name="users_id" class="form-control" value="<?php echo $data['users_id']; ?>">
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Employee First Name</label>
		<input type="text" name="first_name" class="form-control" value="<?php echo $data['first_name']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Employee Last Name</label>
		<input type="text" name="last_name" class="form-control" value="<?php echo $data['last_name']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Father Name</label>
		<input type="text" name="father_name" class="form-control" value="<?php echo $data['father_name']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Mother Name</label>
		<input type="text" name="mother_name" class="form-control" value="<?php echo $data['mother_name']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
    <label for="" class="form-label">Gender</label>
	<select class="form-control" name="gender">
		<option value="male" <?php if( $data['gender']=='male'){ echo'selected'; }?>>Male</option>
		<option value="female" <?php if( $data['gender']=='female'){ echo'selected'; }?>>Female</option>
		<option value="other" <?php if( $data['gender']=='other'){ echo'selected'; }?>>Other</option>
	</select>
</div>
		<div class="col-md-4 form-group">
		<label class="col-form-label">User Type</label>
						<select class="form-control" name="user_type">
                    <?php $getUserRole = $this->Internal_model->getUserRole();
                    foreach ($getUserRole as $user) { ?>
                     <option value="<?php echo $user->slug ;?>" <?php if( $data['user_type']==$user->slug){ echo'selected'; }?>><?php echo $user->name ;?></option>
                     <?php } ?>
                  </select>
					</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">DOB</label>
		<input type="date" name="dob" class="form-control" value="<?php echo $data['dob']; ?>"> 
	</div>

	<div class="col-md-4 form-group">
	<label class="col-form-label">Blood Group</label>
		<select class="form-control" name="blood_group">
			<option value="A+" <?php if( $data['blood_group']=='A+'){ echo'selected'; }?>>A+</option>
			<option value="A-" <?php if( $data['blood_group']=='A-'){ echo'selected'; }?>>A-</option>
			<option value="B+" <?php if( $data['blood_group']=='B+'){ echo'selected'; }?>>B+</option>
			<option value="B-" <?php if( $data['blood_group']=='B-'){ echo'selected'; }?>>B-</option>
			<option value="AB+" <?php if( $data['blood_group']=='AB+'){ echo'selected'; }?>>AB+</option>
			<option value="AB-" <?php if( $data['blood_group']=='AB-'){ echo'selected'; }?>>AB-</option>
			<option value="O+" <?php if( $data['blood_group']=='O+'){ echo'selected'; }?>>O+</option>
			<option value="O-" <?php if( $data['blood_group']=='O-'){ echo'selected'; }?>>O-</option>
		</select>
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Identification Mark</label>
		<input type="text" name="identification_mark" class="form-control" value="<?php echo $data['identification_mark']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Mobile No</label>
		<input type="number" name="mobile" class="form-control" value="<?php echo $data['mobile']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Alt Mobile No</label>
		<input type="number" name="alt_mobile" class="form-control" value="<?php echo $data['alt_mobile']; ?>"> 
	</div>

    <div class="col-md-4 form-group">
		<label for="" class="form-label">Email</label>
		<input type="email" name="email" class="form-control" value="<?php echo $data['email']; ?>"> 
	</div>
	<div class="col-md-4 form-group">
		<label class="col-form-label">Password</label>
		<input type="password" class="form-control" name="password" />
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label"> Aadhar Card No</label>
		<input type="number" name="aadhar_no" class="form-control" value="<?php echo $data['aadhar_no']; ?>"> 
	</div>
	<div class="col-md-4 form-group">
		<label>Profile  </label>
		<input type="file" name="profile_pic" class="file-upload-default">
		<div class="input-group col-xs-12">
			<input type="text" class="form-control file-upload-info" name="profile_pic" disabled placeholder="Upload Image">
			<span class="input-group-append">
			<button class="file-upload-browse btn btn-primary" type="button">Upload</button>
			</span>
		</div>   
    </div>
	<div class="col-md-4 form-group">
		<label>Aadhar Front </label>
		<input type="file" name="aadhar_front" class="file-upload-default">
		<div class="input-group col-xs-12">
			<input type="text" class="form-control file-upload-info" name="aadhar_front" disabled placeholder="Upload Image">
			<span class="input-group-append">
			<button class="file-upload-browse btn btn-primary" type="button">Upload</button>
			</span>
		</div>   
    </div>

	<div class="col-md-4 form-group">
		<label>Aadhar Back </label>
		<input type="file" name="aadhar_back" class="file-upload-default">
		<div class="input-group col-xs-12">
			<input type="text" class="form-control file-upload-info" name="aadhar_back" disabled placeholder="Upload Image">
			<span class="input-group-append">
			<button class="file-upload-browse btn btn-primary" type="button">Upload</button>
			</span>
		</div>   
    </div>

    <div class="col-md-4 form-group">
		<label for="" class="form-label">Any Other Identity</label>
		<label class="col-form-label">Any Other Identity</label>
		<select class="form-control" name="id_proof">
			<option value="voter_id">Voter Id</option>
			<option value="Pan_card">Pan Card</option>
			<option value="passport">Passport</option>
		</select>
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Permanent Address</label>
		<input type="text" name="permanent address" class="form-control" value="<?php echo $data['permanent address']; ?>"> 
	</div>

	
	<div class="col-md-4 form-group">
		<label for="" class="form-label">District</label>
		<input type="text" class="form-control" name="district" value="<?php echo $data['district']; ?>">
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Country</label>
		<input type="hidden" id="country_model" value="<?php echo $data['country_id']; ?>">
            <select class="form-control" name="country_id" onchange="get_state_model(this.value)">
                <option value="">Select Country</option>
                <?php $get_country = $this->Internal_model->get_country();
                foreach($get_country as $country) { ?> 
                    <option value="<?php echo $country->id;?>" <?php if($data['country_id'] == $country->id) { echo 'selected'; } ?>><?php echo $country->name ;?></option>
                <?php } ?>
            </select>
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">State</label>
		<select name="state_id" class="form-control state_model">
		<option value="<?php echo $data['state_id']; ?>"><?php echo $this->Internal_model->get_col_by_key('states','id',$data['state_id'],'name') ;?></>
			</select>
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Pincode</label>
		<input type="number" class="form-control" name="pincode" value="<?php echo $data['pincode']; ?>">
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Present Address</label>
		<input type="text" class="form-control" name="present_address" value="<?php echo $data['present_address']; ?>">
	</div>

	<div class="col-md-4 form-group">
		<label for="" class="form-label">Present District</label>
		<input type="text" class="form-control" name="present_district" value="<?php echo $data['present_district']; ?>">
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">State</label>
	<select name="present_state_id" class="form-control state_model">
		<option value="<?php echo $data['present_state_id']; ?>"><?php echo $this->Internal_model->get_col_by_key('states','id',$data['present_state_id'],'name') ;?></>
			</select>					
</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Present Pincode</label>
		<input type="number" class="form-control" name="present_pincode" value="<?php echo $data['present_pincode']; ?>">
	</div>

	<div class="col-md-4 form-group">
		<label for="" class="form-label">Bank Name</label>
		<input type="text" class="form-control" name="bank_name" value="<?php echo $data['bank_name']; ?>">
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Branch Name</label>
		<input type="text" class="form-control" name="branch_name" value="<?php echo $data['branch_name']; ?>">
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Account No</label>
		<input type="number" class="form-control" name="account_no" value="<?php echo $data['account_no']; ?>">
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">IFSC Code</label>
		<input type="text" class="form-control" name="ifsc_code" value="<?php echo $data['ifsc_code']; ?>">
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Height</label>
		<input type="text" class="form-control" name="height" value="<?php echo $data['height']; ?>">
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Weight</label>
		<input type="text" class="form-control" name="weight" value="<?php echo $data['weight']; ?>">
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Detail of ARM</label>
		<input type="text" class="form-control" name="detail_of_arm" value="<?php echo $data['detail_of_arm']; ?>">
	</div>

	<div class="col-md-4 form-group">
		<label for="" class="form-label">ARM Code</label>
		<input type="text" class="form-control" name="arm_code" value="<?php echo $data['arm_code']; ?>">
	</div>

	<div class="col-md-4 form-group">
		<label for="" class="form-label">License No</label>
		<input type="text" class="form-control" name="license_no" value="<?php echo $data['license_no']; ?>">
	</div>

	<div class="col-md-4 form-group">
		<label for="" class="form-label">Issue Date</label>
		<input type="date" class="form-control" name="issue_date"  value="<?php echo $data['issue_date']; ?>">
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Expiry Date</label>
		<input type="date" class="form-control" name="expiry_date" value="<?php echo $data['expiry_date']; ?>">
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Issue State</label>
		<select name="issue_state_id" class="form-control state_model">
		<option value="<?php echo $data['issue_state_id']; ?>"><?php echo $this->Internal_model->get_col_by_key('states','id',$data['issue_state_id'],'name') ;?></>
		</select>
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Issue District</label>
		<input type="text" class="form-control" name="issue_district" value="<?php echo $data['issue_district']; ?>">
	</div>

	<div class="col-md-4 form-group">
		<label for="" class="form-label">Police Station</label>
		<input type="text" class="form-control" name="police_station" value="<?php echo $data['police_station']; ?>">
	</div>

	<div class="col-md-4 form-group">
		<label for="" class="form-label">Case of Year</label>
		<input type="text" class="form-control" name="case_of_year" value="<?php echo $data['case_of_year']; ?>">
	</div>

	<div class="col-md-4 form-group">
		<label for="" class="form-label">Court Name</label>
		<input type="text" class="form-control" name="court_name" value="<?php echo $data['court_name']; ?>">
	</div>

	<div class="col-md-4 form-group">
		<label for="" class="form-label">Crime</label>
		<input type="text" class="form-control" name="crime" value="<?php echo $data['crime']; ?>">
	</div>

	<div class="col-md-4 form-group">
		<label>Upload Copy </label>
		<input type="file" name="image" class="file-upload-default">
		<div class="input-group col-xs-12">
			<input type="text" class="form-control file-upload-info" name="image" disabled placeholder="Upload Image">
			<span class="input-group-append">
			<button class="file-upload-browse btn btn-primary" type="button">Upload</button>
			</span>
		</div>   
    </div>

	<div class="col-md-4 form-group">
		<label for="" class="form-label">Issue Date</label>
		<input type="date" class="form-control" name="PV_issue_date" value="<?php echo $data['PV_issue_date']; ?>">
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Police Station</label>
		<input type="text" class="form-control" name="PV_police_station" value="<?php echo $data['PV_police_station']; ?>">
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">District</label>
		<input type="text" class="form-control" name="PV_district" value="<?php echo $data['PV_district']; ?>">
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">State</label>
		<select name="PV_state_id" class="form-control state_model">
		<option value="<?php echo $data['PV_state_id']; ?>"><?php echo $this->Internal_model->get_col_by_key('states','id',$data['PV_state_id'],'name') ;?></>
		</select>
	</div>
	<div class="col-md-4 form-group">
		<label>File upload </label>
		<input type="file" name="case_file" class="file-upload-default">
		<div class="input-group col-xs-12">
			<input type="text" class="form-control file-upload-info" name="case_file" disabled placeholder="Upload Image">
			<span class="input-group-append">
			<button class="file-upload-browse btn btn-primary" type="button">Upload</button>
			</span>
		</div>   
    </div>

	<div class="col-md-4 form-group">
		<label for="" class="form-label">Status</label>
		<select name="status" class="form-control input-sm">
			<option value="">Status</option>
			<option value="Active" <?php if( $data['status']=='Active'){ echo'selected'; }?>>Active</option>
			<option value="Deactive" <?php if( $data['status']=='Deactive'){ echo'selected'; }?>>Deactive</option>
		</select>
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Employee Status</label>
		<select name="employee_status" class="form-control input-sm">
			<option value="">Select Employee Status</option>
			<option value="0" <?php if( $data['status']=='0'){ echo'selected'; }?>>Pending</option>
			<option value="1" <?php if( $data['status']=='1'){ echo'selected'; }?>>Confirmed</option>
		</select>
	</div>
	<div class="col-md-4 form-group mt-2">
                <label>Passport Photo</label>
                <input type="file" name="passport_photo" class="file-upload-default">
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control file-upload-info" name="passport_photo" disabled placeholder="Upload Copy">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                  </span>
                </div>
              </div>
			  <div class="col-md-4 form-group mt-2">
                <label>Resume</label>
                <input type="file" name="resume" class="file-upload-default">
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control file-upload-info" name="resume" disabled placeholder="Upload Copy">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                  </span>
                </div>
			</div>

	<div class="col-12"><br>
    <?php $this->load->view('includes/editFormButton'); ?>
	</div>
</form>

   