<style>
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 120px; /* Location of the box */
  left: 0;
  top: 0;
  width: 90%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  margin-left:5%;
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}
</style>
    <!--sidebar end-->
    <!-- **********************************************************************************************************************************************************
        MAIN CONTENT
        *********************************************************************************************************************************************************** -->
    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <h3>Supplier wise Purchase Report</h3>
        <div id="delete_msg"><?php
          if ($this->session->flashdata('delete')) {
            echo $this->session->flashdata('delete');
          }
        ?>
        </div>
        <div class="row">
          <div class="m-b-10 col-sm-3">
              <label for="date">Supplier:</label>
              <select class="form-control" id="sup_id" name="sup_id">
                <option value="0">Select Supplier</option>
                <?php
                    foreach($suppliers as $sup)
                    {
                ?>
                    <option value="<?php echo $sup->id; ?>"><?php echo $sup->supplier; ?></option>
                <?php
                    }
                ?>
              </select>
          </div>
          <div class="m-b-10 col-sm-3">
              <label for="date">From:</label>
              <input class="form-control" type="date" name="date" placeholder="Date" id="fromDate"
                  value="<?php echo $fromDate; ?>">
          </div>
          <div class="m-b-10 col-sm-3">
              <label for="date">To:</label>
              <input class="form-control" type="date" name="date" placeholder="Date" id="toDate"
                  value="<?php echo $toDate; ?>">
          </div>
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
                  <th>Ref No</th>
                  <th>Item</th>
                  <th class="text-center">Quantity</th>
                  <th class="text-right">Purchase Price</th>
                  <th class="text-right">Selling Price</th>
                  <th class="text-right">Total Cost</th>
                </tr>
              </thead>
              <tbody class="table_body">
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
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    $("#sup_id").change(function(){
       var sup_id = $(this).val();
       var fromDate = $("#fromDate").val();
       var toDate = $("#toDate").val();
       fetchdata(sup_id, fromDate, toDate);
    });

    $(document).on('change','#fromDate',function(){
       var fromDate = $(this).val();
       var sup_id = $("#sup_id").val();
       var toDate = $("#toDate").val();
       fetchdata(sup_id, fromDate, toDate);
    });

    $(document).on('change','#toDate',function(){
       var toDate = $(this).val();
       var fromDate = $("#fromDate").val();
       var sup_id = $("#sup_id").val();
       fetchdata(sup_id, fromDate, toDate);
    });

    function fetchdata(sup_id, fromDate, toDate)
    {
      $.ajax({
        url:"<?php echo base_url(); ?>Report/LoadSupplierPurchase",
        type:"POST",
        data:{sup_id:sup_id, fromDate:fromDate, toDate:toDate},
        success:function(data){
          $(".table_body").html(data);
        }
      });
    }
  </script>