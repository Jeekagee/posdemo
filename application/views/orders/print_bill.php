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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&family=Roboto+Condensed:ital@1&family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.js" referrerpolicy="no-referrer"></script>
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <script src="https://printjs-4de6.kxcdn.com/print.min.css"></script>
    <title>Print Bill</title>

    <style>
        
        @font-face {
        font-family: "myFont";
        src: url("<?php echo base_url(); ?>assets/Merchant Copy.ttf");
        }

        body{
            font-size:18px;
        }

        .print_container{
            font-family: 'Poppins', sans-serif;
            font-weight: 1000;
            width: 107mm;
            padding:20px;
            margin-left: 15px;
            margin-top: 15px;
        }

        .logo_img{
            width: 80px;
            height: auto;
        }
        .mt-10{
            margin-top: 1px;
        }
        .mb-10{
            margin-bottom: 1px;
        }
        .line {
            margin:5px 0;
            height:2px;
            background:
            repeating-linear-gradient(to right,black 0,black 5px,transparent 5px,transparent 7px);
            opacity: 0.5;
            /*5px red then 2px transparent -> repeat this!*/
        }

    </style>
</head>
<body>

<?php $CI =& get_instance(); ?>

<div class="print_container" id="bill" style="border-style: solid; padding:10px;">
    <div class="text-center">
        <img class="logo_img" src="<?php echo base_url(); ?>assets/img/pwlogo.png">
    </div>
    <div class="text-center">
        100 A Arasadi Road,<br>
        Jaffna 40000.<br>
        076 299 9797
    </div>
    <div class="row">
        <div class="col-6 text-left">
            Customer : 
        </div>
        <div class="col-6 text-right">
            Invoice : <?php echo $bill_data->bill_no; ?>
        </div>
    </div>
    <div class="line"></div>

        <?php
        $i = 1;
        $order_id = $bill_data->order_id;
        $items = $CI->Orders_model->order_item_data($order_id);
        foreach ($items as $itm) {
            ?>
            <div class="row" style="font-size:16px;">
                <div class="col-4">
                    <?php echo $i; ?> - <?php echo $itm->item_name; ?>
                </div>
                <div class="col-4 text-center">
                    <?php echo $amount = $itm->amount; ?>*<?php echo $qty = $itm->qty; ?>
                </div>
                <div class="col-4 text-right">
                    <?php echo $amount*$qty; ?>.00
                </div>
            </div>
            <div class="line"></div>
            <?php
            $i++;
        }
        ?>
    <div class="row" style="font-size:16px;">
        <div class="col-6 text-left">
            Total
        </div>
        <div class="col-6 text-right">
            <?php echo $total = $bill_data->total; ?>.00
        </div>
    </div>
    <div class="row" style="font-size:16px;">
        <div class="col-6 text-left">
            Discount
        </div>
        <div class="col-6 text-right">
            <?php echo $discount = $bill_data->discount; ?>.00
        </div>
    </div>
    <div class="row" style="font-size:16px;">
        <div class="col-6 text-left">
            Payment
        </div>
        <div class="col-6 text-right">
            <?php echo $payment = $bill_data->payment; ?>.00
        </div>
    </div>
    <div class="line"></div>
    <div class="row" style="font-size:16px;">
        <div class="col-6 text-left">
            Balance
        </div>
        <div class="col-6 text-right">
            <?php echo $payment - $total - $discount; ?>.00
        </div>
    </div>

    <div class="row" style="font-size:16px;">
        <div class="col-6 text-left">
            No of Items : <?php echo $CI->Orders_model->noofitems($order_id); ?>
        </div>
        <div class="col-6 text-right">
            No of PCs : <?php echo $CI->Orders_model->noofpcs($order_id); ?>
        </div>
    </div>

    <?php
        $month = date('m');
        $day = date('d');
        $year = date('Y');
        
        $today = $year . '-' . $month . '-' . $day;
    ?>

    <div class="row" style="font-size: 18px;">
        <div class="col-6 text-left">
            Date : <?php echo $today; ?>
        </div>
        <div class="col-6 text-right">
            Time : <?php echo date('H:s:i'); ?>
        </div>
    </div>

    <div class="line"></div>
        <div class="mb-10 text-center">
        Thankyou for with us
        </div>
    <div class="line"></div>

    <div class="line"></div>
        <div class="mb-10 text-center">
        We offer Complete Party Solutions Party Supplies Wholesale and Retail<br> contact with us 076 299 9797
        </div>
    <div class="line"></div>

    <div class="mb-10 text-center">
        System By : kodplex - 0778434368
    </div>
</div>

<script>
    $(document).ready(function(){
        
        /*printJS({
            printable: 'bill',
            type: 'html',
            header: 'PrintJS - Print Form With Customized Header',
            css:true,
            targetStyle:true,
        });*/
        window.print();
       // window.location.href = "<?php echo base_url(); ?>Orders";
    });
</script>
</body>
</html>