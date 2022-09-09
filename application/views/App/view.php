<section id="main-content">
    <section class="wrapper">
        <div class="row mt">
            <div class="col-lg-8">
                <?php echo form_open('Appoint/update'); ?>
                    <div class="form-panel" style="padding:25px">
                      <div id="delete_msg">
                        <?php
                          if ($this->session->flashdata('invmsg')) {
                            echo $this->session->flashdata('invmsg');
                          }
                        ?>
                      </div>
                        <h4 class="mb">Appointment Details</h4>
                        <div class="form-horizontal style-form">

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Location<span style="color: red;"> *</span></label>
                          <div class="col-sm-8">
                              <select id="location" class="form-control" name="location">
                                <?php
                                foreach ($locations as $location) {
                                    $l_sel = "";
                                    if ($location->id == $apps->user_location) {
                                        $l_sel = "selected";
                                    }
                                    echo "<option $l_sel value='$location->id'>$location->location</option>";
                                }
                                ?>
                              </select>
                              <span class="text-danger"><?php echo form_error('location'); ?></span>
                          </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Invoice No</label>
                            <div class="col-sm-8">
                            <input type="text" value="<?php echo $apps->id; ?>" class="form-control" name="invoice_no" id="invoice_no">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">NIC No<span style="color: red;"> *</span></label>
                            <div class="col-sm-8">
                            <input type="text" value="<?php echo $apps->nic; ?>" class="form-control" name="nic" id="nic">
                            <div id="nic_list"></div>
                            <span class="text-danger"><?php echo form_error('nic'); ?></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Patient Name<span style="color: red;"> *</span></label>
                            <div class="col-sm-8">
                            <input type="text" value="<?php echo $apps->name; ?>" class="form-control" name="pname" id="pname">
                            <span class="text-danger"><?php echo form_error('pname'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Mobile No<span style="color: red;"> *</span></label>
                            <div class="col-sm-8">
                            <input type="text" value="<?php echo $apps->mobile; ?>" class="form-control" name="mobile" id="mobile">
                            <span class="text-danger"><?php echo form_error('mobile'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Address</label>
                            <div class="col-sm-8">
                            <input type="text" value="<?php echo $apps->address; ?>" class="form-control" name="address" id="address">
                            <span class="text-danger"><?php echo form_error('address'); ?></span>
                            </div>
                        </div>

                        <?php
                        $CI =& get_instance();
                        ?>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Specialization<span style="color: red;"> *</span></label>
                            <div class="col-sm-8">
                                <select id="area" class="form-control" name="area">
                                    <option value="">Select Specialization</option>
                                    <?php
                                    $slt = "";
                                    foreach ($specials as $spl) {
                                        if ($spl->id == $apps->area) {
                                            $slt = "selected";
                                        }
                                        else{
                                            $slt = "";
                                        }
                                        echo "<option $slt value='$spl->id'>$spl->specialization</option>";
                                    }
                                    ?>
                                </select>
                                <span class="text-danger"><?php echo form_error('area'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Doctor<span style="color: red;"> *</span></label>
                          <div class="col-sm-8">
                                <select class="form-control" name="doctor" id="doctor">
                                    <option value="">Select Doctor</option>
                                    <?php
                                    $doctors = $this->Appoint_model->doctor_for_area($apps->area);
                                    $slt = "";
                                    foreach ($doctors as $doc) {
                                        if ($apps->doctor == $doc->id) {
                                            $slt = "selected";
                                        }
                                        else{
                                            $slt = "";
                                        }
                                        echo "<option $slt value='$doc->id'>$doc->name</option>";
                                    }
                                    ?>
                                </select>
                          </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Doctor's Charge</label>
                            <div class="col-sm-8">
                            <input type="text" value="<?php echo $apps->doc_charge; ?>" class="form-control" name="dcharge" id="dcharge">
                            <span class="text-danger"><?php echo form_error('dcharge'); ?></span>
                            </div>
                        </div>

                        <?php
                          $month = date('m');
                          $day = date('d');
                          $year = date('Y');
                          
                          $today = $year . '-' . $month . '-' . $day;
                        ?>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Date<span style="color: red;"> *</span></label>
                          <div class="col-sm-8">
                              <input class="form-control" type="date" value="<?php echo $apps->app_date; ?>" name="app_date">
                              <span class="text-danger"><?php echo form_error('app_date'); ?></span>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-3 control-label">Time<span style="color: red;"> *</span></label>
                          <div class="col-sm-8">
                              <input type="time" class="form-control" id="tym" name="tym" value="<?php echo $apps->time; ?>">
                              <span class="text-danger"><?php echo form_error('app_date'); ?></span>
                          </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Comments</label>
                            <div class="col-sm-8">
                            <input type="text" value="<?php echo $apps->comment; ?>" class="form-control" name="comment" id="comment">
                            <span class="text-danger"><?php echo form_error('comment'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Other Charges</label>
                            <div class="col-sm-8">
                                <?php
                                    $o_charges = $this->Appoint_model->other_charges($apps->id);
                                ?>
                                <div id="other_tbl">
                                    
                                </div>
                            </div>

                            <div class="col-sm-3"></div>

                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="other" id="other" placeholder="Description">
                                <span class="text-danger" id="other_error"></span>
                                </div>
                                <div class="col-sm-3">
                                <input type="text" class="form-control" name="amount" id="amount" placeholder="Amount">
                                </div>
                                <div class="col-sm-2">
                                <a class="btn btn-success" id="add_other">Add</a>
                            </div>
                        </div>


                        <div class="form-group">
                          <div class="col-sm-12">
                              <input type="submit" class="btn btn-primary pull-right mr-3" value="Update">
                            <a href="" class="btn btn-success pull-right mr-3" style="margin-right:6px;">Print</a>
                            <a style="margin-right: 15px;" href="" class="pull-left btn btn-danger">Back</a>
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

<!-- Filter Range Modal -->
<div id="filter_range" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Filter Range</h4>
      </div>

      <form method="post" action="<?php echo base_url(); ?>Inventory/add_frange">

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
            <label>Filter Range</label>
          </div>
          <div>
            <input class="form-control" type="text" name="filter_range">
          </div>
      </div>

      <div class="modal-footer">
        <input type="submit" name="save_filter_range" value="Save" class="btn btn-success">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div>

  </div>
</div>
<!-- Filter Modal -->

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