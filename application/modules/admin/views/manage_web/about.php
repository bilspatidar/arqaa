<?php 
    $result = $this->Internal_model->get_about_data();
  ?>

<div class="row">
  <?php $this->load->view('includes/collapseAddForm'); ?>
  
  <div class="col-12 grid-margin collapse show" id="collapseExample">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?></h4>
        <form class="form-sample autoload" id="crudFormAddApiData" action="<?php echo API_DOMAIN; ?>api/about/about/add" method="POST">
          <p class="card-description">Add new</p>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label">Title</label>
                  <input type="hidden" class="form-control" name="id" value="<?php echo $result[0]->id;?>">
                  <input type="text" class="form-control" name="title" value="<?php echo $result[0]->title;?>">
                </div>
              </div>
            </div>
           
           
            <div class="col-md-6 mt-2" >
              <div class="form-group">
                <label>File upload</label>
                <input type="file" name="image" class="file-upload-default">
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control file-upload-info" name="image" disabled placeholder="Upload Image">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                  </span>
                </div>
              </div>
            </div>
            <div class="col-md-12">
             <div class="form-group row">
               <div class="col-sm-12">
                <label class="col-form-label">Description</label>
                <textarea class="form-control" name="description"><?php echo $result[0]->description;?></textarea>
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
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/about/about_list" id="list_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/about/about/" id="delete_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/about/about_details" id="show_endpoint">
  <input type="hidden" value="admin/manage_web/about_edit" id="edit_page_name">
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
            <option value="Active">Active</option>
            <option value="Deactive">Inactive</option>
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
                <th>Title</th>
                <th>Image</th>
                <th>Description</th>
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
                { "data": "title", "orderable": true  },
                { 
                    "data": "image",
                    "render": function(data, type, row) {
                        return '<img src="' + data + '" alt="Image">';
                    }
                },
                { "data": "description", "orderable": true }
                
            ]
  }
</script> 

<script>
  document.getElementById('crudFormAddApiData').addEventListener('submit', function(event) {
    event.preventDefault();
    this.submit();
    setTimeout(function() {
      location.reload();
    }, 100);
  });
</script>



