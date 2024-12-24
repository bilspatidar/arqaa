<div class="modal_title_details text-center mb-4">
<h4 class="card-title">Edit Pages</h4></div>

<form id="crudFormUpdateApiData" action="<?php echo API_DOMAIN; ?>api/pages/pages/update" method="POST" class="row">
    <input type="hidden" name="id" class="form-control" value="<?php echo $data['id']; ?>">

    <!-- Title Field -->
    <div class="col-md-4 ">
    <div class="form-group">

        <label for="title" class="form-label">Title</label>
        <input type="text" id="title" name="title" class="form-control" value="<?php echo $data['title']; ?>">
        <div class="invalid-feedback">Please provide a title.</div>
    </div>
    </div>
    <!-- Page Name Field -->
    <div class="col-md-4">
    <div class="form-group">

        <label for="page_name" class="form-label">Page Name *</label>
        <select id="page_name" name="page_name" class="form-control select2">
            <option value="">Select Page</option>
            <option value="About" <?php echo ($data['page_name'] == 'About') ? 'selected' : ''; ?>>About</option>
            <option value="Privacy & Policy" <?php echo ($data['page_name'] == 'Privacy & Policy') ? 'selected' : ''; ?>>Privacy & Policy</option>
            <option value="FAQ" <?php echo ($data['page_name'] == 'FAQ') ? 'selected' : ''; ?>>FAQ</option>
            <option value="Terms & Condition" <?php echo ($data['page_name'] == 'Terms & Condition') ? 'selected' : ''; ?>>Terms & Condition</option>
        </select>
        <div class="invalid-feedback">Please select a page name.</div>
    </div>
    </div>
    <div class="col-md-4">
    <div class="form-group">
        <?php 
        // Default file URL
        $defaultImage = base_url('uploads/no_file.jpg');
        $fileUrl = !empty($data['image']) ? $data['image'] : $defaultImage;
        ?>
        <label for="file" class="form-label">Upload File</label>
        
        <!-- File Input -->
        <input type="file" class="form-control" name="image" id="image" />

        <!-- Display current file if exists -->
         
        <p class="mt-2">Current File: 
            <a href="<?php echo $fileUrl; ?>" target="_blank">View</a>
        </p>

        <!-- Optionally show an image preview if available -->
        <!-- <img id="currentImage" src="<?php echo $fileUrl; ?>" alt="Uploaded Image" class="img-fluid" style="max-width: 100px;"> -->
    </div>
</div>


    <!-- Status Field -->
    <div class="col-md-4 ">
    <div class="form-group">
        <label for="status" class="form-label">Status</label>
        <select id="status" name="status" class="form-control select2">
            <option value="">Select Status</option>
            <option value="Active" <?php echo ($data['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
            <option value="Deactive" <?php echo ($data['status'] == 'Deactive') ? 'selected' : ''; ?>>Deactive</option>
        </select>
    </div>
    </div>
    <!-- Description Field -->
   
    <div class="col-md-12">
              <div class="form-group">
                <label class="col-form-label"><?php echo $this->lang->line('description'); ?></label>
                <textarea id="description" class="form-control summernote" name="description" rows="4"><?php echo $data['description']; ?></textarea>
                </div>
            </div>
    <!-- Submit Button -->
    <div class="col-12 text-left mt-4">
        <?php $this->load->view('includes/editFormButton'); ?>
    </div>
</form>
