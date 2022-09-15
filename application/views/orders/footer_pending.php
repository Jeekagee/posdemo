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
  $(document).ready(function(){
      
      $("#search_item").on("keyup", function(){
        var search_text = $(this).val();
        var order_id = <?php echo $order_id; ?>;

        if (isNaN(search_text)) { // Search text
          $.ajax({
            url:"<?php echo base_url(); ?>Orders/pending_item_search", //756
            type:"POST",
            cache:false,
            data:{search_txt:search_text, order_id:order_id},
            success:function(data){
              //alert(data);
              $("#items").html(data);
              $("#items").fadeIn();
            }
          });
        }
        else{ // Search number
          if (search_text == "") {
              $.ajax({
              url:"<?php echo base_url(); ?>Orders/pending_item_search", //756
              type:"POST",
              cache:false,
              data:{search_txt:search_text, order_id:order_id},
              success:function(data){
                //alert(data);
                $("#items").html(data);
                $("#items").fadeIn();
              }
              });
          }
        }
        
      });


      $("#p_amount").on("keyup", function(){
        var p_amount = $(this).val();
        var t_amount = $("#t_amount").val();

        var balance = p_amount - t_amount;
        $("#balance").val(balance);

        if (balance >= 0){
          $("#btn_pay").removeAttr("disabled");
          $("#balance").css("border", "2px solid green");
        }
        else{
          $("#btn_pay").prop("disabled",true);
          $("#balance").css("border", "2px solid red");
        }
      });


  });
</script>


</body>

</html>
