
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <h3>Bills</h3>
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
              <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Bill No</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $i =1;
                  foreach ($bills as $bill){
                    ?>
                      <tr class="gradeX">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $bill->bill_no; ?></td>
                        <td class="text-center">
                            <a href="<?php echo base_url(); ?>Orders/delete_bill/<?php echo $bill->order_id; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i></a>
                            <a href="<?php echo base_url(); ?>Orders/confirm_bill/<?php echo $bill->order_id; ?>" class="btn btn-warning btn-xs"><i class="fa fa-print"></i></a>
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
  