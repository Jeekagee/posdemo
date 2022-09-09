
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
        <h3>Edit Order</h3>
        <div class="row mt">
          <div class="col-lg-8">
            <form action="<?php echo base_url(); ?>Orders/update" method="post" enctype="multipart/form-data">
            <div class="form-panel">
              <h4 class="mb"></i> Edit Order(Basci Info)
              </h4>
              <div class="form-horizontal style-form">

                <div id="validation">
                  <?php
                  if ($this->session->flashdata('success')) {
                    echo $this->session->flashdata('success');
                  }
                  ?>
                </div>
                
                <input hidden type="text" value="<?php echo $order->order_id; ?>">
                <div class="form-group">
                  <label class="col-sm-4 control-label">Vehicle No <span style="color: red;"> *</span></label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" name="vehicle_no" id="vehicle_no" value="<?php echo $order->vehicle_no; ?>">
                      <div id="vehicle_no_list"></div>
                      <span style="color:red;"><?php echo form_error('vehicle_no'); ?></span>
                  </div>
                </div>

                <div class="form-group" id="c_no">
                  <label class="col-sm-4 control-label">Contact No<span style="color: red;"> *</span></label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" name="contact_no" id="contact_no" value="<?php echo $order->contact_no; ?>">
                      <span style="color:red;"><?php echo form_error('contact_no'); ?></span>
                  </div>
                </div>

                <div class="form-group" id="c_no">
                  <label class="col-sm-4 control-label">Customer Name<span style="color: red;"> *</span></label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" name="cus_name" id="cus_name" value="<?php echo $order->customer_name; ?>">
                      <span style="color:red;"><?php echo form_error('cus_name'); ?></span>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-4 control-label">Bill No <span style="color: red;"> *</span></label>
                  <div class="col-sm-8">
                    <input disabled type="text" class="form-control" name="bill_no" id="bill_no" value="<?php echo $order->bill_no; ?>">
                    <span style="color:red;"><?php echo form_error('bill_no'); ?></span>
                  </div>
                </div>

                
                <div class="form-group">
                  <label class="col-sm-4 control-label">Bill Date <span style="color: red;"> *</span></label>
                  <div class="col-sm-8">
                    <input type="date" value="<?php echo $order->bill_date; ?>" class="form-control" name="bill_date" id="bill_date">
                  </div>
                </div>

                


                <div class="form-group">
                  <label class="col-sm-2 control-label">Price</label>
                  <div class="col-md-4">
                    <input type="text" class="form-control" name="price" id="price" value="<?php echo $order->price; ?>">
                    <span style="color:red;"><?php echo form_error('price'); ?></span>
                  </div>
                  <label class="col-sm-2 control-label">Discount</label>
                  <div class="col-md-4">
                    <input type="text" class="form-control" name="discount" id="discount" value="<?php echo $order->discount; ?>">
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-12 ">
                    <input type="submit" class="btn btn-primary pull-right mr-5" value="Add Order" name="submit">
                    <a style="margin-right: 15px;" href="" class="pull-right btn btn-danger">Cancel</a>
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

