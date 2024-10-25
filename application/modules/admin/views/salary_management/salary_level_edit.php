<div class="modal_title_details"><h4>Edit Salary Level</h4></div>
<form id="crudFormUpdateApiData" action="<?php echo API_DOMAIN; ?>api/salary_level/salary_level/update" method="POST" class="row g-3">
	<input type="hidden" name="id" class="form-control" value="<?php echo $data['id']; ?>"> 
     
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Name</label>
		<input type="text" name="name" class="form-control" value="<?php echo $data['name']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Salary Head Id</label>
		<select class="form-control" name="salary_head_id">
                <option value="">Select Salary Head </option>
                <?php $get_salary_head = $this->Internal_model->get_salary_head();
                foreach($get_salary_head as $row){?>
                <option value="<?php echo $row->id;?>" 
				<?php if($data['salary_head_id'] == $row->id) {echo 'selected' ;}?>>
				<?php echo $row->head_name;?></option>
                <?php } ?>   
                </select>
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Salary Head Value </label>
		<input type="number" name="salary_head_value" class="form-control" value="<?php echo $data['salary_head_value']; ?>"> 
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

   