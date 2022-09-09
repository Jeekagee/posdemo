
<section id="main-content">
    <section class="wrapper">
        <h3> Add New Item</h3>
        <div class="row mt">
            <div class="col-lg-8">
                <?php echo form_open('Inventory/insert'); ?>
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
                            <label class="col-sm-3 control-label">Barcode ID</label>
                            <div class="col-sm-8">
                            <input type="text" value="<?php echo set_value('barcode'); ?>" class="form-control" name="barcode" id="barcode">
                            <span class="text-danger"><?php echo form_error('barcode'); ?></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Item ID <span style="color: red;"> *</span></label>
                            <div class="col-sm-8">
                            <input type="text" value="<?php echo set_value('item_id'); ?>" class="form-control" name="item_id" id="item_id">
                            <span class="text-danger"><?php echo form_error('item_id'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Item Name <span style="color: red;"> *</span></label>
                            <div class="col-sm-8">
                            <input type="text" value="<?php echo set_value('item_name'); ?>" class="form-control" name="item_name" id="item_name">
                            <span class="text-danger"><?php echo form_error('item_name'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Item Catogery<span style="color: red;"> *</span></label>
                          <div class="col-sm-8">
                              <select id="item_catogery" class="form-control" name="item_catogery">
                                <option value="">Select Catogery</option>
                                <?php
                                foreach ($catogories as $catogery) {
                                  echo "<option value='$catogery->cat_id'>$catogery->catogery</option>";
                                }
                                ?>
                              </select>
                              <span class="text-danger"><?php echo form_error('item_catogery'); ?></span>
                          </div>
                          <div class="col-sm-1" style="padding-right: 0px; padding-left: 0px;">
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#catogery">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                              </button>
                          </div>
                        </div>

                        

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Item Sub Catogery</label>
                          <div class="col-sm-8">
                              <select class="form-control" name="item_sub_catogery" id="item_sub_catogery">
                                <option disabled selected >Select Sub Catogery</option>
                              </select>
                              <span class="text-danger"><?php echo form_error('item_sub_catogery'); ?></span>
                          </div>
                          <div class="col-sm-1" style="padding-right: 0px; padding-left: 0px;">
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sub_catogery">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                              </button>
                          </div>
                        </div>


                        <div class="form-group">
                          <label class="col-sm-3 control-label">Brand<span style="color: red;"> *</span></label>
                          <div class="col-sm-8">
                              <select class="form-control" name="item_brand" id="item_brand">
                                <option>Select Your Brand</option>
                                <?php
                                foreach ($brands as $brand) {
                                  echo "<option value='$brand->brand_id'>$brand->brand</option>";
                                }
                                ?>
                              </select>
                              <span class="text-danger"><?php echo form_error('item_brand'); ?></span>
                          </div>
                          <div class="col-sm-1" style="padding-right: 0px; padding-left: 0px;">
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#brand">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                              </button>
                          </div>
                        </div>


                        <div class="form-group">
                          <div class="col-sm-3"></div>
                          <div class="col-sm-8">
                            <input type="submit" class="btn btn-primary pull-right mr-5" value="Add Item" name="save_item">
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

<!-- Modal -->
<div id="catogery" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Catogery</h4>
      </div>

      <form method="post" action="<?php echo base_url(); ?>Inventory/add_catogery">
        <div class="modal-body">
          <div>
              <label>Catogery</label>
            </div>
            <div>
              <input class="form-control" type="text" name="catogery">
            </div>
          
        </div>
        <div class="modal-footer">
          <input type="submit" name="save_catogery" value="Save" class="btn btn-success">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>

  </div>
</div>
<!-- Catogery Modal -->

<!-- Sub Cat Modal -->
<div id="sub_catogery" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Sub Catogery</h4>
      </div>

      <form method="post" action="<?php echo base_url(); ?>Inventory/add_sub_catogery">
      <div class="modal-body">
          <div>
            <label>Catogery</label>
          </div>
          <div>
            <select class="form-control" id="main_catogery" name="catogery">
            <?php
              foreach ($catogories as $catogery) {
                echo "<option value='$catogery->cat_id'>$catogery->catogery</option>";
              }
            ?>
            </select>
          </div>

          <div>
            <label>Sub Catogery</label>
          </div>
          <div>
            <input class="form-control" type="text" name="sub_catogery">
          </div>
        
      </div>
      <div class="modal-footer">
        <input type="submit" name="save_sub_catogery" value="Save" class="btn btn-success">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>
<!-- Catogery Modal -->



<!-- Modal -->
<div id="brand" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Brand</h4>
      </div>

      <form method="post" action="<?php echo base_url(); ?>Inventory/add_brand">
      <div class="modal-body">
          <div>
            <label>Brand</label>
          </div>
          <div>
            <input class="form-control" type="text" name="brand">
          </div>
        
      </div>
      <div class="modal-footer">
        <input type="submit" name="save_brand" value="Save" class="btn btn-success">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>
<!-- Catogery Modal -->