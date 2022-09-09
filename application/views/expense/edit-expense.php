
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
  .sec-container{
    background-color:white;
    padding:50px;
  }
  
</style>
<?php
  $total_exp = 0;
  foreach ($total_expense as $exp) {
    $total_exp = $total_exp+$exp->amount;
  }

  // Current timestamp is assumed, so these find first and last day of THIS month
  $first_day_this_month = date('01-m-Y'); // hard-coded '01' for first day
  $last_day_this_month  = date('t-m-Y');
?>
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">  
        <h3>Edit Expense</h3>
        <form action="<?php echo base_url(); ?>Expense/update" method="post">
        <div class="sec-container">
            
            <div class="mb-5">
            <div id="delete_msg">
              <?php
                if ($this->session->flashdata('success')) {
                  echo $this->session->flashdata('success');
                }
              ?>
            </div>
                <h4>Edit Expense</h4>
                Total Expense : LKR <?php echo $total_exp; ?>.00 ( <?php echo $first_day_this_month." to ".$last_day_this_month; ?> )
            </div>
            <hr>
            <div class="row">
                <div class="col-md-3">
                    <div style="padding:10px;">
                      <div class="form-group">
                          <label for="">Expense Date *</label>
                          <input value="<?php echo $expenses->ex_date; ?>" id="ex_date" name ="ex_date" type="date" class="form-control"/>
                          <span class="text-danger"><?php echo form_error('ex_date'); ?></span>
                      </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div style="padding:10px;">
                      <div class="form-group">
                          <label for="">Location</label>
                          <select id="ex_loc" name="location" class="form-control">
                            <option value="">Select Location</option>
                            <?php
                              foreach ($location as $loc) {
                                if ($loc->location == $expenses->location) {
                                    $selected = "selected";
                                }
                                else{
                                    $selected = "";
                                }
                                echo "<option $selected value='$loc->location'>$loc->location</option>";
                              }
                            ?>
                          </select>
                      </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div style="padding:10px;">
                      <div class="form-group">
                          <label for="">Ref No</label>
                          <input value="<?php echo $expenses->ref_no; ?>" id="ex_ref" type="text" name ="ref_no" class="form-control" placeholder="Ref No"/>
                          <span class="text-danger"><?php echo form_error('ref_no'); ?></span>
                      </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div style="padding:10px;">
                      <div class="form-group">
                          <label for="">Payee Name*</label>
                          <input value="<?php echo $expenses->payee_name; ?>" id="ex_name" type="text" name ="name" class="form-control" placeholder="Payee Name*"/>
                          <span class="text-danger"><?php echo form_error('name'); ?></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div style="padding:10px;">
                      <div class="form-group">
                          <label for="">Description</label>
                          <input value="<?php echo $expenses->description; ?>" id="ex_des" type="text" name="des" class="form-control" placeholder="Description"/>
                      </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div style="padding:10px;">
                      <div class="form-group">
                          <label for="">Catogery</label>
                          <select name="cat" id="ex_catogery" class="form-control">
                            <option value="">Select Catogery</option>
                            <?php
                              foreach ($catogories as $catogery) {
                                echo "<option value='$catogery->id'>$catogery->category</option>";
                              }
                            ?>
                          </select>
                          <span class="text-danger"><?php echo form_error('cat'); ?></span>
                      </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div style="padding:10px;">
                      <div class="form-group">
                          <label for="">Payment Method</label>
                          <select  name="method" class="form-control" id="method">
                              <?php
                              if ($expenses->method == 'cash') {
                                $sl_cash = 'selected';
                              }
                              else{
                                $sl_cash = '';
                              }

                              if ($expenses->method == 'credit') {
                                $sl_cheque = 'selected';
                              }
                              else{
                                $sl_cheque = '';
                              }
                              ?>
                            <option <?php echo $sl_cash; ?> value="cash">Cash</option>
                            <option <?php echo $sl_cheque; ?> value="credit">Credit</option>
                          </select>

                      </div>
                    </div>
                </div>
                <?php
                    if ($expenses->method == "credit") {
                        ?>
                        <div class="col-md-3" id="check_date">
                            <div style="padding:10px;">
                            <div class="form-group">
                                <label for="">Check Date</label>
                                <input value="<?php echo $expenses->check_date; ?>" id="ex_check_date" name ="check_date" type="date" class="form-control"/>
                                <span class="text-danger"><?php echo form_error('check_date'); ?></span>
                            </div>
                            </div>
                        </div>
                        <?php
                    }
                ?>
                

                <div class="col-md-3">
                    <div style="padding:10px;">
                      <div class="form-group">
                          <label for="">Amount *</label>
                          <input value="<?php echo $expenses->amount; ?>" id="ex_amount" type="text" name ="amount" class="form-control" placeholder="Amount"/>
                          <span class="text-danger"><?php echo form_error('amount'); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <input type="text" value="<?php echo $expenses->id; ?>" name="expenseid" hidden>

            <div class="row">
              <div class="col-sm-2">
                <input type="submit" class="btn btn-block btn-success" value="Update">
              </div>
              </form>
            </div>
        </div>
        
    </section>
</section>
    <!-- /MAIN CONTENT -->

