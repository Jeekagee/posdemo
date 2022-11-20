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
        <h3>Purchase Summary Report</h3>
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

      <style>
        .small-box {
              border-radius: 5px;
              box-shadow: 0 0 1px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.2);
              display: block;
              margin-bottom: 20px;
              position: relative;
          }

          .small-box > .inner {
              padding: 10px;
          }

          .col-lg-3 .small-box h3, .col-md-3 .small-box h3, .col-xl-3 .small-box h3 {
              font-size: 25px;
          }

          .small-box h3 {
              font-size: 25px;
              font-weight: 700;
              margin-top: 10px;
              padding: 0;
              white-space: nowrap;
          }


          .small-box p {
              font-size: 18px;
          }
          p {
              margin-top: 0;
              margin-bottom: 10px;
          }
          *, ::after, ::before {
              box-sizing: border-box;
          }
          .small-box > .small-box-footer {
              background-color: rgba(0,0,0,.1);
              color: rgba(255,255,255,.8);
              display: block;
              padding: 3px 0;
              position: relative;
              text-align: center;
              text-decoration: none;
              z-index: 10;
          }
          .small-box .icon {
              color: rgba(0,0,0,.15);
              z-index: 0;
          }

          .bg-info, .bg-info > a {
              color: #5d5a95 !important;
          }
          .bg-info {
              background-color: white !important;
              border: 1px solid #4aa2bd;
              margin-top: 20px;
              
          }.fa-2x {
            font-size: 2em;
            padding-right: 10px;
          }

          .bg-success, .bg-success > a {
              color: #fff !important;
          }
          .bg-success {
              background-color: #28a745 !important;
          }
    </style>

        <div class="row">
            <div class="col-lg-5 col-12">
              <!-- small box -->
              <div class="small-box bg-info" style="margin-left: 30%;">
                <div class="inner">
                  <h3 style="font-size:18px;"><i class="fa fa-shopping-cart fa-1.5x" aria-hidden="true">&nbsp;</i>Total Purchase
                  <p id="tot_purchase" style="padding-top:10px;"></p></h3>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-5 col-12">
              <!-- small box -->
              <div class="small-box bg-info" style="margin-right: 30%;">
                <div class="inner">
                  <h3 style="font-size:18px;"><i class="fa fa-dollar fa-1x">&nbsp;</i>No of Purchase
                  <p id="no_of_purchase" style="padding-top:10px;"></p></h3>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
        <!-- /.row -->
        </div>

        <div class="row mb" style="padding:10px;">
          <!-- page start-->
          <div class="content-panel" >
            <div class="adv-table"></div>
            <div id="myModal" class="modal">
              <div class="modal-content"></div>
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
    $(document).ready(function(){
     var sup_id = $(this).val();
     var dateObj = new Date();
     var month = dateObj.getUTCMonth() + 1; //months from 1-12
     var day = dateObj.getUTCDate();
     var year = dateObj.getUTCFullYear();
     selDate = year + "-" + month + "-" + day;
     fetchdata(selDate, selDate, sup_id);
     get_total_purchase(selDate, selDate, sup_id);
     get_purchase_count(selDate, selDate, sup_id);
    });

    $("#sup_id").change(function(){
       var sup_id = $(this).val();
       var fromDate = $("#fromDate").val();
       var toDate = $("#toDate").val();
       fetchdata(fromDate, toDate, sup_id);
       get_total_purchase(fromDate, toDate, sup_id);
       get_purchase_count(fromDate, toDate, sup_id);
    });

    $(document).on('change','#fromDate',function(){
       var fromDate = $(this).val();
       var toDate = $("#toDate").val();
       var sup_id = $("#sup_id").val();
       fetchdata(fromDate, toDate, sup_id);
       get_total_purchase(fromDate, toDate, sup_id);
       get_purchase_count(fromDate, toDate, sup_id);
    });

    $(document).on('change','#toDate',function(){
       var toDate = $(this).val();
       var fromDate = $("#fromDate").val();
       var sup_id = $("#sup_id").val();
       fetchdata(fromDate, toDate, sup_id);
       get_total_purchase(fromDate, toDate, sup_id);
       get_purchase_count(fromDate, toDate, sup_id);
    });

    function fetchdata(fromDate, toDate, sup_id)
    {
      $.ajax({
        url:"<?php echo base_url(); ?>Report/LoadPurchaseSummary",
        type:"POST",
        data:{fromDate:fromDate, toDate:toDate, sup_id:sup_id},
        success:function(data){
          $(".adv-table").html(data);
        }
      });
    }

    var modal = document.getElementById("myModal");
      window.onclick = function(event) {
        if (event.target == modal) {
          modal.style.display = "none";
        }
      }

      function viewDetails(id) {
        $.ajax({
          url:"<?php echo base_url(); ?>Report/PurchaseItems",
          type:"POST",
          data:{id:id},
          success:function(data){
            $(".modal-content").html(data);
            modal.style.display = "block";
          }
        });
      }

    function get_total_purchase(fromDate, toDate)
    {
      $.ajax({
        url:"<?php echo base_url(); ?>Report/LoadTotalPurchase",
        type:"POST",
        data:{fromDate:fromDate, toDate:toDate},
        success:function(data){
          //alert(data);
          $("#tot_purchase").html(data);
        }
      });
    }
    function get_purchase_count(fromDate, toDate)
    {
      $.ajax({
        url:"<?php echo base_url(); ?>Report/LoadpurchaseCount",
        type:"POST",
        data:{fromDate:fromDate, toDate:toDate},
        success:function(data){
          //alert(data);
          $("#no_of_purchase").html(data);
        }
      });
    }
  </script>