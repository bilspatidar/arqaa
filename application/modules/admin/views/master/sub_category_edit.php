<div class="modal_title_details"><h4>Edit Sub_category</h4></div>
<form id="crudFormUpdateApiData" action="<?php echo API_DOMAIN; ?>api/sub_category/sub_category/update" method="POST" class="row g-3">
	<input type="hidden" name="id" class="form-control" value="<?php echo $data['id']; ?>"> 
     
	<div class="col-md-12 form-group">
		<label for="" class="form-label">Name</label>
		<input type="text" name="name" class="form-control" value="<?php echo $data['name']; ?>"> 
	</div>
	<div class="col-md-12 form-group">
		<label for="" class="form-label">Category id</label>
		 <select name="category_id" class="form-control">
		  <option value=""><?php echo $this->lang->line('select_option'); ?></option>
		  <?php 
			$get_categories = $this->Internal_model->get_categories();
			foreach($get_categories as $category) { 
			  // Check kar rahe hain ki kya current category data me se selected hai ya nahi
			  $selected = ($data['category_id'] == $category->id) ? 'selected' : '';
		  ?>
			  <option value="<?php echo $category->id; ?>" <?php echo $selected; ?>>
				<?php echo $category->name; ?>
			  </option>
		  <?php } ?>
		</select>
	</div>
	
	<div class="col-md-12 form-group">
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#imageModal">
			Click Here
		</button>
		  <label class="col-form-label"> <?php echo $this->lang->line('image');?></label>
		  <input type="file" class="form-control" name="image" />
		</div>
	
	<div class="col-md-12 form-group">
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

 <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Sub Category Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <?php $image = $data['image'];
				if(!empty($image)){ 
				?>
                    <img src="<?php echo base_url('uploads/sub_category/' . $image); ?>" alt="Sub Category Image" style="max-width: 100%; height: auto;">
				<?php }else{ ?>
				    <img src="<?php echo base_url('uploads/no_file.jpg'); ?>"  style="max-width: 100%; height: auto;">
				<?php } ?>
		   </div>
        </div>
    </div>
</div>
