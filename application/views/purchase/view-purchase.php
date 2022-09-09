

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
                <h4>Purchase Item</h4>
            </div>
            <hr>
            <?php 
            $CI =& get_instance(); 
            $CI->load->model('Purchase_model');
            $purchase_id = $purchase_item->purchase_id;
            $purchase_data = $CI->Purchase_model->purchase_data($purchase_id); //84
            ?>
           <div class="table-responsive">
            <table class="table table-hover table-striped" style="font-size:16px;">
                <tbody>
                <tr>
                    <td>Purchase Date</td>
                    <td><?php echo $purchase_data->rec_date; ?></td>
                </tr>

                <tr>
                    <td>Location</td>
                    <td><?php echo $purchase_data->location; ?></td>
                </tr>

                <tr>
                    <td>Notes</td>
                    <td><?php echo $purchase_data->notes; ?></td>
                </tr>
                <tr>
                    <td>Ref_No</td>
                    <td><?php echo $purchase_data->ref_no; ?></td>
                </tr>
                <tr>
                    <td>Item</td>
                    <td><?php echo $purchase_item->item_id; ?></td>
                </tr>
                <tr>
                    <td>Purchase Price</td>
                    <td>LKR <?php echo $price = $purchase_item->purchase_price; ?>.00</td>
                </tr>

                <tr>
                    <td>Selling Price</td>
                    <td>LKR <?php echo $purchase_item->selling_price; ?>.00</td>
                </tr>

                <tr>
                    <td>Quantity</td>
                    <td><?php echo $purchase_item->quantity; ?></td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td>LKR <?php echo $price*$purchase_item->quantity; ?>.00</td>
                </tr>
                </tbody>
            </table>
           </div>

            <a href="<?php echo base_url(); ?>Purchase/summery" class="btn btn-primary">Back</a>
        </div>
        
    </section>
</section>
    <!-- /MAIN CONTENT -->

