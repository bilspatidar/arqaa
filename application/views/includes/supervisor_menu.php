

 <!-- ******* Manage Member	*********** -->

 <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic-member" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-settings-box"></i>
              </span>
              <span class="menu-title">Manage Employee</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic-member">
              <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>admin/manage_member/employee_joining">Joining Form</a></li>
              <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>admin/manage_member/user">Manage User </a></li>
              
              </ul>
            </div>
          </li>

          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic-attendance" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-settings-box"></i>
              </span>
              <span class="menu-title">Attendance</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic-attendance">
              <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="<?php echo base_url(); ?>admin/manage_member/attendance"> Attendance</a></li>
              
              </ul>
            </div>
          </li>

