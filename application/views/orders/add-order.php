
<style type="text/css">
  .li-style{
    border-bottom: medium;
    background-color:#f4f9f9;
    padding: 8px;
    color: #314e52;
  }
  .li-style:hover{
    background-color:#e7e6e1;
    color: #f2a154;
  }
  .sec-container{
    background-color:white;
    padding:50px;
  }
  .add_items{
    width:100%;
    height:380px;
    background-color: #f7f7f7;
    padding:10px;
    overflow: scroll;
  }
  .btn-order{
    color: #fff;
    background-color: #337ab7;;
    border-color: #337ab7;;
    border-radius: 0px;
  }
  .btn-order:hover {
    background-color: #313552;
    border-color: #313552;
    color:#fff;
  }
  .btn_item{
    width:100%;
  }
  .item_box{
    
    margin-top:20px;
    padding:20px 10px;
    background-color: #f7f7f7;
    height:150px;
    border-radius: 18px;
    box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;
    transition: transform .2s; /* Animation */
  }
  .item_box:hover{
    transform: scale(1.1);
  }
  .item_m{
    padding:5px 0px;
    color:#313552;
  }
  .fnt-15{
    font-size:15px;
  }
  .fnt-bold{
    font-weight:bold;
  }
  .btn-wt-100{
    width:100%;
  }
  .m-top-10{
    margin-top:10px;
  }
  .li-style{
    border-bottom: medium;
    background-color:#f4f9f9;
    padding: 8px;
    color: #314e52;
  }
  .li-style:hover{
    background-color:#e7e6e1;
    color: #f2a154;
  }
  .sec-container{
    background-color:white;
    padding:50px;
  }
