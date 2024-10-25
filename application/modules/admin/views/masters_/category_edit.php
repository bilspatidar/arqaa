<div class="modal_title_details"><h4><?php echo $this->lang->line('edit_category');?></h4></div>
<form id="crudFormUpdateApiData" action="<?php echo API_DOMAIN; ?>api/category/category/update" method="POST" class="row g-3">
	<input type="hidden" name="id" class="form-control" value="<?php echo $data['id']; ?>"> 
     
	<div class="col-md-12 form-group">
		<label for="" class="form-label"><?php echo $this->lang->line('name');?></label>
		<input type="text" name="name" class="form-control" value="<?php echo $data['name']; ?>"> 
	</div>
	<div class="col-md-12 form-group">
		<label for="" class="form-label"><?php echo $this->lang->line('status');?></label>
		<select name="status" class="form-control input-sm">
			<option value="">Status</option>
			<option value="Active" <?php if( $data['status']=='Active'){ echo'selected'; }?>><?php echo $this->lang->line('active');?></option>
			<option value="Deactive" <?php if( $data['status']=='Deactive'){ echo'selected'; }?>><?php echo $this->lang->line('deactive');?></option>
		</select>
	</div>
	<div class="col-md-12">
              <div class="form-group row">
                <div class="col-sm-12">
				<?php if (!empty($data['image'])) { ?>
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#imageModal">
						Click Here
					</button>
				<?php } ?>
                  <label class="col-form-label"> <?php echo $this->lang->line('image');?></label>
                  <input type="file" class="form-control" name="image" />
                </div>
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
                <img src="<?php echo base_url('uploads/sub_category/' . $data['image']); ?>" alt="Sub Category Image" style="max-width: 100%; height: auto;">
            </div>
        </div>
    </div>
</div>