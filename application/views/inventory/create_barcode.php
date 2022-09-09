
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        
        <h3>Create Barcode</h3>
        <div class="row mt">
            <div class="col-lg-8">
                <?php echo form_open('Inventory/get_barcode'); ?>
                    <div class="form-panel" style="padding:25px">
                      <div id="delete_msg">
                        <?php
                          if ($this->session->flashdata('invmsg')) {
                            echo $this->session->flashdata('invmsg');
                          }
                        ?>
                      </div>
                        <h4 class="mb">Item Details</h4>
                        <div class="form-horizontal style-form">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Select Item</label>
                            <div class="col-sm-8">

                                <select name="item_id" id="item_id" class="form-control">
                                    <option value="">Select Item</option>
                                    <?php
                                    foreach ($items as $item) {
                                        $item_id = $item->item_id;
                                        echo "<option value='$item_id'>$item_id</option>";
                                    }
                                    ?>
                                </select>
                                <span class="text-danger"><?php echo form_error('item_id'); ?></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Item Name <span style="color: red;"> *</span></label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" name="item_name" id="item_name">
                            
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Price<span style="color: red;"> *</span></label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" name="item_price" id="item_price">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Counts as Pair<span style="color: red;"> *</span></label>
                            <div class="col-sm-8">
                            <input type="text" value="1" class="form-control" name="count" id="count">
                            </div>
                        </div>

                        <div class="form-group">
                          <div class="col-sm-3"></div>
                          <div class="col-sm-8">
                            <input type="submit" class="btn btn-primary pull-right mr-5" value="Barcode" name="barcode">
                            <a style="margin-right: 15px;" href="" class="pull-right btn btn-danger">Cancel</a>
                          </div>
                        </div>

                      </div>
                    </div>
                </form>
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

  <script>
    $(document).ready(function(){
      $("#item_id").change(function(){
        var item_id = $(this).val();

        // item_name
        $.ajax({
          url:"<?php echo base_url(); ?>Inventory/item_name",
          type:"POST",
          cache:false,
          data:{item_id:item_id},
          success:function(data){
            $("#item_name").val(data);
          }
        });

        // Item price
        $.ajax({
          url:"<?php echo base_url(); ?>Inventory/item_price",
          type:"POST",
          cache:false,
          data:{item_id:item_id},
          success:function(data){
            $("#item_price").val(data);
          }
        });
      }); 
    });
  </script>