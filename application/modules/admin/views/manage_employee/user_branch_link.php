<div class="row">
  <?php $this->load->view('includes/collapseAddForm'); ?>
  
  <div class="col-12 grid-margin collapse show" id="collapseExample">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?></h4>
        <form class="form-sample" id="crudFormAddApiData" action="<?php echo API_DOMAIN; ?>api/employee/user_branch_link/add" method="POST">
          <p class="card-description">Add new</p>
          <div class="row">
          <div class="col-md-6">
    <div class="form-group row">
        <div class="col-sm-12">
            <label class="col-form-label">Users</label>
            <select name="user_id[]" class="form-control select2" multiple>
                        <option value="">Select User</option>
                        <?php $get_user = $this->Internal_model->get_user();
                        foreach($get_user as $user){ ?>
                            <option value="<?php echo $user->id; ?>"><?php echo $user->first_name; ?></option>
                        <?php } ?>
                    </select>
              </div>
          </div>
      </div>

            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label">Site</label>
                  <select name="branch_id" class="form-control">
                  <option value="">Select Site</option>
                  <?php $get_branch =  $this->Internal_model->get_branch();
                  foreach($get_branch as $branch){ ?>
                    <option value="<?php echo $branch->id;?>"><?php echo $branch->name; ?></option>
                 <?php } ?>
                  </select>
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
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/employee/user_branch_link_list" id="list_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/employee/user_branch_link/" id="delete_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/employee/user_branch_link_details" id="show_endpoint">
  <input type="hidden" value="admin/manage_employee/user_branch_link_edit" id="edit_page_name">
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
            <option value="Pending">Pending</option>
            <option value="Accepted">Accepted</option>
            <option value="Cancelled">Cancelled</option>
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
                <th>Employee Name</th>
                <th>Branch Name</th>
                <th>Branch Employee Code</th>
                <th>Form Role</th>
                <th>To Role</th>
                <th>Transfer Date</th>
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
  var dpsCode = <?php echo json_encode($this->Internal_model->getDPSCode()); ?>;
    return [
        { "data": null, "render": function(data, type, row, meta) {
            return meta.row + 1; // Adding 1 to meta.row to start from 1 instead of 0
        }},
        { "data": "FirstName", "orderable": true },
        { "data": "branchName", "orderable": true },
        {  "data": "branch_employee_code",  "orderable": true,
            "render": function(data, type, row) {
                return dpsCode + ' ' + data; 
            }
        },
        { "data": "from_role", "orderable": true },
        { "data": "to_role", "orderable": true },
        { "data": "transfer_date", "orderable": true },
        { "data": "status", "orderable": true },
        { 
            "data": null, 
            "render": function(data, type, row) {
              return renderOptionBtn(data, type, row)
            }
        }
    ];
}
</script> 

<script>
$(document).ready(function() {
    // Add dropdown when the button is clicked
    $('#add-dropdown').on('click', function() {
        // Clone the first dropdown and append it to the container
        var newDropdown = $('#dropdown-container select:first').clone();
        $('#dropdown-container').append(newDropdown);
    });
});
</script>



