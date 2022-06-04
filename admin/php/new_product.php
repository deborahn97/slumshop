<?php
    session_start();

    if (!isset($_SESSION['sessionid'])) {
        echo "<script>alert('Session not available. Please login');</script>";
        echo "<script> window.location.replace('login.php')</script>";
    } else {
        $email = $_SESSION['email'];
    }

    if(isset($_POST['submit'])) {
        include_once("db_connect.php");

        $prname = addslashes($_POST['productname']);
        $prdesc = addslashes($_POST['productdesc']);
        $prqty = $_POST['productqty'];
        $prprice = $_POST['productprice'];
        $prbarcode = $_POST['productbarcode'];
        $prstatus = "Available";

        $sql_insert = "INSERT INTO `tbl_products` (`product_name`, `product_desc`, `product_qty`, `product_price`, `product_barcode`, `product_status`) VALUES ('$prname', '$prdesc', $prqty, $prprice, '$prbarcode', '$prstatus')";

        try {
            $conn -> exec($sql_insert);
            if (file_exists($_FILES["productimage"]["tmp_name"]) || is_uploaded_file ($_FILES["productimage"]["tmp_name"])) {
                $last_id = $conn -> lastInsertId();
                uploadImage($last_id);
                echo "<script>alert('Add product successful')</script>";
                echo "<script>window.location.replace('products.php')</script>";
            }
        } catch(PDOException $e) {
            echo "<script>alert('Add product failed')</script>";
            echo "<script>window.location.replace('new_product.php')</script>";

        }
    }

    function uploadImage($filename)
    {
        $target_dir = "../res/products/";
        $target_file = $target_dir . $filename . ".png";
        move_uploaded_file($_FILES["productimage"]["tmp_name"], $target_file);
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
    <script src="../js/menu.js"></script>
    <script src="../js/script.js"></script>
</head>

<body>
    <div class="w3-sidebar w3-bar-block w3-collapse w3-card w3-animate-left" style="width:200px;" id="mySidebar">
        <button class="w3-bar-item w3-button w3-large w3-hide-large" onclick="w3_close()">Close &times;</button>
        <div class="w3-card w3-padding w3-container w3-margin" style="height: 150px; width: 150px"></div>
        <hr />
        <a href="index.php" class="w3-bar-item w3-button">Dashboard</a>
        <a href="products.php" class="w3-bar-item w3-button">My Products</a>
        <a href="#" class="w3-bar-item w3-button">Customer</a>
        <a href="#" class="w3-bar-item w3-button">Orders</a>
        <a href="#" class="w3-bar-item w3-button">Reports</a>
        <a href="logout.php" class="w3-bar-item w3-button">Logout</a>
    </div>

    <div class="w3-main" style="margin-left:200px">
        <div class="w3-purple">
            <button class="w3-button w3-purple w3-xlarge w3-hide-large" onclick="w3_open()">&#9776;</button>
        <div class="w3-container">
            <h2>SlumShop</h2>
        </div>
    </div>

    <div class="w3-bar w3-purple w3-padding">
        <?php echo "Welcome $email!"; ?>
    </div>

    <div class="w3-bar w3-purple">
        <a href="logout.php" class="w3-bar-item w3-button w3-right">Logout</a>
    </div>

    <div class="w3-content w3-padding-32">
        <form class="w3-container w3-padding-32 w3-margin w3-card" action="new_product.php" method="post" enctype="multipart/form-data" onsubmit="return confirm('Are you sure?')">
            <div class="w3-container w3-purple">
                <h3>New Product</h3>
            </div>
            <div class="w3-container w3-padding w3-center">
                <img class="w3-image w3-margin" src="../res/new_product.png" style="max-height: 25%; max-width: 25%" /><br />
                <input type="file" name="productimage" onchange="previewFile()" />
            </div>
            <div class="w3-padding">
                <hr />
                <p>
                    <label><b>Product Name</b></label>
                    <input class="w3-input w3-border w3-round" name="productname" type="text" required />
                </p>
                <p>
                    <label><b>Description</b></label>
                    <textarea class="w3-input w3-border w3-round" rows="4" width="100%" name="productdesc" placeholder="Enter Description Here" required></textarea>
                </p>
                <div class="w3-row">
                    <div class="w3-third" style="padding-right: 10px">
                        <p>
                            <label><b>Quantity</b></label>
                            <input class="w3-input w3-border w3-round" name="productqty" type="number" required />
                        </p>
                    </div>
                    <div class="w3-third" style="padding-right: 10px">
                        <p>
                            <label><b>Price (RM)</b></label>
                            <input class="w3-input w3-border w3-round" name="productprice" type="number" step="any" required />
                        </p>
                    </div>
                    <div class="w3-third">
                        <p>
                            <label><b>Barcode</b></label>
                            <input class="w3-input w3-border w3-round" name="productbarcode" type="number" required />
                        </p>
                    </div>
                </div>
                <p class="w3-center">
                    <button class="w3-button w3-purple w3-round" type="submit" name="submit">Add Product</button>
                </p>
            </div>
        </form>
    </div>

    <footer class="w3-center w3-purple w3-padding">
        <p>&copy; SlumShop 2022.</p>
    </footer>
</body>
</html>