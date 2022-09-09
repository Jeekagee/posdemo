
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
                    <h4 class="mb" style="font-weight: bold; padding-left: 2%;">PROFIT & LOST REPORT</h4>
                    <label class="text-right" style="padding-left: 10%;">From Date 
                      <input type="date" name="from_date" id="from_date" value="" class=""></label>
                    <label class="text-right" style="padding-left: 12%;">To Date 
                      <input type="date" name="to_date" id="to_date" value="" class=""></label>
                    <label style="padding-left: 2%;"></label>

                      <input class= "btn btn-primary" type="submit" name="submit" value="filter">
                  </form> 
                    <div class="row mb" style="padding:10px;">
                      <!-- page start-->
                      <div class="content-panel" >
                        <div class="adv-table">
                          
                          <table id="example" class="display nowrap" style="width:100%">
                            <thead>
                            <tr>
                              <th>Profit/Lost</th>
                              <th style="text-align:right;">Amount<th>
                            </tr>
                            </thead>
                              <tbody>
                                  <tr>
                                    <td>Total Sales</td>
                                    <td style="text-align:right;"><?php echo $total_sales; ?>.00<td>
                                  </tr>
                                  <tr>
                                    <td>Total Sales Return</td>
                                    <td style="text-align:right;">(0.00)<td>
                                  </tr>
                                  <tr>
                                    <td>Total COG</td>
                                    <td style="text-align:right;">(<?php echo $total_cog; ?>.00)<td>
                                  </tr>
                                  <tr>
                                    <td>Revenue</td>
                                    <td style="text-align:right;"><?php echo $total_sales-$total_cog; ?>.00<td>
                                  </tr>
                                  <tr>
                                    <td>Total Expenses</td>
                                    <td style="text-align:right;">(<?php echo $total_expense; ?>.00)<td>
                                  </tr>
                                  <tr>
                                    <td>Net Profit</td>
                                    <td style="text-align:right; font-weight: bold;"><?php echo $total_sales-$total_cog; ?>.00<td>
                                  </tr>
                              </tbody>
                          </table> 
                        </div>
                           
                                      
                      </div>
                          <!-- page end-->
                    </div>
                  

                    <!-- <div class="columns download">
                    <p>
                      <a href="downloadpdf" class="btn btn-success button" download><i class="fa fa-download"></i>Download</a>
                    </p>
                   </div> -->
                      
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
