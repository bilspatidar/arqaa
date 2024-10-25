<div class="modal_title_details"><h4>Edit Payment Mode </h4></div>
<form id="crudFormUpdateApiData" action="<?php echo API_DOMAIN; ?>api/payment_mode/payment_mode/update" method="POST" class="row g-3">
	<input type="hidden" name="id" class="form-control" value="<?php echo $data['id']; ?>"> 
     
	<div class="col-md-6 form-group">
		<label for="" class="form-label">Name</label>
		<input type="text" name="name" class="form-control" value="<?php echo $data['name']; ?>"> 
	</div>
	<div class="col-md-6 form-group">
		<label for="" class="form-label">Status</label>
		<select name="status" class="form-control input-sm">
			<option value="">Status</option>
			<option value="Active" <?php if( $data['status']=='Active'){ echo'selected'; }?>>Active</option>
			<option value="Deactive" <?php if( $data['status']=='Deactive'){ echo'selected'; }?>>Deactive</option>
		</select>
	</div>
	<div class="col-md-12 form-group">
		<label for="" class="form-label">Description</label>
		<textarea name="description" class="form-control summernote"> <?php echo $data['description']; ?></textarea> 
	</div>

     
    </div>
	<div class="col-12"><br>
    <?php $this->load->view('includes/editFormButton'); ?>
	</div>
</form>

   