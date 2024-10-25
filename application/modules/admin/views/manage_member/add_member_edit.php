<div class="modal_title_details"><h4>Edit Add Member</h4></div>
<form id="crudFormUpdateApiData" action="<?php echo API_DOMAIN; ?>api/employee/employee/update" method="POST" class="row g-3">
	<input type="hidden" name="id" class="form-control" value="<?php echo $data['id']; ?>"> 
     
	<div class="col-md-4 form-group">
		<label for="" class="form-label">First Name</label>
		<input type="text" name="first_name" class="form-control" value="<?php echo $data['first_name']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Last Name</label>
		<input type="text" name="last_name" class="form-control" value="<?php echo $data['last_name']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Email</label>
		<input type="text" name="email" class="form-control" value="<?php echo $data['email']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Mobile</label>
		<input type="text" name="mobile" class="form-control" value="<?php echo $data['mobile']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Alt Mobile</label>
		<input type="text" name="alt_mobile" class="form-control" value="<?php echo $data['alt_mobile']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">User Type</label>
		<input type="text" name="user_type" class="form-control" value="<?php echo $data['user_type']; ?>"> 
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
		<label for="" class="form-label">Dob</label>
		<input type="text" name="dob" class="form-control" value="<?php echo $data['dob']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Doj</label>
		<input type="text" name="doj" class="form-control" value="<?php echo $data['doj']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Country Id</label>
		<input type="text" name="country_id" class="form-control" value="<?php echo $data['country_id']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">State Id</label>
		<input type="text" name="state_id" class="form-control" value="<?php echo $data['state_id']; ?>"> 
	</div>

	<div class="col-md-4 form-group">
		<label for="" class="form-label">City Id</label>
		<input type="text" name="city_id" class="form-control" value="<?php echo $data['city_id']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Street Address</label>
		<input type="text" name="street_address" class="form-control" value="<?php echo $data['street_address']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Street Address2</label>
		<input type="text" name="street_address2" class="form-control" value="<?php echo $data['street_address2']; ?>"> 
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
                <label>Profile Pic</label>
                <input type="file" name="profile_pic" class="file-upload-default">
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control file-upload-info" name="image" disabled placeholder="Upload Image">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                  </span>
                </div>
	<div class="col-md-4 form-group">
                <label>Address Proof</label>
                <input type="file" name="address_proof" class="file-upload-default">
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control file-upload-info" name="address_proof" disabled placeholder="Upload Image">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                  </span>
                </div>	
	<div class="col-md-4 form-group">
                <label>Id Proof</label>
                <input type="file" name="id_proof" class="file-upload-default">
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control file-upload-info" name="id_proof" disabled placeholder="Upload Image">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                  </span>
                </div>		
	<div class="col-md-4 form-group">
                <label>Business Signature</label>
                <input type="file" name="businessSignature" class="file-upload-default">
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control file-upload-info" name="businessSignature" disabled placeholder="Upload Image">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                  </span>
                </div>
             
    </div>
	<div class="col-12"><br>
    <?php $this->load->view('includes/editFormButton'); ?>
	</div>
</form>

   