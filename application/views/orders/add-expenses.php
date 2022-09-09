
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
  input[type="text"],
  input[type="date"],
  select
  {
    background-color:#f0f0f0;
  }
</style>
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">  
        <h3>Add New Expense</h3>

        
        
        <form action="<?php echo base_url(); ?>Orders/insert_expense" method="post">
        <div class="sec-container">
            
            <div class="mb-5">
            <div id="delete_msg">
              <?php
                if ($this->session->flashdata('success')) {
                  echo $this->session->flashdata('success');
                }
              ?>
            </div>
                <h4>Add Expense</h4>
            </div>
            <hr>

            <?php
              $month = date('m');
              $day = date('d');
              $year = date('Y');
              
              $today = $year . '-' . $month . '-' . $day;
            ?>

            <div class="row">
                <div class="col-md-3">
                    <div style="padding:10px;">
                      <div class="form-group">
                          <label for="">Expense Date *</label>
                          <input name ="ex_date" type="date" class="form-control input-lg" value="<?php echo $today; ?>"/>
                          <span class="text-danger"><?php echo form_error('ex_date'); ?></span>
                      </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div style="padding:10px;">
                      <div class="form-group">
                          <label for="">Location</label>
                          <select name="location" class="form-control input-lg">
                            <option value="">Select Location</option>
                            <?php
                              foreach ($location as $loc) {
                                echo "<option value='$loc->location'>$loc->location</option>";
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
                          <input type="text" name ="ref_no" class="form-control input-lg" placeholder="Ref No"/>
                          <span class="text-danger"><?php echo form_error('ref_no'); ?></span>
                      </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div style="padding:10px;">
                      <div class="form-group">
                          <label for="">Payee Name*</label>
                          <input type="text" name ="name" class="form-control input-lg" placeholder="Payee Name*"/>
                          <span class="text-danger"><?php echo form_error('name'); ?></span>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div style="padding:10px;">
                      <div class="form-group">
                          <label for="">Description</label>
                          <input type="text" name="des" class="form-control input-lg" placeholder="Description"/>
                      </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div style="padding:10px;">
                      <div class="form-group">
                          <label for="">Catogery</label>
                          <select name="cat" id="ex_catogery" class="form-control input-lg">
                            <option value="">Select Catogery</option>
                            <?php
                              foreach ($catogories as $catogery) {
                                echo "<option value='$catogery->cat_id'>$catogery->catogery</option>";
                              }
                            ?>
                          </select>
                      </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div style="padding:10px;">
                      <div class="form-group">
                          <label for="">Sub Catogery</label>
                          <select name="subcat" id="ex_sub_catogery" class="form-control input-lg">
                            <option value="">Select sub catogery</option>
                          </select>
                      </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div style="padding:10px;">
                      <div class="form-group">
                          <label for="">Payment Method</label>
                          <select name="method" class="form-control input-lg" id="method">
                            <option value="cash">Cash</option>
                            <option value="credit">Credit</option>
                          </select>

                      </div>
                    </div>
                </div>
                <div class="col-md-3" style="display:none;" id="check_date">
                    <div style="padding:10px;">
                      <div class="form-group">
                          <label for="">Check Date</label>
                          <input name ="check_date" type="date" class="form-control input-lg"/>
                          <span class="text-danger"><?php echo form_error('check_date'); ?></span>
                      </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div style="padding:10px;">
                      <div class="form-group">
                          <label for="">Amount *</label>
                          <input type="text" name ="amount" class="form-control input-lg" placeholder="Amount"/>
                          <span class="text-danger"><?php echo form_error('amount'); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
              <div class="col-md-2">
                <input type="submit" class="btn btn btn-block btn-flat btn-success" value="Add">
              </div>
              <div class="col-md-2">
                <button class="btn btn btn-block btn-flat btn-info">Reset</button>
              </div>
              <div class="col-md-2">
              <button class="btn btn btn-block btn-flat btn-warning">Print</button>
              </div>
            </div>
        </div>
        </form>
    </section>
</section>
    <!-- /MAIN CONTENT -->