</style>
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height"> 
        <div class="row mt">
          <div class="col-lg-12">
            <div class="form-panel">
              <div class="row">
                <div class="col-md-4" id="add_items">
                  <div class="add_items">
                      <div class="m-top-10">
                        <table class="table">
                          <thead>
                            <th class="text-center">No</th>
                            <th class="text-center">Item</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Qty</th>
                            <th class="text-center">Total</th>
                            <th class="text-center"></th>
                          </thead>
                          <tbody>
                            <?php
                            $CI =& get_instance();
                            $i = 1;
                            $sub_total = 0;
                            foreach ($order_items as $o_itm) {
                              ?>
                              <tr>
                                <td class="text-center"><?php echo $i; ?></td>
                                <td data-toggle="modal" data-target="#update<?php echo $o_itm->id; ?>" class="text-left"><?php echo $o_itm->item_name; ?></td>
                                <td class="text-right"><?php echo $itm_amt =  $o_itm->amount; ?>.00</td>
                                <td class="text-center"><?php echo $itm_qty = $o_itm->qty; ?></td>
                                <td class="text-right"><?php echo $item_total = $itm_amt*$itm_qty; ?>.00</td>
                                <td>
                                  <a href="<?php echo base_url(); ?>Orders/delete_order_item/<?php echo $o_itm->id; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                                </td>
                              </tr>

                              <!-- Qunatity Update Modal -->
                              <div id="update<?php echo $o_itm->id; ?>" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                  <!-- Modal content-->
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      <h4 class="modal-title">Update</h4>
                                    </div>
                                    <div class="modal-body">
                                      <form action="<?php echo base_url(); ?>Orders/update_order_qty" method="post">
                                        <div class="row">
                                        <input name="order_id" type="hidden" class="form-control" value="<?php echo $o_itm->id; ?>" >
                                          <div class="col-sm-4">
                                            <label for="">Quantity</label>
                                            <input id="update_qty" style="height:90px; font-size:40px;" name="update_qty" type="text" class="form-control" value="<?php echo $itm_qty = $o_itm->qty; ?>">
                                          </div>
                                          
                                          <div class="col-sm-4">
                                          <label for="">Price (Selling Price)</label>
                                          <input style="height:90px; font-size:40px;" name="price" type="text" class="form-control" value="<?php echo $o_itm->amount; ?>">
                                          </div>

                                          <div class="col-sm-4">
                                          <label for="">Discount</label>
                                          <input style="height:90px; font-size:40px;" name="update_dis" type="text" class="form-control" value="0">
                                          </div>

                                        </div>
                                        <div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                      <input type="submit" class="btn btn-primary" value="Update">
                                    </form>
                                    </div>
                                  </div>

                                </div>
                              </div>

                              <script>
                                window.onload = function() {
                                  document.getElementById("update_qty").focus();
                                };
                              </script>
                              <?php
                              $sub_total = $sub_total+$item_total;
                              $i++;
                            }
                            // update total in order tbl
                            $CI->Orders_model->update_total($order_id,$sub_total);
                            ?>
                          </tbody>
                        </table>
                      </div>
                  </div>

                  <div style="margin-top:10px;">
                    <div class="row fnt-15 fnt-bold">
                      <div class="col-md-6">
                        <div class="item_m">
                          Sub Total
                        </div>
                        <div class="item_m">
                          Discount
                        </div>
                        <div class="item_m">
                          Total
                        </div>
                      </div>
                      <div class="col-md-6 text-right">
                        <div class="item_m">
                          <?php echo $sub_total; ?>.00
                        </div>
                        <div class="item_m">
                        <?php
                        // Discount from order
                        echo $discount = $CI->Orders_model->order_discount($order_id); //83
                        ?>.00
                        </div>
                        <div class="item_m">
                        <?php echo $sub_total-$discount; ?>.00
                        </div>
                      </div>
                    </div>
                  </div>

                  <div style="margin-top:10px;">
                    <div class="row fnt-15 fnt-bold">
                      <div class="col-xs-3 col-md-6 col-lg-3">
                        <a class="btn btn-order btn-wt-100" href="<?php echo base_url(); ?>Orders/clear_items/<?php echo $order_id; ?>">Clear</a>
                      </div>
                      <div class="col-xs-3 col-md-6 col-lg-3">
                        <button type="button" class="btn btn-order btn-wt-100" data-toggle="modal" data-target="#discount">Discount</button>
                      </div>
                      <div class="col-xs-3 col-md-6 col-lg-3">
                        <a class="btn btn-order btn-wt-100" href="<?php echo base_url(); ?>Orders/hold_order/<?php echo $order_id; ?>">Hold</a>
                      </div>
                      <div class="col-xs-3 col-md-6 col-lg-3">
                        <button type="button" class="btn btn-order btn-wt-100" data-toggle="modal" data-target="#pay">Pay</button>
                      </div>
                    </div>
                  </div>

                  <!-- Discount Starts -->
                  <div id="discount" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Add Discount</h4>
                        </div>
                        <form action="<?php echo base_url(); ?>Orders/add_discount" method="post">
                        <div class="modal-body">
                          <input type="text" value="<?php echo $order_id; ?>" name="order_id" hidden>
                          <div class="row">
                            <div class="col-sm-8">
                              <input type="text" name="discount" class="form-control">
                            </div>
                            <div class="col-sm-4">
                              <select name="discount_type" class="form-control">
                                <option value="1">Amount</option>
                                <option value="2">Percentage</option>
                              </select>
                            </div>
                          </div>
                          
                        </div>
                        <div class="modal-footer">
                          <input type="submit" class="btn btn-success" value="Add">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </form>
                        </div>
                      </div>

                    </div>
                  </div>
                  <!-- Discounts Ends -->
                  <div id="pay" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Payment</h4>
                        </div>
                        <form action="<?php echo base_url(); ?>Orders/add_bill" method="post">
                        <div class="modal-body">
                          <input type="text" value="<?php echo $order_id; ?>" name="p_order_id" hidden>
                          <input type="text" value="<?php echo $sub_total; ?>" name="sub_total" hidden>
                          <input type="text" value="<?php echo $discount; ?>" name="discount" hidden>

                          <div class="row fnt-15 m-top-10">
                            <div class="col-sm-5">
                              <label>Total Amount:</label>
                            </div>
                            <div class="col-sm-7">
                              <input class="form-control" type="text" name="total_amount" id="t_amount" value="<?php echo $sub_total-$discount; ?>" disabled>
                            </div>
                          </div>

                          <div class="row fnt-15 m-top-10">
                            <div class="col-sm-5">
                              <label>Payment:</label>
                            </div>
                            <div class="col-sm-7">
                              <input class="form-control" type="number" name="p_amount" id="p_amount" value="">
                            </div>
                          </div>

                          <div class="row fnt-15 m-top-10">
                            <div class="col-sm-5">
                              <label>Balance:</label>
                            </div>
                            <div class="col-sm-7">
                              <div></div>
                              <input class="form-control has-error" type="text" name="balance" id="balance" disabled>
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
                          <input type="submit" class="btn btn-primary" value="Pay" id="btn_pay" disabled>
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </form>
                        </div>
                      </div>

                    </div>
                  </div>

                </div>
                <div class="col-md-8">
                  <div class="row">
                    <div class="col-md-3">
                      <a href="<?php echo base_url(); ?>Orders/hold_orders" class="btn btn-primary btn_item">Hold Orders <span class="badge bg-warning"><?php echo $CI->Orders_model->hold_order_count(); ?></span></a>
                    </div>
                    <div class="col-md-2">
                      <a class="btn btn-primary btn_item" data-toggle="modal" data-target="#add_customer">Customer</a>
                    </div>

                    <div class="col-md-4">
                      <input type="text" class="form-control" placeholder="Search" id="search_item">
                      <div id="item_list"></div>
                    </div>

                    <div class="col-md-1">
                      <a class="btn btn-primary btn_item" id="search_btn"><i class="fa fa-search"></i></a>
                    </div>

                    <div class="col-md-2">
                      <a class="btn btn-primary btn_item" id="clear_btn" onclick="clear_search()">Clear</a>
                    </div>
                  </div>
                  <div class="row" id="items">

                  <!-- Modal -->
                  <div id="add_customer" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Select Cutomer</h4>
                        </div>
                        <form action="<?php echo base_url(); ?>Orders/add_customer" method="post">
                        <div class="modal-body">
                          <input type="text" value="<?php echo $order_id; ?>" name="p_order_id" hidden>
                          <input type="text" value="<?php echo $sub_total; ?>" name="sub_total" hidden>
                          <input type="text" value="<?php echo $discount; ?>" name="discount" hidden>

                          <style>
                            .f-20{
                              font-size: 20px;
                            }
                            .h-50 {
                              height: 50px;
                            }

                            .mbt-10{
                              padding: 10px 50px 10px 50px;
                              width: 100%;
                            }
                          </style>

                          <div id="validation"></div>

                          <div class="row fnt-15 m-top-10">
                            <div class="col-sm-5">
                              <label class="f-20">Mobile Number : </label>
                            </div>
                            <div class="col-sm-7">
                              <input class="h-50 f-20 form-control" type="text" name="mobile" id="mobile" >

                              <div id="mobile_list"></div>
                            </div>
                          </div>

                          

                          <div class="row fnt-15 m-top-10">
                            <div class="col-sm-5">
                              <label class="f-20">Customer Name:</label>
                            </div>
                            <div class="col-sm-7">
                              <input class=" h-50 f-20 form-control" type="name" name="name" id="name">
                            </div>
                          </div>

                        </div>
                        <div class="modal-footer">
                          <input width="100%" type="submit" class="btn btn-primary" value="Add Customer" id="add_customer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </form>
                        </div>
                      </div>

                    </div>
                  </div>

                      <?php
                      foreach ($items as $itm) {
                        $int_qty_id = $itm->id; // id from int_qty tbl
                        ?>
                        <a id="single_item<?php echo $int_qty_id; ?>">
                          <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="item_box">
                              <div class="item_m">
                                <?php
                                $item_id = $itm->item_id; // Item_ID
                                echo $CI->Orders_model->barcode($item_id); 
                                ?>
                              </div>
                              <!-- <div class="item_m">
                                <?php echo $item_id = $itm->item_id; ?>
                              </div> -->
                              <?php $var_id = $itm->variation_id; ?>
                              <div class="item_m fnt-bold" style="color:#313552;">
                                <?php echo $CI->Orders_model->item_name($item_id); ?> - <?php echo $CI->Orders_model->selling_price($item_id,$var_id); ?>
                              </div>
                              <div class="item_m">
                                Qty : <?php echo $itm->qty; ?><br>
                                Purchase price: <?php echo $CI->Orders_model->purchase_price($item_id,$var_id); ?>
                              </div>
                            </div>
                          </div>
                        </a>
                        <input hidden type="text" id="id<?php echo $int_qty_id; ?>" value="<?php echo $int_qty_id; ?>">
                        <input hidden type="text" id="order_id<?php echo $int_qty_id; ?>" value="<?php echo $order_id; ?>">
                       
                        <script>
                          $(document).ready(function(){
                            $("#single_item<?php echo $int_qty_id; ?>").click(function(){
                              var order_id = $("#order_id<?php echo $int_qty_id; ?>").val();
                              var id = $("#id<?php echo $int_qty_id; ?>").val();
                                $.ajax({
                                  url:"<?php echo base_url(); ?>Orders/insert_order_item", //803
                                  type:"POST",
                                  cache:false,
                                  data:{order_id:order_id,id:id},
                                  success:function(data){
                                    //alert(data);
                                    $("#add_items").html(data);
                                    location.reload();
                                  }
                                });
                            }); 
                          });
                        </script>

                        <?php
                      }
                      ?>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
