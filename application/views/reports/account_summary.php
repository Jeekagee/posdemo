
  <!-- <style>
         table, th, td {
            border: 1px solid black;
         }
      </style> -->
  
      <link  rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<?php $CI =& get_instance(); ?>
<section id="main-content">
    <section class="wrapper">
        <div class="row mt">
            <div class="col-lg-8" >
                <div class="form-panel">
                  <form action="ProfitReport" method="POST">
                    <h4 class="mb" style="font-weight: bold; padding-left: 2%;">ACCOUNT SUMMARY REPORT</h4>
                  </form> 
                    <div class="row mb" style="padding:10px;">
                      <!-- page start-->
                      <div class="content-panel" style="padding-left: 5px; padding-right: 5px;">
                        <div class="adv-table">
                          
                          <table id="example" class="display nowrap" style="width:100%">
                            <thead>
                            <tr>
                              <th>Details</th>
                              <th style="text-align:right;">Amount<th>
                              <th style="text-align:right;">As at<th>
                            </tr>
                            </thead>
                              <tbody>
                                  <tr>
                                    <td style="font-weight: bold;">Opening balance</td>
                                    <td style="text-align:right; font-weight: bold;"><?php echo $opening_balance; ?>.00<td>
                                    <td style="text-align:right;"><?php echo $obalance_date; ?><td>
                                  </tr>
                                  <tr>
                                    <td>Total Sales</td>
                                    <td style="text-align:right;"><?php echo $account_sales; ?>.00<td>
                                    <td style="text-align:right;"><?php $date = date('Y-m-d h:i:s'); 
                                                                        echo $date; ?><td>
                                  </tr>
                                  <tr>
                                    <td>Total Sales Return</td>
                                    <td style="text-align:right;">(0.00)<td>
                                    <td style="text-align:right;"><?php $date = date('Y-m-d h:i:s'); 
                                                                        echo $date; ?><td>
                                  </tr>
                                  <tr>
                                    <td>Total Expenses</td>
                                    <td style="text-align:right;">(<?php echo $account_expense; ?>.00)<td>
                                    <td style="text-align:right;"><?php $date = date('Y-m-d h:i:s'); 
                                                                        echo $date; ?><td>
                                  </tr>
                                  <tr>
                                    <td>Total Purchase</td>
                                    <td style="text-align:right;">(<?php echo $account_purchase; ?>.00)<td>
                                    <td style="text-align:right;"><?php $date = date('Y-m-d h:i:s'); 
                                                                        echo $date; ?><td>
                                  </tr>
                                  <tr>
                                    <td>Total Purchase Return</td>
                                    <td style="text-align:right;">.00<td>
                                    <td style="text-align:right;"><?php $date = date('Y-m-d h:i:s'); 
                                                                        echo $date; ?><td>
                                  </tr>
                                  <tr>
                                    <td style="font-weight: bold;">Closing Balance</td>
                                    <td style="text-align:right; font-weight: bold;"><?php echo $opening_balance+$account_sales-$account_expense-$account_purchase; ?>.00<td>
                                    <td style="text-align:right;"><?php $date = date('Y-m-d h:i:s'); 
                                                                        echo $date; ?><td>
                                  </tr>
                              </tbody>
                          </table> 
                        </div>
                           
                                      
                      </div>
                          <!-- page end-->
                    </div>

                      
                </div>
                       
            </div>
                
        </div>
       
        
    </section>
</section>


<script>
$(document).ready(function() {
  $('#example').DataTable( {
      dom: 'Bfrtip',
      'ordering':false,
      buttons: [
      'pdf'
      ]
  });
});
</script>
