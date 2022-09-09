
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div id="delete_msg"><?php
          if ($this->session->flashdata('delete')) {
            echo $this->session->flashdata('delete');
          }
        ?>
        </div>
            <div style="margin-bottom: 10px; margin-top:10px;" >
                <a href="<?php echo base_url(); ?>Appoint/addnew" class="btn btn-success"><i class="fa fa-plus"></i> Add New</a>
            </div>
        <div class="row mb" style="padding:10px;">
          <!-- page start-->
          <div class="content-panel" >
            <div class="adv-table">
              <table class="table table-hover table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>Nic</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Area</th>
                    <th>Doctor</th>
                    <th>Time</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $CI =& get_instance();
                  $i =1;
                  foreach ($apps as $app){
                    ?>
                      <tr>
                        <td class="text-center"><?php echo $i; ?></td>
                        <td><?php echo $app->nic; ?></td>
                        <td><?php echo $app->name; ?></td>
                        <td><?php echo $app->mobile; ?></td>
                        <td>
                          <?php 
                          $area = $app->area; 
                          echo $this->Appoint_model->area_name($area);
                          ?>
                        </td>
                        <td>
                          <?php 
                          $id = $app->doctor; 
                          echo $this->Appoint_model->doctor_name($id);
                          ?>
                        </td>
                        <td><?php echo date("h:i A", strtotime($app->time)); ?></td>
                        
                        <td class="text-center">
                          <a href="<?php echo base_url(); ?>Appoint/view/<?php echo $app->id; ?>" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>
                          <!--<a href="" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>-->
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
  