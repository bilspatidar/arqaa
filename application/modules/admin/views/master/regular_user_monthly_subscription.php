<div class="row">
  <?php $this->load->view('includes/collapseAddForm'); ?>
  
  <div class="col-12 grid-margin collapse show" id="collapseExample">
    <div class="card">
      <div class="card-body">
        <h3 class="card-title texth2"><?php echo $page_title; ?></h3>
        <form class="form-sample " id="crudFormAddApiData" action="<?php echo API_DOMAIN; ?>api/regular_user_monthly_subscription/regular_user_monthly_subscription/add" method="POST">
          <p class="texth2">Here you can add new subscription and also see all subscription as well as you can edit or delete it</p>
        <h4 class="card-description texth2"><?php echo $this->lang->line('add_new_plan');?></h4>
          <br>
          <div class="row">
          <!-- <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> <?php echo $this->lang->line('image');?></label>
                  <input type="file" class="form-control" name="image" />
                </div>
              </div>
            </div>  -->
          <div class="col-md-4">
            <label class="col-form-label"><?php echo $this->lang->line('subscription_type');?></label>
            <select  name="sub_type" class="form-control Select2">
             
                <option value="Boost Your Profile">Boost Your Profile</option>
                <option value="Extra Service">Extra Service</option>
                <option value="Advertising Banner">Advertising Banner</option>
                <option value="CV / Resume">CV / Resume</option>
        
            </select>
        </div>
         
          
         

            <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('price');?></label>
                  <input type="text" class="form-control" name="price" />
                </div>
              </div>
            </div>
           
            <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('currency');?></label>
				  <select name="currency" class="form-control select2" >
				  <option value=""><?php echo $this->lang->line('select_option');?></option>
				  <?php $get_currencys = $this->Internal_model->get_currency();
				  foreach($get_currencys as $get_currency) { ?>
				  <option value="<?php echo $get_currency->symbol;?>"><?php echo $get_currency->name;?> (<?php echo $get_currency->symbol;?>)</option>
				  <?php } ?>
				  </select>
                </div>
              </div>
            </div>

           
            <div class="col-md-4">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('tax');?></label>
                  <input type="text" class="form-control" name="tax" />
                </div>
              </div>
            </div>
           
   <div class="col-md-12">
    <div class="form-group row">
        <div class="col-sm-12">
            <label class="col-form-label"><?php echo $this->lang->line('description'); ?></label>
            <textarea class="form-control summernote" name="concept" rows="4"></textarea>
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
     <input type="hidden" value="<?php echo API_DOMAIN; ?>api/regular_user_monthly_subscription/regular_user_monthly_subscription_list" id="list_end_point">
    <input type="hidden" value="<?php echo API_DOMAIN; ?>api/regular_user_monthly_subscription/regular_user_monthly_subscription/" id="delete_end_point">
    <input type="hidden" value="<?php echo API_DOMAIN; ?>api/regular_user_monthly_subscription/regular_user_monthly_subscription_details" id="show_endpoint">
    <input type="hidden" value="admin/master/regular_user_monthly_subscription_edit" id="edit_page_name">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h3 class="card-title"><?php echo $page_title; ?> Plan <?php $this->load->view('includes/collapseFilterForm'); ?></h3>
        

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
                <th><?php echo $this->lang->line('description');?></th>
                <th><?php echo $this->lang->line('prices');?></th>
                <th><?php echo $this->lang->line('currency');?></th>
                <th><?php echo $this->lang->line('taxes');?></th>
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
      { "data": "concept", "orderable": true },
      { "data": "price", "orderable": true },
      { "data": "currency", "orderable": true },
      { "data": "tax", "orderable": true },
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