

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
    font-size:14px;
    padding:50px 0px 50px 0px; 
    color:black;
    font-weight:300;
    border-radius: 18px;
    transition: box-shadow .3s;
    margin-bottom: 20px;
    border: 1px solid #20c11e;
  }

  .report-cart:hover {
  box-shadow: 0 0 11px rgba(33,33,33,.2); 
    }

</style>
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">  
        <h3>Reports</h3>

        <div class="sec-container">
            <div class="row">
            <div class="col-md-4">
                <a href="<?php echo base_url(); ?>Report/ViewpurchaseReports">
                        <div class="text-center report-cart" style="background-color:white;">
                            PURCHASE
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="<?php echo base_url(); ?>Report/ExpenseReport">
                    <div class="text-center report-cart" style="background-color:white;">
                        EXPENSE
                    </div>
                </div>
                <div class="col-md-4">
                    <a href="<?php echo base_url(); ?>Report/ViewsupplierReports">
                    <div class="text-center report-cart" style="background-color:white;">
                        SUPPLIER
                    </div>
                </div>
                <div class="col-md-4">
                    <a href="<?php echo base_url(); ?>Report/ViewsaleReports">
                    <div class="text-center report-cart" style="background-color:white;">
                        SALES
                    </div>
                </div>
                <div class="col-md-4">
                    <a href="<?php echo base_url(); ?>Report/ProfitReport">
                    <div class="text-center report-cart" style="background-color:white;">
                        PROFIT&LOST
                    </div>
                </div>
                <div class="col-md-4">
                    <a href="<?php echo base_url(); ?>Report/AccountReport">
                    <div class="text-center report-cart" style="background-color:white;">
                        ACCOUNTS
                    </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
</section>
    <!-- /MAIN CONTENT -->

