<style>
    .hidden {
        display: none;
    }
    .form-control[multiple] {
        height: auto;
    }
</style>
<div class="row">
  <?php $status ;?>
  <?php if(empty($status)): ?>
    <!-- Add New Project Form -->
    <?php $this->load->view('includes/collapseAddForm'); ?>
  <?php endif; ?>
  
  <div class="col-12 grid-margin <?php echo !empty($status) ? 'collapse' : 'show'; ?>" id="collapseExample">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?></h4>
        <?php if(empty($status)): ?>
          <form class="form-sample form-submit-api-data" id="crudFormAddApiData" action="<?php echo API_DOMAIN; ?>api/pms_project/pms_project/add" method="POST">
            <p class="card-description">Add new</p>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <label class="col-form-label"> Title</label>
                    <input type="text" class="form-control" name="title" />
                  </div>
                </div>
              </div>
              <!-- <div class="col-md-6">
    <div class="form-group row">
        <div class="col-sm-12">
            <label class="col-form-label">Users</label>
            <select class="form-control select2" name="employee_id[]" multiple>
                <option value="">Select User</option>
                < ?php 
                $get_user = $this->Internal_model->get_user_employee();
                foreach($get_user as $user) { 
                ?> 
                <option value="<  ?php echo $user->id;?>"> < ?php echo $user->first_name;?></option>
                < ?php } ?>
            </select>
        </div>
    </div>
