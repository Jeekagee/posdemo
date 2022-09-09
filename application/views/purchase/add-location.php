
<section id="main-content">
    <section class="wrapper">
        <h3> Add New Location</h3>
        <div class="row mt">
            <div class="col-lg-6" >
                <?php echo form_open('Purchase/insertLocation'); ?>
                    <div class="form-panel">
                        <h4 class="mb">Location</h4>
                        <div class="form-horizontal style-form">

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Location Name <span style="color: red;"> *</span></label>
                            <div class="col-sm-8">
                            <input type="text" class="form-control" value="<?php echo set_value('location'); ?>" name="location" id="supplier">
                            <span class="text-danger"><?php echo form_error('location'); ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12 ">
                            <input type="submit" class="btn btn-primary pull-right mr-5" value="Add Location" name="submit">
                            <a style="margin-right: 15px;" href="<?php echo base_url(); ?>Purchase/AddNew" class="pull-right btn btn-danger">Cancel</a>
                            </div>
                        </div>

                        </div>

                        
                    </div>
                </form>
                
            </div>
        </div>
        <div class="content-panel" style="padding:20px 20px 2px 20px;">
                <div class="adv-table">
              <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Location ID</th>
                    <th>Location Name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $i =1;
                  foreach ($location as $location){
                    ?>
                      <tr class="gradeX">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $location->id; ?></td>
                        <td><?php echo $location->location; ?></td>
                        <td class="text-center">
                         <a href="<?php echo base_url(); ?>Purchase/edit/<?php echo $location->id; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                         
                          
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
    </section>
</section>