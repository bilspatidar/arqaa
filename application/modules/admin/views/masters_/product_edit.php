<div class="modal_title_details"><h4>Edit Product</h4></div>
<form id="crudFormUpdateApiData" action="<?php echo API_DOMAIN; ?>api/product/product/update" method="POST" class="row g-3">
	<input type="hidden" name="id" class="form-control" value="<?php echo $data['id']; ?>"> 
     
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Name</label>
		<input type="text" name="name" class="form-control" value="<?php echo $data['name']; ?>"> 
	</div>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Short Name</label>
		<input type="text" name="short_name" class="form-control" value="<?php echo $data['short_name']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Product Code</label>
		<input type="text" name="product_code" class="form-control" value="<?php echo $data['product_code']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Barcode</label>
		<input type="text" name="barcode" class="form-control" value="<?php echo $data['barcode']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Category</label>
		<select name="category_id" class="form-control">
				  <option value="">Select Category</option>
				  <?php $getCategory = $this->Common->getCategory();
				  foreach ($getCategory as $Category){ ?>
				  <option value="<?php echo $Category->id ;?>" <?php if($data['subcategory_id'] == $Category->id) {echo 'selected';} ?>><?php echo $Category->name ;?></option>
				  <?php } ?>
				  </select>
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Subcategory</label> 
		<select name="subcategory_id" class="form-control">
				  <option value="">Select Sub Category</option>
				  <?php $get_sub_category = $this->Common->get_sub_category();
				  foreach ($get_sub_category as $SubCategory){ ?>
				  <option value="<?php echo $SubCategory->id ;?>" <?php if($data['subcategory_id'] == $SubCategory->id) {echo 'selected';} ?>><?php echo $SubCategory->name ;?></option>
				  <?php } ?>
				  </select>
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Brand</label>
		<select name="brand_id" class="form-control">
				  <option value="">Select Brand</option>
				  <?php $getBrand = $this->Common->getBrand();
				  foreach ($getBrand as $Brand){ ?>
				  <option value="<?php echo $Brand->id ;?>" <?php if($Brand->id == $data['brand_id']) {echo 'selected';} ?>><?php echo $Brand->name ;?></option>
				  <?php } ?>
		</select>		
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Unit</label>
		<select name="unit_id" class="form-control">
		  <option value="">Select Unit</option>
		  <?php $getUnit = $this->Common->getUnit();
		  foreach ($getUnit as $Unit){ ?>
		  <option value="<?php echo $Unit->id; ?>" <?php if ($data['unit_id'] == $Unit->id) {echo 'selected';} ?>><?php echo $Unit->name; ?></option>
		  <?php } ?>
		</select>
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Billing Unit Id</label>
		<input type="text" name="billing_unit_id" class="form-control" value="<?php echo $data['billing_unit_id']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Gst</label>
		<input type="text" name="gst" class="form-control" value="<?php echo $data['gst']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Sku</label>
		<input type="text" name="sku" class="form-control" value="<?php echo $data['sku']; ?>"> 
	</div>
    <div class="col-md-4 form-group">
		<label for="" class="form-label">Type</label>
		<input type="text" name="type" class="form-control" value="<?php echo $data['type']; ?>"> 
	</div>
>
	<div class="col-md-4 form-group">
		<label for="" class="form-label">Status</label>
		<select name="status" class="form-control input-sm">
			<option value="">Status</option>
			<option value="Active" <?php if( $data['status']=='Active'){ echo'selected'; }?>>Active</option>
			<option value="Deactive" <?php if( $data['status']=='Deactive'){ echo'selected'; }?>>Deactive</option>
		</select>
	</div>
	<div class="col-md-4 form-group">
                <label>File upload</label>
                <input type="file" name="image" class="file-upload-default">
                <div class="input-group col-xs-12">
                  <input type="text" class="form-control file-upload-info" name="image" disabled placeholder="Upload Image">
                  <span class="input-group-append">
                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                  </span>
                </div>
             
    </div>
	<div class="col-12"><br>
    <?php $this->load->view('includes/editFormButton'); ?>
	</div>
</form>

   