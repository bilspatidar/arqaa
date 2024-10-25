
<div class="row">
  
  <div class="col-12 grid-margin <?php echo !empty($status) ? 'collapse' : 'show'; ?>" id="collapseExample">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?></h4>
     
          <form class="form-sample form-submit-api-data" id="crudFormAddApiData" action="<?php echo API_DOMAIN; ?>api/project_report/project_report/add" method="POST">
          
          </form>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <!-- Hidden Fields -->
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/project_report/project_report_list" id="list_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/project_report/project_report/" id="delete_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/project_report/project_report_details" id="show_endpoint">
  <input type="hidden" value="admin/master/projects_edit" id="edit_page_name">
  
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?> <?php $this->load->view('includes/collapseFilterForm'); ?></h4>
        <?php if(empty($status)): ?>
          <div class="collapse show" id="collapseExampleFilter">
            <form id="filterForm">
              <div class="row">
                <div class="col-md-3 form-group">
                  <input type="text" id="filterName" name="name" placeholder="Name" class="form-control">
                </div>
               
                <div class="col-md-3 form-group">
                <select class="form-control" id="filterAgent" name="agent_id">
                <option value="">Select Agent </option>
                <?php $get_agent = $this->Internal_model->get_agent();
                        foreach($get_agent as $agent) { ?> 
                        <option value="<?php echo $agent->id;?>"><?php echo $agent->first_name ;?></option>
                    <?php } ?>
            </select>
                </div>
                <div class="col-md-3 form-group">
                <select class="form-control" id="filterManager" name="manager_id">
                <option value="">Select Manager </option>
                    <?php $get_manager = $this->Internal_model->get_manager();
                        foreach($get_manager as $manager) { ?> 
                        <option value="<?php echo $manager->id;?>"><?php echo $manager->first_name ;?></option>
                    <?php } ?>
                </select>
                </div>
                <div class="col-md-3 form-group">
                <select class="form-control" name="billing_type" id="filterBilling">
                <option value="">Select Billing Type</option>
                <option value="Fixed Rate">Fixed Rate</option>
                <option value="Hours Based">Hours Based</option>
            </select>
                </div>
                <div class="col-md-3 form-group">
                  <select id="filterStatus" name="status" class="form-control">
                    <option value="">Select Status</option>
                    <option value="Not Started">Not Started</option>
                    <option value="In Progress">In Progress</option>
                    <option value="On Hold">On Hold</option>
                    <option value="Finished">Finished</option>
                    <option value="Cancelled">Cancelled</option>
                  </select>
                </div>
                <div class="col-md-3 form-group">
                  <?php $this->load->view('includes/filter_form_btn'); ?>
                </div>
              </div>
            </form> 
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<div class="table-responsive">
  <table class="table table-white table-striped" id="api_response_table">
    <thead>
      <tr>
        <th>#</th>
        <th>Title</th>
        <th>Total Amount</th>
        <th>Total Income</th>
        <th>Due Amount</th>
        <th>Total Expenses</th>
        <th>Location</th>
        <th>State</th>
        <th>Agent</th>
        <th>Manager</th>
        <th>Billing Type</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody id="api_response_table_body">
      
    </tbody>
    <tfoot>
    <tr>
        <th colspan="2" style="text-align:right">Total:</th>
        <th id="totalAmountFooter"></th>
        <th id="totalIncomeFooter"></th>
        <th id="dueAmountFooter"></th>
        <th id="totalExpensesFooter"></th>
    </tr>
</tfoot>
  </table>
</div>

