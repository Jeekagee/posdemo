
<section id="main-content">
    <section class="wrapper">
        <h3> Add New Employee</h3>
        <div class="row mt">
            <div class="col-lg-6" >
                <?php echo form_open('Employees/insert'); ?>
                    <div class="form-panel">
                        <h4 class="mb">Employee</h4>
                        <div class="form-horizontal style-form">
                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Employee ID <span style="color: red;"> *</span></label>
                            <div class="col-sm-8">
                            <input type="text" value="<?php echo set_value('emp_id'); ?>" class="form-control" name="emp_id" id="employee_id">
                            <span class="text-danger"><?php echo form_error('emp_id'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Employee Name <span style="color: red;"> *</span></label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" value="<?php echo set_value('emp_name'); ?>" name="emp_name" id="emp_name">
                            <span class="text-danger"><?php echo form_error('emp_name'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Location<span style="color: red;"> *</span></label>
                            <div class="col-sm-8">
                            <select class="form-control" name="emp_loc">
                                <option value="">Select the Location</option>
                                <?php
                                  foreach ($location as $loc) {
                                    echo "<option value='$loc->location'>$loc->location</option>";
                                  }
                                ?>
                            </select>
                            <span class="text-danger"><?php echo form_error('emp_loc'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Designation<span style="color: red;"> *</span></label>
                            <div class="col-sm-8">
                            <select class="form-control" name="emp_des">
                                <option value="">Select the Designation</option>
                                <option value="1">Staff</option>
                                <option value="2">Employee</option>
                            </select>
                            <span class="text-danger"><?php echo form_error('emp_des'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Salary <span style="color: red;"> *</span></label>
                            <div class="col-sm-8">
                            <input type="text" value="<?php echo set_value('salary'); ?>" class="form-control" name="salary" id="salary">
                            <span class="text-danger"><?php echo form_error('salary'); ?></span>
                            </div>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-12 ">
                            <input type="submit" class="btn btn-primary pull-right mr-5" value="Add Employee" name="submit">
                            <a style="margin-right: 15px;" href="<?php echo base_url(); ?>Employees" class="pull-right btn btn-danger">Cancel</a>
                            </div>

                        </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</section>