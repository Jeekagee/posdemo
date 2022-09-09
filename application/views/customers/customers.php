
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
                    <th class="text-center">Customer Name</th>
                    <th class="text-center">Address</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Contact Number</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $i =1;
                  foreach ($customers as $customer){
                    ?>
                      <tr class="gradeX">
                      <td><?php echo $i; ?></td>
                        <td><?php echo $customer->fname; ?></td>
                        <td><?php echo $customer->address; ?></td>
                        <td><?php echo $customer->email; ?></td>
                        <td><?php echo $customer->mobile; ?></td>
                        <td class="text-center">
                          <a href="<?php echo base_url(); ?>Customers/edit/<?php echo $customer->customer_id; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                          <a href="<?php echo base_url(); ?>Customers/delete/<?php echo $customer->customer_id; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
                          
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
  