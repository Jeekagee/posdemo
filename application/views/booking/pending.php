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
        <h3>Pending Booking</h3>
        <div id="delete_msg">
          <?php
            if ($this->session->flashdata('message')) {
              echo $this->session->flashdata('message');
            }
          ?>
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
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $i =1;
                  foreach ($pendings as $pending){
                    ?>
                      <tr class="gradeX">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $pending->name; ?></td>
                        <td><?php echo $pending->vehicle_no; ?></td>
                        <td><?php echo $pending->contact_no; ?></td>
                        <td><?php echo $pending->service; ?></td>
                        <td id="date_<?php echo $pending->book_id; ?>"><?php echo date('Y-m-d', strtotime($pending->book_date)); ?></td>
                        <td id="time_<?php echo $pending->book_id; ?>"><?php echo date('H:i', strtotime($pending->book_time)); ?></td>

                        <td class="text-center">
                            <a href="<?php echo base_url(); ?>Booking/confirm/<?php echo $pending->book_id; ?>/<?php echo $pending->name; ?>/<?php echo $pending->vehicle_no; ?>/<?php echo $pending->book_date; ?>/<?php echo $pending->book_time; ?>/<?php echo $pending->contact_no; ?>" class="btn btn-success btn-sm">Confirm</a>
                            <a href="#" data-toggle="modal" data-target="#modal" data-role="update" data-id="<?php echo $pending->book_id; ?>" class="btn btn-sm btn-primary">Update</a>
                            <a href="<?php echo base_url(); ?>Booking/cancel/<?php echo $pending->book_id; ?>/<?php echo $pending->name; ?>/<?php echo $pending->vehicle_no; ?>/<?php echo $pending->book_date; ?>/<?php echo $pending->book_time; ?>/<?php echo $pending->contact_no; ?>" class="btn btn-danger btn-sm">Cancel</a>
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

           <!-- Update Modal -->
           <div id="modal" class="modal fade" role="dialog">
              <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Update Date & Time</h4>
                  </div>

                  <form method="post" action="">

                  <div class="modal-body">
                      <div>
                        <label>Booking Date</label>
                      </div>
                      <div>
                        <input class="form-control" type="date" name="book_date" id="book_date">
                      </div>

                      <div>
                        <label>Booking Time</label>
                      </div>
                      <div>
                        <input class="form-control" type="time" name="book_time" id="book_time">
                        <input class="form-control" type="hidden" name="book_id" id="book_id">
                      </div>
                  </div>

                  <div class="modal-footer">
                    <button type="submit" id="update" class="btn btn-success">Update</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>
                  </form>
                </div>

              </div>
            </div>
            <!-- Update Modal -->
        </div>
        <!-- /row -->
      </section>
      <!-- /wrapper -->
    </section>
    <!-- /MAIN CONTENT -->
    <!--main content end-->
  </section>
  