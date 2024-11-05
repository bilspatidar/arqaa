<?php 
 $users_id = getUser('id');
 $UserDetails = $this->Internal_model->getUserDetails($users_id) ;?>
 <div class="refresh-page">

        <div class="block-header">
            <div class="row clearfix">
                <div class="col-md-6 col-sm-12">
                    <h1>User Profile</h1>
                </div>            
                <div class="col-md-6 col-sm-12 text-right">
                    <div class="inlineblock vivify swoopInTop delay-900 mr-4">Visitors <span id="mini-bar-chart1" class="mini-bar-chart"></span></div>
                    <div class="inlineblock vivify swoopInTop delay-950 mr-4">Visits <span id="mini-bar-chart2" class="mini-bar-chart"></span></div>
                    <div class="inlineblock vivify swoopInTop delay-1000">Chats <span id="mini-bar-chart3" class="mini-bar-chart"></span></div>
                </div>
            </div>
        </div>
        
        <div class="container-fluid">
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="card social">
                        <div class="profile-header d-flex justify-content-between justify-content-center">
                            <div class="d-flex">
                                <div class="mr-3">
                                    <img src="<?php echo $UserDetails[0]->profile_pic;?>" class="rounded" alt="">
                                </div>
                                <div class="details">
                                    <h5 class="mb-0"><?php echo $UserDetails[0]->name;?></h5>
                                </div>                                
                            </div>
                        </div>
                    </div>                    
                </div>               

                <div class="col-xl-9 col-lg-8 col-md-7">
                    <div class="card">
                        <div class="header">
                            <h2>Basic Information</h2>
                        </div>
                        <div class="body"> 
<form id="crudFormAddApiData" action="<?php echo API_DOMAIN; ?>api/user/user_profile_update/update" method="POST" class="row g-3" enctype="multipart/form-data">						
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">   
 <input type="hidden" class="form-control" name="id" value="<?php echo $UserDetails[0]->id;?>">									
                                        <input type="text" class="form-control" name="name" placeholder="<?php echo $this->lang->line('name');?>" value="<?php echo $UserDetails[0]->name;?>">
                                    </div>
                                </div>  
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">                                                
                                        <input type="text" class="form-control" name="mobile" placeholder="<?php echo $this->lang->line('mobile');?>" value="<?php echo $UserDetails[0]->mobile;?>">
                                    </div>
                                </div> 
                               <div class="col-lg-6 col-md-12">
                                    <div class="form-group">                                                
                                        <input type="email" class="form-control" name="email" placeholder="<?php echo $this->lang->line('email');?>" value="<?php echo $UserDetails[0]->email;?>">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">                                                
                                        <textarea rows="4" type="text" name="address" class="form-control" placeholder="<?php echo $this->lang->line('address');?>"><?php echo $UserDetails[0]->address;?></textarea>
                                    </div>
                                </div>
								<div class="col-lg-6 col-md-12">
                                    <div class="form-group">                                                
                                        <input type="file" class="form-control" name="profile_pic">
                                    </div>
                                </div>
                            </div>
							<div class="col-12"><br>
								<?php $this->load->view('includes/editFormButton'); ?>
							</div>
							</form>
                        </div>
                    </div>
                                
                </div>

                <div class="col-xl-3 col-lg-4 col-md-5">
                    <div class="card">
                        <div class="header">
                            <h2>Info</h2>
                        </div>
                        <div class="body">
                            <small class="text-muted">Address: </small>
                            <p><?php echo $UserDetails[0]->address;?></p>
                            <hr>
                            <small class="text-muted">Email address: </small>
                            <p><?php echo $UserDetails[0]->email;?></p>                            
                            <hr>
                            <small class="text-muted">Mobile: </small>
                            <p><?php echo $UserDetails[0]->mobile;?></p>
                            <hr>
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
</div>





