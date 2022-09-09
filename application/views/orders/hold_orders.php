
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
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
              <table class="table table-hover table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>Order ID</th>
                    <th>Total</th>
                    <th>Discount</th>
                    <th>Date</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $CI =& get_instance();
                  $i =1;
                  foreach ($orders as $order){
                    ?>
                      <tr>
                        <td class="text-center"><?php echo $i; ?></td>
                        <td ><?php echo $order->id; ?></td>
                        <td class="text-right"><?php echo $total = $order->total; ?>.00</td>
                        <td class="text-right"><?php echo $discount = $order->discount; ?>.00</td>
                        <td class="text-right"><?php echo $order->updated; ?></td>
                        
                      
                        <td class="text-center">
                            <a data-toggle="modal" data-target="#pay<?php echo $order->id; ?>" class="btn btn-primary btn-xs">Pay</a>
                            <a href="<?php echo base_url(); ?>" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>
                            <a href="" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
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

  <style>
    .m-top-10{
        margin-top:10px;
    }
  </style>
  
  <?php
  foreach ($orders as $order) {
    ?>
    <!-- Modal -->
    <div id="pay<?php echo $order->id; ?>" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Payment</h4>
                        </div>
                        <form action="<?php echo base_url(); ?>Orders/add_bill" method="post">
                        <div class="modal-body">
                          <input type="text" value="<?php echo $order->id; ?>" name="p_order_id" hidden>
                          <input type="text" value="<?php echo $total = $order->total; ?>" name="sub_total" hidden>
                          <input type="text" value="<?php echo $discount = $order->discount; ?>" name="discount" hidden>

                          <div class="row fnt-15 m-top-10">
                            <div class="col-sm-5">
                              <label>Total Amount:</label>
                            </div>
                            <div class="col-sm-7">
                              <input class="form-control" type="text" name="total_amount" id="t_amount<?php echo $order->id; ?>" value="<?php echo $total-$discount; ?>" disabled>
                            </div>
                          </div>

                          <div class="row fnt-15 m-top-10">
                            <div class="col-sm-5">
                              <label>Payment:</label>
                            </div>
                            <div class="col-sm-7">
                              <input class="form-control" type="number" name="p_amount" id="p_amount<?php echo $order->id; ?>" value="">
                            </div>
                          </div>

                          <div class="row fnt-15 m-top-10">
                            <div class="col-sm-5">
                              <label>Balance:</label>
                            </div>
                            <div class="col-sm-7">
                              <div></div>
                              <input class="form-control has-error" type="text" name="balance" id="balance<?php echo $order->id; ?>" disabled>
                            </div>
                          </div>

                          <div class="row fnt-15 m-top-10">

                            <div class="col-sm-5">
                              Payment Method
                            </div>
                            <div class="col-sm-7">
                              <input value="1" type="radio" class="custom-control-input"  name="p_method" checked>
                              <label class="custom-control-label">Cash</label>

                              <input value="2" type="radio" class="custom-control-input" id="defaultChecked" name="p_method">
                              <label class="custom-control-label">Card</label>
                            </div>
                          </div>

                        </div>
                        <div class="modal-footer">
                          <input type="submit" class="btn btn-primary" value="Pay" id="btn_pay<?php echo $order->id; ?>" disabled>
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </form>
                        </div>
                      </div>

                    </div>
                  </div>

                  <script type="text/javascript">
                    $(document).ready(function(){
                        
                        $("#p_amount<?php echo $order->id; ?>").on("keyup", function(){
                            var p_amount = $(this).val();
                            var t_amount = $("#t_amount<?php echo $order->id; ?>").val();

                            var balance = p_amount - t_amount;
                            $("#balance<?php echo $order->id; ?>").val(balance);

                            if (balance >= 0){
                            $("#btn_pay<?php echo $order->id; ?>").removeAttr("disabled");
                            $("#balance<?php echo $order->id; ?>").css("border", "2px solid green");
                            }
                            else{
                            $("#btn_pay<?php echo $order->id; ?>").prop("disabled",true);
                            $("#balance<?php echo $order->id; ?>").css("border", "2px solid red");
                            }
                        });


                    });
                    </script>
    <?php
  }
  ?>