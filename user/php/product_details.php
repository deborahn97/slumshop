<?php

    session_start();

    if (!isset($_SESSION['sessionid'])) {
        echo "<script>alert('Session not available. Please login');</script>";
        echo "<script> window.location.replace('login.php')</script>";
    } else {
        $email = $_SESSION['email'];
    }

    include_once("db_connect.php");

    if(isset($_GET['prid'])) {
        $prid = $_GET['prid'];
        $sql_product = "SELECT * FROM tbl_products WHERE product_id = '$prid'";
        $stmt_product = $conn -> prepare($sql_product);
        $stmt_product -> execute();
        $number_of_result = $stmt_product -> rowCount();

        if($number_of_result > 0) {
            $result = $stmt_product -> setFetchMode(PDO::FETCH_ASSOC);
            $rows = $stmt_product -> fetchAll();
        } else {
            echo "<script>alert('Product Not Found');</script>";
            echo "<script>window.location.replace('index.php');</script>";
        }
    } else {
        echo "<script>alert('Page Error');</script>";
        echo "<script>window.location.replace('index.php');</script>";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SlumShop - Welcome</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="../css/style.css" />
    <script src="../js/menu.js"></script>
</head>

<body>
<div class="w3-sidebar w3-bar-block w3-collapse w3-card w3-animate-left" style="width:200px;" id="mySidebar">
        <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">Close &times;</button>
        <div class="w3-card w3-padding w3-container w3-margin" style="height: 150px; width: 150px"></div>
        <hr />
        <a href="index.php" class="w3-bar-item w3-button">Products</a>
        <a href="#" class="w3-bar-item w3-button">My Cart</a>
        <a href="#" class="w3-bar-item w3-button">My Orders</a>
        <a href="#" class="w3-bar-item w3-button">My Profile</a>
        <a href="logout.php" class="w3-bar-item w3-button">Logout</a>
    </div>

    <div class="w3-main" style="margin-left:200px">
        <div class="w3-purple">
            <button class="w3-button w3-purple w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
        <div class="w3-container">
            <h2>SlumShop</h2>
        </div>
    </div>

    <div class="w3-bar w3-purple">
        <a onclick="history.go(-1);" class="w3-bar-item w3-button w3-right">Back</a>
    </div>

    <div class="w3-container w3-padding">
        <h3>Product Details</h3>
        <?php
            foreach ($rows as $products) {
                $pr_id = $products['product_id'];
                $pr_name = $products['product_name'];
                $pr_desc = $products['product_desc'];
                $pr_qty = $products['product_qty'];
                $pr_price = number_format((float)$products['product_price'], 2, '.', '');
                $pr_barcode = $products['product_barcode'];
                $pr_date = $products['product_date'];
                $pr_status = $products['product_status'];

                echo 
                "<div class='w3-container w3-padding'>
                    <img class='w3-image' src=../../admin/res/products/$pr_id.png" .
                    " onerror=this.onerror=null;this.src='../res/images/users/profile.png' style='height: 150px; display: block; margin: auto'>
                    <br /><hr />
                </div>
                <div class='w3-container w3-padding'>
                    <div>
                        <h4><b>$pr_name</b></h4>
                    </div>
                    <div>
                        <p>Description<br />$pr_desc</p>
                    </div>
                    <div>
                        <p>Quantity<br />$pr_qty</p>
                    </div>
                    <div>
                        <p>Price<br />RM$pr_price</p>
                    </div>
                    <div>
                        <input type='hidden' name='prid'
                        <input class='w3-button w3-purple w3-round' type='submit' name='submit' value='Add to Cart' />
                    </div>
                </div>";
            }
        ?>
        <div class="w3-padding">
            <input class="w3-button w3-round w3-border w3-purple" type="submit" name="addtocart" value="Add to Cart" id="idaddtocart" />
        </div>
    </div>

    <footer class="w3-center w3-purple w3-padding">
        <p>&copy; SlumShop 2022.</p>
    </footer>
</body>
</html>