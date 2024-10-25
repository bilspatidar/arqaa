<div class="row">
  <?php $this->load->view('includes/collapseAddForm'); ?>
  
  <div class="col-12 grid-margin collapse show" id="collapseExample">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title"><?php echo $page_title; ?></h4>
        <form class="form-sample" id="crudFormAddApiData" 
        action="<?php echo API_DOMAIN; ?>api/user/update_password" method="POST">
          <p class="card-description">Add new</p>
          <div class="row">
          <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label">Old Password</label>
                  <input type="text" class="form-control" name="old_password" />
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label">New Password </label>
                  <input type="text" class="form-control" name="password" />
                </div>
              </div>
            </div>
           
            <div class="col-md-6">
              <div class="form-group row">
                <div class="col-sm-12">
                  <label class="col-form-label">Confirm Password</label>
                  <input type="text" class="form-control" name="cPassword" />
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

