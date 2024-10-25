<li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-settings-box"></i>
              </span>
              <span class="menu-title">Master Settings</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>admin/master/expenses">Expenses</a></li>
             
              </ul>
            </div>
  </li>


  <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ui-project-menu" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-wallet-travel"></i>
              </span>
              <span class="menu-title">Manage Project</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-project-menu">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>admin/master/projects">New Project</a></li>
                <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>admin/master/projects/Not Started">Not Started</a></li>
                <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>admin/master/projects/In Progress">In Progress</a></li>
                <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>admin/master/projects/On Hold">On Hold</a></li>
                <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>admin/master/projects/>Finished">Finished</a></li>
                <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>admin/master/projects/Cancelled">Cancelled</a></li>
              </ul>
            </div>
  </li>
 <!-- ******* Manage Member	*********** -->
 <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ui-report" aria-expanded="false" aria-controls="ui-web">
              <span class="menu-icon">
                <i class="mdi mdi-web"></i>
              </span>
              <span class="menu-title">Manage Report</span>
              <i class="menu-user"></i>
            </a>
            <div class="collapse" id="ui-report">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>admin/report/project_report">Project Report</a></li>
                <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>admin/report/expenses_report">Expenses Report</a></li>
                <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>admin/report/income_report">Income Report</a></li>
                
               
              
              </ul>	
            </div>
</li>