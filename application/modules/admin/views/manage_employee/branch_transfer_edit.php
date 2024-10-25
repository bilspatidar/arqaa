<div class="modal_title_details"><h4>Edit Branch Transfer </h4></div>
<form id="crudFormUpdateApiData" action="<?php echo API_DOMAIN; ?>api/branch_transfer/branch_transfer/update" method="POST" class="row g-3">
	<input type="hidden" name="id" class="form-control" value="<?php echo $data['id']; ?>"> 
     
	<div class="col-md-4 form-group">
		<label for="" class="form-label"> Branch Name</label>
		<input type="text" name="branch_id" class="form-control" value="<?php echo $data['branch_id']; ?>"> 
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Product Name</label>
		<input type="text" name="product_id" class="form-control" value="<?php echo $data['product_id']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Admin Remark</label>s
		<input type="text" name="adminRemarks" class="form-control" value="<?php echo $data['adminRemarks']; ?>"> 
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Status</label>
		<select name="status" class="form-control input-sm">
			<option value="">Status</option>
			<option value="Pending" <?php if( $data['status']=='Pending'){ echo'selected'; }?>>Pending</option>
			<option value="Accepted" <?php if( $data['status']=='Accepted'){ echo'selected'; }?>>Accepted</option>
			<option value="Cancelled" <?php if( $data['status']=='Cancelled'){ echo'selected'; }?>>Cancelled</option>
		</select>
	</div>

    </div>
	<div class="col-12"><br>
    <?php $this->load->view('includes/editFormButton'); ?>
	</div>
</form>

   