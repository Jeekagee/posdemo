<!--sidebar end-->
<!-- **********************************************************************************************************************************************************
   MAIN CONTENT
   *********************************************************************************************************************************************************** -->
<!--main content start-->
<section id="main-content">
   <section class="wrapper">
      <div class="row mb">
         <div class="col-lg-3"></div>
         <div class="col-lg-6">
            <?php echo form_open('Settings/update_service'); ?>
            <div class="form-panel">
               <h4 class="mb">Update Service</h4>
               <div id="delete_msg">
                    <?php
                    $CI =& get_instance();
                     if ($this->session->flashdata('msg')) {
                     echo $this->session->flashdata('msg');
                     }
                    ?>
               </div>
               <div class="form-horizontal style-form">
                  <div class="form-group">
                     <label class="col-sm-4 control-label">Service<span style="color: red;"> *</span></label>
                     <div class="col-sm-8">
                     <input type="text" value="<?php echo $service_id; ?>"  class="form-control" name="service_id" style="display:none;">
                        <input type="text" value="<?php echo $CI->Setting_model->service_name($service_id); ?>"  class="form-control" name="service" placeholder="Service Name">
                        <span class="text-danger"><?php echo form_error('service'); ?></span>
                     </div>
                  </div>
                  
                  <style>
                     .padding-15{
                     padding-right: 15px;
                     padding-left: 15px;
                     }
                  </style>
                  <div class="form-group">
                     <?php
                        
                        foreach ($locations as $loc) {
                            $location_id = $loc->id;
                            ?>
                           <div class="row padding-15" style="margin-bottom:10px;">
                              <label class="col-sm-4 control-label"><?php echo $loc->location; ?></label>
                              <div class="col-sm-8">

                              <?php
                              $count = $CI->Setting_model->location_avaiable($location_id,$service_id);
                              if ($count == 1) {
                                 $amount = $CI->Setting_model->get_amount($service_id,$location_id);
                              }
                              else{
                                 $amount = 0;
                              }
                              ?>
                                  
                                 <input type="number" value="<?php echo $amount; ?>"  class="form-control" name="location<?php echo $loc->id; ?>">
                              </div>
                           </div>
                           <?php
                        }
                        ?>
                  </div>
                  <div class="form-group">
                     <div class="col-sm-12 ">
                        <input type="submit" class="btn btn-primary pull-right mr-5" value="Update" name="submit">
                     </div>
                  </div>
               </div>
            </div>
            </form>
         </div>
         <div class="col-lg-3"></div>
      </div>
      <!-- /row -->
   </section>
   <!-- /wrapper -->
</section>
<!-- /MAIN CONTENT -->
<!--main content end-->
</section>