<div class="card">
                        <div class="header">
                          <!--  <h2>Account Data</h2>-->
                        </div>
                        <div class="body">	
                            <div class="row clearfix">
                              <!--  <div class="col-lg-4 col-md-12">                                            
                                    <div class="form-group">                                                
                                        <input type="text" class="form-control" value="louispierce" disabled placeholder="Username">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <input type="email" class="form-control" value="louis.info@yourdomain.com" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Phone Number">
                                    </div>
                                </div>-->                                
                                <div class="col-lg-12 col-md-12">
                                    <hr>
                                    <h6>Change Password</h6>
									<form id="crudFormAddApiData" action="<?php echo API_DOMAIN; ?>api/user/update_password" method="POST" class="row g-3" enctype="multipart/form-data">
                                    <div class="form-group col-md-6">
                                        <input type="password" name="old_password" class="form-control" placeholder="Current Password">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="password" name="password" class="form-control" placeholder="New Password">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="password" name="cPassword" class="form-control" placeholder="Confirm New Password">
                                    </div>
									<div class="col-sm-12">
									  <?php $this->load->view('includes/form_button'); ?>
									</div>
							</form>
                                </div>
                            </div>
							
                            <!--<button type="button" class="btn btn-round btn-primary">Update</button> &nbsp;&nbsp;
                            <button type="button" class="btn btn-round btn-default">Cancel</button>-->
						</div>
                    </div>     