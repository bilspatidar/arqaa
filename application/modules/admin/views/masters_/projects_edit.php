<style>
    .hidden {
        display: none;
    }
</style>
<style>
    .select2-results__option {
        color: white;
    }
</style>
<div class="modal_title_details"><h4>Edit Project</h4></div>
<form id="crudFormUpdateApiData" action="<?php echo API_DOMAIN; ?>api/pms_project/pms_project/update" method="POST" class="row g-3">
	<input type="hidden" name="id" class="form-control" value="<?php echo $data['id']; ?>"> 

    <div class="col-md-4 form-group">
		<label for="" class="form-label">Title</label>
		<input type="text" name="title" class="form-control" value="<?php echo $data['title']; ?>"> 
	</div>
    <!-- <div class="col-md-4 form-group">
    <label for="" class="form-label">User Name</label>
    <select class="form-control" name="employee_id[]">
        <option value="">Select User</option>
        < ?php 
        $get_user = $this->Internal_model->get_user_employee();
        foreach($get_user as $user) { 
        ?> 
        <option value="< ?php echo $user->id;?>" < ?php if($user->id == $data['employee_id'])
         { echo 'selected'; }?>>< ?php echo $user->first_name;?></option>

        <  ?php } ?>
    </select>
</div> -->

    <div class="col-md-4 form-group">
		<label for="" class="form-label">Agent Name</label>
        <select class="form-control select2" name="agent_id">
                <option value="">Select Agent </option>
                <?php $get_agent = $this->Internal_model->get_agent();
                        foreach($get_agent as $agent) { ?> 
                        <option value="<?php echo $agent->id;?>" <?php if($agent->id== $data['agent_id']){ echo'selected'; }?>><?php echo $agent->name ;?></option>
                    <?php } ?>
            </select>
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Agent Commission %</label>
		<input type="text" name="agent_commission" class="form-control" value="<?php echo $data['agent_commission']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
    <label for="" class="form-label">Manager Name</label>
    <select class="form-control select2" name="manager_id" style="color: white;">
        <option value="">Select Manager</option>
        <?php 
        $get_manager = $this->Internal_model->get_manager();
        foreach($get_manager as $manager) { 
        ?> 
        <option value="<?php echo $manager->id;?>" <?php if($manager->id== $data['manager_id']){ echo 'selected'; }?>><?php echo $manager->name;?></option>
        <?php } ?>
    </select>
</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Location</label>
		<input type="text" name="location" class="form-control" value="<?php echo $data['location']; ?>"> 
	</div>

    <div class="col-md-4 form-group">
		<label for="" class="form-label">State Name</label>
        <select class="form-control select2" name="state_id" onchange="get_city_model(this.value)">
                <option value="">Select State </option>
                <?php $get_state = $this->Internal_model->get_state();
                        foreach($get_state as $state) { ?> 
                        <option value="<?php echo $state->id;?>" <?php if($state->id== $data['state_id']){ echo'selected'; }?>><?php echo $state->name ;?></option>
                    <?php } ?>
            </select>
	</div>

    <div class="col-md-4 form-group">
		<label for="" class="form-label">City</label>
        <select class="form-control select2" name="city_id" id="city_model">
        <option value="<?php echo $data['city_id']; ?>"><?php echo $this->Internal_model->get_col_by_key('cities','id',$data['city_id'],'name') ;?></option>
        </select>
	</div>
   
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Billing Type</label>
		<select name="billing_type" class="form-control input-sm" id="billing_type_model">
			<option value="">Billing Type</option>
			<option value="Fixed Rate" <?php if( $data['billing_type']=='Fixed Rate'){ echo'selected'; }?>>Fixed Rate</option>
			
            <option value="Hours Based" <?php if( $data['billing_type']=='Hours Based'){ echo'selected'; }?>>Hours Based</option>
		</select>
	</div>
	<div class="col-md-4 form-group hours_fields_model hidden">
		<label for="" class="form-label">EST Hrs</label>
		<input type="text" name="est_hrs" class="form-control" value="<?php echo $data['est_hrs']; ?>"> 
	</div>
        <div class="col-md-4 hours_fields_model hidden">
                    <label class="col-form-label">HRS Rate</label>
                    <input type="number" step="any" class="form-control" name="hrs_rate" value="<?php echo $data['hrs_rate']; ?>">
                </div>

        <div class="col-md-4">
                    <label class="col-form-label">Amount</label>
                    <input type="number" step="any" class="form-control" name="amount" value="<?php echo $data['amount']; ?>">
                </div>

 
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Status</label>
		<select name="status" class="form-control input-sm">
			<option value="">Status</option>
			<option value="In Progress" <?php if( $data['status']=='In Progress'){ echo'selected'; }?>>In Progress</option>
			<option value="Not Started" <?php if( $data['status']=='Not Started'){ echo'selected'; }?>>Not Started</option>
            <option value="On Hold" <?php if( $data['status']=='On Hold'){ echo'selected'; }?>>On Hold</option>
            <option value="Finished" <?php if( $data['status']=='Finished'){ echo'selected'; }?>>Finished</option>
            <option value="Cancelled" <?php if( $data['status']=='Cancelled'){ echo'selected'; }?>>Cancelled</option>
		</select>
	</div>
    <div class="col-md-4 form-group">
                <label>File upload</label>
                <input type="file" name="image" class="file-upload-default">
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control file-upload-info" name="image" disabled placeholder="Upload Image">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                  </span>
                </div>
            </div>
	<div class="col-md-12 form-group">
		<label for="" class="form-label">Description</label>
		<textarea name="description" class="form-control"> <?php echo $data['description']; ?></textarea>
	</div>
	<div class="col-12"><br>
    <?php $this->load->view('includes/editFormButton'); ?>
	</div>
</form>

<script>
    $(document).ready(function() {
        $('#billing_type_model').change(function(){
            var selectedOption = $(this).val();
            if(selectedOption === 'Fixed Rate') {
                $('.hours_fields_model').addClass('hidden');
                $('.fixed_rate_field_model').removeClass('hidden');
            } else if(selectedOption === 'Hours Based') {
                $('.hours_fields_model').removeClass('hidden');
                $('.fixed_rate_field_model').addClass('hidden');
            } else {
                $('.hours_fields_model').addClass('hidden');
                $('.fixed_rate_field_model').addClass('hidden');
            }
        });
    });
</script>
<script>
    function updateAmount() {
        var est_hrs_value = parseFloat(document.querySelector('input[name="est_hrs"]').value);
        var hrs_rate_value = parseFloat(document.querySelector('input[name="hrs_rate"]').value);
        
        var amount = est_hrs_value * hrs_rate_value;
        
        document.querySelector('input[name="amount"]').value = isNaN(amount) ? '' : amount;
    }
    
    document.querySelector('input[name="est_hrs"]').addEventListener('input', updateAmount);
    document.querySelector('input[name="hrs_rate"]').addEventListener('input', updateAmount);
</script>
