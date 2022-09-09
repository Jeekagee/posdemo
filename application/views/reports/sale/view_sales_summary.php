
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
    <section class="wrapper site-min-height">
        <h3></i>View sales</h3>
        <div class="row mt">
            <div class="col-lg-8">
            <!-- page start-->
            <div class="content-panel" style="padding-left: 15px; padding-right: 15px;">
              <div class="adv-table">
                <?php $CI =& get_instance(); ?>
                <table cellpadding="0" cellspacing="0" border="0" class="table table-hover">
                  <thead style="background: #4ECDC4; font-size:16px;">
                    <tr>
                        <th>Sales Details</th>
                        <th></th>
                    </tr>
                  </thead>
                  <tbody style="font-size:15px;">
                    <tr>
                        <td>Items</td>
                        <td>
                                  <table class="table table-striped">
                                    <thead>
                                      <th>Item</th>
                                      <th>Price</th>
                                      <th>Quantity</th>
                                      <th>Total</th>
                                    </thead>
                                    <tbody>
                                        <?php
                                         $ser_total = 0;
                                            $bill_no = $sale->bill_no;
                                          $items = $CI->Report_model->sale_item($bill_no); //530
                                          $itm_total = 0;
                                          foreach ($items as $itm) {
                                            ?>
                                            <tr>
                                              <td><?php echo $itm->item_name; ?></td>
                                              <td><?php echo $itm->amount; ?>.00</td>
                                              <td><?php echo $itm->qty; ?></td>
                                              <td>LKR <?php echo $to = $itm->qty*$itm->amount; ?>.00</td>
                                            </tr>
                                            <?php
                                            $itm_total = $itm_total+$to;
                                          }
                                        ?>
                                    </tbody>
                                  </table>
                        </td>
                    </tr>

                  
                    <tr>
                        <td>Total</td>
                        <td>LKR <?php echo $ser_total+$itm_total; ?>.00</td>
                    </tr>
                    <tr>
                        <td>Discount</td>
                        <td>LKR <?php echo $sale->discount; ?></td>
                    </tr>
                    
                  </tbody>
                </table>
              </div>
            </div>
            <!-- page end-->
            </div>
          </div>
        </div>
      </section>
    </section>
  