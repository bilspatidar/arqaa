<div class="row">
  <?php $this->load->view('includes/collapseAddForm'); ?>
  
  <div class="col-12 grid-margin collapse show" id="collapseExample">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?></h4>
        <form class="form-sample" id="crudFormAddApiData" action="<?php echo API_DOMAIN; ?>api/pages/pages/add" method="POST">
        <!-- <input type="hidden" name="id" value="<?php echo $row[0]->id; ?>"> -->

          <p class="card-description"><?php echo $this->lang->line('add_new'); ?></p>
          
          <div class="row">
            <!-- Title Input -->
            <div class="col-md-4">
              <div class="form-group">
                <label class="col-form-label"><?php echo $this->lang->line('title'); ?></label>
                <input type="text" class="form-control" name="title"/>
              </div>
            </div>
            
            <!-- Pages Name Dropdown -->
            <div class="col-md-4">
                        <label for="page_name" class="form-label">Page Name *</label>
                        <select name="page_name" class="form-control select2" required>
                            <option value="">Selecte Page</option>
                            <option value="About" >About</option>
                            <option value="Privacy & Policy" >Privacy & Policy</option>
                            <option value="FAQ" >FAQ </option>
                            <option value="Terms & Condition" >Terms & Condition</option>
                        </select>
                    </div>
            
            <!-- Image Upload -->
            
          <div class="col-md-4">
          <div class="form-group">
         <label class="col-form-label"><?php echo $this->lang->line('image'); ?></label>
         <input type="file" class="form-control" name="image"  />
         </div>
          </div>
          
         
            <!-- Description Input -->
            <div class="col-md-12">
              <div class="form-group">
                <label class="col-form-label"><?php echo $this->lang->line('description'); ?></label>
                <textarea class="form-control summernote" name="description" rows="4"></textarea>
              </div>
            </div>
          
          
    </div>
          <div class="row">
            <!-- Submit Button -->
            <div class="col-md-4">
              <div class="form-group">
                <?php $this->load->view('includes/form_button'); ?>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/pages/pages_list" id="list_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/pages/pages/" id="delete_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/pages/pages_details" id="show_endpoint">
  <input type="hidden" value="admin/master/pages_edit" id="edit_page_name">
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
            <div class="col-md-3 form-group">
            <select id="filterStatus" name="status" class="form-control">
            <option value=""><?php echo $this->lang->line('select_status');?></option>
            <option value="Active"><?php echo $this->lang->line('active');?></option>
            <option value="Deactive"><?php echo $this->lang->line('inactive');?></option>
            </select>
            </div>
            <div class="col-md-3 form-group">
            <?php $this->load->view('includes/filter_form_btn'); ?>
            </div>
           </div>
       </form> 
       </div>

        <div class="table-responsive">
        <table class="table table-hover js-basic-example dataTable table-custom spacing5" id="api_response_table">

            <thead>
              <tr>
                <th>#</th>
                <th><?php echo $this->lang->line('title');?></th>
                <th><?php echo $this->lang->line('image');?></th>
                <th><?php echo $this->lang->line('status');?></th>
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
      { "data": "title", "orderable": true },
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