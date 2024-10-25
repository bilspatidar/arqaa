<div class="row">
  <?php $this->load->view('includes/collapseAddForm'); ?>
  
  <div class="col-12 grid-margin collapse show" id="collapseExample">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?></h4>
        <form class="form-sample" id="crudFormAddApiData" action="<?php echo API_DOMAIN; ?>api/expenses_report/expenses_report/add" method="POST">
        
        </form>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/expenses_report/expenses_report_list" id="list_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/expenses_report/expenses_report/" id="delete_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/expenses_report/expenses_report_details" id="show_endpoint">
  <input type="hidden" value="admin/master/expenses_report_edit" id="edit_page_name">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?> <?php $this->load->view('includes/collapseFilterForm'); ?></h4>
        

         <div class="collapse show" id="collapseExampleFilter">
        <form id="filterForm">
          <div class="row">
            <div class="col-md-3 form-group">
            <input type="text" id="filterName" name="name" placeholder="Title" class="form-control">
            </div>
            <div class="col-md-3 form-group">
            <select id="filterAddedBy" name="added_by" class="form-control">
            <option value="">Select Added By</option>
            <?php $expense_user = $this->Internal_model->get_expense_user();
            foreach ($expense_user as $user){ ?>
          <option value="<?php echo $user->id;?>"><?php echo $user->first_name;?></option>
          <?php  }  ?>
            </select>
            </div>
            <div class="col-md-3 form-group">
            <select id="filterProject" name="project" class="form-control">
            <option value="">Select Project</option>
            <?php $get_project = $this->Internal_model->get_project();
            foreach ($get_project as $project){ ?>
          <option value="<?php echo $project->id;?>"><?php echo $project->title;?></option>
          <?php  }  ?>
            </select>
            </div>
            <div class="col-md-3 form-group">
            <select id="filterCategory" name="category" class="form-control">
            <option value="">Select Category</option>
            <?php $categories = $this->Internal_model->get_expense_categories();
            foreach ($categories as $category){ ?>
          <option value="<?php echo $category->id;?>"><?php echo $category->name;?></option>
          <?php  }  ?>
            </select>
            </div>
            <div class="col-md-3 form-group">
            <select id="filterStatus" name="status" class="form-control">
            <option value="">Select Status</option>
            <option value="Pending">Pending</option>
            <option value="Approved">Approved</option>
            <option value="Cancelled">Cancelled</option>
            </select>
            </div>
            <div class="col-md-3 form-group">
            <input type="date" id="filterFromDate" name="from_date" placeholder="From Date" class="form-control">
            </div>
            <div class="col-md-3 form-group">
            <input type="date" id="filterToDate" name="to_date" placeholder="To Date" class="form-control">
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
              </tr>
            </thead>
            <tbody id="api_response_table_body">
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" style="text-align:right">Total:</th>
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
            }
           
        ];
    }

    $(document).ready(function() {
  setTimeout(function() {
    function calculateTotalAmount() {
        var totalAmount = 0; // Initial value
        
        // Iterate through visible rows and calculate total amount
        $('#api_response_table tbody tr:visible').each(function() {
            var rowDataAmount = parseFloat($(this).find('td:nth-child(4)').text().trim()); // Total Amount column
            
            if (!isNaN(rowDataAmount)) {
                totalAmount += rowDataAmount;
            }
        });

        // Update total amount in the footer
        $("#totalAmountFooter").html(totalAmount.toFixed(2));
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

    // Trigger form submission and calculate total amount on page load if filters are applied
    <?php if(!empty($status)): ?>
        $('#filterForm').submit();
    <?php endif; ?>
     }, 1000);
});

</script>


<script>
  $(document).ready(function() {
    function toggleElementsVisibility() {
      var expenses_reportCategoryId = $('select[name="expenses_report_category_id"]').val();
      
      if (expenses_reportCategoryId === '5') {
        $('.employee-field').show();
        $('.machines-field').hide();
      } else if (expenses_reportCategoryId === '6') {
        $('.employee-field').hide();
        $('.machines-field').show();
      } else {
        $('.employee-field').hide();
        $('.machines-field').hide();
      }
    }
    
    toggleElementsVisibility();
    
    $('select[name="expenses_report_category_id"]').change(function() {
      toggleElementsVisibility();
    });
  });
</script>