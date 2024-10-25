<div class="row">
  <?php $this->load->view('includes/collapseAddForm'); ?>
  
  <div class="col-12 grid-margin collapse show" id="collapseExample">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?></h4>
        <form class="form-sample" id="crudFormAddApiData" action="<?php echo API_DOMAIN; ?>api/product/product/add" method="POST">
          <p class="card-description">Add new</p>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Name</label>
                  <input type="text" class="form-control" name="name" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Short Name</label>
                  <input type="text" class="form-control" name="shortName"/>
                </div>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Category</label>
				  <select name="category_id" class="form-control">
				  <option value="">Select Category</option>
				  <?php $getCategory = $this->Common->getCategory();
				  foreach ($getCategory as $Category){ ?>
				  <option value="<?php echo $Category->id ;?>"><?php echo $Category->name ;?></option>
				  <?php } ?>
				  </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Sub Category</label>
				  <select name="subcategory_id" class="form-control">
				  <option value="">Select Sub Category</option>
				  <?php $get_sub_category = $this->Common->get_sub_category();
				  foreach ($get_sub_category as $SubCategory){ ?>
				  <option value="<?php echo $SubCategory->id ;?>"><?php echo $SubCategory->name ;?></option>
				  <?php } ?>
				  </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Brand</label>
				  <select name="brand_id" class="form-control">
				  <option value="">Select Brand</option>
				  <?php $getBrand = $this->Common->getBrand();
				  foreach ($getBrand as $Brand){ ?>
				  <option value="<?php echo $Brand->id ;?>"><?php echo $Brand->name ;?></option>
				  <?php } ?>
				  </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Unit</label>
				  <select name="unit_id" class="form-control">
				  <option value="">Select Unit</option>
				  <?php $getUnit = $this->Common->getUnit();
				  foreach ($getUnit as $Unit){ ?>
				  <option value="<?php echo $Unit->id ;?>"><?php echo $Unit->name ;?></option>
				  <?php } ?>
				  </select>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Billing Unit</label>
                  <input type="text" class="form-control" name="billing_unit_id" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Gst</label>
                  <input type="text" class="form-control" name="gst" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Sku</label>
                  <input type="text" class="form-control" name="sku" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label"> Type</label>
                  <input type="text" class="form-control" name="Type" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
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
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/product/product_list" id="list_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/product/product/" id="delete_end_point">
  <input type="hidden" value="<?php echo API_DOMAIN; ?>api/product/product_details" id="show_endpoint">
  <input type="hidden" value="admin/master/product_edit" id="edit_page_name">
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
                <th>Name</th>
                <th>Short name</th>
                <th>Product Code</th>
                <th>Barcode</th>
                <th>Category</th>
                <th>Subcategory</th>
                <th>Brand</th>
                <th>Unit</th>
                <th>Billing Unit</th>
                <th>Gst</th>
                <th>Sku</th>
                <th>Type</th>
                <th>Image</th>
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
                { "data": "name", "orderable": true  },
                { "data": "short_name", "orderable": true },
                { "data": "product_code", "orderable": true },
                { "data": "barcode", "orderable": true },
                { "data": "category_id", "orderable": true },
                { "data": "subcategory_id", "orderable": true },
                { "data": "brand_id", "orderable": true },
                { "data": "unit_id", "orderable": true },
                { "data": "billing_unit_id", "orderable": true },
                { "data": "gst", "orderable": true },
                { "data": "sku", "orderable": true },
                { "data": "type", "orderable": true },
               
                { 
                    "data": "image",
                    "render": function(data, type, row) {
                        return '<img src="' + data + '" alt="Image">';
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
</script> 