<div class="modal_title_details"><h4>Edit User Branch Link</h4></div>
<form id="crudFormUpdateApiData" action="<?php echo API_DOMAIN; ?>api/employee/user_branch_link/update" method="POST" class="row g-3">
	<input type="hidden" name="id" class="form-control" value="<?php echo $data['id']; ?>"> 
     
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Users</label>	
		<select name="user_id" class="form-control">
                        <option value="">Select User</option>
                        <?php $get_user = $this->Internal_model->get_user();
                        foreach($get_user as $user){ ?>
                        <option value="<?php echo $user->id; ?>" <?php if($data['user_id'] == $user->id){echo 'selected';} ?>>
						<?php echo $user->first_name; ?></option>
                        <?php } ?>
                    </select>
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Site</label>	
		<select name="branch_id" class="form-control">
                  <option value="">Select Site</option>
                  <?php $get_branch =  $this->Internal_model->get_branch();
                  foreach($get_branch as $branch){ ?>
                    <option value="<?php echo $branch->id;?>" <?php if($data['branch_id'] == $branch->id){echo 'selected';} ?>><?php echo $branch->name; ?></option>
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

   