</div> -->

              <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label">Agent Name</label>
                  <select class="form-control" name="agent_id">
                <option value="">Select Agent </option>
                <?php $get_agent = $this->Internal_model->get_agent();
                        foreach($get_agent as $agent) { ?> 
                        <option value="<?php echo $agent->id;?>"><?php echo $agent->first_name ;?></option>
                    <?php } ?>
            </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <label class="col-form-label">Agent Commission (per hours)</label>
                    <input type="text" class="form-control" name="agent_commission" />
                  </div>
                </div>
              </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label">Manager Name</label>
                  <select class="form-control" name="manager_id">
                <option value="">Select Manager </option>
                <?php $get_manager = $this->Internal_model->get_manager();
                        foreach($get_manager as $manager) { ?> 
                        <option value="<?php echo $manager->id;?>"><?php echo $manager->first_name ;?></option>
                    <?php } ?>
            </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Location</label>
                  <input type="text" class="form-control" name="location"/>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label">State Name</label>
                  <select class="form-control select2" name="state_id" onchange="get_city(this.value)">
                <option value="">Select State </option>
                <?php $get_state = $this->Internal_model->get_state();
                        foreach($get_state as $state) { ?> 
                        <option value="<?php echo $state->id;?>"><?php echo $state->name ;?></option>
                    <?php } ?>
            </select>
                </div>
              </div>
            </div>

        <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label">City</label>
                  <select class="form-control select2" name="city_id" id="city">
                <option value="">Select State First</option>
            </select>
                </div>
              </div>
            </div>


            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label">Billing Type</label>
                  <select class="form-control" name="billing_type" id="billing_type">
                <option value="">Select Billing Type</option>
                <option value="Fixed Rate">Fixed Rate</option>
                <option value="Hours Based">Hours Based</option>
            </select>
                </div>
              </div>
            </div>

          
        <div class="col-md-6 hours_fields hidden">
            <div class="form-group row">
                <div class="col-sm-12">
                    <label class="col-form-label">EST Hrs</label>
                    <input type="number" step="any" class="form-control" name="est_hrs"/>
                </div>
            </div>
        </div>
        <div class="col-md-6 hours_fields hidden">
            <div class="form-group row">
                <div class="col-sm-12">
                    <label class="col-form-label">HRS Rate</label>
                    <input type="number" step="any" class="form-control" name="hrs_rate"/>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group row">
                <div class="col-sm-12">
                    <label class="col-form-label">Amount</label>
                    <input type="number" step="any" class="form-control" name="amount"/>
                </div>
            </div>
        </div>

        <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label">Status</label>
                  <select class="form-control" name="status" >
                <option value="">Select Status</option>
                <option value="Not Started">Not Started</option>
                <option value="In Progress">In Progress</option>
                <option value="On Hold">On Hold</option>
                <option value="Finished">Finished</option>
                <option value="Cancelled">Cancelled</option>
            </select>
                </div>
              </div>
            </div>
            <div class="col-md-6 mt-2" >
              <div class="form-group">
                <label>File upload</label>
                <input type="file" name="file" class="file-upload-default">
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control file-upload-info" name="file" disabled placeholder="Upload Image">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Description</label>
                  <textarea type="text" class="form-control" name="description"/></textarea>
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
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <!-- Hidden Fields -->
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/Pms_project/pms_project_list" id="list_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/pms_project/pms_project/" id="delete_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/pms_project/pms_project_details" id="show_endpoint">
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
                  <select id="filterStatus" name="status" class="form-control">
                    <option value="">Select Status</option>
                    <option value="Not Started" <?php echo ($status == 'Not Started') ? 'selected' : ''; ?>>Not Started</option>
                    <option value="In Progress" <?php echo ($status == 'In Progress') ? 'selected' : ''; ?>>In Progress</option>
                    <option value="On Hold" <?php echo ($status == 'On Hold') ? 'selected' : ''; ?>>On Hold</option>
                    <option value="Cancelled" <?php echo ($status == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
                    <option value="Finished" <?php echo ($status == 'Finished') ? 'selected' : ''; ?>>Finished</option>
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
        <th>Location</th>
        <th>State</th>
        <th>Status</th>
        <th>Total Amount</th>
        <th>Total Income</th>
        <th>Due Amount</th>
        <th>Total Expenses</th>
        <th>Image</th>
        <th>Expense / Payment</th>
        <th>Project Details</th>
        <th>Option</th>
      </tr>
    </thead>
    <tbody id="api_response_table_body">
      <!-- Table data will be filled using JavaScript -->
    </tbody>
    <tfoot>
    <!-- Table footer row for totals -->
    <tr>
        <th colspan="5" style="text-align:right">Total:</th>
        <th id="totalAmountFooter"></th>
        <th id="totalIncomeFooter"></th>
        <th id="dueAmountFooter"></th>
        <th id="totalExpensesFooter"></th>
    </tr>
</tfoot>
  </table>
</div>

<script>
  function renderTableData() {
    return [
      { "data": null, "render": function(data, type, row, meta) {
        return meta.row + 1; // Adding 1 to meta.row to start from 1 instead of 0
      }},
      { "data": "title", "orderable": true },
      { "data": "location", "orderable": true },
      { "data": "state_name", "orderable": true },
      { 
        "data": "status", "orderable": true,
        "render": function(data, type, row) {
          return renderStatusBtn(data, type, row)
        }
      },
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
      { 
                    "data": "image",
                    "render": function(data, type, row) {
                        return '<img src="' + data + '" alt="Image">';
                    }
                },
      { 
        "data": null, 
        "render": function(data, type, row) {
          return renderOptionBtnPayment(data, type, row)
        }
      },
      { 
        "data": null, 
        "render": function(data, type, row) {
          return renderOptionBtnDetails(data, type, row)
        }
      },
      { 
        "data": null, 
        "render": function(data, type, row) {
          return renderOptionBtn(data, type, row)
        }
      }
    ];
  }

$(document).ready(function() {
  setTimeout(function() {
  function calculateTotalAmount() {
    var totalAmount = 0; 
    var totalIncome = 0;
    var dueAmount = 0;
    var totalExpenses = 0;

    $('#api_response_table tbody tr').each(function() {
      var rowDataAmount = parseFloat($(this).find('td:nth-child(6)').text().trim()); // Total Amount column
      var rowDataIncome = parseFloat($(this).find('td:nth-child(7)').text().trim()); // Total Income column
      var rowDataExpenses = parseFloat($(this).find('td:nth-child(9)').text().trim()); // Total Expenses column

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
    }, 1000); // Wait for 1 second before updating to ensure all AJAX requests are completed
  }

  updateTotalAmount(); // Update total amounts after page load

  $('#filterForm').submit(function(event) {
    setTimeout(function() {
    event.preventDefault(); 
    updateTotalAmount(); // Update total amounts after filtering
  }, 1000);
  });
}, 1000); 
});


</script>
<script>
$(document).ready(function() {
  <?php if(!empty($status)): ?>
    var decodedStatus = decodeURIComponent('<?php echo $status; ?>');
    $('#filterStatus').val(decodedStatus);
    $('#filterForm').submit();

    $(document).ajaxComplete(function() {
      setTimeout(function() {
      filterTableByStatus(decodedStatus);
        calculateTotalAmountStatus(); // Call calculateTotalAmount() after a delay
      }, 1000); // Adjust the delay time as needed
    });
  <?php endif; ?>
});

function calculateTotalAmountStatus() {
  var totalAmount = 0; 
  var totalIncome = 0;
  var dueAmount = 0;
  var totalExpenses = 0;

  $('#api_response_table tbody tr:visible').each(function() {
    var rowDataAmount = parseFloat($(this).find('td:nth-child(6)').text().trim()); // Total Amount column
    var rowDataIncome = parseFloat($(this).find('td:nth-child(7)').text().trim()); // Total Income column
    var rowDataExpenses = parseFloat($(this).find('td:nth-child(9)').text().trim()); // Total Expenses column

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

function filterTableByStatus(status) {
  $('#api_response_table tbody tr').each(function() {
    var rowStatus = $(this).find('td:eq(4)').text();
    if (rowStatus !== status) {
      $(this).hide();
    } else {
      $(this).show();
    }
  });

  calculateTotalAmountStatus();
}

  </script>

<script>
    $(document).ready(function() {
        $('#billing_type').change(function(){
            var selectedOption = $(this).val();
            if(selectedOption === 'Fixed Rate') {
                $('.hours_fields').addClass('hidden');
                $('.fixed_rate_field').removeClass('hidden');
            } else if(selectedOption === 'Hours Based') {
                $('.hours_fields').removeClass('hidden');
                $('.fixed_rate_field').addClass('hidden');
            } else {
                $('.hours_fields').addClass('hidden');
                $('.fixed_rate_field').addClass('hidden');
            }
        });
    });
</script>
<script>
      function renderOptionBtnPayment(data, type, row) {
    return `
      <div class="btn-group">
        <a href="<?php echo base_url();?>admin/master/expenses/${row.id}" class="btn btn-outline-info btn-sm" role="button">
          Expense
        </a>
        /
        <a href="<?php echo base_url();?>admin/master/payments/${row.id}" class="btn btn-outline-info btn-sm" role="button">
          Add Payment
        </a>
      </div>
    `;
  }
  function renderOptionBtnDetails(data, type, row) {
    return `
      <div class="btn-group">
        <a href="<?php echo base_url();?>admin/master/project_details/${row.id}" class="btn btn-outline-info btn-sm" role="button">
        Project Details
        </a>
      </div>
    `;
  }
  
  </script>
<script>
    function updateAmount() {
        var est_hrs_value = parseFloat(document.querySelector('input[name="est_hrs"]').value);
        var hrs_rate_value = parseFloat(document.querySelector('input[name="hrs_rate"]').value);
        
        var amount = est_hrs_value * hrs_rate_value;
        
        document.querySelector('input[name="amount"]').value = isNaN(amount) ? '' : amount;
    }
    
    document.querySelector('input[name="est_hrs"]').addEventListener('input', updateAmount);
    document.querySelector('input[name="hrs_rate"]').addEventListener('input', updateAmount);
</script>