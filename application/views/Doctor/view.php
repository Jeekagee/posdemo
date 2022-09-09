
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <h3>Orders</h3>
        <div id="delete_msg"><?php
          if ($this->session->flashdata('delete')) {
            echo $this->session->flashdata('delete');
          }
        ?>
        </div>
            <div style="margin-bottom: 10px;" >
                <a href="<?php echo base_url(); ?>Doctor/Add" class="btn btn-success"><i class="fa fa-plus"></i> Add New</a>
            </div>
            <div style="margin-bottom: 10px;" >
                
            </div>
        <div class="row mb" style="padding:10px;">
          <!-- page start-->
          <div class="content-panel" >
            <div class="adv-table">
              <table class="table table-hover table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>specialization</th>
                    <th>Fees</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $CI =& get_instance();
                  $i =1;
                  foreach ($doctors as $doc){
                    ?>
                      <tr>
                        <td class="text-center"><?php echo $i; ?></td>
                        <td ><?php echo $doc->name; ?></td>
                        <td class="text-left"><?php echo $doc->mobile; ?></td>
                        <td class="text-left">
                            <?php 
                                $spl_id = $doc->specialization; 
                                echo $CI->Doctor_model->specialization_name($spl_id);
                            ?>
                        </td>
                        <td class="text-right"><?php echo $doc->charge; ?>.00</td>
                        
                        <td class="text-center">
                          <a href="" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>
                          <a href="" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
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
        <!-- /row -->
      </section>
      <!-- /wrapper -->
    </section>
    <!-- /MAIN CONTENT -->
    <!--main content end-->
  </section>
  