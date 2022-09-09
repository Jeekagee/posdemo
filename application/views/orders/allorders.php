
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <h3>Orders</h3>
        <div id="delete_msg"><?php
          if ($this->session->flashdata('delete')) {
            echo $this->session->flashdata('delete');
          }
        ?>
        </div>
            <div style="margin-bottom: 10px;" >
                <a href="<?php echo base_url(); ?>Orders/insert" class="btn btn-success"><i class="fa fa-plus"></i> Add New</a>
            </div>

            <div style="margin-bottom: 10px;" >
                <div class="row">
                    <div class="col-md-2">
                        <select id="main_catogery" onchange="location = this.value;" class="form-control" style="width:150px;">
                        <option value='<?php echo base_url(); ?>Orders'>This Month</option>
                            <?php
                            foreach ($bill_years as $bill_year) {
                              if ($bill_year->bill_year == $selected_yr) {
                                $slt = "selected";
                                $all = "";
                              }
                              elseif ($selected_yr == "") {
                                $slt = "";
                                $all = "selected";
                              }
                              else{
                                $slt = "";
                                $all = "";
                              }
                              echo "<option $slt value='".base_url()."Orders/All/$bill_year->bill_year'>$bill_year->bill_year</option>";
                            }
                            echo "<option $all value='".base_url()."Orders/All'>All</option>";
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        <div class="row mb" style="padding:10px;">
          <!-- page start-->
          <div class="content-panel" >
            <div class="adv-table">
              <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Vehicle No</th>
                    <th>Bill No</th>
                    <th>Date</th>
                    <th>Mobile</th>
                    <th class="hidden-phone">Service</th>
                    <th>Type</th>
                    <th>Make</th>
                    <th>Price</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $i =1;
                  foreach ($orders as $order){
                    ?>
                      <tr class="gradeX">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $order->vehicle_no; ?></td>
                        <td><?php echo $order->bill_no; ?></td>
                        <td><?php echo $order->bill_date; ?></td>
                        <td><?php echo $order->contact_no; ?></td>
                        <td class="hidden-phone"><?php echo $order->service; ?></td>
                        <td><?php echo $order->type; ?></td>
                        <td><?php echo $order->make; ?></td>
                        <td><?php echo $order->price; ?></td>
                        <td>
                          <a href="<?php echo base_url(); ?>Orders/view/<?php echo $order_id = $order->order_id; ?>" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>
                          <a href="<?php echo base_url(); ?>Orders/edit/<?php echo $order->order_id; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                          <a href="<?php echo base_url(); ?>Orders/delete/<?php echo $order->order_id; ?>/<?php echo $order->bill_no; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
                          <?php
                            $CI =& get_instance();
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
                            }
                          ?>
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
  