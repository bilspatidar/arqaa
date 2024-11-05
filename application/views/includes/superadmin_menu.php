<?php 
 $users_id = getUser('id');
 $UserDetails = $this->Internal_model->getUserDetails($users_id) ;?>

<div id="left-sidebar" class="sidebar">
        <div class="navbar-brand">
            <a href="#"><img src="<?php echo base_url(); ?>assets/assets/images/icon.svg" alt="Osam Logo" class="img-fluid logo"><span>Osam</span></a>
            <button type="button" class="btn-toggle-offcanvas btn btn-sm float-right"><i class="lnr lnr-menu fa fa-chevron-circle-left"></i></button>
        </div>
        <div class="sidebar-scroll">
            <div class="user-account">

                <div class="user_div">
                    <img src="<?php echo $UserDetails[0]->profile_pic;?>" class="user-photo" alt="User Profile Picture">
                </div>
                <div class="dropdown">
                    <span>Welcome,</span>
                    <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong><?php echo $UserDetails[0]->name;?></strong></a>
                    <ul class="dropdown-menu dropdown-menu-right account vivify flipInY">
                        <li><a href="<?php echo base_url();?>admin/master/my_profile"><i class="icon-user"></i>My Profile</a></li>
                        <!-- <li><a href="app-inbox.html"><i class="icon-envelope-open"></i>Messages</a></li> -->
                        <li><a href="<?php echo base_url();?>admin/master/setting"><i class="icon-settings"></i><?php echo $this->lang->line('change_password') ?: 'Change Password';?></a></li>
                       
                        <li><a href="<?php echo base_url();?>admin/admin/logout"><i class="icon-power"></i>Logout</a></li>
                    </ul>
                </div>
                <a href="javascript:void(0);" class="btn btn-sm btn-block btn-primary btn-round mt-3" title=""><i class="icon-plus mr-1"></i> Create New</a>
            </div>  
            <nav id="left-sidebar-nav" class="sidebar-nav">
                <ul id="main-menu" class="metismenu">
                    <li class="header">Main</li>
                  
                    <li>
                        <a href="#uiElements" class="has-arrow"><i class="icon-diamond"></i><span><?php echo $this->lang->line('control_de_precios'); ?></span></a>
                        <ul>
                           <li><a href="<?php echo base_url();?>admin/master/regular_user_monthly_subscription"><?php echo $this->lang->line('regular_user_monthly_subscription');?> </a></li>
                           <!-- <li><a href="<?php echo base_url();?>admin/master/monthly_subscription_for_company_users"><?php echo $this->lang->line('monthly_subscription_for_company_users');?> </a></li>
                           <li><a href="<?php echo base_url();?>admin/master/boost_your_profile"><?php echo $this->lang->line('boost_your_profile');?> </a></li>
                           <li><a href="<?php echo base_url();?>admin/master/additional_services"><?php echo $this->lang->line('additional_services');?> </a></li>
                           <li><a href="<?php echo base_url();?>admin/master/banners"><?php echo $this->lang->line('banners');?> </a></li>
                           <li><a href="<?php echo base_url();?>admin/master/taxes"><?php echo $this->lang->line('taxes');?> </a></li>
                           <li><a href="<?php echo base_url();?>admin/master/cv"><?php echo $this->lang->line('cv');?> </a></li> -->

                        </ul>
                    </li>
                    <li>
                        <a href="#uiElements" class="has-arrow"><i class="icon-diamond"></i><span><?php echo $this->lang->line('manage_user') ?: 'Manage User';?></span></a>
                        <ul>
                          
                        <li>
                        <a href="<?php echo base_url();?>admin/master/regular_user" class=""><i class="icon-plus"></i><span><?php echo $this->lang->line('regular_user');?></span></a>
                      
                       </li>
                       <?php $ur = $this->Common->getUserRole();  foreach($ur as $urres){ ?>
                    <li>
                    <a href="<?php echo base_url();?>admin/master/company_user" class=""><i class="icon-layers"></i><span><?php echo $this->lang->line($urres->name) ?: $urres->name;?></span></a>
                     
                    </li>
                <?php } ?>
                        </ul>
                    </li>
                   
                    
                    <li>
    <a href="#uiElements" class="has-arrow"><i class="icon-notebook"></i><span><?php echo $this->lang->line('statistics'); ?></span></a>
    <ul>
        <li>
            <a href="#uiElements" class="has-arrow"><i class="icon-arrow-down"></i><?php echo $this->lang->line('general');?></a>
            <!-- Add more nested items under "General" -->
            <ul>
                <li><a href="<?php echo base_url();?>admin/master/registered_users"><?php echo $this->lang->line('registered_users'); ?></a></li>
                <li><a href="<?php echo base_url();?>admin/master/services"><?php echo $this->lang->line('services'); ?></a></li>
                <li><a href="<?php echo base_url();?>admin/master/cart"><?php echo $this->lang->line('cart'); ?></a></li>

            </ul>

        </li>
        <li>
        <a href="#" ><i class="icon-key"></i><?php echo $this->lang->line('postal_codes');?></a>
        </li>
        <li>
        <a href="<?php echo base_url();?>admin/master/papular" ><i class="icon-paper-plane"></i><?php echo $this->lang->line('popular');?></a>
        </li>
        <li>
        <a href="#" ><i class="icon-heart"></i><?php echo $this->lang->line('days_and_times');?></a>
        </li>
        
    </ul>
</li>


                    <li>
                        <a href="<?php echo base_url();?>admin/master/reported_users" class=""><i class=" icon-cloud-upload"></i><span><?php echo $this->lang->line('reported_users');?></span></a>
                    </li>
                    <li>
                         <a href="#" class=""><i class=" icon-symbol-female"></i><span><?php echo $this->lang->line('elite_users');?></span></a>
                    </li>
                    <li>
                        <a href="<?php echo base_url();?>admin/master/categories" class=""><i class="icon-docs"></i><span><?php echo $this->lang->line('categorias');?></span></a>
                    </li>
                    <li>
                        <a href="<?php echo base_url();?>admin/master/sub_category" class=""><i class="icon-directions"></i><span><?php echo $this->lang->line('subcategorias');?></span></a>
                    </li>
                    <li>
                        <a href="#" class=""><i class=" icon-users"></i><span><?php echo $this->lang->line('activate_free_users');?></span></a>
                    </li>
                    <li>
                        <a href="#" class=""><i class=" icon-user"></i><span><?php echo $this->lang->line('contact_users');?></span></a>
                    </li>
                    <li>
                        <a href="#" class=""><i class=" icon-graduation"></i><span><?php echo $this->lang->line('rent_/_sale');?></span></a>
                    </li>
                    <li>
                        <a href="<?php echo base_url();?>admin/master/earrings" class=""><i class=" icon-badge"></i><span><?php echo $this->lang->line('earrings');?></span></a>
                    </li>

                    <li>
                        <a href="#uiElements" class="has-arrow"><i class="icon-arrow-right"></i><span><?php echo $this->lang->line('manage_news'); ?></span></a>
                        <ul>
                           <li><a href="<?php echo base_url();?>admin/master/news_categories"><?php echo $this->lang->line('news_categories');?> </a></li>
                           <li><a href="<?php echo base_url();?>admin/master/news"><?php echo $this->lang->line('news');?> </a></li>

                        </ul>
                    </li>
                    <li>

                </ul>
            </nav>     
        </div>
    </div>