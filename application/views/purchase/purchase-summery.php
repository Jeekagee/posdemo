
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <h3>Purchase</h3>
        <div id="delete_msg"><?php
          if ($this->session->flashdata('delete')) {
            echo $this->session->flashdata('delete');
          }
        ?>
        </div>
            <div style="margin-bottom: 10px;" >
                <a href="<?php echo base_url(); ?>Purchase/AddNew" class="btn btn-success"><i class="fa fa-plus"></i> Add New</a>
            </div>
        <div class="row mb" style="padding:10px;">
          <!-- page start-->
          <div class="content-panel" >
            <div class="adv-table">
              <table class="table table-hover table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>#</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Ref No</th>
                    <th class="text-center">Supplier</th>
                    <th class="text-center">Item Id</th>
                    <th class="text-center">Item Name</th>
                    <th class="text-center">Qunatity</th>
                    <th class="text-center">Last update Quantity</th>
                    <th class="text-center">Purchase Price</th>
                    <th class="text-center">Selling Price</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                    $CI =& get_instance();
                
                  $i =1;
                  foreach ($purchases as $purchase){
                        $puritem_id = $purchase->purchase_id;
                        $intqty_id = $purchase->item_id;
                        $intvar_id = $purchase->variation_id;
                        //Purchase Table
                        $purchase_data = $CI->Purchase_model->purchase_data($puritem_id);
                        $supplier = $CI->Purchase_model->supplier($purchase_data->supplier);
                        $intqty = $CI->Purchase_model->intqty_data($intqty_id,$intvar_id);
                    ?>
                      <tr id="pur<?php echo $purchase->id; ?>">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $purchase_data->rec_date; ?></td>
                        <td><?php echo $purchase_data->ref_no; ?></td>
                        <td><?php echo $supplier->supplier;  ?></td>
                        <td><?php echo $purchase->item_id; ?></td>
                        <td><?php echo $purchase->item_name; ?></td>
                        <td class="text-center"><?php echo $qty = $purchase->quantity; ?></td>
                        <td class="text-center"><?php echo $intqty->qty; ?></td>
                        <td class="text-right"><?php echo $price = $purchase->purchase_price; ?>.00</td>
                        <td class="text-right"><?php echo $purchase->selling_price; ?>.00</td>
                        <td class="text-right"><?php echo $qty*$price; ?>.00</td>
                        <td class="text-center">
                          <a href="<?php echo base_url(); ?>Purchase/view/<?php echo $purchase->id; ?>" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>
                          <a data-toggle="modal" data-target="#update<?php echo $i; ?>" class="btn btn-primary btn-xs"><i class="fa fa-upload"></i></a>
                          <!-- <a href="<?php echo base_url(); ?>Purchase/edit/<?php echo $purchase_data->id; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a> -->
                          <a id="<?php echo $purchase->id; ?>" class="btn btn-danger btn-xs delete_purchase"><i class="fa fa-trash"></i></a>
                          <?php
                           /* $CI =& get_instance();
                            $bill_available = $CI->Orders_model->bill_status($order_id);
                            if ($bill_available == 1) {
                              ?>
                                <a href="<?php echo base_url(); ?>Orders/confirm_bill/<?php echo $order_id; ?>" class="btn btn-info btn-xs"><i class="fa fa-print"></i></a>
                              <?php
                            }
                            if ($bill_available == 0){
                              ?>
                                <a href="<?php echo base_url(); ?>Orders/Print/<?php echo $order_id; ?>" class="btn btn-warning btn-xs"><i class="fa fa-print"></i></a>
                              <?php
                            }*/
                          ?>
                        </td>
                      </tr>

                      <!-- Modal -->
                      <div id="update<?php echo $i; ?>" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Update Selling Price</h4>
                            </div>
                            <div class="modal-body">
                              <form action="<?php echo base_url(); ?>Purchase/update_sellingprice" method="POST">
                                <div class="form-group">
                                  <input type="hidden" name="id" class="form-control" value="<?php echo $purchase->id; ?>">
                                </div>
                                <div class="form-group">
                                  <label for="">Product ID</label>
                                  <input type="text" class="form-control" value="<?php echo $purchase->item_id; ?>" readonly>
                                </div>
                                <div class="form-group"> 
                                  <label for="">Puchase Price</label>
                                  <input type="text" class="form-control" value="<?php echo $price; ?>" readonly>
                                </div>
                                <div class="form-group"> 
                                  <label for="">Selling Price</label>
                                  <input type="text" name="price" class="form-control" value="<?php echo $purchase->selling_price; ?>">
                                </div>
                                <div class="form-group"> 
                                  <label for="">Quantity</label>
                                  <input type="text" name="quantity" class="form-control" value="<?php echo $purchase->quantity; ?>">
                                </div>
                            </div>
                            <div class="modal-footer">
                              <input type="submit" class="btn btn-success" value="Update">
                              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>

                            </form>
                          </div>
                        </div>
                      </div>

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
  