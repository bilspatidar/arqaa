<div class="modal_title_details"><h4>Edit Payment</h4></div>
<form id="crudFormUpdateApiData" action="<?php echo API_DOMAIN; ?>api/payments/payment/update" method="POST" class="row g-3">
    <input type="hidden" name="id" class="form-control" value="<?php echo $data['id']; ?>"> 
    <div class="col-md-4 form-group">
        <label for="" class="form-label">Title</label>
        <input type="text" name="title" class="form-control" value="<?php echo $data['title']; ?>">
    </div>

    <div class="col-md-4 form-group">
        <label for="" class="form-label">Project</label>
        <select name="project_id" class="form-control">
                <option value="">Select Project </option>  
                <?php
                $get_project = $this->Internal_model->get_project();
                foreach($get_project as $project_result){ ?> 
                <option value="<?php echo $project_result->id;?>" <?php if($project_result->id == $data['project_id']) {echo 'selected';} ?>><?php echo $project_result->title;?></option> 
                <?php } ?>
                </select>
    </div>

    <div class="col-md-4 form-group">
        <label for="" class="form-label">Amount</label>
        <input type="text" name="amount" class="form-control" value="<?php echo $data['amount']; ?>"> 
    </div>

    
    <div class="col-md-4 form-group">
        <label for="" class="form-label">Status</label>
        <select name="status" class="form-control input-sm">
            <option value="">Status</option>
            <option value="Pending" <?php if( $data['status']=='Pending'){ echo'selected'; }?>>Pending</option>
            <option value="Approved" <?php if( $data['status']=='Approved'){ echo'selected'; }?>>Approved</option>
            <option value="Cancelled" <?php if( $data['status']=='Cancelled'){ echo'selected'; }?>>Cancelled</option>
        </select>
    </div>
    
    <div class="col-md-12 form-group">
        <label for="" class="form-label">Admin Remarks</label>
        <textarea name="admin_remarks" class="form-control summernote"><?php echo $data['admin_remarks']; ?></textarea> 
    </div>

    <div class="col-md-12 form-group">
        <label for="" class="form-label">Remarks</label>
        <textarea name="remarks" class="form-control summernote"><?php echo $data['remarks']; ?></textarea>
    </div>
             
    </div>
    <div class="col-12"><br>
    <?php $this->load->view('includes/editFormButton'); ?>
    </div>
</form>

