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
            <?php echo form_open('Settings/insert_service'); ?>
            <div class="form-panel">
               <h4 class="mb">Add New Service</h4>
               <div id="delete_msg">
                  <?php
                     if ($this->session->flashdata('msg')) {
                     echo $this->session->flashdata('msg');
                     }
                     ?>
               </div>
               <div class="form-horizontal style-form">
                  <div class="form-group">
                     <label class="col-sm-4 control-label">Service<span style="color: red;"> *</span></label>
                     <div class="col-sm-8">
                        <input type="text"  class="form-control" name="service" placeholder="Service Name">
                        <span class="text-danger"><?php echo form_error('service'); ?></span>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="col-sm-12 text-danger">
                        <label class="checkbox-inline"><input type="checkbox" value="">Same value for all locations</label>
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
                        foreach ($locations as $location) {
                            ?>
                           <div class="row padding-15" style="margin-bottom:10px;">
                              <label class="col-sm-4 control-label"><?php echo $loc = $location->location; ?></label>
                              <div class="col-sm-8">
                                 <input type="number" placeholder="Service Amount for <?php echo $loc; ?>"  class="form-control" name="location<?php echo $location->id; ?>">
                              </div>
                           </div>
                           <?php
                        }
                        ?>
                  </div>
                  <div class="form-group">
                     <div class="col-sm-12 ">
                        <input type="submit" class="btn btn-primary pull-right mr-5" value="Add Service" name="submit">
                     </div>
                  </div>
               </div>
            </div>
            </form>
         </div>
         <div class="col-lg-3"></div>
      </div>
      <div class="row mb">
         <div class="col-lg-12">
            <!-- page start-->
            <div class="content-panel" >
               <div class="adv-table">
                  <table class="table table-hover table-bordered" id="hidden-table-info">
                     <thead>
                        <tr>
                           <th class="text-center">#</th>
                           <th>Service</th>
                           <?php
                            foreach ($locations as $loc) {
                                echo "<th>$loc->location</th>";
                            } 
                           ?>
                           <th class="text-center">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           $CI =& get_instance();
                           $i =1;
                            foreach ($services as $ser){
                               $service_id = $ser->service_id;
                            ?>
                        <tr>
                           <td class="text-center"><?php echo $i; ?></td>
                           <td><?php echo $ser->service; ?></td>
                           <?php
                            foreach ($locations as $loc) {
                              $location_id = $loc->id;
                              $count = $CI->Setting_model->location_avaiable($location_id,$service_id);
                              if ($count == 1) {
                                 $amount = $CI->Setting_model->location_amount($location_id,$service_id);
                              }
                              else{
                                 $amount = 0;
                              }
                                
                              echo "<td class='text-right'>$amount.00</td>";
                            } 
                           ?>
                           <td class="text-center">
                              <a href="<?php echo base_url(); ?>Settings/deleteService/<?php echo $service_id; ?>" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                              <a href="<?php echo base_url(); ?>Settings/edit_service/<?php echo $service_id; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                           </td>
                        </tr>
                        <?php
                           $i++;
                           }
                           ?>
                     </tbody>
                  </table>
               </div>
            </div>
            <!-- page end-->
         </div>
      </div>
      <!-- /row -->
   </section>
   <!-- /wrapper -->
</section>
<!-- /MAIN CONTENT -->
<!--main content end-->
</section>