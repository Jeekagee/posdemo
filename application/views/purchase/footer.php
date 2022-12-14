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
      $("#item").on("keyup", function(){
        var item = $(this).val();
        if (item !== "") {
          $.ajax({
            url:"<?php echo base_url(); ?>Purchase/item_search",
            type:"POST",
            cache:false,
            data:{item:item},
            success:function(data){
              //alert(data);
              $("#item_list").html(data);
              $("#item_list").fadeIn();
            }
          });
        }else{
          $("#item_list").html("");
          $("#item_list").fadeOut();
        }
      });

      // click one particular city name it's fill in textbox
      $(document).on("click","#item_list li", function(){

        $('#item').val($(this).text());
        $('#item_list').fadeOut("fast");
        var item_id = $('#item').val();

        //$('#c_no').fadeOut("fast");

        $.ajax({
          url:"<?php echo base_url(); ?>Purchase/item_name",
          type:"POST",
          cache:false,
          data:{item_id:item_id},
          success:function(data){
            $("#itm_name").val(data);
            //alert(data);
          }
        });
      });

      $("#item").on("keyup", function(){
          var item = $(this).val();
          $.ajax({
            url:"<?php echo base_url(); ?>Purchase/item_name_fill",
            type:"POST",
            cache:false,
            data:{item_id:item},
            success:function(data){
              $("#itm_name").val(data);
              //alert(data);
            }
          });
      });
  });
</script>

<script type="text/javascript">
    $(document).ready(function(){
      setTimeout(function() {
        $("#delete_msg").hide('blind', {}, 500)
    }, 3000);
    $("#item").focus();
    });

</script>

<script type="text/javascript">
// Load sub cat  and brand for Catogery
    $(document).ready(function(){
      $("#ex_catogery").change(function(){
        var catogery = $(this).val();
        $.ajax({
          url:"<?php echo base_url(); ?>Inventory/show_sub_cat",
          type:"POST",
          cache:false,
          data:{catogery:catogery},
          success:function(data){
            //alert(data);
            $("#ex_sub_catogery").html(data);
          }
        });
      }); 
    });

    function insert(){
        var item = $("#item").val();
        var quantity = $("#qty").val();
        var purchase_id = $("#purchase_id").val();
        var s_price = $("#s_price").val();
        var p_price = $("#p_price").val();
        var ex_date = $("#ex_date").val();

        if (item == "" ||  quantity == "" || s_price == "" || p_price == "") {
            $("#validation").html("<div class='alert alert-warning'>Fill Required Feilds</div>");
        }
        else{
            $.ajax({
                url:"<?php echo base_url(); ?>Purchase/insert_items",
                type:"POST",
                cache:false,
                data:{item:item,quantity:quantity,purchase_id:purchase_id,s_price:s_price,p_price:p_price,ex_date:ex_date},
                success:function(data){
                    //alert(data);
                    $("#show_itmes").html(data);
                    $("#item").val("");
                    $("#price").val("");
                    $("#quantity").val("");
                }
            });
        }

    }

    $(document).ready(function(){
      var purchase_id = $("#purchase_id").val();
      $.ajax({
          url:"<?php echo base_url(); ?>Purchase/show_purchase_items",
          type:"POST",
          cache:false,
          data:{purchase_id:purchase_id},
          success:function(data){
              //alert(data);
              $("#show_itmes").html(data);
              $("#item").val("");
              $("#price").val("");
              $("#quantity").val("");
          }
      });
    });

    function clear(){
        $("#item").val("");
        $("#price").val("");
        $("#quantity").val("");
        $("#check_date").val("");
    }

    $(document).ready(function(){
      $("#method").change(function(){
        var method = $(this).val();
        if (method == "credit") {
          $("#check_date").show();
        }
        else{
          $("#check_date").hide();
        }
      }); 

      $("#ref_no").change(function(){
        var ref_no = $(this).val();

        //alert(invoice_no);
        $.ajax({
          url:"<?php echo base_url(); ?>Purchase/show_purchasereturn",
          type:"POST",
          cache:false,
          data:{ref_no:ref_no},
          success:function(data){
            //alert(data);
            $("#purchase_table").html(data);
          }
        });
      });
    });

    function myFunction(id) {
        var qty = $("#qty").val();
        if (confirm("Are you sure you want to click this?")) {
          //alert(id);
          //var checkBox = document.getElementById("myCheck");
            $.ajax({
              url:"<?php echo base_url(); ?>Purchase/update_purchasereturn",
              type:"POST",
              cache:false,
              data:{id:id, quantity:qty},
              success:function(data){
                //alert(data);
                //$("#products_table").html(data);
              }
            });
            } else {
                return false;
            }
        
      }
    // $(document).ready(function(){
    //   $("#method").change(function(){
    //     var method = $(this).val();
    //     if (method == "credit") {
    //       $("#pay").show();
    //     }
    //     else{
    //       $("#pay").hide();
    //     }
    //   }); 
    // });
  </script>

<script>
    $(document).ready(function() {
        $('.delete_purchase').click(function() {
            var id = $(this).attr("id");
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>Purchase/delete", //178
                    data: ({
                        id: id
                    }),
                    cache: false,
                    success: function(data) {
                      //alert(data);
                      $("#pur" + id).fadeOut('slow');
                    }
              });
          });
    });
</script>
</body>

</html>
