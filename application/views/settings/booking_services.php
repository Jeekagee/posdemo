
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <h3>Booking Services</h3>
        <div id="delete_msg">
          <?php
            if ($this->session->flashdata('msg')) {
              echo $this->session->flashdata('msg');
            }
          ?>
        </div>
            <div style="margin-bottom: 10px;" >
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addservice">
                <i class="fa fa-plus" aria-hidden="true"></i>Add New
              </button>
            </div>
        <div class="row mb">
            
          <!-- page start-->
          <div class="content-panel" style="padding:20px 20px 2px 20px;">
            <div class="adv-table">
              <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Service</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $i =1;
                  foreach ($services as $service){
                    ?>
                      <tr class="gradeX">
                        <td class="text-center"><?php echo $i; ?></td>
                        <td><?php echo $service->service; ?></td>
                        <td class="text-center">
                          <a href="<?php echo base_url(); ?>Settings/delete_service/<?php echo $service->service_id; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
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

  <!-- Modal -->
  <div id="addservice" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add New Service</h4>
        </div>

        <form method="post" action="<?php echo base_url(); ?>Settings/add_service">
          <div class="modal-body">
            <div>
                <label>Service</label>
              </div>
              <div>
                <input class="form-control" type="text" name="service" required>
              </div>
            
          </div>
          <div class="modal-footer">
            <input type="submit" name="save" value="Save" class="btn btn-success">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>

    </div>
  </div>
  <!-- Catogery Modal -->
  