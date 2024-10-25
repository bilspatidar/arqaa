<div class="modal_title_details"><h4>Edit Document Upload</h4></div>
<form id="crudFormUpdateApiData" action="<?php echo API_DOMAIN; ?>api/document_upload/document_upload/update" method="POST" class="row g-3">
	<input type="hidden" name="id" class="form-control" value="<?php echo $data['id']; ?>"> 
     
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Users Id</label>
		<input type="number" name="users_id" class="form-control" value="<?php echo $data['users_id']; ?>"> 
	</div>

    <div class="col-md-4 form-group">
		<label for="" class="form-label">Document Category Id</label>
		<input type="number" name="document_category_id" class="form-control" value="<?php echo $data['document_category_id']; ?>"> 
	</div>

    <div class="col-md-4 form-group">
		<label for="" class="form-label">Document Sub Category Id</label>
		<input type="number" name="document_sub_category_id" class="form-control" value="<?php echo $data['document_sub_category_id']; ?>"> 
	</div>

    <div class="col-md-4 form-group">
		<label for="" class="form-label">Title</label>
		<input type="text" name="title" class="form-control" value="<?php echo $data['title']; ?>"> 
	</div>

    <div class="col-md-4 form-group">
		<label>Document Front File </label>
		<input type="file" name="image" class="file-upload-default">
		<div class="input-group col-xs-12">
			<input type="text" class="form-control file-upload-info" name="document_front_file" disabled placeholder="Document Front File">
			<span class="input-group-append">
			<button class="file-upload-browse btn btn-primary" type="button">Upload</button>
			</span>
		</div>   
    </div>

    <div class="col-md-4 form-group">
		<label>Document Back File </label>
		<input type="file" name="image" class="file-upload-default">
		<div class="input-group col-xs-12">
			<input type="text" class="form-control file-upload-info" name="document_back_file" disabled placeholder="Document Back File">
			<span class="input-group-append">
			<button class="file-upload-browse btn btn-primary" type="button">Upload</button>
			</span>
		</div>   
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

   