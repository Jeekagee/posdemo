<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <title>Print Bill</title>

    <style>
        body  
        { 
            font-weight: bold;
            height:140mm;
            padding : 15px;
            padding-top : 0px;
        }

        .tbl-bor{
            border: 1.5px solid black;
            padding-left : 5px;
        }
        
        .blank_row
        {
            height: 30px !important; 
            background-color: #FFFFFF;
        }
    </style>
</head>
<body>

<div style="margin-top:0.1mm; letter-spacing:6px;">
    <h3 class="text-center" style="padding-right: 80px; line-height: 1; font-size: 1rem; font-family: auto;">INVOICE</h3>
    <div>
        <table class="table tbl-bor" style="width:75%; margin-bottom: 0.5rem;">
            <tr>
                <td class="text-left" style="width:50.25mm; font-size:8px; padding-top:0px; padding-bottom:0px;">
                    <div>
                        <img src="<?php echo base_url(); ?>assets/img/aclogo.png" style="height:50px;">
                        <p style="line-height:12px; letter-spacing:4px; margin-bottom: 0rem; font-family: auto;">
                            Address<br>
                            Tel : 000 000 0000
                        </p>
                    </div>
                </td>
                <td style="width:70.25mm">
                    
                </td>
                <td class="text-left" style="width:70.25mm; vertical-align:bottom; font-size:8px; letter-spacing:4px; padding-bottom:0px; font-family: auto;">
                        <div>
                            
                            <p>
                                Invoice No: <?php echo $bill_details->invoice_no; ?><br>
                                NIC Number: <?php echo $bill_details->nic; ?><br>
                                Patient Name: <?php echo $bill_details->name; ?><br>
                                Address: <?php echo $bill_details->address; ?><br>
                                Mobile Number: <?php echo $bill_details->mobile; ?><br>
                                <!-- Doctor: <?php echo $bill_details->name; ?><br> -->
                            </p>
                        </div>
                </td>
            </tr>
        </table>
    </div>
    <div style="padding-right:5px; letter-spacing:4px; font-size:8px;font-family: auto;">
        <table>
            <thead style="heigh:30px;" class="text-center tbl-bor">
                <th style="width:30mm;" class="tbl-bor">No</th>
                <th style="width:150mm;" class="tbl-bor">Service</th>
                <th style="width:60mm;" class="tbl-bor">Amount</th>
            </thead>
                <?php
                $CI =& get_instance();
                $i = 1;
                $invoice_no = $bill_details->invoice_no;
                $services = $CI->Laboratory_model->lab_services($invoice_no); 
                $total = 0;
                foreach ($services as $service) {
                ?>
                    <tr class="tbl-bor" style="height:0mm; font-size: 8px;font-family: auto;">
                        <td class="tbl-bor text-center"><?php echo $i; ?></td>
                        <td class="tbl-bor text-left"><?php 
                         
                                        $service_id = $service->service_id; 
                                          echo $CI->Laboratory_model->get_service($service_id)
                                          ?></td>
                        <td class="tbl-bor text-right"><?php echo $charge = $service->charge; ?>.00</td>
                    </tr>
                    <?php

                    $i++;
                    $total = $total+$charge;

                    if($i == 9)
                    {
                    ?>
                        <tr class="blank_row">
                            <td colspan="5"></td>
                        </tr>
                    <?php
                    }
                }
                ?>
            
            
            <tr style="height:0mm; font-size: 8px;font-family: auto;">
                <td class="text-center"></td>
                <td class="text-right">Total</td>
                <td class="text-right">Rs.<?php echo $total; ?>.00</td>
            </tr>
        </table>
    </div>
            </div>
    

<script>
    $(document).ready(function(){
        window.print();
        //window.location.href = "<?php echo base_url(); ?>Orders/P";
    });
</script>
</body>
</html>