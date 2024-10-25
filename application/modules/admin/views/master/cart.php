
<div class="row">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/category/category_list" id="list_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/category/category/" id="delete_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/category/category_details" id="show_endpoint">
  <input type="hidden" value="admin/master/category_edit" id="edit_page_name">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?> <?php $this->load->view('includes/collapseFilterForm'); ?></h4>
        

         <div class="collapse show" id="collapseExampleFilter">
        <form id="filterForm">
          <div class="row">
            <div class="col-md-3 form-group">
            <label class="col-form-label"><?php echo $this->lang->line('name');?></label>

            <input type="text" id="filterName" name="name" placeholder="<?php echo $this->lang->line('name');?>" class="form-control">
            </div>
            <div class="col-md-3 form-group">
            <label class="col-form-label"><?php echo $this->lang->line('select_status');?></label>

            <select id="filterStatus" name="status" class="form-control">
            <option value=""><?php echo $this->lang->line('select_status');?></option>
            <option value="Active"><?php echo $this->lang->line('active');?></option>
            <option value="Deactive"><?php echo $this->lang->line('inactive');?></option>
            </select>
            </div>
            <div class="col-md-3 form-group">
            <label class="col-form-label"><?php echo $this->lang->line('starting_date');?></label>

            <input type="date" id="filterFromDate" name="starting_date" placeholder="<?php echo $this->lang->line('starting_date');?>" class="form-control">
            </div>
            <div class="col-md-3 form-group">
            <label class="col-form-label"><?php echo $this->lang->line('end_date');?></label>

            <input type="date" id="filterToDate" name="end_date" placeholder="<?php echo $this->lang->line('end_date');?>" class="form-control">
            </div>
            <div class="col-md-3 form-group">
            <?php $this->load->view('includes/filter_form_btn'); ?>
            </div>
           
           </div>
       </form> 
       </div>

        <div class="table-responsive">
        <table class="table table-hover js-basic-example dataTable table-custom spacing5  " id="api_response_table">

            <thead>
              <tr>
                <th>#</th>
                <th><?php echo $this->lang->line('name');?></th>
                <th><?php echo $this->lang->line('mail');?></th>
                <th><?php echo $this->lang->line('cellular');?></th>
                <th><?php echo $this->lang->line('country');?></th>
                <th><?php echo $this->lang->line('date');?></th>
                <th><?php echo $this->lang->line('information');?></th>
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
          return meta.row + 1; // Adding 1 to meta.row to start from 1 instead of 0
        }
      },
      { "data": "name", "orderable": true },
      { "data": "name", "orderable": true },
      { "data": "name", "orderable": true },
      {
        "data": "image",
        "render": function(data, type, row) {
          // Agar image data available hai to usse display karo, warna default image
          var imageUrl = data ? data : '/uploads/no_file.jpg';
          return '<img src="' + imageUrl + '" alt="Image" style="height: 60px; width: 80px;">';
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
/*
  function renderTableData(){
    return [
                { "data": null, "render": function(data, type, row, meta) {
                    return meta.row + 1; // Adding 1 to meta.row to start from 1 instead of 0
                }},
                { "data": "name", "orderable": true  },
                { 
                    "data": "image",
                  //  "render": function(data, type, row) {
                  //      return '<img src="' + data + '" alt="Image" style="height: 60px; width: 80px;">';
                  //  }
					"render": function(data, type, row) {
					  var imageUrl = data ? data : 'uploads/no_file.jpg';
					  return '<img src="' + imageUrl + '" alt="Image" style="height: 60px; width: 80px;">';
					}
                },
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
  */
  </script>