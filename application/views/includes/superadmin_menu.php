<?php 
 $users_id = getUser('id');
 $UserDetails = $this->Internal_model->getUserDetails($users_id) ;
?>

<style>
   .header1{
    font-family: Montserrat;
    color:#2a64b7;
font-size: 20px;
font-weight: 700;
line-height: 34.13px;
letter-spacing: 0.03em;
text-align: left;
text-underline-position: from-font;
text-decoration-skip-ink: none;

   } 
   .header2{
    font-family: Montserrat;
    color:#2a64b7;
font-size: 20px;
font-weight: 700;
text-align: left;
text-underline-position: from-font;
text-decoration-skip-ink: none;

   } 
   .headerlogo{
    width: 185px;
height: 50px;
top: 14px;
left: 868px;
gap: 0px;
opacity: 0px;

}
</style>

<div id="left-sidebar" class="sidebar">
        <div class="navbar-brand">
  <a href="<?php echo base_url();?>admin/index">
                    <img class="headerlogo"src="<?php echo base_url(); ?>assets/assets/images/logoarqaa.png" alt="Osam Logo" class="img-fluid logo"></a>            <button type="button" class="btn-toggle-offcanvas btn btn-sm float-right"><i class="lnr lnr-menu fa fa-chevron-circle-left"></i></button>
        </div>
        <div class="sidebar-scroll">
        <div class="user-account">
            <div class="user_div">
                <img src="<?php echo $UserDetails[0]->profile_pic;?>" class="user-photo" alt="User Profile Picture">
            </div>
            <div class="dropdown">
                <span><?php echo $UserDetails[0]->user_type;?></span>
                <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown">
                    <strong><?php echo $UserDetails[0]->name;?></strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-right account vivify flipInY">
                    <li><a href="<?php echo base_url();?>admin/master/my_profile"><i class="icon-user"></i>My Profile</a></li>
                    <li><a href="<?php echo base_url();?>admin/master/setting"><i class="icon-settings"></i>Change Password</a></li>
                    <li><a href="<?php echo base_url();?>admin/admin/logout"><i class="icon-power"></i>Logout</a></li>
                </ul>
            </div>
            <a href="<?php echo base_url();?>admin/master/add_user" class="btn btn-sm btn-block btn-primary btn-round mt-3">
                <i class="icon-plus mr-1"></i> Create New
            </a>
        </div> 
            <nav id="left-sidebar-nav" class="sidebar-nav">
                <ul id="main-menu" class="metismenu">
             
                <?php
           $country = $this->input->get('country_id');

            if (!empty($country)) {
                 $user_details = $this->session->userdata('user_details');

                   if (empty($user_details)) {
                    $user_details = [];
                        }

                     $user_details['country_id'] = $country;

                   $this->session->set_userdata('user_details', $user_details);
                      }

                    $user_details = $this->session->userdata('user_details');

                    if (!empty($user_details) && isset($user_details['country_id'])) {
                        // Display country name with a clickable button
                        echo '<p class="header1" style="display: flex; align-items: center;">' . $user_details['country_id'] . ' 
                            <a href="' . base_url() . 'admin/master/open_a_country" class=" btn-danger btn-sm ml-2" style="height: 5px; line-height: 0px;width:55px;padding-left: 0px;">' . $this->lang->line('switch') . '</a>
                        </p>';
                    } else {
                        // If country is not set, display "Country not available" with a clickable button
                        echo '<p class="header1" style="display: flex; align-items: center;">Country not available
                            <a href="' . base_url() . 'admin/master/open_a_country" class=" btn-danger btn-sm ml-2" style="height: 5px; line-height: 0px;width:55px;padding-left: 0px;">' . $this->lang->line('switch') . '</a>
                        </p>';
                    }
                    
                    
                    
                    
