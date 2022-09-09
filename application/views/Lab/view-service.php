
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
                <a href="<?php echo base_url(); ?>Laboratory/Add" class="btn btn-success"><i class="fa fa-plus"></i> Add New</a>
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
                    <th>Location</th>
                    <th>Doctor Ref</th>
                    <th>Comment</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $CI =& get_instance();
                  $i =1;
                  foreach ($services as $service){
                    $nic = $service->patient_nic;
                    $location_id = $service->location_id;
                    $doctor_id = $service->doctor_id;
                    // Get Patient Detail by nic
                    $patient = $CI->Laboratory_model->patient_detail($nic); //70
                    // Get Location Detail by location_id
                    $location = $CI->Laboratory_model->get_location($location_id); //77
                    // Get Doctor name by doctor_id
                    $doctor_name = $CI->Laboratory_model->get_doctor($doctor_id); //91
                    ?>
                      <tr id="service<?php echo $service->id; ?>">
                        <td class="text-center"><?php echo $i; ?></td>
                        <td><?php echo $nic; ?></td>
                        <td><?php echo $patient->name; ?></td>
                        <td><?php echo $patient->mobile; ?></td>
                        <td><?php echo $location; ?></td>
                        <td><?php
                        if ($doctor_id != 0) {
                          echo $doctor_name->name; 
                        }
                
                        ?>
                        </td>
                        <td><?php echo $service->comment; ?></td>
                        <td class="text-center">
                          <a href="<?php echo base_url(); ?>Laboratory/view_single/<?php echo $service->id; ?>" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>
                          <a id="<?php echo $service->id; ?>" class="btn btn-danger btn-xs del_service"><i class="fa fa-trash"></i></a>
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
  