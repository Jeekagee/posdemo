
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <h3>Billing</h3>
        <div id="delete_msg"><?php
          if ($this->session->flashdata('delete')) {
            echo $this->session->flashdata('delete');
          }
        ?>
        </div>
        <div class="row mb" style="padding:10px;">
          <div class="col-lg-8 col-md-offset-2" style="background-color:white; padding-top:10px;">
            <div style="background-color:#FF449F; padding:10px 10px 10px 10px; margin-bottom:20px; color:white;">
                <h4>Billing Details</h4>
            </div>

            <div class="row" style="padding:10px; font-size:14px">
                <div class="col-md-4">
                    Date: <?php echo $bill_orders->bill_date; ?>
                </div>
                <div class="col-md-4">

                </div>
                <div class="col-md-4">
                    Bill No: <?php echo $bill_orders->bill_no; ?>
                </div>
            </div>

            <div class="row" style="padding:10px; font-size:14px">
                <div class="col-md-4">
                    Vehicle No: <?php echo $bill_orders->vehicle_no; ?>
                </div>
            </div>

            <div>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="col-md-2">No</th>
                  <th class="col-md-4">Good/Service</th>
                  <th class="col-md-2">Quantity</th>
                  <th class="col-md-2">Unit Price</th>
                  <th  class="col-md-2 text-right">Price</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 1;
                $total = 0;
                foreach ($bill_items as $item) {
                  ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $item->service; ?></td>
                      <td>
                        <?php
                          if ($item->service_type == 2) { // Only for Goods
                            echo $quantity = $item->quantity; 
                          }
                          else{
                            $quantity = 1;
                          }
                        ?>
                      </td>
                      <td>
                        <?php
                          if ($item->service_type == 2) { // Only for Goods
                            echo $unit_price = $item->unit_price.".00"; 
                          }
                          else{
                            $unit_price = $item->price;
                          }
                        ?>
                      </td>
                      <td class="text-right"><?php echo $total_price = $quantity*$unit_price; ?>.00</td>
                    </tr>
                  <?php
                  $i++;
                  $total = $total+$total_price;
                }
                ?>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td style="font-weight: bold; font-size:14px; color:#FF449F;">Total</td>
                  <td class="text-right" style="font-weight: bold; font-size:14px; color:#FF449F;">
                    <?php echo $total; ?>.00
                  </td>
                </tr>

                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td style="font-weight: bold; font-size:14px; color:#FF449F;">Discount</td>
                  <td class="text-right" style="font-weight: bold; font-size:14px; color:#FF449F;">
                    <?php echo $item->discount; ?>.00
                  </td>
                </tr>

                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td style="font-weight: bold; font-size:14px; color:#FF449F;">Sub Total</td>
                  <td class="text-right" style="font-weight: bold; font-size:14px; color:#FF449F;">
                    <?php echo $total-$item->discount; ?>.00
                  </td>
                </tr>


              </tbody>
            </table>
            </div>
            <form action="<?php echo base_url(); ?>Orders/add_bill_item" method="post">
              <div class="row" style="margin-bottom:10px">
                <input type="text" name="order_id" value="<?php echo $item->order_id; ?>" hidden>
                <div class="col-md-3">
                  <div>
                    <label class="control-label">Good/Service</label>
                  </div>
                  <div>
                    <input type="text" class="form-control" name="item" required>
                  </div>
                </div>

                <div class="col-md-3">
                  <div>
                    <label class="control-label">Unit Price</label>
                  </div>
                  <div>
                    <input type="text" class="form-control" name="price" required>
                  </div>
                </div>

                <div class="col-md-3">
                  <div>
                    <label class="control-label">Quantity</label>
                  </div>
                  <div>
                    <input type="text" class="form-control" name="qty" required>
                  </div>
                </div>

                <div class="col-md-3">
                    <div>
                      <label class="control-label">Add Item</label>
                    </div>
                    <div>
                    <input type="submit" style="width:100%;" class="btn btn-primary" value="Add" name="add">
                    </div>
                </div>

              </div>
            </form>

            <div style="margin-bottom:20px; margin-top:20px;">
                <div>
                  <a class="btn btn-warning text-right" href="<?php echo base_url() ?>Orders/confirm_bill/<?php echo $item->order_id; ?>"><i class="fa fa-print"></i> Confirm</a>
                  <a class="btn btn-danger text-right" href="<?php echo base_url() ?>Orders/cancel_bill/<?php echo $item->order_id; ?>">Cancel</a>
                </div>
            </div>
          </div>
        </div>
        <!-- /row -->
      </section>
      <!-- /wrapper -->
    </section>
    <!-- /MAIN CONTENT -->
    <!--main content end-->
  </section>
  