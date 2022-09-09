
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <h3>Items</h3>
        <div id="delete_msg">
          <?php
            if ($this->session->flashdata('message')) {
              echo $this->session->flashdata('message');
            }
          ?>
        </div>
            <div style="margin-bottom: 10px;" >
                <div class="row">
                    <div class="col-md-2">
                        <select id="main_catogery" onchange="location = this.value;" class="form-control" style="width:150px;">
                            <?php
                            echo "<option value='".base_url()."Inventory/Items'>All</option>";
                            foreach ($catogories as $catogery) {
                              if ($item_catogery->catogery == $catogery->catogery) {
                                $select = "selected";
                              }
                              else{
                                $select = "";
                              }
                                echo "<option $select value='".base_url()."Inventory/Items/$catogery->cat_id'>$catogery->catogery</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                      <a href="<?php echo base_url(); ?>Inventory/Create_barcode" class="btn btn-primary">Barcode</a>
                    </div>
                </div>

            </div>
        <div class="row mb">
            
          <!-- page start-->
          <div class="content-panel" style="padding:20px 20px 2px 20px;">
            <div class="adv-table">
              <table class="table table-hover table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Item ID</th>
                    <th>Catogery</th>
                    <!-- <th>Brand</th> -->
                    <!--
                    <th>Stock</th>
                    <th>Unit Price</th>-->
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  // Load Model to get Catogery
                  $CI =& get_instance();
                  $CI->load->model('Inventory_model');
                  $i =1;
                  foreach ($items as $item){
                    ?>
                      <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $item->item_name; ?></td>
                        <td><?php echo $item->item_id; ?></td>
                        <td>
                          <?php 
                            $item_catogery = $this->Inventory_model->item_catogery($item->item_catogery);
                            echo $item_catogery->catogery;
                          ?>
                        </td>
                        <!-- <td>
                          <?php 
                            $item_brand = $this->Inventory_model->item_brand($item->item_brand);
                            echo $item_brand->brand;
                          ?>
                        </td> -->

                        <td class="text-center">
                          <a href="<?php echo base_url(); ?>Inventory/edit/<?php echo $item->item_id; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                          <!-- <?php
                              if($return = true){
                             ?> 
                              <a href="<?php echo base_url(); ?>Inventory/delete/<?php echo $item->item_id; ?>/<?php echo $item->item_name; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                            <?php 
                              }
                            ?> -->
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

          <!-- Update Model Modal -->
        <div id="modal" class="modal fade" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Update Price & Stocks</h4>
                </div>

                <form method="post" action="">

                <div class="modal-body">
                    <div>
                      <label>Stock</label>
                    </div>
                    <div>
                      <input class="form-control" type="text" name="stock" id="stock">
                    </div>

                    <div>
                      <label>Price</label>
                    </div>
                    <div>
                      <input class="form-control" type="text" name="price" id="price">
                      <input class="form-control" type="hidden" name="item_id" id="item_id">
                    </div>
                </div>

                <div class="modal-footer">
                  <input type="submit" id="update" name="update" class="btn btn-success" value="Update">
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
                </form>
              </div>

            </div>
          </div>
          <!-- Update Modal -->
          <!-- page end-->
        </div>
        <!-- /row -->
      </section>
      <!-- /wrapper -->
    </section>
    <!-- /MAIN CONTENT -->
    <!--main content end-->
  </section>
  