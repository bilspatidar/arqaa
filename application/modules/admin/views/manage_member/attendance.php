<div class="row">
  <?php $this->load->view('includes/collapseAddForm'); ?>
  
  <div class="col-12 grid-margin collapse show" id="collapseExample">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?></h4>
      <form class="form-sample" id="crudFormAddApiDataMultiple" action="<?php echo API_DOMAIN; ?>api/attendance/attendance/add" method="POST">
    <p class="card-description">Add new</p>
 <!-- <input type="hidden" name="change_date" onchange="getDateUserData(this.value)"> -->
 <input type="date" name="date" onchange="getDateUserData(this.value)" value="<?php echo date('Y-m-d');?>">
 
    <div class="table-responsive" id="date_html">
        <table class="table table-dark table-striped" id="">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Employee Name</th>
                    <th>Remarks</th>
                    <!-- <th>Latitude</th>
                    <th>Longitude</th> -->
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            
                <?php 
             
                $getUser = $this->Internal_model->getUser();
                $sr = 1;
                foreach($getUser as $row){ ?>
                <tr>
                    <td><?php echo $sr++;?></td>
                    
                    <td>
                    <input type="hidden" name="user_id[]" value="<?php echo $row->users_name;?>" readonly>
                    <input type="text" value="<?php echo $row->first_name;?>" readonly></td>
                    <td><input type="text" name="remarks[]" ></td>
                    <input type="hidden" name="latitude[]">
                    <input type="hidden" name="longitude[]">
                    <td><select name="status[]"><option value="Absent">Absent</option><option value="Present">Present</option>
                            <option value="Half day">Half day</option>
                            <option value="Leave">Leave</option>
                        </select>
                    </td>
                </tr>
                <?php  } ?>
            </tbody>
        </table>
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
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/attendance/attendance_list" id="list_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/attendance/attendance/" id="delete_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/attendance/attendance_details" id="show_endpoint">
  <input type="hidden" value="admin/manage_member/attendance_edit" id="edit_page_name">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?> <?php $this->load->view('includes/collapseFilterForm'); ?></h4>
        

         <div class="collapse show" id="collapseExampleFilter">
        <form id="filterForm">
          <div class="row">
            <div class="col-md-3 form-group">
            <select id="filterName" name="name" class="form-control">
              <option value="">Select User</option>
              <?php $getUser = $this->Internal_model->getUser();
                foreach($getUser as $row){ ?>
              <option value="<?php echo $row->users_id;?>"><?php echo $row->first_name;?></option>
              <?php } ?>
            </select>
           </div>
            <div class="col-md-3 form-group">
            <select id="filterStatus" name="status" class="form-control">
            <option value="">Select Status</option>
            <option value="Absent">Absent</option>
            <option value="Present">Present</option>
            <option value="Half day">Half day</option>
            <option value="Leave">Leave</option>
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
                <th>Employee Name</th>
                <th>Remarks</th>
                <th>Date</th>
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
                { "data": null, "render": function(data, type, row, meta) {
                    return meta.row + 1; // Adding 1 to meta.row to start from 1 instead of 0
                }},
                { "data": "FirstName", "orderable": true  },
                { "data": "remarks", "orderable": true },
                { "data": "date", "orderable": true },
                { "data": "status", "orderable": true },
               
                { 
                    "data": null, 
                    "render": function(data, type, row) {
                      return renderOptionBtn(data, type, row)
                    }
                }
            ]
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




