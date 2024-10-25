
<div id="left-sidebar" class="sidebar">
        <div class="navbar-brand">
            <a href="index.html"><img src="<?php echo base_url(); ?>assets/assets/images/icon.svg" alt="Osam Logo" class="img-fluid logo"><span>Osam</span></a>
            <button type="button" class="btn-toggle-offcanvas btn btn-sm float-right"><i class="lnr lnr-menu fa fa-chevron-circle-left"></i></button>
        </div>
        <div class="sidebar-scroll">
            <div class="user-account">
                <div class="user_div">
                    <img src="<?php echo base_url(); ?>assets/assets/images/user.png" class="user-photo" alt="User Profile Picture">
                </div>
                <div class="dropdown">
                    <span>Welcome,</span>
                    <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong>Louis Pierce</strong></a>
                    <ul class="dropdown-menu dropdown-menu-right account vivify flipInY">
                        <li><a href="page-profile.html"><i class="icon-user"></i>My Profile</a></li>
                        <li><a href="app-inbox.html"><i class="icon-envelope-open"></i>Messages</a></li>
                        <li><a href="javascript:void(0);"><i class="icon-settings"></i>Settings</a></li>
                        <li class="divider"></li>
                        <li><a href="page-login.html"><i class="icon-power"></i>Logout</a></li>
                    </ul>
                </div>
                <a href="javascript:void(0);" class="btn btn-sm btn-block btn-primary btn-round mt-3" title=""><i class="icon-plus mr-1"></i> Create New</a>
            </div>  
            <nav id="left-sidebar-nav" class="sidebar-nav">
                <ul id="main-menu" class="metismenu">
                    <li class="header">Main</li>
                   <!-- <li class="active">
                        <a href="#Dashboard" class="has-arrow"><i class="icon-speedometer"></i><span>Dashboard</span></a>
                        <ul>
                            <li class="active"><a href="index.html">Dark Version</a></li>
                            <li><a href="<?php echo base_url(); ?>light/index.html">Light Version</a></li>
                            <li><a href="<?php echo base_url(); ?>fluid/index.html">Fluid Version</a></li>
                            <li><a href="<?php echo base_url(); ?>hmenu/index.html">H-Menu Version</a></li>
                            <li><a href="<?php echo base_url(); ?>landing/index.html">Landing Page</a></li>
                        </ul>
                    </li>-->
                   <!-- <li class="header">App</li>
                    <li><a href="app-inbox.html"><i class="icon-envelope"></i> <span>Email</span> <span class="badge badge-default float-right mr-0">12</span></a></li>
                    <li><a href="app-chat.html"><i class="icon-bubbles"></i> <span>Messenger</span></a></li>
                    <li><a href="app-calendar.html"><i class="icon-calendar"></i> <span>Calendar</span></a></li>
                    <li class="header">UI Elements</li>-->
                    <li>
                        <a href="#uiElements" class="has-arrow"><i class="icon-diamond"></i><span><?php echo $this->lang->line('control_de_precios'); ?></span></a>
                        <ul>
                           <!-- <li><a href="ui-helper-class.html">Helper Classes</a></li>
                            <li><a href="ui-bootstrap.html">Bootstrap UI</a></li>
                            <li><a href="ui-typography.html">Typography</a></li>
                            <li><a href="ui-tabs.html">Tabs</a></li>
                            <li><a href="ui-buttons.html">Buttons</a></li>                            
                            <li><a href="ui-icons.html">Icons</a></li>
                            <li><a href="ui-notifications.html">Notifications</a></li>
                            <li><a href="ui-colors.html">Colors</a></li>
                            <li><a href="ui-dialogs.html">Dialogs</a></li>                                    
                            <li><a href="ui-list-group.html">List Group</a></li>
                            <li><a href="ui-media-object.html">Media Object</a></li>
                            <li><a href="ui-modals.html">Modals</a></li>
                            <li><a href="ui-nestable.html">Nestable</a></li>
                            <li><a href="ui-progressbars.html">Progress Bars</a></li>
                            <li><a href="ui-range-sliders.html">Range Sliders</a></li>-->
                        </ul>
                    </li>
                    <li>
                        <a href="#forms" class=""><i class="icon-pencil"></i><span><?php echo $this->lang->line('usuario_regular');?></span></a>
                      
                    </li>
                    <li>
                        <a href="#Tables" class="has-arrow"><i class="icon-layers"></i><span><?php echo $this->lang->line('usuario_empresa');?></span></a>
                     
                    </li>
                    <li>
                        <a href="#charts" class=""><i class="icon-pie-chart"></i><span><?php echo $this->lang->line('estadisticas');?></span></a>
                        <ul>
                            <!--<li><a href="chart-c3.html">C3 Charts</a></li>-->
                        </ul>
                    </li>
                    <li>
                        <a href="chart-c3.html" class=""><i class="fas fa-users"></i><span><?php echo $this->lang->line('usuarios_reportados');?></span></a>
                    </li>
                    <li>
                         <a href="#" class=""><i class="icon-pie-chart"></i><span><?php echo $this->lang->line('usuarios_elite');?></span></a>
                    </li>
                    <li>
                        <a href="<?php echo base_url();?>admin/master/categories" class=""><i class="icon-pie-chart"></i><span><?php echo $this->lang->line('categorias');?></span></a>
                    </li>
                    <li>
                        <a href="<?php echo base_url();?>admin/master/categories" class=""><i class="icon-pie-chart"></i><span><?php echo $this->lang->line('subcategorias');?></span></a>
                    </li>
                    <li>
                        <a href="#" class=""><i class="icon-pie-chart"></i><span><?php echo $this->lang->line('activar_usuarios_free');?></span></a>
                    </li>
                    <li>
                        <a href="#" class=""><i class="icon-pie-chart"></i><span><?php echo $this->lang->line('contactar_usuarios');?></span></a>
                    </li>
                    <li>
                        <a href="#" class=""><i class="icon-pie-chart"></i><span><?php echo $this->lang->line('renta_venta');?></span></a>
                    </li>
                    <li>
                        <a href="#" class=""><i class="icon-pie-chart"></i><span><?php echo $this->lang->line('pendientes');?></span></a>
                    </li>
                    <li>
<!--
                    <li class="header">Extra</li>
                    <li><a href="widgets.html"><i class="icon-puzzle"></i><span>Widgets</span></a></li>
                    <li>
                        <a href="#Pages" class="has-arrow"><i class="icon-docs"></i><span>Pages</span></a>
                        <ul>
                            <li><a href="page-login.html">Login</a></li>
                            <li><a href="page-register.html">Register</a></li>
                            <li><a href="page-forgot-password.html">Forgot Password</a></li>
                            <li><a href="page-404.html">Page 404</a></li>
                            <li><a href="page-blank.html">Blank Page</a></li>
                            <li><a href="page-search-results.html">Search Results</a></li>
                            <li><a href="page-profile.html">Profile </a></li>
                            <li><a href="page-invoices.html">Invoices </a></li>
                            <li><a href="page-gallery.html">Image Gallery </a></li>
                            <li><a href="page-timeline.html">Timeline</a></li>
                            <li><a href="page-pricing.html">Pricing</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#Maps" class="has-arrow"><i class="icon-map"></i><span>Maps</span></a>
                        <ul>
                            
                            <li><a href="map-jvectormap.html">jVector Map</a></li>
                        </ul>
                    </li>-->
                </ul>
            </nav>     
        </div>
    </div>