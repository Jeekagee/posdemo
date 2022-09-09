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
<section id="main-content">
    <section class="wrapper">
        <div class="row mt">
            <div class="col-lg-8">
                <?php echo form_open('Doctor/insert'); ?>
                    <div class="form-panel" style="padding:25px">
                      <div id="delete_msg">
                        <?php
                          if ($this->session->flashdata('docmsg')) {
                            echo $this->session->flashdata('docmsg');
                          }
                        ?>
                      </div>
                        <h4 class="mb">Doctor Details</h4>
                        <div class="form-horizontal style-form">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Doctor Name<span style="color: red;"> *</span></label>
                            <div class="col-sm-8">
                            <input type="text" value="<?php echo set_value('d_name'); ?>" class="form-control" name="d_name" id="d_name">
                            <span class="text-danger"><?php echo form_error('d_name'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Mobile No<span style="color: red;"> *</span></label>
                            <div class="col-sm-8">
                            <input type="text" value="<?php echo set_value('d_mobile'); ?>" class="form-control" name="d_mobile" id="d_mobile">
                            <span class="text-danger"><?php echo form_error('d_mobile'); ?></span>
                            </div>
                        </div>


                        <div class="form-group">
                          <label class="col-sm-3 control-label">Specialization<span style="color: red;"> *</span></label>
                          <div class="col-sm-8">
                              <select id="d_special" class="form-control" name="d_special">
                                <option value="">Select Specialization</option>
                                <?php
                                foreach ($specials as $spl) {
                                  echo "<option value='$spl->id'>$spl->specialization</option>";
                                }
                                ?>
                              </select>
                              <span class="text-danger"><?php echo form_error('d_special'); ?></span>
                          </div>
                          <div class="col-sm-1" style="padding-right: 0px; padding-left: 0px;">
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_area">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                              </button>
                          </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label">Doctor's Fees</label>
                            <div class="col-sm-8">
                            <input type="text" value="<?php echo set_value('d_charge'); ?>" class="form-control" name="d_charge" id="d_charge">
                            <span class="text-danger"><?php echo form_error('d_charge'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Doctor's Commision</label>
                            <div class="col-sm-4">
                            <input type="text" value="<?php echo set_value('d_commision'); ?>" class="form-control" name="d_commision" id="d_commision">
                            <span class="text-danger"><?php echo form_error('d_commision'); ?></span>
                            </div>
                            <div class="col-sm-4">
                              <label class="radio-inline"><input type="radio" name="com_type" value="1" checked>Amount</label>
                              <label class="radio-inline"><input type="radio" name="com_type" value="2">Percentage</label>
                            </div>
                        </div>


                        <div class="form-group">
                          <div class="col-sm-3"></div>
                          <div class="col-sm-8">
                            <input type="submit" class="btn btn-primary pull-right mr-5" value="Save" name="save_item">
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
<div id="add_area" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add New Specialization</h4>
      </div>

      <form method="post" action="<?php echo base_url(); ?>Appoint/add_area/doctor">
        <div class="modal-body">
          <div>
              <label>Specialization</label>
            </div>
            <div>
              <input class="form-control" type="text" name="area">
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