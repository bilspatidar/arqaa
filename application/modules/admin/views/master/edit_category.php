<form id="crudFormEdit" action="<?php echo base_url(); ?>api/category/category_update" method="POST" class="row g-3">
    <input type="hidden" name="id" class="form-control">
    <div class="col-md-4">
        <label for="" class="form-label">Name</label>
        <input type="text" name="name" class="form-control"> 
    </div>
    <div class="col-md-4">
        <label for="" class="form-label">Short Name</label>
        <input type="text" name="shortName" class="form-control"> 
    </div>
    <div class="col-md-4">
        <label for="" class="form-label">Status</label>
        <select name="status" class="form-control input-sm">
            <option value="">Status</option>
            <option value="Active">Active</option>
            <option value="Deactive">Deactive</option>
        </select>
    </div>
    <div class="col-12">
        <button class="btn btn-outline-primary btn-sm" type="submit">Submit</button>
    </div>
</form>