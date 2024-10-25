<div class="modal_title_details"><h4>Edit Group </h4></div>
<form id="crudFormUpdateApiData" action="<?php echo API_DOMAIN; ?>api/groups/group/update" method="POST" class="row g-3">
	<input type="hidden" name="id" class="form-control" value="<?php echo $data['id']; ?>"> 
     
	<div class="col-md-4 form-group">
		<label for="" class="form-label"> Name</label>
		<input type="text" name="name" class="form-control" value="<?php echo $data['name']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Code</label>
		<input type="number" name="code" class="form-control" value="<?php echo $data['code']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Branch Id</label>
		<input type="number" name="branch_id" class="form-control" value="<?php echo $data['branch_id']; ?>"> 
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

   