?>






                    <li class="">
                        <a href="<?php echo base_url();?>admin/master/manage_country" ><i class="icon-user-follow"></i><span><?php echo $this->lang->line('manage_country'); ?></span></a>
                        
                    </li>
                  
                    <li>
                        <a href="#uiElements" class="has-arrow"><i class="icon-screen-desktop"></i><span><?php echo $this->lang->line('control_de_precios'); ?></span></a>
                        <ul>
                           <li><a href="<?php echo base_url();?>admin/master/income_report"><?php echo $this->lang->line('income_report');?> </a></li>
                           <li><a href="<?php echo base_url();?>admin/master/regular_user_monthly_subscription"><?php echo $this->lang->line('regular_user_monthly_subscription');?> </a></li>
                           <li><a href="<?php echo base_url();?>admin/master/country_tax_settings"><?php echo $this->lang->line('country_tax_settings');?> </a></li>

                           <!-- <li><a href="<?php echo base_url();?>admin/master/monthly_subscription_for_company_users"><?php echo $this->lang->line('monthly_subscription_for_company_users');?> </a></li>
                           <li><a href="<?php echo base_url();?>admin/master/boost_your_profile"><?php echo $this->lang->line('boost_your_profile');?> </a></li>
                           <li><a href="<?php echo base_url();?>admin/master/additional_services"><?php echo $this->lang->line('additional_services');?> </a></li>
                           <li><a href="<?php echo base_url();?>admin/master/banners"><?php echo $this->lang->line('banners');?> </a></li>
                           <li><a href="<?php echo base_url();?>admin/master/taxes"><?php echo $this->lang->line('taxes');?> </a></li>
                           <li><a href="<?php echo base_url();?>admin/master/cv"><?php echo $this->lang->line('cv');?> </a></li> -->

                        </ul>
                    </li>
                    <!-- <li>
                        <a href="#uiElements" class="has-arrow"><i class="icon-diamond"></i><span><?php echo $this->lang->line('manage_user') ?: 'Manage User';?></span></a>
                        <ul>
                          
                        <li>
                        <a href="<?php echo base_url();?>admin/master/add_user" class=""><i class="icon-plus"></i><span><?php echo $this->lang->line('regular_user');?></span></a>
                      
                       </li>
                       <?php $ur = $this->Common->getUserRole('internal');  foreach($ur as $urres){ ?>
                    <li>
                    <a href="<?php echo base_url();?>admin/master/users/<?php echo $urres->slug; ?>" class=""><i class="icon-layers"></i><span><?php echo $this->lang->line($urres->name) ?: $urres->name;?></span></a>
                     
                    </li>
                <?php } ?>
                        </ul>
                    </li>
                    <li>
                        <a href="#uiElements" class="has-arrow"><i class="icon-diamond"></i><span><?php echo $this->lang->line('application_user') ;?></span></a>
                        <ul>
                          
                       
                       <?php $ur = $this->Common->getUserRole('application');  foreach($ur as $urres){ ?>
                    <li>
                    <a href="<?php echo base_url();?>admin/master/application_user/<?php echo $urres->slug; ?>" class=""><i class="icon-layers"></i><span><?php echo $this->lang->line($urres->name) ?: $urres->name;?></span></a>
                     
                    </li>
                <?php } ?>
                        </ul>
                    </li>  -->
                    
                    <li>
    <a href="#uiElements" class="has-arrow"><i class="icon-list"></i><span><?php echo $this->lang->line('statistics'); ?></span></a>
    <ul>
        <!-- <li>
            <a href="#uiElements" class="has-arrow"><i class="icon-arrow-down"></i><?php echo $this->lang->line('general');?></a>
            <ul>
                <li><a href="<?php echo base_url();?>admin/master/registered_users"><?php echo $this->lang->line('registered_users'); ?></a></li>
                <li><a href="<?php echo base_url();?>admin/master/services"><?php echo $this->lang->line('services'); ?></a></li>
                <li><a href="<?php echo base_url();?>admin/master/cart"><?php echo $this->lang->line('cart'); ?></a></li>

            </ul>

        </li> -->
        <!-- <li>
        <a href="#" ><i class="icon-key"></i><?php echo $this->lang->line('postal_codes');?></a>
        </li> -->
        <!-- <li>
        <a href="<?php echo base_url();?>admin/master/papular" ><i class="icon-paper-plane"></i><?php echo $this->lang->line('popular');?></a>
        </li> -->
        <!-- <li>
        <a href="#" ><i class="icon-heart"></i><?php echo $this->lang->line('days_and_times');?></a>
        </li> -->

       
        <li>
        <a href="#" ><?php echo $this->lang->line('completed_service');?></a>
        </li>
        <li>
        <a href="#" ><?php echo $this->lang->line('daily_visits');?></a>
        </li>
        <li>
        <a href="#" ><?php echo $this->lang->line('tatal_download_app');?></a>
        </li>
        <li>
        <a href="#" ><?php echo $this->lang->line('member');?></a>
        </li>
        <li>
        <a href="#" ><?php echo $this->lang->line('marketing');?></a>
        </li>
        <li>
        <a href="#" ><?php echo $this->lang->line('sales_this_week');?></a>
        </li>
        
    </ul>
