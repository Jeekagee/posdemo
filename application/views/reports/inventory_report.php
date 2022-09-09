
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <h3>Inventory Report</h3>
        <div id="delete_msg"><?php
          if ($this->session->flashdata('delete')) {
            echo $this->session->flashdata('delete');
          }
        ?>
        </div>
            
        <div class="row mb" style="padding:10px;">
          <!-- page start-->
          <div class="content-panel" >
            <div class="adv-table">
                <table id="example" class="display nowrap" style="width:100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th class="text-center">Item Id</th>
                    <th class="text-center">Item Name</th>
                    <th class="text-center">Total Quantity</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                 $CI =& get_instance();
                  $i =1;
                  foreach ($inventory as $inv){
                    $item_id=$inv->item_id;
                    $item_name =  $CI->Report_model->item_name($item_id);
                    ?>
                      <tr id="inv<?php echo $inv->id; ?>">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $inv->item_id; ?></td>
                        <td><?php echo $item_name->item_name; ?></td>
                        <td class="text-center"><?php echo $qty = $inv->totalqty; ?></td>
                      </tr>
                     
                    <?php
                    $i++;
                  }
                ?>
                </tbody>
              </table>
            </div>
            <script>$(document).ready(function() {
            $('#example').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                'excel'
                ]
            } );
            } );</script>
            
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
  