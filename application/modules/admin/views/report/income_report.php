<div class="row">
  <?php $this->load->view('includes/collapseAddForm'); ?>
  
  <div class="col-12 grid-margin collapse show" id="collapseExample">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?></h4>
        <form class="form-sample" id="crudFormAddApiData" action="<?php echo API_DOMAIN; ?>api/income_report/income_report/add" method="POST">
       
        </form>
      </div>
    </div>
  </div>
</div>

<div class="row">
<input type="hidden" value="<?php echo API_DOMAIN; ?>api/income_report/income_report_list" id="list_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/income_report/income_report/" id="delete_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/income_report/income_report_details" id="show_endpoint">
  <input type="hidden" value="admin/master/income_reports_edit" id="edit_page_name">
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
                <th>Projects Name</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Option</th>
              </tr>
            </thead>
            <tbody id="api_response_table_body">
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2" style="text-align:right">Total:</th>
                    <th id="totalAmountFooter"></th>
                </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
  function renderTableData(){
    return [
                { "data": null, "render": function(data, type, row, meta) {
                    return meta.row + 1; // Adding 1 to meta.row to start from 1 instead of 0
                }},
                { "data": "project_name", "orderable": true  },
                { "data": "amount", "orderable": true  },
                { 
                    "data": "status", "orderable": true,
                    "render": function(data, type, row) {
                        return renderStatusBtn(data, type, row)
                    }
                },
                { 
                    "data": null, 
                    "render": function(data, type, row) {
                      return renderOptionBtn(data, type, row)
                    }
                }
            ]
  }
  $(document).ready(function() {
  setTimeout(function() {
    function calculateTotalAmount() {
        var totalAmount = 0; // Initial value
        
        // Iterate through visible rows and calculate total amount
        $('#api_response_table tbody tr:visible').each(function() {
            var rowDataAmount = parseFloat($(this).find('td:nth-child(3)').text().trim()); // Total Amount column
            
            if (!isNaN(rowDataAmount)) {
                totalAmount += rowDataAmount;
            }
        });

        // Update total amount in the footer
        $("#totalAmountFooter").html(totalAmount.toFixed(3));
    }
  
    function updateTotalAmount() {
 setTimeout(function() {
        calculateTotalAmount();
         }, 1000); 
    }

    updateTotalAmount();

    $('#filterForm').submit(function(event) {
        event.preventDefault(); 
        updateTotalAmount();
    });


     }, 1000);
});

</script> 