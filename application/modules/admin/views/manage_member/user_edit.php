<div class="modal_title_details"><h4>Edit Employee Joining </h4></div>
<form id="crudFormUpdateApiData" action="<?php echo API_DOMAIN; ?>api/employee/user/update" method="POST" class="row g-3">
	<input type="hidden" name="id" class="form-control" value="<?php echo $data['id']; ?>"> 
	<input type="hidden" name="users_id" class="form-control" value="<?php echo $data['users_id']; ?>">
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Employee First Name</label>
		<input type="text" name="first_name" class="form-control" value="<?php echo $data['first_name']; ?>"> 
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
			<?php $getUserRole = $this->Common->getUserRole();
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
		<label for="" class="form-label">Mobile No</label>
		<input type="number" name="mobile" class="form-control" value="<?php echo $data['mobile']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Alt Mobile No</label>
		<input type="number" name="alt_mobile" class="form-control" value="<?php echo $data['alt_mobile']; ?>"> 
	</div>
	<div class="col-md-4 form-group">
		<label class="col-form-label">Password</label>
		<input type="password" class="form-control" name="password" />
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

   