</section>
    <!-- /MAIN CONTENT -->


<script>
      $(document).ready(function(){
      
        $("#mobile").on("keyup", function(){
          var mobile = $(this).val();
          var name = $("#name").val();

          if (mobile !== '') {
            $.ajax({
              url:"<?php echo base_url(); ?>Orders/search_mobile",
              type:"POST",
              cache:false,
              data:{mobile:mobile},
              success:function(data){
                //alert(data);
                  $("#mobile_list").html(data);
                  $("#mobile_list").fadeIn();
              }
            });
          }
          else{
            $("#mobile_list").html("");
            $("#mobile_list").fadeOut();
          }

        });


        // click one particular number it's fill in textbox
      $(document).on("click","#mobile_list li", function(){

        $('#mobile').val($(this).text());
        $('#mobile_list').fadeOut("fast");
        var mobile = $('#mobile').val();


        $.ajax({
          url:"<?php echo base_url(); ?>Orders/customer_name",
          type:"POST",
          cache:false,
          data:{mobile:mobile},
          success:function(data){
            $("#name").val(data);
            //alert(data);
          }
        });
      });


      $("#add_customer").submit(function() {
        var mobile = $("#mobile").val();
        var name = $("#name").val();

        if (mobile == "" || name == "") {
          $("#validation").html("<div class='alert alert-danger'>Mobile number and Customer name is Requested</div>");
          return false;
        }
        else {
          if (mobile.length == 10) {
            $("#validation").html("<div class='alert alert-success'>Added Successfully</div>");
            return true;
          }
          else{
            $("#validation").html("<div class='alert alert-warning'>Please Enter a Valid Number (0771234567)</div>");
            return false;
          }
        }
      });
  });

  // Click Search btn
  $(document).ready(function(){
    $("#search_btn").click(function(){

          var search_text = $('#search_item').val();
          $.ajax({
            url:"<?php echo base_url(); ?>Orders/item_id_search",
            type:"POST",
            cache:false,
            data:{search_txt:search_text},
            success:function(data){
              //alert(data);
              $("#items").html(data);
              $("#items").fadeIn();
            }
          });

    });
  });
</script>

<script>
  function clear_search(){
    $("#search_item").val("");
  }
  $(document).ready(function(){
    // Get the input field
    var input = document.getElementById("search_item");

    // Execute a function when the user releases a key on the keyboard
    input.addEventListener("keyup", function(event) {
      // Number 13 is the "Enter" key on the keyboard
      if (event.keyCode === 13) {
        // Cancel the default action, if needed
        event.preventDefault();
        // Trigger the button element with a click
        document.getElementById("search_btn").click();
      }
    });
  });
</script>
