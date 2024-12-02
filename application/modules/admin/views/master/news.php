<div class="row">
  <?php $this->load->view('includes/collapseAddForm'); ?>
  
  <div class="col-12 grid-margin collapse show" id="collapseExample">
    <div class="card">
      <div class="card-body">
        <h3 class="card-title"><?php echo $page_title; ?></h3>
        <p class="texth2">Here you can add new news and also see all news as well as you can edit or delete it</p>
        <form class="form-sample" id="crudFormAddApiData" action="<?php echo API_DOMAIN; ?>api/news/news/add" method="POST">
          <h4 class="card-description"><?php echo $this->lang->line('add_new');?> News</h4>
          <div class="row">
          <div class="col-md-12">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"><?php echo $this->lang->line('title');?></label>
                  <input type="text" class="form-control" name="title" />
                </div>
              </div>
              <input type="hidden" name="news_categories_id" value="1">
  </div>
		  <!--<div class="col-md-6">-->
    <!--          <div class="form-group row">-->
    <!--            <div class="col-sm-12">-->
    <!--              <label class="col-form-label"><?php echo $this->lang->line('news_categories');?></label>-->
				<!--  <select name="news_categories_id" class="form-control select2">-->
				<!--  <option value=""><?php echo $this->lang->line('select_option');?></option>-->
				  <!-- //$get_news_categories = $this->Internal_model->get_news_categories();-->
				<!--  //foreach($get_news_categories as $news_categories) { ?>-->
				<!--  <option value="<?php //echo $news_categories->id;?>"><?php echo $news_categories->name;?></option>-->
				<!--  <?php //} ?>-->
				<!--  </select>-->
    <!--            </div>-->
    <!--          </div>-->
    <!--        </div>-->
            
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> <?php echo $this->lang->line('image');?></label>
                  <input type="file" class="form-control" name="image" />
                </div>
              </div>
            </div>
            			 <div class="col-md-12">
    <div class="form-group row">
        <div class="col-sm-12">
            <label class="col-form-label"><?php echo $this->lang->line('short_description'); ?></label>
            <textarea class="form-control summernote" name="short_description" rows="4"></textarea>
        </div>
    </div>
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
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/news/news_list" id="list_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/news/news/" id="delete_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/news/news_details" id="show_endpoint">
  <input type="hidden" value="admin/master/news_edit" id="edit_page_name">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h3 class="card-title">All <?php echo $page_title; ?>  <?php $this->load->view('includes/collapseFilterForm'); ?></h3>
        

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
                <th><?php echo $this->lang->line('title');?></th>
                <th><?php echo $this->lang->line('short_description');?></th>
                <th><?php echo $this->lang->line('image');?></th>
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
 function renderTableData() {
  
  return [
    {
      "data": null,
      "render": function(data, type, row, meta) {
        return meta.row + 1; // Adding 1 to meta.row to start from 1 instead of 0
      }
    },
    { 
      "data": "title", // Check if 'name' exists in your data
      "orderable": true 
    },
    { 
      "data": "short_description", // Check if 'name' exists in your data
      "orderable": true 
    },
    {
      "data": "image",
      "render": function(data, type, row) {
        return '<img src="' + data + '" alt="Image" style="height: 60px; width: 80px;">';
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