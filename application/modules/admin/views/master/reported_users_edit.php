	<div class="modal_title_details"><h4><?php echo $this->lang->line('edit_category');?></h4></div>
<form id="crudFormUpdateApiData" action="<?php echo API_DOMAIN; ?>api/reported_users/reported_users/update"  method="POST" class="row g-3">
	<input type="hidden" name="id" class="form-control" value="<?php echo $data['id']; ?>"> 
     
	<div class="col-md-12 form-group">
		<label class="col-form-label"><?php echo $this->lang->line('name');?></label>
        <input type="text" class="form-control" name="name" value="<?php echo $data['name']; ?>">
	</div><div class="col-md-12 form-group">
		<label for="" class="form-label"><?php echo $this->lang->line('status');?></label>
		<select name="status" class="form-control input-sm">
			<option value="">Status</option>
			<option value="Active" <?php if( $data['status']=='Active'){ echo'selected'; }?>><?php echo $this->lang->line('active');?></option>
			<option value="Deactive" <?php if( $data['status']=='Deactive'){ echo'selected'; }?>><?php echo $this->lang->line('deactive');?></option>
		</select>
	</div>
	<div class="col-12"><br>
    <?php $this->load->view('includes/editFormButton'); ?>
	</div>
</form>