<script>
  function renderTableData(){
    return [
      { "data": null, "render": function(data, type, row, meta) {
        return meta.row + 1; // Adding 1 to meta.row to start from 1 instead of 0
      }},
      { "data": "title", "orderable": true },
      { "data": "amount", "orderable": true },
      {
        "data": "id",
        "orderable": true,
        "render": function(data, type, row) {
          var totalincome = '';
          $.ajax({
            url: '<?php echo base_url("internal/get_total_income"); ?>',
            type: 'GET',
            dataType: 'json',
            data: { project_id: data },
            async: false,
            success: function(response) {
              if (response && response.amount) {
                totalincome = response.amount;
              }
            },
            error: function(xhr, status, error) {
              console.log(error);
            }
          });
          return totalincome;
        }
      },
      {
        "data": "amount",
        "orderable": true,
        "render": function(data, type, row) {
          var totalincome = 0;
          $.ajax({
            url: '<?php echo base_url("internal/get_total_income"); ?>',
            type: 'GET',
            dataType: 'json',
            data: { project_id: row.id },
            async: false,
            success: function(response) {
              if (response && response.amount) {
                totalincome = parseFloat(response.amount);
              }
            },
            error: function(xhr, status, error) {
              console.log(error);
            }
          });
          
          var netAmount = (totalincome > 0) ? parseFloat(data) - totalincome : parseFloat(data);
          return netAmount;
        }
      },
      { 
        "data": "id",
        "orderable": true,
        "render": function(data, type, row) {
          var totalexpenses = '';
          $.ajax({
            url: '<?php echo base_url("internal/get_total_expenses"); ?>',
            type: 'GET',
            dataType: 'json',
            data: { project_id: data },
            async: false,
            success: function(response) {
              if (response && response.amount) {
                totalexpenses = response.amount;
              }
            },
            error: function(xhr, status, error) {
              console.log(error);
            }
          });
          return totalexpenses;
        }
      },
      { "data": "location", "orderable": true },
      { "data": "state_name", "orderable": true },
      { "data": "manager_id", "orderable": true, "render": function(data, type, row) {
                    var manager_name = '';
                    $.ajax({
                        url: '<?php echo base_url("internal/get_col_by_key"); ?>',
                        type: 'GET',
                        dataType: 'json',
                        data: { id: data },
                        async: false,
                        success: function(response) {
                            if (response && response.first_name) {
                                manager_name = response.first_name;
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                    return manager_name;
                }
            },
            { "data": "agent_id", "orderable": true, "render": function(data, type, row) {
                    var agent_name = '';
                    $.ajax({
                        url: '<?php echo base_url("internal/get_col_by_key"); ?>',
                        type: 'GET',
                        dataType: 'json',
                        data: { id: data },
                        async: false,
                        success: function(response) {
                            if (response && response.first_name) {
                                agent_name = response.first_name;
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(error);
                        }
                    });
                    return agent_name;
                }
            },
      { "data": "billing_type", "orderable": true },
      { 
        "data": "status", "orderable": true,
        "render": function(data, type, row) {
          return renderStatusBtn(data, type, row)
        }
      }
      
    ]
  }


$(document).ready(function() {
  setTimeout(function() {
    function calculateTotalAmount() {
    var totalAmount = 0; 
    var totalIncome = 0;
    var dueAmount = 0;
    var totalExpenses = 0;

    $('#api_response_table tbody tr').each(function() {
      var rowDataAmount = parseFloat($(this).find('td:nth-child(3)').text().trim()); // Total Amount column
      var rowDataIncome = parseFloat($(this).find('td:nth-child(4)').text().trim()); // Total Income column
      var rowDataExpenses = parseFloat($(this).find('td:nth-child(6)').text().trim()); // Total Expenses column

      if (!isNaN(rowDataAmount)) {
        totalAmount += rowDataAmount;
      }
      if (!isNaN(rowDataIncome)) {
        totalIncome += rowDataIncome;
      }
    
      if (!isNaN(rowDataExpenses)) {
        totalExpenses += rowDataExpenses;
      }
    });

    dueAmount = totalAmount - totalIncome;

    $("#totalAmountFooter").html(totalAmount.toFixed(2));
    $("#totalIncomeFooter").html(totalIncome.toFixed(2));
    $("#dueAmountFooter").html(dueAmount.toFixed(2));
    $("#totalExpensesFooter").html(totalExpenses.toFixed(2));
  }
  
    function updateTotalAmount() {
 setTimeout(function() {
        calculateTotalAmount();
         }, 500); 
    }

    updateTotalAmount();

    $('#filterForm').submit(function(event) {
        event.preventDefault(); 
        updateTotalAmount();
    });

    // Trigger form submission and calculate total amount on page load if filters are applied
    <?php if(!empty($status)): ?>
        $('#filterForm').submit();
    <?php endif; ?>
     }, 500);
});


</script>