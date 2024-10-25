<div class="row">
  <?php $this->load->view('includes/collapseAddForm'); ?>
  
  <div class="col-12 grid-margin collapse show" id="collapseExample">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?></h4>
        <form class="form-sample" id="crudFormAddApiData" action="<?php echo API_DOMAIN; ?>api/earrings/earrings/add" method="POST">
          <p class="card-description"><?php echo $this->lang->line('add_new');?></p>
          <div class="row">
          <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('name');?></label>
                  <input type="text" class="form-control" name="name" />
                </div>
              </div>
            </div>

          

            <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('user');?></label>
				  <select name="user_id" class="form-control" >
				  <option value=""><?php echo $this->lang->line('select_option');?></option>
				  <?php $get_user = $this->Internal_model->get_user();
				  foreach($get_user as $user) { ?>
				  <option value="<?php echo $user->id;?>"><?php echo $user->name;?></option>
				  <?php } ?>
				  </select>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('categorias');?></label>
				  <select name="category_id" class="form-control" >
				  <option value=""><?php echo $this->lang->line('select_option');?></option>
				  <?php $get_categories = $this->Internal_model->get_categories();
				  foreach($get_categories as $category) { ?>
				  <option value="<?php echo $category->id;?>"><?php echo $category->name;?></option>
				  <?php } ?>
				  </select>
                </div>
              </div>
            </div>

            <div class="col-md-4">
            <label class="col-form-label"><?php echo $this->lang->line('state');?></label>
       <select id="currencySelect" class="form-control" name="state">
        <option value="0"><?php echo $this->lang->line('select_option');?></option>
        
    </select>
</div>
<div class="col-md-12">
    <div class="form-group row">
        <div class="col-sm-12">
            <label class="col-form-label"><?php echo $this->lang->line('description'); ?></label>
            <textarea class="form-control summernote" name="description" rows="4"></textarea>
        </div>
    </div>
</div>
			
          </div>
          <div class="row">
            <div class="col-md-4">
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
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/earrings/earrings_list" id="list_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/earrings/earrings/" id="delete_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/earrings/earrings_details" id="show_endpoint">
  <input type="hidden" value="admin/master/earrings_edit" id="edit_page_name">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?> <?php $this->load->view('includes/collapseFilterForm'); ?></h4>
        

         <div class="collapse show" id="collapseExampleFilter">
        <form id="filterForm">
          <div class="row">
            <div class="col-md-3 form-group">
            <input type="text" id="filterName" name="name" placeholder="<?php echo $this->lang->line('name');?>" class="form-control">
            </div>
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
                <th><?php echo $this->lang->line('description');?></th>
                <th><?php echo $this->lang->line('user');?></th>
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
 function fetchUserName(userId) {
    let userName = 'Unknown User';
    var base_url = '<?php echo base_url();?>admin/admin/get_user';

    $.ajax({
        url: base_url,
        method: 'POST',
        data: { user_id: userId },
        async: false,
        success: function(response) {
            console.log('AJAX Response:', response);
            try {
                var data = JSON.parse(response);
                userName = data.name || 'Unknown User';
            } catch (e) {
                console.error('Error parsing JSON response:', e);
               // alert('Parsing error'); 
            }
        },
        error: function(xhr, status, error) {
            console.log('Error fetching user name:', error);
            //alert('Error: ' + error); 
        }
    });
    return userName;
}



  function renderTableData() {
    return [
      {
        "data": null,
        "render": function(data, type, row, meta) {
          return meta.row + 1; // Adding 1 to meta.row to start from 1 instead of 0
        }
      },
      { "data": "name", "orderable": true },
      { "data": "description", "orderable": true },
      {
		"data": "user_id",
		"orderable": true,
		"render": function(data, type, row) {
		   return fetchUserName(data); // Pass user_id to fetch the name
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