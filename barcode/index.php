<?php
require 'vendor/autoload.php';
// This will output the barcode as HTML output to display in the browser
$generator= new Picqer\Barcode\BarcodeGeneratorPNG(); // Vector based HTML
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>Document</title>

    <style>
        body{
            width: 100%;
            height: 100%;
        }
        
        @media print {
            html, body {
                padding: 1mm;
                width: 127mm;
                background-color: yellow;    
            }
        }
    </style>
</head>
<body>
    <div class="barcode-container">
        <?php
        $count = $_GET['count'];
        for ($i=0; $i < $count; $i++) { 
            ?>
            <div class="row">
                <div class="col-xs-6 abarcode">
                    <div class="text-center">
                        <?php echo $_GET['item_name']; ?>
                    </div>
                    <div class="text-center">
                        Rs.<?php echo $_GET['price']; ?>
                    </div>
                    <div class="text-center">
                        <?php 
                        //echo $generatorHTML->getBarcode($item_id, $generatorHTML::TYPE_CODE_128);
                        $item_id = $_GET['id'];
                        $barcode = $generator->getBarcode($item_id, $generator::TYPE_CODE_128);
                        echo '<img src="data:image/png;base64,' . base64_encode($barcode) . '">';
                        ?>
                    </div>
                    <div class="text-center">
                        <?php echo $item_id; ?>
                    </div>
                </div>

                <div class="col-xs-6 abarcode">
                    <div class="text-center">
                        <?php echo $_GET['item_name']; ?>
                    </div>
                    <div class="text-center">
                        Rs.<?php echo $_GET['price']; ?>
                    </div>
                    <div class="text-center">
                        <?php 
                        //echo $generatorHTML->getBarcode($item_id, $generatorHTML::TYPE_CODE_128);
                        $item_id = $_GET['id'];
                        $barcode = $generator->getBarcode($item_id, $generator::TYPE_CODE_128);
                        echo '<img src="data:image/png;base64,' . base64_encode($barcode) . '">';
                        ?>
                    </div>
                    <div class="text-center">
                        <?php echo $item_id; ?>
                    </div>
                </div>
            </div>
            <?php
        }
        ?>
    </div>

    <script>
        $(document).ready(function(){
          
            window.print();
            window.location.href = "../Inventory/Create_barcode";
        });
    </script>
</body>
</html>


