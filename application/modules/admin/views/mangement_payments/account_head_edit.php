<div class="modal_title_details"><h4>Edit Account Head</h4></div>
<form id="crudFormUpdateApiData" action="<?php echo API_DOMAIN; ?>api/accounthead/accounthead/update" method="POST" class="row g-3">
	<input type="hidden" name="id" class="form-control" value="<?php echo $data['id']; ?>"> 
     
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Name</label>
		<input type="text" name="name" class="form-control" value="<?php echo $data['name']; ?>"> 
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Date</label>
		<input type="text" date="date" class="form-control" value="<?php echo $data['date']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Type</label>
		<input type="text" name="type" class="form-control" value="<?php echo $data['type']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Account No</label>
		<input type="number" name="accountNo" class="form-control" value="<?php echo $data['accountNo']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Opening Balance</label>
		<input type="number" name="openingBalance" class="form-control" value="<?php echo $data['openingBalance']; ?>"> 
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

   