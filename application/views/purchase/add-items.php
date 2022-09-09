
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
        <h3>Add New Purchase</h3>

        <div class="sec-container">
            <div class="mb-5">
                <h4>Add Items</h4>
            </div>
            <hr>

            <div class="row">
                <div class="col-md-2">
                    <p>Supplier :</p>
                </div>
                <div class="col-md-2">
                    <p><?php echo $suppliers->supplier;?></p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <p>Receieve Date :</p>
                </div>
                <div class="col-md-2">
                    <p><?php echo $suppliers->rec_date;?></p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <p>Location :</p>
                </div>
                <div class="col-md-2">
                    <p><?php echo $suppliers->location;?></p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <p>Ref No :</p>
                </div>
                <div class="col-md-2">
                    <p><?php echo $suppliers->ref_no;?></p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-2">
                    <p>Method :</p>
                </div>
                <div class="col-md-2">
                    <p><?php echo $suppliers->method;?></p>
                </div>
            </div>

            <?php
            if ($suppliers->method == "credit") {
                ?>
                    <div class="row">
                        <div class="col-md-2">
                            <p>Cheque Date :</p>
                        </div>
                        <div class="col-md-2">
                            <p><?php echo $suppliers->check_date;?></p>
                        </div>
                    </div>
                <?php
            }
            
            ?>

            

            <div style="margin-top:35px;">
                <div style="width:80%; padding:10px; background-color:#f2f2f2; margin:auto">
                    <div id="validation">

                    </div>
                    <input type="text" id="purchase_id" value="<?php echo $suppliers->id;?>" hidden>
                    <div class="row">
                        <div class="col-md-4">
                            <div style="padding:10px;">
                                <div class="form-group">
                                    <label for="">Item ID</label>
                                    <input type="text" class="form-control" name="item" id="item"/>
                                    <div id="item_list"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div style="padding:10px;">
                                <div class="form-group">
                                    <label for="">Item Name</label>
                                    <input disabled type="text" class="form-control" name="itm_name" id="itm_name"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div style="padding:10px;">
                                <div class="form-group">
                                    <label for="">Purchase Price</label>
                                    <input type="text" class="form-control" name="p_price" id="p_price"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div style="padding:10px;">
                                <div class="form-group">
                                    <label for="">Selling Price</label>
                                    <input type="text" class="form-control" name="s_price" id="s_price"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div style="padding:10px;">
                                <div class="form-group">
                                    <label for="">Quantity</label>
                                    <input type="text" class="form-control" name="qty" id="qty"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div style="padding:10px;">
                                <div class="form-group">
                                    <label for="">Expiry Date</label>
                                    <input type="date" class="form-control" name="ex_date" id="ex_date"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <button class="btn btn btn-block btn-success" onclick="insert()">Add Items</button>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn btn-block" onclick="clear()">Clear</button>
                        </div>
                    </div>

                    <div style="margin-top:10px;" id="show_itmes">
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
    <!-- /MAIN CONTENT -->

