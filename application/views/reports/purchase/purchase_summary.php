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
    });

    $("#sup_id").change(function(){
       var sup_id = $(this).val();
       var fromDate = $("#fromDate").val();
       var toDate = $("#toDate").val();
       fetchdata(fromDate, toDate, sup_id);
    });

    $(document).on('change','#fromDate',function(){
       var fromDate = $(this).val();
       var toDate = $("#toDate").val();
       var sup_id = $("#sup_id").val();
       fetchdata(fromDate, toDate, sup_id);
    });

    $(document).on('change','#toDate',function(){
       var toDate = $(this).val();
       var fromDate = $("#fromDate").val();
       var sup_id = $("#sup_id").val();
       fetchdata(fromDate, toDate, sup_id);
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
  </script>