
<style>
.custom-select2-dropdown {
    max-width: 1200px;
    /* Add any other necessary styles */
}
</style>
<div class="modal_title_details"><h4>Edit Attendance</h4></div>
<form id="crudFormUpdateApiData" action="<?php echo API_DOMAIN; ?>api/attendance/attendance/update" method="POST" class="row g-3">
	<input type="hidden" name="id" class="form-control" value="<?php echo $data['id']; ?>"> 
     
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Employee Name </label>
        <select name="user_id" class="form-control" >
            <option value="">Selecte Employee</option>
            <?php 
                $getUser = $this->Internal_model->getUser();
                foreach($getUser as $row){ ?>
                <option value="<?php echo $row->users_id;?>" <?php if($row->users_id == $data['user_id']){echo 'selected' ;} ?>><?php echo $row->first_name;?></option>
            <?php } ?>
        </select>
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label"> Latitude </label>
        <input type="text" name="latitude" class="form-control" value="<?php echo $data['latitude']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label"> Date </label>
        <input type="date" name="date" class="form-control" value="<?php echo $data['date']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label"> Longitude </label>
        <input type="text" name="longitude" class="form-control" value="<?php echo $data['longitude']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label"> Remarks </label>
        <textarea name="remarks" class="form-control" > <?php echo $data['remarks']; ?></textarea>
	</div>

	<div class="col-md-4 form-group">
		<label for="" class="form-label">Status</label>
		<select name="status" class="form-control input-sm">
			<option value="">Status</option>
			<option value="Absent" <?php if( $data['status']=='Absent'){ echo'selected'; }?>>Absent</option>
			<option value="Present" <?php if( $data['status']=='Present'){ echo'selected'; }?>>Present</option>
            <option value="Half day" <?php if( $data['status']=='Half day'){ echo'selected'; }?>>Half day</option>
            <option value="Leave" <?php if( $data['status']=='Leave'){ echo'selected'; }?>>Leave</option>
		</select>
	</div>

    </div>
	<div class="col-12"><br>
    <?php $this->load->view('includes/editFormButton'); ?>
	</div>
</form>

<script>

</script>  	