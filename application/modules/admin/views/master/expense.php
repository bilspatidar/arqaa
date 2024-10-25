<div class="row">
  <?php $this->load->view('includes/collapseAddForm'); ?>
  
  <div class="col-12 grid-margin collapse show" id="collapseExample">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?></h4>
        <form class="form-sample" id="crudFormAddApiData" action="<?php echo API_DOMAIN; ?>api/expense/expense/add" method="POST">
          <p class="card-description">Add new</p>
          <div class="row">
          <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Title</label>
                  <input type="text" class="form-control" name="title"/>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Expense Category </label>
                  <select name="expense_category_id" class="form-control">
                <option value="">Select Expense Category</option>  
                <?php
                $expense = $this->Internal_model->get_expense_categories();
                foreach($expense as $expense_result){ ?> 
                <option value="<?php echo $expense_result->id;?>"><?php echo $expense_result->name;?></option> 
                <?php } ?>
                </select>
                </div>
              </div>
            </div>

            <div class="col-md-6 employee-field">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Employee </label>
                  <select name="employee_id" class="form-control">
                <option value="">Select Employee </option>  
                <?php $getUser = $this->Internal_model->getUser();
                foreach($getUser as $user_result){ ?> 
                <option value="<?php echo $user_result->id;?>"><?php echo $user_result->first_name;?></option> 
                <?php } ?>
                </select>
                </div>
              </div>
            </div>
            <div class="col-md-6 employee-field">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Salary Month</label>
                  <input type="date" class="form-control" name="salary_month" />
                </div>
              </div>
            </div>

            <div class="col-md-6 machines-field">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Machines </label>
                  <select name="machine_id" class="form-control">
                <option value="">Select Machines </option>  
                <?php
                $getmachines = $this->Internal_model->get_machines();
                foreach($getmachines as $mresult){ ?> 
                <option value="<?php echo $mresult->id;?>"><?php echo $mresult->name;?></option> 
                <?php } ?>
                </select>
                </div>
              </div>
            </div>
            <div class="col-md-6 machines-field">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Parts Name</label>
                  <input type="text" class="form-control" name="parts_name" />
                </div>
              </div>
            </div>

                        
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Project </label>
                  <select name="project_id" class="form-control">
                <option value="">Select Project </option>  
                <?php
                if(!empty($project_id)){ ?>
                  <option value="<?php echo $project_id;?>" selected>
                  <?php echo $this->Internal_model->get_col_by_key('pms_project','id',$project_id,'title');?>
                  </option>
               <?php }else{ 
                $get_project = $this->Internal_model->get_project();
                foreach($get_project as $project_result){ ?> 
                <option value="<?php echo $project_result->id;?>"><?php echo $project_result->title;?></option> 
                <?php } } ?>
                </select>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Payment Mode </label>
                  <select name="payment_mode_id" class="form-control">
                <option value="">Select Payment Mode </option>  
                <?php
                $get_payment_mode = $this->Internal_model->get_payment_mode();
                foreach($get_payment_mode as $payment_mode_row){ ?> 
                <option value="<?php echo $payment_mode_row->id;?>"><?php echo $payment_mode_row->name;?></option> 
                <?php } ?>
                </select>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Amount</label>
                  <input type="text" class="form-control" name="amount" />
                </div>
              </div>
            </div>
            <div class="col-md-6 mt-2">
              <div class="form-group">
                <label> File</label>
                <input type="file" name="file" class="file-upload-default">
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control file-upload-info" name="file" disabled placeholder="Upload Copy">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Admin Remarks</label>
                  <textarea class="form-control summernote" name="admin_remarks"/></textarea>
                </div>
              </div>
            </div>

          <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Remarks</label>
                  <textarea class="form-control summernote" name="remarks"/></textarea>
                </div>
              </div>
            </div>



          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <?php $this->load->view('includes/form_button'); ?>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/expense/expense_list" id="list_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/expense/expense/" id="delete_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/expense/expense_details" id="show_endpoint">
  <input type="hidden" value="admin/master/expense_edit" id="edit_page_name">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?> <?php $this->load->view('includes/collapseFilterForm'); ?></h4>
        

         <div class="collapse show" id="collapseExampleFilter">
        <form id="filterForm">
          <div class="row">
            <div class="col-md-3 form-group">
            <input type="text" id="filterName" name="name" placeholder="Name" class="form-control">
            </div>
            <div class="col-md-3 form-group">
            <select id="filterStatus" name="status" class="form-control">
            <option value="">Select Status</option>
            <option value="Active">Active</option>
            <option value="Deactive">Inactive</option>
            </select>
            </div>
            <div class="col-md-3 form-group">
            <select name="project" class="form-control" id="filterProject">
                <option value="">Select Project </option>  
                <?php
                if(!empty($project_id)){ ?>
                  <option value="<?php echo $project_id;?>" selected>
                  <?php echo $this->Internal_model->get_col_by_key('pms_project','id',$project_id,'title');?>
                  </option>
               <?php }else{ 
                $get_project = $this->Internal_model->get_project();
                foreach($get_project as $project_result){ ?> 
                <option value="<?php echo $project_result->id;?>"><?php echo $project_result->title;?></option> 
                <?php } } ?>
                </select>
                </div>
            <div class="col-md-3 form-group">
            <?php $this->load->view('includes/filter_form_btn'); ?>
            </div>
           </div>
       </form> 
       </div>

        <div class="table-responsive">
          <table class="table table-dark  table-striped" id="api_response_table">
            <thead>
              <tr>
                <th>#</th>
                <th>Title</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Category</th>
                <th>Project Name</th>
                <th>Added By</th>
                <th>Status</th>
                <th>Option</th>
              </tr>
            </thead>
            <tbody id="api_response_table_body">
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
    function renderTableData(){
        return [
            { 
                "data": null, 
                "render": function(data, type, row, meta) {
                    return meta.row + 1; // meta.row ko 1 se shuru karna hai 0 ke bajaye
                }
            },
            { "data": "title", "orderable": true  },
            { "data": "added", "orderable": true  },
            { "data": "amount", "orderable": true  },
            { "data": "categories_name", "orderable": true  },
            { "data": "project_name", "orderable": true  },
            { 
                "data": "addedBy", 
                "orderable": true, 
                "render": function(data, type, row) {
                    var addedByMobile = '';
                    $.ajax({
                        url: '<?php echo base_url("internal/get_col_by_key"); ?>',
                        type: 'GET',
                        dataType: 'json',
                        data: { id: data },
                        async: false,
                        success: function(response) {
                            if (response && response.first_name) {
                                addedByMobile = response.first_name;
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                    return addedByMobile;
                }
            },
            { 
                "data": "status", 
                "orderable": true,
                "render": function(data, type, row) {
                    return renderStatusBtn(data, type, row);
                }
            },
            { 
                "data": null, 
                "render": function(data, type, row) {
                    return renderOptionBtn(data, type, row);
                }
            }
        ];
    }
</script>


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