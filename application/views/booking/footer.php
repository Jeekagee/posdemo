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
      setTimeout(function() {
        $("#delete_msg").hide('blind', {}, 500)
    }, 5000);
    });

    function confirm_cancel(id){
      var r = confirm("Confirm to cancel the booking");
      if (r == true) {
        window.location.href = "<?php echo base_url(); ?>Booking/cancel/";
      }
    }

    function cancel_confirmed(id){
      var r = confirm("Confirm to cancel the booking");
      if (r == true) {
        window.location.href = "<?php echo base_url(); ?>Booking/cancel_confirm/"+id;
      }
    }

    //Update Modal Show date and time
    $(document).ready(function(){
      $(document).on('click','a[data-role=update]',function(){
        var item_id = $(this).data('id');
        var book_date = $("#date_"+item_id).eq(0).text().replace(/\s+/g,'');
        var book_time = $("#time_"+item_id).eq(0).text().replace(/\s+/g,'');
        
        //alert(stock);
        $("#book_date").val(book_date);
        $("#book_time").val(book_time);
        $("#book_id").val(item_id);
      });
    });

    //Update date and time of booking
    $(document).ready(function(){
      $("#update").click(function(){

        var book_date = $("#book_date").val();
        var book_time = $("#book_time").val();
        var book_id = $("#book_id").val();

        $.ajax({
          url:"<?php echo base_url(); ?>Booking/update",
          type:"POST",
          cache:false,
          data:{book_date:book_date, book_time:book_time, book_id:book_id},
          success:function(data){
            //alert(data);
            window.location.reload(false); 
          }
        });
      });
    });
    
</script>

</body>

</html>
