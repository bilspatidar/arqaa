<div class="modal_title_details"><h4>Edit State</h4></div>
<form id="crudFormUpdateApiData" action="<?php echo API_DOMAIN; ?>api/state/state/update" method="POST" class="row g-3">
	<input type="hidden" name="id" class="form-control" value="<?php echo $data['id']; ?>"> 
     
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Name</label>
		<input type="text" name="name" class="form-control" value="<?php echo $data['name']; ?>"> 
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Country Name</label>
		<select class="form-control select2" name="country_id">
			<option value="">Select Country Name</option>
			<?php $get_country = $this->Internal_model->get_country();
			foreach($get_country as $row) { ?> 
			<option value="<?php echo $row->id;?>" <?php if($data['country_id'] == $row->id){echo 'selected';} ?>><?php echo $row->name ;?></option>
			<?php } ?>
		</select>
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Status</label>
		<select name="status" class="form-control input-sm">
			<option value="">Status</option>
			<option value="Active" <?php if( $data['status']=='Active'){ echo'selected'; }?>>Active</option>
			<option value="Deactive" <?php if( $data['status']=='Deactive'){ echo'selected'; }?>>Deactive</option>
		</select>
	</div>

    </div>
	<div class="col-12"><br>
    <?php $this->load->view('includes/editFormButton'); ?>
	</div>
</form>

   