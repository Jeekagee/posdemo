
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <h3>Customers</h3>
        <div id="delete_msg">
          <?php
            if ($this->session->flashdata('delete')) {
              echo $this->session->flashdata('delete');
            }
          ?>
        </div>
        <div class="row mb">
          <!-- page start-->
          <div class="content-panel" style="padding:20px 20px 2px 20px;">
            <div class="adv-table">
              <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-hover" id="hidden-table-info">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Vehicle No</th>
                    <th class="text-center">Contact Number</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $i =1;
                  foreach ($customers as $customer){
                    ?>
                      <input type="text" value="<?php echo $customer->vehicle_no; ?>" id="vehicle_no" hidden>
                      <tr id="black<?php echo $customer->vehicle_id;?>">
                        <td class="text-center"><?php echo $i; ?></td>
                        <td><?php echo $customer->vehicle_no; ?></td>
                        <td><?php echo $customer->contact_no; ?></td>
                        <td class="text-center">
                          <a id="<?php echo $customer->vehicle_id;?>" class="btn btn-success btn-sm active-customer">
                            Active
                          </a>
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
  