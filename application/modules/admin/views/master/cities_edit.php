
<style>
.custom-select2-dropdown {
    max-width: 1200px;
    /* Add any other necessary styles */
}
</style>
<div class="modal_title_details"><h4>Edit Cities</h4></div>
<form id="crudFormUpdateApiData" action="<?php echo API_DOMAIN; ?>api/city/city/update" method="POST" class="row g-3">
	<input type="hidden" name="id" class="form-control" value="<?php echo $data['id']; ?>"> 
     
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Name</label>
		<input type="text" name="name" class="form-control" value="<?php echo $data['name']; ?>"> 
	</div>
	<div class="col-md-6">
    <div class="form-group row">
        <div class="col-sm-12">
            <label class="col-form-label">Country Name</label>
			<input type="hidden" id="country_model" value="<?php echo $data['country_id']; ?>">
            <select class="form-control" name="country_id" onchange="get_state_model(this.value)">
                <option value="">Select Country</option>
                <?php $get_country = $this->Internal_model->get_country();
                foreach($get_country as $country) { ?> 
                    <option value="<?php echo $country->id;?>" <?php if($data['country_id'] == $country->id) { echo 'selected'; } ?>><?php echo $country->name ;?></option>
                <?php } ?>
            </select>
        </div>
    </div>
</div>
	<div class="col-md-4 form-group">
<input type="hidden" id="default_state_id" value="<?php echo $data['state_id']; ?>">
		<label for="" class="form-label">State</label>
		<select class="form-control state_model" name="state_id">
		<option value="<?php echo $data['state_id']; ?>"><?php echo $this->Internal_model->get_col_by_key('states','id',$data['state_id'],'name') ;?></>
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

<script>

</script>  	