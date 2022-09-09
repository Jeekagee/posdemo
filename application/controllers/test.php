foreach ($result as $row)
            {
                $p_id = $row->id;
                    ?>
                        <a id="single_item<?php echo $p_id; ?>">
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="item_box">
                                    <div class="item_m">
                                    <?php echo $item_id = $row->item_id; ?>
                                    </div>
                                    <div class="item_m" style="color:#313552;">
                                    <?php echo $this->Orders_model->item_name($item_id); ?>
                                    </div>
                                    <div class="item_m">
                                    Qty : <?php echo $item_id = $row->quantity; ?>
                                    </div>
                                </div>
                            </div>
                        </a>

                        <input hidden type="text" id="p_id<?php echo $p_id; ?>" value="<?php echo $p_id; ?>">
                        <input hidden type="text" id="order_id<?php echo $p_id; ?>" value="<?php echo $order_id; ?>">

                        <script>
                        $(document).ready(function(){
                            $("#single_item<?php echo $p_id; ?>").click(function(){
                            var order_id = $("#order_id<?php echo $p_id; ?>").val();
                            var p_id = $("#p_id<?php echo $p_id; ?>").val();
                                $.ajax({
                                url:"<?php echo base_url(); ?>Orders/insert_order_item", //803
                                type:"POST",
                                cache:false,
                                data:{order_id:order_id,p_id:p_id},
                                success:function(data){
                                    //alert(data);
                                    $("#add_items").html(data);
                                }
                                });
                            }); 
                        });
                        </script>
                <?php
            }