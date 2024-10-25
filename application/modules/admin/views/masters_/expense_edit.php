<div class="modal_title_details"><h4>Edit Expense Category</h4></div>
<form id="crudFormUpdateApiData" action="<?php echo API_DOMAIN; ?>api/expense/expense/update" method="POST" class="row g-3">
    <input type="hidden" name="id" class="form-control" value="<?php echo $data['id']; ?>"> 
    <div class="col-md-4 form-group">
        <label for="" class="form-label">Title</label>
        <input type="text" name="title" class="form-control" value="<?php echo $data['title']; ?>">
    </div>
    <div class="col-md-4 form-group">
        <label for="" class="form-label">Expense Category</label>
        <select name="expense_category_id" class="form-control">
            <option value="">Select Expense Category</option>  
            <?php $expense = $this->Internal_model->get_expense_categories();
            foreach($expense as $expense_result){ ?> 
            <option value="<?php echo $expense_result->id;?>" <?php if($expense_result->id == $data['expense_category_id']) {echo 'selected';} ?>><?php echo $expense_result->name;?></option> 
            <?php } ?>
        </select>
    </div>

    <div class="col-md-4 form-group employee-field">
        <label for="" class="form-label">Employee</label>
        <select name="employee_id" class="form-control">
                <option value="">Select Employee </option>  
                <?php $getUser = $this->Internal_model->getUser();
                foreach($getUser as $user_result){ ?> 
                <option value="<?php echo $user_result->id;?>" <?php if($user_result->id == $data['employee_id']) {echo 'selected';} ?>><?php echo $user_result->first_name;?></option> 
                <?php } ?>
        </select>
    </div>

    <div class="col-md-4 form-group employee-field">
      <label for="" class="form-label"> Salary Month</label>
      <input type="date" class="form-control" name="salary_month" value="<?php echo $data['salary_month']; ?>">
    </div>

    <div class="col-md-4 machines-field form-group">
        <label for="" class="form-label">Machines</label>
        <select name="machine_id" class="form-control">
            <option value="">Select Machines </option>  
            <?php
            $getmachines = $this->Internal_model->get_machines();
            foreach($getmachines as $mresult){ ?> 
            <option value="<?php echo $mresult->id;?>" <?php if($mresult->id == $data['machine_id']) {echo 'selected';} ?>><?php echo $mresult->name;?></option> 
            <?php } ?>
            </select>
    </div>

    <div class="col-md-4 form-group machines-field">
        <label for="" class="form-label">Parts Name</label>
        <input type="text" class="form-control" name="parts_name" value="<?php echo $data['parts_name']; ?>">
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


    <div class="col-md-4 form-group mt-2">
        <label> File</label>
        <input type="file" name="file" class="file-upload-default">
        <div class="input-group col-xs-12">
          <input type="text" class="form-control file-upload-info" name="file" disabled placeholder="Upload Copy">
          <span class="input-group-append">
            <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
          </span>
        </div>
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

<script>
  $(document).ready(function() {
    function toggleElementsVisibility() {
      var expenseCategoryId = $('select[name="expense_category_id"]').val();
      
      if (expenseCategoryId === '5') {
        $('.employee-field').show();
        $('.machines-field').hide();
      } else if (expenseCategoryId === '6') {
        $('.employee-field').hide();
        $('.machines-field').show();
      } else {
        $('.employee-field').hide();
        $('.machines-field').hide();
      }
    }
    
    toggleElementsVisibility();
    
    $('select[name="expense_category_id"]').change(function() {
      toggleElementsVisibility();
    });
  });
</script>
