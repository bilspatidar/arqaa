<div class="row">
  <?php $this->load->view('includes/collapseAddForm'); ?>
  
  <div class="col-12 grid-margin collapse show" id="collapseExample">
    <div class="card">
      <div class="card-body">
        <h3 class="card-title"><?php echo $page_title; ?></h3>
        <p class="texth2">Here you can add new news categories and also see all news categories as well as you can edit or delete it</p>
        <form class="form-sample" id="crudFormAddApiData" action="<?php echo API_DOMAIN; ?>api/news_categories/news_categories//add" method="POST">
          <h4 class="card-description"><?php echo $this->lang->line('add_new');?></h4>
          <div class="row">
		  
           
			 <div class="col-md-12">
    <div class="form-group row">
        <div class="col-sm-6">
            <label class="col-form-label"><?php echo $this->lang->line('name'); ?></label>
            <input type="text" class="form-control" name="name" >
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
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/news_categories/news_categories_list" id="list_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/news_categories/news_categories/" id="delete_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/news_categories/news_categories_details" id="show_endpoint">
  <input type="hidden" value="admin/master/news_categories_edit" id="edit_page_name">
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
        <table class="table table-hover js-basic-example dataTable table-custom spacing5 " id="api_response_table">
            <thead>
              <tr>
                <th>#</th>
                <th><?php echo $this->lang->line('news_category_name');?></th>
                <th><?php echo $this->lang->line('status');?></th>
                <th><?php echo $this->lang->line('Action');?></th>
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
                { "data": "name", "orderable": true  },
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
</script> 