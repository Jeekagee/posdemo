
<aside>
      <div id="sidebar" class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
          <p class="centered"><a href="profile.html"><img src="<?php echo base_url(); ?>assets/img/aclogo.png" class="img-circle" width="80"></a></p>
          <h5 class="centered"><?php echo $username; ?></h5>

          <li class="mt">
            <a class="active" href="<?php echo base_url(); ?>Dashboard">
              <i class="fa fa-dashboard"></i>
              <span>Dashboard</span>
              </a>
          </li>

          <?php
            $user_level = $this->session->user_level;
            $CI =& get_instance();
            //user_level menu id
            $main_menu = $CI->Dashboard_model->menu($user_level);

            foreach ($main_menu as $menu) {
              $menu_id = $menu->menu_id;
              $main_menu_data = $CI->Dashboard_model->main_menu($menu_id);

              if ($main_menu_data->menu_name == $nav) {
                $active = "active";
              }
              else{
                $active = "";
              }
              ?>
                <li class="sub-menu">
                  <a <?php echo $active; ?> href="javascript:;">
                    <i class="<?php echo $main_menu_data->menu_icon; ?>"></i>
                    <span><?php echo $main_menu_data->menu_name; ?></span>
                    </a>
                      <ul class="sub">
                      <?php
                        $sub_menu = $CI->Dashboard_model->sub_menu($user_level,$menu_id);
                        foreach ($sub_menu as $s_menu) {
                          $sub_menu_id = $s_menu->sub_menu_id;
                          $sub_menu_data = $CI->Dashboard_model->sub_menu_data($sub_menu_id);
                          ?>
                            <li>
                              <a href="<?php echo base_url().$sub_menu_data->url; ?>">
                                <i class="<?php echo $sub_menu_data->icon; ?>"></i> 
                                <span><?php echo $sub_menu_data->name; ?></span>
                              </a>
                            </li>
                          <?php
                        }
                      ?>
                    </ul>
                </li>
              <?php
            }
          ?>
        </ul>
        <!-- sidebar menu end-->
      </div>
</aside>
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <h3>Canclled Booking</h3>
        <div id="delete_msg">
          <?php
            if ($this->session->flashdata('message')) {
              echo $this->session->flashdata('message');
            }
          ?>
        </div>
            <div style="margin-bottom: 10px;" >
                <a href="<?php echo base_url(); ?>Employees/Add" class="btn btn-success"><i class="fa fa-plus"></i> Add New</a>
            </div>
        <div class="row mb">
            
          <!-- page start-->
          <div class="content-panel" style="padding:20px 20px 2px 20px;">
            <div class="adv-table">
              <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Owner Name</th>
                    <th>Vehicle No</th>
                    <th>Service</th>
                    <th>Contact No</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $i =1;
                  foreach ($cancelled as $cancel){
                    ?>
                      <tr class="gradeX">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $cancel->name; ?></td>
                        <td><?php echo $cancel->vehicle_no; ?></td>
                        <td><?php echo $cancel->service; ?></td>
                        <td><?php echo $cancel->contact_no; ?></td>
                        <td id="date_<?php echo $cancel->book_id; ?>"><?php echo date('Y-m-d', strtotime($cancel->book_date)); ?></td>
                        <td id="time_<?php echo $cancel->book_id; ?>"><?php echo date('H:i', strtotime($cancel->book_time)); ?></td>
                        <td>
                        <?php
                            $status = $cancel->status;
                            
                            if ($status == 0) {
                                echo "<span class='label label-danger'>Canclled</span>";
                            }
                            if ($status == 1) {
                                echo "<span class='label label-warning'>Canclled after Confirmed</span>";
                            }
                        ?>
                        </td>
                      </tr>
                    <?php
                    $i++;
                  }
                ?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- page end-->
        </div>
        <!-- /row -->
      </section>
      <!-- /wrapper -->
    </section>
    <!-- /MAIN CONTENT -->
    <!--main content end-->
  </section>
  