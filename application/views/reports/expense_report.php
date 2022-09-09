
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <h3>Expense Report</h3>
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
                <table id="example" class="display nowrap" style="width:100%">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Payee</th>
                    <th>Description</th>
                    <th>Payment Method</th>
                    <th>Amount</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $i =1;
                  foreach ($expense_report as $expense){
                    ?>
                      <tr id="exp<?php echo $expense->id; ?>">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $expense->ex_date; ?></td>
                        <td><?php echo $expense->location; ?></td>
                        <td><?php echo $expense->payee_name; ?></td>
                        <td><?php echo $expense->description; ?></td>
                        <td><?php echo $expense->method; ?></td>
                        <td><?php echo $expense->amount; ?></td>
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
  