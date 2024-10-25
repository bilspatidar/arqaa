<div class="modal_title_details"><h4>Edit Payment Voucher</h4></div>
<form id="crudFormUpdateApiData" action="<?php echo API_DOMAIN; ?>api/payment_voucher/payment_voucher/update" method="POST" class="row g-3">
	<input type="hidden" name="id" class="form-control" value="<?php echo $data['id']; ?>"> 
     
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Date</label>
		<input type="date" name="Date" class="form-control" value="<?php echo $data['Date']; ?>"> 
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label"> Party Id</label>
		<input type="text" date="PartyId" class="form-control" value="<?php echo $data['PartyId']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Amount</label>
		<input type="text" name="Amount" class="form-control" value="<?php echo $data['Amount']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Payment Mode Id</label>
		<input type="number" name="PaymentModeId" class="form-control" value="<?php echo $data['PaymentModeId']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label"> Account Head Id</label>
		<input type="number" name="AccountHeadId" class="form-control" value="<?php echo $data['AccountHeadId']; ?>"> 
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Narration</label>
		<input type="text" name="Narration" class="form-control" value="<?php echo $data['Narration']; ?>"> 
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

   