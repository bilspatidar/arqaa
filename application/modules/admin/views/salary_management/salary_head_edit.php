<div class="modal_title_details"><h4>Edit Salary Head</h4></div>
<form id="crudFormUpdateApiData" action="<?php echo API_DOMAIN; ?>api/salary_head/salary_head/update" method="POST" class="row g-3">
	<input type="hidden" name="id" class="form-control" value="<?php echo $data['id']; ?>"> 
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Head Name</label>
		<input type="text" name="head_name" class="form-control" value="<?php echo $data['head_name']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Types</label>
		<select class="form-control" name="types">
		<option value="">Select Types</option>
		<option value="Earning" <?php if( $data['types']=='Earning'){ echo'selected'; }?>>Earning</option>
		<option value="Deduction" <?php if( $data['types']=='Deduction'){ echo'selected'; }?>>Deduction</option>
</select>
	</div>
    <div class="col-md-4 form-group">
       <label for="" class="form-label">Description</label>
       <textarea name="description" class="form-control"><?php echo $data['description']; ?></textarea>
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

   