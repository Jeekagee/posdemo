
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <h3>Supplier summary</h3>
        <div id="delete_msg"><?php
          if ($this->session->flashdata('success')) {
            echo $this->session->flashdata('success');
          }
        ?>
        </div>
        <div class="row mb" style="padding:10px;">
          <!-- page start-->
          <div class="content-panel" >
            <div class="adv-table">
              <table class="table table-hover table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Supplier</th>
                    <th>Description</th>
                    <th>Total</th>
                    <th>Credit Balance</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                $CI =& get_instance();
                  $i =1;
                  foreach ($supplier_summary as $sup){
                    $supplier_id = $sup->id;
                    $total_purchase = $CI->Purchase_model->total_purchase($supplier_id);
                    $credit_balance = $CI->Purchase_model->credit_balance($supplier_id);
                    ?>
                      <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $sup->supplier; ?></td>
                        <td><?php echo $sup->description; ?></td>
                        <td><?php echo $total_purchase; ?></td>
                        <td><?php echo $credit_balance; ?></td>
                        <td class="text-center">
                          <a href="<?php echo base_url(); ?>Purchase/ViewSummary/<?php echo $sup->id; ?>" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>
                        
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
  