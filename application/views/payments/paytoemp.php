
 <!--main content start-->
 <section id="main-content">
      <section class="wrapper">
        <h3>Payment</h3>
        <div id="delete_msg">
          <?php
            if ($this->session->flashdata('msg')) {
              echo $this->session->flashdata('msg');
            }
          ?>
        </div>

        <div class="row mb ">
            <div class="col-lg-8 col-md-offset-2">
            <div class="form-panel">
              <div style="background-color:#FF449F; padding:10px 10px 10px 10px; margin-bottom:20px; color:white;">
                <h4><?php echo $emp->emp_name; ?></h4>
                <span class="mb">
                <?php
                    if ($emp->emp_des == 1) {
                        echo "Labour";
                    }
                    if ($emp->emp_des == 2) {
                        echo "Staff";
                    }
                ?>
                </span>
              </div>

              <div class="form-horizontal style-form">
                <form action="<?php echo base_url(); ?>Payments/MakePayment/<?php echo $emp->id; ?>" method="post">
                <div class="form-group">
                  <label class="col-sm-4 control-label">Employee ID <span style="color: red;"> *</span></label>
                  <div class="col-sm-8">
                  <input type="text" value="<?php echo $emp->id; ?>" class="form-control" name="id" id="id" hidden>
                    <input type="text" value="<?php echo $emp->emp_id; ?>" class="form-control" name="employee_id" id="employee_id" disabled>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-4 control-label">Employee Name <span style="color: red;"> *</span></label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" value="<?php echo $emp->emp_name; ?>" name="emp_name" id="emp_name" disabled>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-4 control-label">Salary <span style="color: red;"> *</span></label>
                  <div class="col-sm-8">
                    <input type="text" value="<?php echo $emp->emp_salary; ?>" class="form-control" name="salary" id="salary" disabled>
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-4 control-label">Payment Type<span style="color: red;"> *</span></label>
                  <div class="col-sm-8">
                    <select name="payment_type" class="form-control">
                        <option value="advance">Advance</option>
                        <option value="salary">Salary</option>
                    </select>
                  </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 control-label">Gross Salary to Pay</label>
                    <div class="col-sm-8">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Month</th>
                            <th>Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>January</td>
                            <td>LKR 35000</td>
                        </tr>
                        <tr>
                            <td>February</td>
                            <td>10000</td>
                        </tr>
                        <tr>
                            <td>March</td>
                            <td>5000</td>
                        </tr>
                        </tbody>
                    </table>
                    <a href="" class="btn btn-primary pull-right"> View History</a>
                    </div>
                </div>


                <div class="form-group">
                  <label class="col-sm-4 control-label">Payment</label>

                  <div class="col-sm-3">
                    <input type="text" value="" class="form-control" name="amount" id="amount" placeholder="Amount">
                    <span class="text-danger"><?php echo form_error('amount'); ?></span>
                  </div>
                    
                  <label class="col-sm-2 control-label">Payment For</label>
                  <div class="col-sm-3">
                    <select name="pay_month" class="form-control">
                        <option value="">Select Month</option>
                        <option value="1">January</option>
                        <option value="2">February</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                    <span class="text-danger"><?php echo form_error('pay_month'); ?></span>
                  </div>

                </div>
              

              

                <div class="form-group">
                  <div class="col-sm-12">
                        <input type="submit" name="salary" class="btn btn-success pull-right" value="Make Payment">
                  </div>
                </div>


                </form>
              
              </div>
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