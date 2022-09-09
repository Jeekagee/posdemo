
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <h3>View summary</h3>
        <div id="delete_msg"><?php
          if ($this->session->flashdata('success')) {
            echo $this->session->flashdata('success');
          }
        ?>
        </div>
        <div class="row mb" style="padding:10px;">
          <!-- page start-->
          <div class="content-panel" >
            <div class="adv-table">
              <table class="table table-hover table-bordered" id="hidden-table-info">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Item Id</th>
                    <th>Purchase price</th>
                    <th>Method</th>
                    <th>Check date</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $i =1;
                  foreach ($view_summary as $sum){
                    ?>
                      <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $sum->created_at; ?></td>
                        <td><?php echo $sum->item_id; ?></td>
                        <td><?php echo $sum->purchase_price; ?></td>
                        <td><?php echo $sum->method; ?></td>
                        <td><?php echo $sum->check_date; ?></td>
                        <td class="text-center">
                          <?php
                              if($sum->method == "credit" && $sum->status == 0){
                             ?> 
                              <a data-toggle="modal" data-target="#pay<?php echo $sum->id; ?>" class="btn btn-primary btn-xs">Pay</a>
                            <?php 
                              }
                            ?>
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
  
  <style>
    .m-top-10{
        margin-top:10px;
    }
  </style>
  <?php
  foreach ($view_summary as $sum) {
    ?>
        <!-- Modal -->
        <div id="pay<?php echo $sum->id; ?>" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Credit Payment</h4>
                </div>
                
                  <div class="modal-body">
                    <div class="row fnt-15 m-top-10">
                      <div class="col-sm-5">
                        <label>Purchase Amount:</label>
                      </div>
                      <div class="col-sm-7">
                        <input class="form-control" type="text" name="purchase_amount" id="p_amount<?php echo $sum->id; ?>" value="<?php echo $sum->purchase_price; ?>" disabled>
                      </div>
                    </div>

                  </div>
                  <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" value="Pay" id="btn_pay<?php echo $sum->id; ?>" onclick="submitFun('<?php echo $sum->id; ?>')">
                    <!-- <input type="submit" class="btn btn-primary" value="Pay" id=""> -->
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>
              </div>

            </div>
          </div>

                  
    <?php
  }
  ?>

<script>
function submitFun(val) {
  //alert(val);
  $.ajax({
            type: 'post',
            url: '<?php echo base_url(); ?>Purchase/credit_pay',
            data: {
                'id': val,
            },
            success: function(response) {
                //alert("success");
                window.location.reload();
            }
        });
}
</script>