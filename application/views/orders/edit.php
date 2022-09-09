
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
</style>
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">  
        <h3>Update Order Details</h3>
        <div class="row mt">
          <div class="col-lg-8">
            <form action="<?php echo base_url(); ?>Orders/Update" method="post" enctype="multipart/form-data">
            <div class="form-panel">
              <h4 class="mb"></i> Order Profile
              </h4>
              <div class="form-horizontal style-form">

                <div id="validation">
                  <?php
                  if ($this->session->flashdata('editsuccess')) {
                    echo $this->session->flashdata('editsuccess');
                  }
                  ?>
                </div>

                <div class="form-group" id="c_no">
                  <label class="col-sm-4 control-label">Contact No<span style="color: red;"> *</span></label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" name="contact_no" id="contact_no" value="<?php echo $order->customer_mobile; ?>">
                      <span style="color:red;"><?php echo form_error('contact_no'); ?></span>
                  </div>
                </div>
<!-- 
                <div class="form-group" id="c_no">
                  <label class="col-sm-4 control-label">Customer Name<span style="color: red;"> *</span></label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" name="cus_name" id="cus_name" value="<?php echo $order->fname; ?>">
                      <span style="color:red;"><?php echo form_error('cus_name'); ?></span>
                  </div>
                </div>  -->

                <div class="form-group">
                  <label class="col-sm-4 control-label">Bill No <span style="color: red;"> *</span></label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" name="bill_no" id="bill_no" value="<?php echo $order->bill_no; ?>">
                    <span style="color:red;"><?php echo form_error('bill_no'); ?></span>
                  </div>
                </div>
        
                <?php $CI =& get_instance(); ?>

                <div class="form-group">
                  <label class="col-md-4 control-label">Order Items</label>
                  <div class="col-md-4">
                    <select class="form-control" name="items" id="items">
                      <option value="">Select Item</option>
                      <?php
                      //echo 
                        foreach($items as $item){
                          $id = $item->item_id;
                          $name = $item->item_name;
                          //get qunatity from int_qty
                          $p_id = $item->id;
                          $qty = $CI->Orders_model->current_qty($p_id);
                          //$qty = $item->quantity;
                          if ($qty == 0) {
                            $disabled = "disabled";
                          }
                          else{
                            $disabled = "";
                          }

                          if ($qty > 5) {
                            $clr = "";
                          }
                          else{
                            $clr = "#FF9966";
                          }
                          echo "<option style='background-color:$clr;' $disabled value='$p_id'>$name - $id($qty)</option>";
                        }
                      ?>
                    </select>
                    <span class="text-danger" id="item_error"></span>
                  </div>

                  <div class="col-md-2">
                    <input type="text" placeholder="Quantity" class="form-control" name="qty" id="qty">
                    
                  </div>

                  <div class="col-md-2">
                    <input type="text" class="form-control" name="item_amount" id="item_amount">
                    
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-4"></div>
                  <div class="col-sm-8">
                      <a id="add_item" class="btn btn-success">Add Item</a>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-4"></div>
                    <div class="col-sm-8" id="item_tbl">
                          
                    </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-2 control-label">Discount</label>
                  <div class="col-md-4">
                    <input type="text" class="form-control" name="discount" id="discount" value="<?php echo $order->discount; ?>">
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-12 ">
                    <input type="submit" class="btn btn-primary pull-right mr-5" value="Update Order" name="submit">
                    <a href="<?php echo base_url(); ?>Orders" class="btn btn-danger pull-right" style="margin-right:5px">Back</a>
                  </div>

                </div>

              </div>
            </div>
              </form>
          </div>
        </div>
    </section>
</section>
    <!-- /MAIN CONTENT -->

