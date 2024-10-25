<div class="modal_title_details"><h4>Edit Branch</h4></div>
<form id="crudFormUpdateApiData" action="<?php echo API_DOMAIN; ?>api/branch/branch/update" method="POST" class="row g-3">
	<input type="hidden" name="id" class="form-control" value="<?php echo $data['id']; ?>"> 
     
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Name</label>
		<input type="text" name="name" class="form-control" value="<?php echo $data['name']; ?>"> 
	</div>
	
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Site Phone</label>
		<input type="text" name="branch_phone" class="form-control" value="<?php echo $data['branch_phone']; ?>"> 
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Site Email</label>
		<input type="text" name="branch_email" class="form-control" value="<?php echo $data['branch_email']; ?>"> 
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Site Code</label>
		<input type="text" name="side_code" class="form-control" value="<?php echo $data['side_code']; ?>"> 
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Site Address</label>
		<input type="text" name="branch_address" class="form-control" value="<?php echo $data['branch_address']; ?>"> 
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Site Lang</label>
		<input type="text" name="lang" class="form-control" value="<?php echo $data['lang']; ?>"> 
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Site Latt</label>
		<input type="text" name="latt" class="form-control" value="<?php echo $data['latt']; ?>"> 
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Site Location</label>
		<input type="text" name="branch_location" class="form-control" value="<?php echo $data['branch_location']; ?>"> 
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Country Name</label>
		<select class="form-control" name="country_id" onchange="get_state_model(this.value)">
                <option value="">Select Country</option>
                <?php $get_country = $this->Internal_model->get_country();
                foreach($get_country as $country) { ?> 
                    <option value="<?php echo $country->id;?>" <?php if($data['country_id'] == $country->id) { echo 'selected'; } ?>><?php echo $country->name ;?></option>
                <?php } ?>
            </select>
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">State Name</label>
		<select class="form-control" name="state_id" id="state_model" onchange="get_city_model(this.value)">
		<option value="<?php echo $data['state_id']; ?>"><?php echo $this->Common->get_col_by_key('states','id',$data['state_id'],'name') ;?></>
			</select>
	</div>
	<div class="col-md-4 form-group">
	<label class="col-form-label">City Name</label>
                  <select class="form-control select2" name="city_id" id="city_model">
				  <option value="<?php echo $data['city_id']; ?>"><?php echo $this->Common->get_col_by_key('cities','id',$data['city_id'],'name') ;?></>
            </select>
	</div>
	<div class="col-md-4 form-group">
		<label class="col-form-label">Area Name</label>
		<input type="text" class="form-control" name="area_name" value="<?php echo $data['area_name']; ?>" />
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
		<label>File upload</label>
		<input type="file" name="branch_image" class="file-upload-default">
		<div class="input-group col-xs-12">
		  <input type="text" class="form-control file-upload-info" name="branch_image" disabled placeholder="Upload Image">
		  <span class="input-group-append">
			<button class="file-upload-browse btn btn-primary" type="button">Upload</button>
		  </span>
		</div>
	  </div>
	<div class="col-12"><br>
    <?php $this->load->view('includes/editFormButton'); ?>
	</div>
</form>

   