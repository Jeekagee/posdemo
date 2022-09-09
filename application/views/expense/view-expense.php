
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
  
</style>
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">  
        <h3>View</h3>
        <form action="<?php echo base_url(); ?>Expense/update" method="post">
        <div class="sec-container col-md-8">
            
            <div class="mb-5">
            <div id="delete_msg">
              <?php
                if ($this->session->flashdata('success')) {
                  echo $this->session->flashdata('success');
                }
              ?>
            </div>
                <h4>Ref No : <?php echo $expenses->ref_no; ?></h4>
            </div>
            <hr>
            <?php 
            $CI =& get_instance(); 
            $CI->load->model('Inventory_model');
            ?>
            <table class="table table-hover table-striped">
                <tbody style="font-size:15px;">
                <tr>
                    <td>Expense Date</td>
                    <td><?php echo $expenses->ex_date; ?></td>
                </tr>

                <tr>
                    <td>Location</td>
                    <td><?php echo $expenses->location; ?></td>
                </tr>

                <tr>
                    <td>Payee Name</td>
                    <td><?php echo $expenses->payee_name; ?></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><?php echo $expenses->description; ?></td>
                </tr>
                <tr>
                    <td>Catogery</td>
                    <td>
                        <?php 
                        $exp_catogery = $this->Expense_model->exp_catogery($expenses->catogery);
                        echo $exp_catogery->category;
                        ?>
                    </td>
                </tr>
                
                <tr>
                    <td>Payee Name</td>
                    <td><?php echo $expenses->payee_name; ?></td>
                </tr>
                <tr>
                    <td>Method</td>
                    <td><?php echo $expenses->method; ?></td>
                </tr>
                <?php
                if ($expenses->method == 'credit') {
                    ?>
                        <tr>
                            <td>Credit Date</td>
                            <td><?php echo $expenses->check_date; ?></td>
                        </tr>
                    <?php
                }
                ?>
                
                <tr>
                    <td>Amount</td>
                    <td><?php echo $expenses->amount; ?></td>
                </tr>

                <tr>
                    <td>Created</td>
                    <td>
                      <?php 
                      $create_tym = $expenses->created;
                      $sortcretym = strtotime($create_tym);

                      echo date('d/m/Y g:i A', $sortcretym);
                      ?>
                    </td>
                </tr>

                <tr>
                    <td>Updated</td>
                    <td>
                      <?php
                        $update_tym = $expenses->updated;
                        $sortuptym = strtotime($update_tym);
  
                        echo date('d/m/Y g:i A', $sortuptym);
                      ?>
                    </td>
                </tr>
                </tbody>
            </table>

            <a href="<?php echo base_url(); ?>Expense/summery" class="btn btn-primary"><i class="fa fa-back"></i> Back</a>
            <a href="<?php echo base_url(); ?>Expense/edit/<?php echo $expenses->id; ?>" class="btn btn-success"><i class="fa fa-pencil"></i> Edit</a>
        </div>
        
    </section>
</section>
    <!-- /MAIN CONTENT -->

