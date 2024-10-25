<div class="row">
  <?php $this->load->view('includes/collapseAddForm'); ?>
  
  <div class="col-12 grid-margin collapse show" id="collapseExample">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?></h4>
        <form class="form-sample" id="crudFormAddApiData" action="<?php echo API_DOMAIN; ?>api/taxes/taxes/add" method="POST">
          <p class="card-description"><?php echo $this->lang->line('add_new');?></p>
          <div class="row">
          <div class="col-md-12">
    <div class="form-group row">
        <div class="col-sm-12">
            <label class="col-form-label"><?php echo $this->lang->line('concept'); ?></label>
            <textarea class="form-control" name="concept" rows="4"></textarea>
        </div>
    </div>
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
            <label class="col-form-label"><?php echo $this->lang->line('currency');?></label>
       <select id="currencySelect" class="form-control">
        <option value="0">Seleccione una opción</option>
        <option value="MXN">MXN</option>
        <option value="USA">USA</option>
        <option value="EUR">EUR</option>
    </select>
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
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/taxes/taxes_list" id="list_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/taxes/taxes/" id="delete_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/taxes/taxes_details" id="show_endpoint">
  <input type="hidden" value="admin/master/taxes_edit" id="edit_page_name">
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
        <table class="table table-hover js-basic-example dataTable table-custom spacing5 " id="api_response_table">

            <thead>
              <tr>
                <th>#</th>
                <th><?php echo $this->lang->line('concept');?></th>
                <th><?php echo $this->lang->line('price');?></th>
                <th><?php echo $this->lang->line('currency');?></th>
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
          return meta.row + 1; // Adding 1 to meta.row to start from 1 instead of 0
        }
      },
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