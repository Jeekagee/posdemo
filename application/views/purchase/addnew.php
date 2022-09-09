

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
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">  
        <h3>Add New Purchase</h3>

        <div class="sec-container">
        <div style="margin-bottom: 10px;" >
                <a href="<?php echo base_url(); ?>Purchase/AddSupplier" class="btn btn-success"><i class="fa fa-plus"></i> Add Supplier</a>
                <a href="<?php echo base_url(); ?>Purchase/AddLocation" class="btn btn-success"><i class="fa fa-plus"></i> Add Location</a>
            </div>
            <div class="mb-5">
                <h4>Add Purchase</h4>
            </div>
            <hr>
            
            <form action="<?php echo base_url(); ?>Purchase/AddItem" method="post">
            <div class="row" style="margin-bottom:10px;">
                <div class="col-md-3">
                    <select name="supplier" id="supplier" class="form-control">
                            <option value="">Select Supplier</option>
                            <?php
                              foreach ($suppliers as $sup) {
                                echo "<option value='$sup->id'>$sup->supplier</option>";
                              }
                            ?>
                    </select>
                    <span class="text-danger"><?php echo form_error('supplier'); ?></span>
                </div>
            </div>
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
                          <label for="">Receive Date *</label>
                          <input value="<?php echo $today; ?>" name="rec_date" type="date" class="form-control"/>
                          <span class="text-danger"><?php echo form_error('rec_date'); ?></span>
                      </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div style="padding:10px;">
                      <div class="form-group">
                          <label for="">Location</label>
                          <select name="location" class="form-control">
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
                          <label for="">Notes</label>
                          <input name="notes" type="text" class="form-control" placeholder="Notes"/>
                      </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div style="padding:10px;">
                      <div class="form-group">
                          <label for="">Ref No</label>
                          <input name="ref_no" type="text" class="form-control" placeholder="Ref No"/>
                          <span class="text-danger"><?php echo form_error('ref_no'); ?></span>
                      </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div style="padding:10px;">
                    <div class="form-group">
                        <label for="">Payment Method</label>
                        <select name="method" class="form-control" id="method">
                            <option value="cash">Cash</option>
                            <option value="credit">Credit</option>
                        </select>

                    </div>
                    </div>
                </div>

                <div class="col-md-3" style="display:none;" id="check_date">
                    <div style="padding:10px;">
                    <div class="form-group">
                        <label for="">Credit Date</label>
                        <input name ="check_date" type="date" class="form-control" id="check_date"/>
                        <span class="text-danger"><?php echo form_error('check_date'); ?></span>
                    </div>
                    </div>
                </div>

                
            </div>

            <div class="row">
                <div class="col-md-2">
                    <input type="submit" class="btn btn btn-block btn-flat btn-success" value="Add Items">
                </div>
            </div>

            
            </form>

            <div style="margin-top:35px; display:none;">
                <div style="width:80%; padding:10px; background-color:#f2f2f2; margin:auto">
                    <div class="row">
                        <div class="col-md-4">
                            <div style="padding:10px;">
                                <div class="form-group">
                                    <label for="">Item</label>
                                    <input type="text" class="form-control" name="item" id="item"/>
                                    <div id="vehicle_no_list"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div style="padding:10px;">
                                <div class="form-group">
                                    <label for="">Price</label>
                                    <input type="text" class="form-control" name="price" id="price"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div style="padding:10px;">
                                <div class="form-group">
                                    <label for="">Quantity</label>
                                    <input type="text" class="form-control" name="quantity" id="quantity"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <button class="btn btn btn-block btn-success">Add Items</button>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn btn-block">Clear</button>
                        </div>
                    </div>

                    <div style="margin-top:10px;">
                        <h4>Purchase Items</h4>            
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>John</td>
                                <td>2</td>
                                <td>500.00</td>
                                <td>1234.00</td>
                            </tr>

                            <tr>
                                <td>John</td>
                                <td>2</td>
                                <td>500.00</td>
                                <td>1234.00</td>
                            </tr>

                            </tbody>
                        </table>

                        <div>
                            <button class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
    <!-- /MAIN CONTENT -->

