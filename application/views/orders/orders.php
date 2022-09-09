
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <?php
          $total_sale = 0;
          foreach ($today_sale as $t_sale) {
            $total_sale = $total_sale+$t_sale->total-$t_sale->discount;
          }
        
    ?>
    <section id="main-content">
      <section class="wrapper">
        <h3>Orders</h3>
        <div id="delete_msg"><?php
          if ($this->session->flashdata('ordermsg')) {
            echo $this->session->flashdata('ordermsg');
          }
        ?>
        </div>
            <div style="margin-bottom: 10px;" >
                <a href="<?php echo base_url(); ?>Orders/insert" class="btn btn-success"><i class="fa fa-plus"></i> Add New</a>
            </div>
            <div style="margin-bottom: 10px;" >
                
            </div>
        <div class="row mb" style="padding:10px;">
          <!-- page start-->
          <div class="content-panel" >
            <div class="adv-table">
                <p style="padding-left: 10px; font-weight: bold;">Today Total Sales : LKR <?php echo $total_sale; ?>.00 (<?php echo $t_sale->bill_date; ?>)</p> 
              <table class="table table-hover table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>Ivoice ID</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Discount</th>
                    <th>Payment</th>
                    <th class="text-right">Net Amount</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $CI =& get_instance();
                  $i =1;
                  foreach ($orders as $order){
                    $order_id = $order->order_id;
                    $bill_no = $order->bill_no;
                    ?>
                      <tr>
                        <td class="text-center"><?php echo $i; ?></td>
                        <td ><?php echo $order->bill_no; ?></td>
                        <td ><?php echo $order->bill_date; ?></td>
                        <td class="text-right"><?php echo $total = $order->total; ?>.00</td>
                        <td class="text-right"><?php echo $discount = $order->discount; ?>.00</td>
                        <td class="text-right"><?php echo $order->payment; ?>.00</td>
                    <?php
                    // Mobile number for this order
                      $mobile_is = $CI->Orders_model->order_customer_is($order_id);

                      if ($mobile_is == 1) { //mobile is in
                        $disable = "";
                        $href = "Orders/trakeesApi/$bill_no";
                      }
                      if ($mobile_is == 0) { //mobile is in
                        $disable = "disabled";
                        $href = "#";
                      }
                    ?>
                      
                        <td class="text-right"><?php echo $total-$discount; ?>.00</td>
                        <td class="text-center">
                          <a href="<?php echo $href; ?>" <?php echo $disable; ?> class="btn btn-warning btn-xs"><i class="fa fa-message"></i></a>
                          <a href="<?php echo base_url(); ?>Orders/print_bill/<?php echo $bill_no; ?>" class="btn btn-info btn-xs"><i class="fa fa-print"></i></a>
                          <a href="<?php echo base_url(); ?>Orders/view/<?php echo $bill_no = $order->bill_no; ?>" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>
                          <!-- <a href="<?php echo base_url(); ?>Orders/edit/<?php echo $bill_no; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a> -->
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
  