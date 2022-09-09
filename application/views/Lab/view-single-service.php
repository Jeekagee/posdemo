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
  <?php 
    $CI =& get_instance();
    $CI->load->model('Laboratory_model');
  ?>
    <section class="wrapper">
        <div class="row mt">
            <div class="col-lg-8">
                <?php echo form_open('Laboratory/update'); ?>
                <input type="text" value="<?php echo $service_data->id; ?>" name="id" hidden >
                    <div class="form-panel" style="padding:25px">
                      <div id="delete_msg">
                        <?php
                          if ($this->session->flashdata('updatemsg')) {
                            echo $this->session->flashdata('updatemsg');
                          }
                        ?>
                      </div>
                        <h4 class="mb">Labortary Service</h4>
                        <div class="form-horizontal style-form">
                        
                        <div class="form-group">
                          <label class="col-sm-3 control-label">Location<span style="color: red;"> *</span></label>
                          <div class="col-sm-8">
                              <select id="location" class="form-control" name="location">
                                <?php
                                foreach ($locations as $location) {
                                    $l_sel = "";
                                    if ($location->id == $service_data->location_id) {
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
                            <input type="text" value="<?php echo $invoice_no = $service_data->invoice_no; ?>" class="form-control" name="invoice_no" id="invoice_no" readonly >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">NIC No<span style="color: red;"> </span></label>
                            <div class="col-sm-8">
                            <input type="text" value="<?php echo $nic = $service_data->patient_nic; ?>"  class="form-control" name="nic" id="nic">
                            <div id="nic_list"></div>
                            <span class="text-danger"><?php echo form_error('nic'); ?></span>
                            </div>
                        </div>

                        <?php
                            $CI =& get_instance();
                            // Get Patient Detail by nic
                            $patient = $CI->Laboratory_model->patient_detail($nic); //70
                        ?>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Title<span style="color: red;"> *</span></label>
                          <div class="col-sm-8">
                              <select id="title" class="form-control" name="title">
                                <?php
                                foreach ($titles as $title) {
                                    $l_sel = "";
                                    if ($title->id == $patient->title) {
                                        $l_sel = "selected";
                                    }
                                    echo "<option $l_sel value='$title->id'>$title->title_name</option>";
                                }
                                ?>
                              </select>
                              <span class="text-danger"><?php echo form_error('title'); ?></span>
                          </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Patient Name<span style="color: red;"> *</span></label>
                            <div class="col-sm-8">
                            <input type="text" value="<?php echo $patient->name; ?>" class="form-control" name="pname" id="pname">
                            <span class="text-danger"><?php echo form_error('pname'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Gender<span style="color: red;"> *</span></label>
                          <div class="col-sm-8">
                                <?php
                                  $sel_male = "";
                                  $sel_female = "";
                                  if ($patient->gender == 1) 
                                  {
                                    $sel_male = "checked";
                                  }
                                  else
                                  {
                                    $sel_female = "checked";
                                  }
                                ?>
                              <input type="radio" <?php echo $sel_male; ?> id="male" name="pgender" value="1">
                              <label for="pmale">Male</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                              <input type="radio" <?php echo $sel_female; ?> id="female" name="pgender" value="2">
                              <label for="pfemale">Female</label>
                              <span class="text-danger"><?php echo form_error('pgender'); ?></span>
                          </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Age<span style="color: red;"> *</span></label>
                            <div class="col-sm-4">
                            <input type="number" value="<?php echo $patient->ageyear; ?>" class="form-control" name="pyear" id="pyear">
                            <label for="pyear">Years</label>
                            </div>
                            <div class="col-sm-4">  
                            <input type="number" value="<?php echo $patient->agemonth; ?>" class="form-control" name="pmonth" id="pmonth" max="12">
                            <label for="pmonth">Months</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" placeholder = "771234567">Mobile No<span style="color: red;"> *</span></label>
                            <div class="col-sm-8">
                            <input type="text" placeholder ="771234567" value="<?php echo $patient->mobile; ?>" class="form-control" name="mobile" id="mobile">
                            <span class="text-danger"><?php echo form_error('mobile'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Address</label>
                            <div class="col-sm-8">
                            <input type="text" value="<?php echo $patient->address; ?>" class="form-control" name="address" id="address">
                            <span class="text-danger"><?php echo form_error('address'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Service<span style="color: red;"> *</span></label>
                          <div class="col-sm-4">
                              <select id="service" class="form-control" name="service">
                                <option value="">Select Service</option>
                                <?php
                                foreach ($services as $service) {
                                    echo "<option value='$service->service_id'>$service->service</option>";
                                }
                                ?>
                              </select>
                              <span class="text-danger" id="service_error"></span>
                          </div>
                          <div class="col-sm-4">
                            <input type="text" class="form-control" id="charge" readonly id="charge">
                          </div>
                          <div class="col-sm-1" style="padding-right: 0px; padding-left: 0px;">
                             <a onclick="addService()" class="btn btn-primary">Add</a>
                          </div>
  
                        </div>

                        <div class="form-group" id="services">
                            <?php
                            $CI =& get_instance();
                            $is_service = $CI->Laboratory_model->is_service($invoice_no);
                            if ($is_service > 0) {
                              $services = $CI->Laboratory_model->addedServices($invoice_no);
                              ?>
                              <table class="table table-hover">
                                <thead>
                                <th class="text-center">Service</th>
                                <th class="text-right">Amount</th>
                              </thead>
                              
                                <tbody>
                                    <?php
                                    $CI =& get_instance();
                                    $services = $CI->Laboratory_model->lab_services($invoice_no); 
                                    $total = 0;
                                    foreach ($services as $service) {
                                      ?>
                                      <tr>
                                        <td class="text-center">
                                          <?php 
                                          $service_id = $service->service_id; 
                                          echo $CI->Laboratory_model->get_service($service_id)
                                          ?>
                                        </td>
                                        <td class="text-right" >LKR <?php echo $charge = $service->charge; ?>.00</td>
                                      </tr>
                                      <?php
                                      $total = $total+$charge;
                                    }
                                    ?>
                                    <tr>
                                        <td class="text-center text-danger" style="font-weight:900;">Total</td>
                                        <td class="text-right text-danger" style="font-weight:900;"><?php echo $total; ?>.00</td>
                                        
                                    </tr>
                                    </tbody>
                                </table>
                              <?php
                            }
                            ?>
                        </div>

                        <div class="form-group">
                          <label class="col-sm-3 control-label">Doctor</label>
                          <div class="col-sm-8">
                              <select id="doctor" class="form-control" name="doctor">
                                <option value="">Select Doctor</option>
                                <?php
                                
                                foreach ($doctors as $doctor) {
                                    $d_sel = "";
                                    if ($doctor->id == $service_data->doctor_id) {
                                        $d_sel = "selected";
                                    }
                                    echo "<option $d_sel value='$doctor->id'>$doctor->name</option>";
                                }
                                ?>
                              </select>
                              <span class="text-danger"><?php echo form_error('doctor'); ?></span>
                          </div>
                        </div>

                        <?php
                          $month = date('m');
                          $day = date('d');
                          $year = date('Y');
                          
                          $today = $year . '-' . $month . '-' . $day;
                        ?>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Comments</label>
                            <div class="col-sm-8">
                            <input type="text" value="<?php echo $service_data->comment; ?>" class="form-control" name="comment" id="comment">
                            <span class="text-danger"><?php echo form_error('comment'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                          <div class="col-sm-3"></div>
                          <div class="col-sm-8">
                            <input type="submit" class="btn btn-primary pull-right mr-5" value="Update" name="save_item">
                            <a target="_blank" href="<?php echo base_url();?>Laboratory/viewprintBill/<?php echo $service_data->invoice_no;?>" class="btn btn-success">Print</a>
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


