<style type="text/css">
  .add_items {
    width: 100%;
    height: 380px;
    background-color: #f7f7f7;
    padding: 10px;
    overflow: scroll;
  }

  .btn-order {
    color: #fff;
    background-color: #337ab7;
    ;
    border-color: #337ab7;
    ;
    border-radius: 0px;
  }

  .btn-order:hover {
    background-color: #313552;
    border-color: #313552;
    color: #fff;
  }

  .btn_item {
    width: 100%;
  }

  .item_box {

    margin-top: 20px;
    padding: 20px 10px;
    background-color: #f7f7f7;
    height: 150px;
    border-radius: 18px;
    box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;
    transition: transform .2s;
    /* Animation */
  }

  .item_box:hover {
    transform: scale(1.1);
  }

  .item_m {
    padding: 5px 0px;
    color: #313552;
  }

  .fnt-15 {
    font-size: 15px;
  }

  .fnt-bold {
    font-weight: bold;
  }

  .btn-wt-100 {
    width: 100%;
  }

  .m-top-10 {
    margin-top: 10px;
  }

  .li-style {
    border-bottom: medium;
    background-color: #f4f9f9;
    padding: 8px;
    color: #314e52;
  }

  .li-style:hover {
    background-color: #e7e6e1;
    color: #f2a154;
  }

  .sec-container {
    background-color: white;
    padding: 50px;
  }
</style>
<!--main content start-->
<?php
$CI = &get_instance();
?>
<section id="main-content">
  <section class="wrapper site-min-height">
    <div class="row mt">
      <div class="col-lg-12">
        <div class="form-panel">
          <div class="row">

            <div class="col-md-4" id="add_items">

              <div id="item_section">
                <!-- This is Order -->
              </div>

              <div style="margin-top:10px;">
                <div class="row fnt-15 fnt-bold">
                  <div class="col-xs-3 col-md-6 col-lg-3">
                    <a class="btn btn-order btn-wt-100" onclick="clear_items(<?php echo $order_id; ?>)">Clear</a>
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
                </div>

                <div class="col-md-1">
                  <a class="btn btn-primary btn_item" id="search_btn"><i class="fa fa-search"></i></a>
                </div>

                <div class="col-md-2">
                  <a class="btn btn-primary btn_item" id="clear_btn" onclick="clear_search()">Clear</a>
                </div>
              </div>

              <div class="row" id="items">
                <?php
                foreach ($items as $itm) {
                  $int_qty_id = $itm->id; // id from int_qty tbl
                ?>
                  <a id="single_hold_item<?php echo $int_qty_id; ?>">
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
                          <?php echo $CI->Orders_model->item_name($item_id); ?> - <?php echo $CI->Orders_model->selling_price($item_id, $var_id); ?>
                        </div>
                        <div class="item_m">
                          Qty : <?php echo $itm->qty; ?><br>
                          Purchase price: <?php echo $CI->Orders_model->purchase_price($item_id, $var_id); ?>
                        </div>
                      </div>
                    </div>
                  </a>

                  <input hidden type="text" id="id<?php echo $int_qty_id; ?>" value="<?php echo $int_qty_id; ?>">
                  <input hidden type="text" id="order_id<?php echo $int_qty_id; ?>" value="<?php echo $order_id; ?>">

                  <script>
                    $(document).ready(function() {
                      $("#single_hold_item<?php echo $int_qty_id; ?>").click(function() {
                        var order_id = $("#order_id<?php echo $int_qty_id; ?>").val();
                        var id = $("#id<?php echo $int_qty_id; ?>").val();
                        $.ajax({
                          url: "<?php echo base_url(); ?>Orders/insert_hold_order_item", //803
                          type: "POST",
                          cache: false,
                          data: {
                            order_id: order_id,
                            id: id
                          },
                          success: function(data) {
                            //alert(data);
                            $("#item_section").html(data);
                            //location.reload();
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

<!-- Models Start -->
<!-- Add Customer Modal -->
<div id="add_customer" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Select Cutomer</h4>
      </div>
      <form action="<?php echo base_url(); ?>Orders/add_customer" method="post">
        <!-- Model Body  -->
        <div class="modal-body">
          <input type="text" value="<?php echo $order_id; ?>" name="p_order_id" hidden>
          <input type="text" value="<?php echo $sub_total; ?>" name="sub_total" hidden>
          <input type="text" value="<?php echo $discount; ?>" name="discount" hidden>

          <style>
            .f-20 {
              font-size: 20px;
            }

            .h-50 {
              height: 50px;
            }

            .mbt-10 {
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
              <input class="h-50 f-20 form-control" type="text" name="mobile" id="mobile">

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
        <!-- Model Body End -->

        <div class="modal-footer">
          <input width="100%" type="submit" class="btn btn-primary" value="Add Customer" id="add_customer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </form>
    </div>

  </div>
</div>
</div>
<!-- Add Customer End -->

<!-- Discount Starts -->
<div id="discount" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Discount</h4>
      </div>
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
        </div>
  </div>

</div>
</div>
<!-- Discounts Ends -->

<!-- Model Ends -->


<script>
  $(document).ready(function() {

    $("#mobile").on("keyup", function() {
      var mobile = $(this).val();
      var name = $("#name").val();

      if (mobile !== '') {
        $.ajax({
          url: "<?php echo base_url(); ?>Orders/search_mobile",
          type: "POST",
          cache: false,
          data: {
            mobile: mobile
          },
          success: function(data) {
            //alert(data);
            $("#mobile_list").html(data);
            $("#mobile_list").fadeIn();
          }
        });
      } else {
        $("#mobile_list").html("");
        $("#mobile_list").fadeOut();
      }

    });


    // click one particular number it's fill in textbox
    $(document).on("click", "#mobile_list li", function() {

      $('#mobile').val($(this).text());
      $('#mobile_list').fadeOut("fast");
      var mobile = $('#mobile').val();


      $.ajax({
        url: "<?php echo base_url(); ?>Orders/customer_name",
        type: "POST",
        cache: false,
        data: {
          mobile: mobile
        },
        success: function(data) {
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
      } else {
        if (mobile.length == 10) {
          $("#validation").html("<div class='alert alert-success'>Added Successfully</div>");
          return true;
        } else {
          $("#validation").html("<div class='alert alert-warning'>Please Enter a Valid Number (0771234567)</div>");
          return false;
        }
      }
    });
  });

  // Click Search btn
  $(document).ready(function() {
    $("#search_btn").click(function() {

      var search_text = $('#search_item').val();
      $.ajax({
        url: "<?php echo base_url(); ?>Orders/item_id_search",
        type: "POST",
        cache: false,
        data: {
          search_txt: search_text
        },
        success: function(data) {
          //alert(data);
          $("#items").html(data);
          $("#items").fadeIn();
        }
      });

    });
  });
</script>

<script>
  function clear_search() {
    $("#search_item").val("");
  }
  $(document).ready(function() {
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

<!-- Items Loading -->
<script>
  $(document).ready(function() {
    var order_id = <?php echo $order_id; ?>;
    $.ajax({
      url: "<?php echo base_url(); ?>Orders/pending_order_items",
      type: "POST",
      cache: false,
      data: {
        order_id: order_id
      },
      success: function(data) {
        //alert(data);
        $("#item_section").html(data);
      }
    })
  });
</script>
<!-- Items Loading -->