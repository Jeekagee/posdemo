<aside>
      <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
          <p class="centered"><a href="profile.html"><img src="<?php echo base_url(); ?>assets/img/logo.png" class="img-circle" width="80"></a></p>
          <h5 class="centered"><?php echo $username; ?></h5>

          <li class="mt">
            <a class="active" href="<?php echo base_url(); ?>Dashboard">
              <i class="fa fa-dashboard"></i>
              <span>Dashboard</span>
              </a>
          </li>

          <li class="sub-menu">
            <a href="javascript:;">
              <i class="fa fa-car"></i>
              <span>Orders</span>
              </a>
            <ul class="sub">
              <li><a href="<?php echo base_url(); ?>Orders/insert"><i class="fa fa-plus"></i> <span>Add Order</span></a></li>
              <li><a href="<?php echo base_url(); ?>Orders"><i class="fa fa-car"></i> <span>Orders</span></a></li>
            </ul>
          </li>

          <li class="sub-menu">
            <a href="javascript:;">
              <i class="fa fa-heart"></i>
              <span>Customer</span>
              </a>
            <ul class="sub">
              <li><a href="<?php echo base_url(); ?>Customers"><i class="fa fa-heart"></i> <span>Customers</span></a></li>
              <li><a href="<?php echo base_url(); ?>Customers/Message"><i class="fa fa-envelope"></i> <span>Message</span></a></li>
            </ul>
          </li>

          <li class="sub-menu">
            <a href="javascript:;">
              <i class="fa fa-users"></i>
              <span>Employees</span>
              </a>
            <ul class="sub">
              <li><a href="<?php echo base_url(); ?>Employees/Add"><i class="fa fa-plus"></i> <span>Add Employee</span></a></li>
              <li><a href="<?php echo base_url(); ?>Employees"><i class="fa fa-users"></i> <span>Employees</span></a></li>
            </ul>
          </li>

          <li class="sub-menu">
            <a href="javascript:;">
              <i class="fa fa-users"></i>
              <span>Payments</span>
              </a>
            <ul class="sub">
              <li><a href="<?php echo base_url(); ?>Payments/Summery"><i class="fa fa-plus"></i> <span>Summery</span></a></li>
            </ul>
          </li>

          <li class="sub-menu">
            <a href="javascript:;">
              <i class="fa fa-bookmark"></i>
              <span>Booking</span>
              <span class="label label-theme pull-right mail-info">2<?php //echo $pending_count; ?></span>
              </a>
            <ul class="sub">
                <li>
                    <a href="<?php echo base_url(); ?>Booking/pending"><i class="fa fa-spinner"></i>
                        <span>Pending</span>
                        <span class="badge bg-warning">2<?php //echo $pending_count; ?></span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url(); ?>Booking/confirmed"><i class="fa fa-check"></i> 
                        <span>Confirm</span>
                        <span class="badge bg-success">2</span>
                    </a>
                </li>
              <li><a href="<?php echo base_url(); ?>Booking/cancelled"><i class="fa fa-ban"></i> <span>Cancel</span></a></li>
            </ul>
          </li>

          <li class="sub-menu">
            <a href="javascript:;">
              <i class="fa fa-server"></i>
              <span>Inventory</span>
              </a>
            <ul class="sub">
              <li><a href="<?php echo base_url(); ?>Inventory/Add"><i class="fa fa-plus"></i> <span>Add Item</span></a></li>
              <li><a href="<?php echo base_url(); ?>Inventory/Items"><i class="fa fa-eye"></i> <span>Show Items</span></a></li>
            </ul>
            
          </li>

          <li class="sub-menu">
            <a href="javascript:;">
              <i class="fa fa-cogs"></i>
              <span>Settings</span>
              </a>
            <ul class="sub">
              <li><a href="<?php echo base_url(); ?>Settings/BookingService"><i class="fa fa-plus"></i> <span>Add Booking Service</span></a></li>
              <li><a href="<?php echo base_url(); ?>Inventory/Items"><i class="fa fa-plus"></i> <span>Add User</span></a></li>
              <li><a href="<?php echo base_url(); ?>Inventory/Items"><i class="fa fa-user"></i> <span>Users</span></a></li>
              <li><a href="<?php echo base_url(); ?>Inventory/Items"><i class="fa fa-cog"></i> <span>Change Password</span></a></li>
            </ul>
            
          </li>
        </ul>
        <!-- sidebar menu end-->
      </div>
</aside>