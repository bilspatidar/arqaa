
<div class="row">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/user/company_user_list/<?php echo $role;?>" id="list_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/user/company_user/" id="delete_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/user/company_user_details" id="show_endpoint">
  <input type="hidden" value="admin/master/company_user_edit" id="edit_page_name">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h3 class="card-title"><?php echo $page_title; ?> <?php $this->load->view('includes/collapseFilterForm'); ?></h3>
        

         <div class="collapse show" id="collapseExampleFilter">
        <form id="filterForm">
          <div class="row">
            <div class="col-md-3 form-group">
            <input type="text" id="filterName" name="name" placeholder="<?php echo $this->lang->line('name');?>" class="form-control">
            </div>
            <!--<div class="col-md-3 form-group">
            <select id="filterStatus" name="status" class="form-control">
            <option value=""><?php echo $this->lang->line('select_status');?></option>
            <option value="Active"><?php echo $this->lang->line('active');?></option>
            <option value="Deactive"><?php echo $this->lang->line('inactive');?></option>
            </select>
            </div>-->
            <div class="col-md-3 form-group">
            <?php $this->load->view('includes/filter_form_btn'); ?>
            </div>
           </div>
       </form> 
       </div>

        <div class="table-responsive">
        <table class="table table-hover js-basic-example dataTable table-custom spacing5 " id="api_response_table">

            <thead>
              <tr>
                <th>#</th>
                <th><?php echo $this->lang->line('name');?></th>
                <th><?php echo $this->lang->line('last_name');?></th>
                <th><?php echo $this->lang->line('role');?></th>
                <th><?php echo $this->lang->line('status');?></th>
                <th><?php echo $this->lang->line('Action');?></th>
              </tr>
            </thead>
            <tbody id="api_response_table_body dataTables_paginate">
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
          return meta.row + 1;
        }
      },
      { "data": "name", "orderable": true },
      { "data": "last_name", "orderable": true },
      { "data": "email", "orderable": true },
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
    let currentValue = 2; // Initial value

    function updateOutput() {
        document.getElementById('spinValue').textContent = currentValue;
		$("#value_of_spin").val(currentValue);
    }

    function increment() {
        if (currentValue < 1000) {
            currentValue++;
            updateOutput();
        }
    }

    function decrement() {
        if (currentValue > 1) {
            currentValue--;
            updateOutput();
        }
    }
    function increment() {
    let spinValue = document.getElementById('spinValue');
    let hiddenInput = document.getElementById('value_of_spin');
    let currentValue = parseInt(spinValue.innerText);
    spinValue.innerText = currentValue + 1;
    hiddenInput.value = currentValue + 1; // Update the hidden input
}

function decrement() {
    let spinValue = document.getElementById('spinValue');
    let hiddenInput = document.getElementById('value_of_spin');
    let currentValue = parseInt(spinValue.innerText);
    if (currentValue > 1) { // Prevent decrementing below 1
        spinValue.innerText = currentValue - 1;
        hiddenInput.value = currentValue - 1; // Update the hidden input
    }
}

	
</script>
