
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <h3>Expenses</h3>
        <div id="delete_msg"><?php
          if ($this->session->flashdata('success')) {
            echo $this->session->flashdata('success');
          }
        ?>
        </div>
            <div style="margin-bottom: 10px;" >
                <a href="<?php echo base_url(); ?>Expense/AddExpenses" class="btn btn-success"><i class="fa fa-plus"></i> Add New</a>
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
                    <th>Payee</th>
                    <th>Ref ID</th>
                    <th>Method</th>
                    <th>Amount</th>
                    <th class="text-center">Action</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                  $i =1;
                  foreach ($expenses as $expense){
                    ?>
                      <tr id="exp<?php echo $expense->id; ?>">
                        <td><?php echo $i; ?></td>
                        <td><?php echo $expense->ex_date; ?></td>
                        <td><?php echo $expense->payee_name; ?></td>
                        <td><?php echo $expense->ref_no; ?></td>
                        <td><?php echo $expense->method; ?></td>
                        <td><?php echo $expense->amount; ?></td>
                        <td class="text-center">
                          <a href="<?php echo base_url(); ?>Expense/view/<?php echo $expense->id; ?>" class="btn btn-success btn-xs"><i class="fa fa-eye"></i></a>
                          <a href="<?php echo base_url(); ?>Expense/edit/<?php echo $expense->id; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                          <a id="<?php echo $expense->id; ?>" class="btn btn-danger btn-xs delete_exp"><i class="fa fa-trash"></i></a>
                          <?php
                           /* $CI =& get_instance();
                            $bill_available = $CI->Orders_model->bill_status($order_id);
                            if ($bill_available == 1) {
                              ?>
                                <a href="<?php echo base_url(); ?>Orders/confirm_bill/<?php echo $order_id; ?>" class="btn btn-info btn-xs"><i class="fa fa-print"></i></a>
                              <?php
                            }
                            if ($bill_available == 0){
                              ?>
                                <a href="<?php echo base_url(); ?>Orders/Print/<?php echo $order_id; ?>" class="btn btn-warning btn-xs"><i class="fa fa-print"></i></a>
                              <?php
                            }*/
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
  