</li>

                    <li>
                        <a href="<?php echo base_url();?>admin/master/reported_users" class=""><i class=" icon-user-unfollow"></i><span><?php echo $this->lang->line('reported_users');?></span></a>
                    </li>
                    <li>
                        <a href="<?php echo base_url();?>admin/master/handy_andy" class=""><i class=" icon-user-unfollow"></i><span><?php echo $this->lang->line('Handy_Andy_s');?></span></a>
                    </li>
                    <li>
                        <a href="<?php echo base_url();?>admin/master/company" class=""><i class="icon-users"></i><span><?php echo $this->lang->line('company');?></span></a>
                    </li>
                    <li>
                        <a href="<?php echo base_url();?>admin/master/reported_users" class=""><i class="icon-emoticon-smile"></i><span><?php echo $this->lang->line('notification');?></span></a>
                    </li>

                    <li class="header2">Global Option</li>

                    <!-- <li>
                         <a href="#" class=""><i class=" icon-symbol-female"></i><span><?php echo $this->lang->line('elite_users');?></span></a>
                    </li> -->
                    <li>
                        <a href="<?php echo base_url();?>admin/master/categories" class=""><i class=" icon-grid"></i><span><?php echo $this->lang->line('categorias');?></span></a>
                    </li>
                    <li>
                        <a href="<?php echo base_url();?>admin/master/sub_category" class=""><i class="icon-social-dropbox"></i><span><?php echo $this->lang->line('subcategorias');?></span></a>
                    </li>
                    <!-- <li>
                        <a href="#" class=""><i class=" icon-users"></i><span><?php echo $this->lang->line('activate_free_users');?></span></a>
                    </li> -->
                    <!-- <li>
                        <a href="#" class=""><i class=" icon-user"></i><span><?php echo $this->lang->line('contact_users');?></span></a>
                    </li> -->
                    <!-- <li>
                        <a href="#" class=""><i class=" icon-graduation"></i><span><?php echo $this->lang->line('rent_/_sale');?></span></a>
                    </li> -->
                    <!-- <li>
                        <a href="<?php echo base_url();?>admin/master/earrings" class=""><i class=" icon-badge"></i><span><?php echo $this->lang->line('earrings');?></span></a>
                    </li> -->
                         <!-- <li>
                        <a href="<?php echo base_url();?>admin/master/news" class=""><i class="icon-speech"></i><span><?php echo $this->lang->line('news');?> </span></a>
                    </li>  -->
                    <li>
                        <a href="#uiElements" class="has-arrow"><i class="icon-speech"></i><span><?php echo $this->lang->line('news'); ?></span></a>
                        <ul>
                           <li><a href="<?php echo base_url();?>admin/master/news_categories"><?php echo $this->lang->line('news_categories');?> </a></li>
                           <li><a href="<?php echo base_url();?>admin/master/news"><?php echo $this->lang->line('news');?> </a></li>

                        </ul>
                    </li>
                    <!-- <li>
                        <a href="<?php echo base_url();?>admin/master/map" class=""><i class=" icon-badge"></i><span><?php echo $this->lang->line('map');?></span></a>
                    </li> -->
                    <li>
                        <a href="<?php echo base_url();?>admin/master/manage_your_staff" class=""><i class=" icon-settings"></i><span><?php echo $this->lang->line('manage_your_staff');?></span></a>
                    </li>
                   
                    <li>
                        <a href="#" class=""></a>
                    </li>
                    <li>
                        <a href="#" class=""></a>
                    </li>
                   
                </ul>
            </nav>     
        </div>
    </div>