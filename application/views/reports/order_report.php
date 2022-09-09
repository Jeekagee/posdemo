

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

  .report-cart{
    font-size:30px;
    padding:50px 0px 50px 0px; 
    color:white;
    font-weight:900;
    border-radius: 18px;
    transition: box-shadow .3s;
  }

  .report-cart:hover {
  box-shadow: 0 0 11px rgba(33,33,33,.2); 
    }

</style>
<!--main content start-->

    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <h3>Orders</h3>
        <div id="delete_msg"><?php
          if ($this->session->flashdata('ordermsg')) {
            echo $this->session->flashdata('ordermsg');
          }
        ?>
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
                    <th>Ivoice ID</th>
                    <th>Total</th>
                    <th>Discount</th>
                    <th>Payment</th>
                    <th class="text-right">Net Amount</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $CI =& get_instance();
                  $i =1;
                  foreach ($order_report as $order){
                    ?>
                      <tr>
                        <td class="text-center"><?php echo $i; ?></td>
                        <td ><?php echo $order->bill_no; ?></td>
                        <td class="text-right"><?php echo $total = $order->total; ?>.00</td>
                        <td class="text-right"><?php echo $discount = $order->discount; ?>.00</td>
                        <td class="text-right"><?php echo $order->payment; ?>.00</td>
                        
                      
                        <td class="text-right"><?php echo $total-$discount; ?>.00</td>
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
  
    <!-- /MAIN CONTENT -->

