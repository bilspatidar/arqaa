<div class="modal_title_details"><h4>Edit Faq</h4></div>
<form id="crudFormUpdateApiData" action="<?php echo API_DOMAIN; ?>api/faq/faq/update" method="POST" class="row g-3">
	<input type="hidden" name="id" class="form-control" value="<?php echo $data['id']; ?>"> 
     
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Question</label>
		<input type="text" name="question" class="form-control" value="<?php echo $data['question']; ?>"> 
	</div>
	<div class="col-md-4 form-group">
        <label for="" class="form-label">Answer</label>
        <textarea name="answer" class="form-control"><?php echo $data['answer']; ?></textarea>
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

   