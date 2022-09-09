
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <h3>Change Your Password</h3>
        
        <div class="row mb">
            <div class="col-lg-6">
                <?php echo form_open('Settings/ChangePassword'); ?>
                <div class="form-panel">
                        <h4 class="mb">Change New Password</h4>
                        <div id="delete_msg">
                        <?php
                            if ($this->session->flashdata('msg')) {
                            echo $this->session->flashdata('msg');
                            }
                        ?>
                        </div>
                        <div class="form-horizontal style-form">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Password<span style="color: red;"> *</span></label>
                                <div class="col-sm-8">
                                <input autocomplete="false" type="password"  class="form-control" name="pwd">
                                <span class="text-danger"><?php echo form_error('pwd'); ?></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">New Password<span style="color: red;"> *</span></label>
                                <div class="col-sm-8">
                                <input autocomplete="false" type="password"  class="form-control" name="npwd">
                                <span class="text-danger"><?php echo form_error('npwd'); ?></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-4 control-label">Confirm Password<span style="color: red;"> *</span></label>
                                <div class="col-sm-8">
                                <input autocomplete="false" type="password"  class="form-control" name="cpwd">
                                <span class="text-danger"><?php echo form_error('cpwd'); ?></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12 ">
                                <input type="submit" class="btn btn-primary pull-right mr-5" value="Submit" name="submit">
                                <a style="margin-right: 15px;" href="<?php echo base_url(); ?>Dashboard" class="pull-right btn btn-danger">Cancel</a>
                                </div>
                            </div>
                        </div>
                </div>
                </form>
            </div>
        </div>
        <!-- /row -->
      </section>
      <!-- /wrapper -->
    </section>
    <!-- /MAIN CONTENT -->
    <!--main content end-->
  </section>
  