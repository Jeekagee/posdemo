<!-- js placed at the end of the document so the pages load faster -->
<script src="<?php echo base_url(); ?>assets/admin/lib/jquery/jquery.min.js"></script>
  <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/admin/lib/advanced-datatable/js/jquery.js"></script>
  <script src="<?php echo base_url(); ?>assets/admin/lib/bootstrap/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="<?php echo base_url(); ?>assets/admin/lib/jquery.dcjqaccordion.2.7.js"></script>
  <script src="<?php echo base_url(); ?>assets/admin/lib/jquery.scrollTo.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/admin/lib/jquery.nicescroll.js" type="text/javascript"></script>
  <script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/admin/lib/advanced-datatable/js/jquery.dataTables.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/lib/advanced-datatable/js/DT_bootstrap.js"></script>
  <!--common script for all pages-->
  <script src="<?php echo base_url(); ?>assets/admin/lib/common-scripts.js"></script>

  <script src="<?php echo base_url(); ?>assets/admin/lib/jquery-ui-1.9.2.custom.min.js"></script>
  <!--custom switch-->
  <script src="<?php echo base_url(); ?>assets/admin/lib/bootstrap-switch.js"></script>
  <!--custom tagsinput-->
  <script src="<?php echo base_url(); ?>assets/admin/lib/jquery.tagsinput.js"></script>
  <!--custom checkbox & radio-->
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/lib/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/lib/bootstrap-daterangepicker/date.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/lib/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/lib/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/admin/lib/form-component.js"></script>
  <!--script for this page-->

  
  <script type="text/javascript">
    /* Formating function for row details */
    function fnFormatDetails(oTable, nTr) {
      var aData = oTable.fnGetData(nTr);
      var sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';
      sOut += '<tr><td>Rendering engine:</td><td>' + aData[1] + ' ' + aData[4] + '</td></tr>';
      sOut += '<tr><td>Link to source:</td><td>Could provide a link here</td></tr>';
      sOut += '<tr><td>Extra info:</td><td>And any further details here (images etc)</td></tr>';
      sOut += '</table>';

      return sOut;
    }

    $(document).ready(function() {
      var oTable = $('#hidden-table-info').dataTable({
        "aoColumnDefs": [{
          "bSortable": false,
          "aTargets": [0]
        }],
      });


    });
  </script>

<script type="text/javascript">
  $(document).ready(function(){
      $("#nic").on("keyup", function(){

        $("#pname").val("");
        $("#mobile").val("");
        $("#address").val("");

        var nic = $(this).val();
        if (nic !== "") {
          $.ajax({
            url:"<?php echo base_url(); ?>Appoint/nic_search",
            type:"POST",
            cache:false,
            data:{nic:nic},
            success:function(data){
              //alert(data);
              $("#nic_list").html(data);
              $("#nic_list").fadeIn();
            }
          });
        }else{
          $("#nic_list").html("");
          $("#nic_list").fadeOut();
        }
      });

      // click one particular city name it's fill in textbox
      $(document).on("click","#nic_list li", function(){

        $('#nic').val($(this).text());
        $('#nic_list').fadeOut("fast");
        var nic = $('#nic').val();

        //$('#c_no').fadeOut("fast");

         $.ajax({
          url:"<?php echo base_url(); ?>Appoint/patient_name",
          type:"POST",
          cache:false,
          data:{nic:nic},
          success:function(data){
            $("#pname").val(data);
            //alert(data);
          }
        });

        $.ajax({
          url:"<?php echo base_url(); ?>Appoint/patient_mobile",
          type:"POST",
          cache:false,
          data:{nic:nic},
          success:function(data){
            $("#mobile").val(data);
            //alert(data);
          }
        });

        $.ajax({
          url:"<?php echo base_url(); ?>Appoint/patient_address",
          type:"POST",
          cache:false,
          data:{nic:nic},
          success:function(data){
            $("#address").val(data);
            //alert(data);
          }
        });
      });
  });
</script>

<script type="text/javascript">
  $(document).ready(function(){
      // click one particular city name it's fill in textbox
      $(document).on("click","#vehicle_no_list li", function(){

        $('#vehicle_no').val($(this).text());
        $('#vehicle_no_list').fadeOut("fast");
        var v_no = $('#vehicle_no').val();

        //$('#c_no').fadeOut("fast");

         $.ajax({
          url:"<?php echo base_url(); ?>Orders/contact_no",
          type:"POST",
          cache:false,
          data:{v_no:v_no},
          success:function(data){
            $("#contact_no").val(data);
            //alert(data);
          }
        });

        $.ajax({
          url:"<?php echo base_url(); ?>Orders/customername",
          type:"POST",
          cache:false,
          data:{v_no:v_no},
          success:function(data){
            $("#customer_name").val(data);
            //alert(data);
          }
        });
      });
  });
</script>

<script type="text/javascript">
// Load doctors  and brand for special
    $(document).ready(function(){
      $("#area").change(function(){
        var area = $(this).val();
        $.ajax({
          url:"<?php echo base_url(); ?>Appoint/doctors",
          type:"POST",
          cache:false,
          data:{area:area},
          success:function(data){
            //alert(data);
            $("#doctor").html(data);
          }
        });
      });

      $("#doctor").change(function(){
        var doctor = $(this).val();
        $.ajax({
          url:"<?php echo base_url(); ?>Appoint/doctors_charge",
          type:"POST",
          cache:false,
          data:{doctor:doctor},
          success:function(data){
            //alert(data);
            $("#dcharge").val(data);
          }
        });
      });  
    });

    // Price for Service
    $(document).ready(function(){
      $("#add_other").click(function(){
        var other = $("#other").val();
        var amount = $("#amount").val();
        var invoice_no = $("#invoice_no").val();

        if (other == "" || amount == "") {
          $("#other_error").html("Please fill both");
        }
        else{
          $("#other_error").html("");
          $.ajax({
            url:"<?php echo base_url(); ?>Appoint/Add_Other",
            type:"POST",
            cache:false,
            data:{other:other,amount:amount,invoice_no:invoice_no},
            success:function(data){
              //alert(data);
              $("#other_tbl").html(data);
              $('#other').val("");
              $('#amount').val("");
            }
          });
        }
        
      }); 
    });

    $(document).ready(function(){
          var invoice_no = $("#invoice_no").val();
          $.ajax({
            url:"<?php echo base_url(); ?>Appoint/view_other",
            type:"POST",
            cache:false,
            data:{invoice_no:invoice_no},
            success:function(data){
              //alert(data);
              $("#other_tbl").html(data);
              $('#other').val("");
              $('#amount').val("");
            }
          });
    }); 

    // Price for Service
    $(document).ready(function(){
      $("#add_order_item").click(function(){
        var order_no = $("#order_no").val();
        var p_id = $("#p_id").val();
        alert(p_id)
          /*$.ajax({
            url:"<?php echo base_url(); ?>Orders/insert_order_item", //803
            type:"POST",
            cache:false,
            data:{bill_no:bill_no},
            success:function(data){
              //alert(data);
              $("#service_tbl").html(data);
              $('#service').val("");
              $('#submit_btn').show();
            }
          });*/
      }); 
    });
  </script>
</body>

</html>
