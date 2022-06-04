<?php
    session_start();
    
    include_once("db_connect.php");

    if(isset($_GET['submit'])) {
        $operation = $_GET['submit'];

        if($operation == 'delete') {
            $pr_id = $_GET['prid'];

            $sql_delete = "DELETE FROM tbl_products WHERE product_id = " . $pr_id;
            $conn -> exec($sql_delete);
            echo "<script>alert('Product deleted successfully');</script>";
        }
        
        if($operation == 'search') {
            $search = $_GET['search'];
            $option = $_GET['option'];

            if ($option == 'name') {
                $sql_product = "SELECT * FROM tbl_products WHERE product_name LIKE '%$search%'";
            } else if ($option == 'status') {
                $sql_product = "SELECT * FROM tbl_products WHERE product_status LIKE '%$search%'";
            }   
        }
    } else {
        $sql_product = "SELECT * FROM tbl_products";
    }

    // Pagination
    $results_per_page = 2; // can change

    if (isset($_GET['pageno'])) {
        $page_no = (int)$_GET['pageno'];
        $page_first_result = ($page_no - 1) * $results_per_page;
    } else {
        $page_no = 1;
        $page_first_result = 0;
    }

    $stmt_product = $conn -> prepare($sql_product);
    $stmt_product -> execute();

    $number_of_result = $stmt_product -> rowCount();
    $number_of_page = ceil($number_of_result / $results_per_page); // round off

    $sql_product = $sql_product . " LIMIT $page_first_result, $results_per_page";

    $stmt = $conn -> prepare($sql_product);
    $stmt -> execute();
    $result = $stmt -> setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt -> fetchAll();

    $conn = null; // close connection

    function truncate($string, $length, $dots = "...") {
        return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
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
        <a href="" class="w3-bar-item w3-button w3-right"></a>
    </div>

    <div class="w3-container w3-padding">
        <h3>My Products</h3>
        <div class="w3-card w3-container w3-padding w3-margin w3-round">
            <h4>Product Search</h4>
            <form action="" method="get">
                <div class="w3-row">
                    <div class="w3-half w3-container" style="padding-right: 5px">
                        <p><input class="w3-input w3-block w3-round w3-border" type="search" id="search" name="search" placeholder="Enter search term" /></p>
                    </div>
                    <div class="w3-half w3-container">
                        <p><select class="w3-input w3-block w3-round w3-border" name="option" id="idoption">
                            <option value="name">By Name</option>
                            <option value="status">By Status</option>
                        </select></p>
                    </div>
                </div>
                <button class="w3-button w3-purple w3-round w3-right" type="submit" name="submit" value="search">Search</button>
            </form>
        </div>
        <div class="w3-margin w3-border w3-grid-template" style='overflow-x: auto;'>
            <?php
                $i = 0;

                echo 
                "<table class='w3-table w3-striped w3-border w3-bordered'>";

                foreach ($rows as $products) {
                    $i++;

                    $pr_id = $products['product_id'];
                    $pr_name = truncate($products['product_name'], 15);
                    $pr_desc = $products['product_desc'];
                    $pr_qty = $products['product_qty'];
                    $pr_price = number_format((float)$products['product_price'], 2, '.', '');
                    $pr_status = $products['product_status'];

                    echo 
                    "<a style='text-decoration: none' href='product_details.php?prid=$pr_id'><div class='w3-card-4 w3-round' style='margin: 6px'>
                        <header class='w3-container w3-purple'>
                            <b>$pr_name</b>
                        </header>
                        <p><img class='w3-image' src=../../admin/res/products/$pr_id.png" .
                        " onerror=this.onerror=null;this.src='../res/images/users/profile.png' style='height: 150px; display: block; margin: auto'></p>
                        <hr />
                        <p class='w3-container w3-center'>Price: RM$pr_price<br />Quantity: $pr_qty<br />Status: $pr_status</p>
                    </div></a>";
                }

                echo "</table>";
            ?>
        </div>
        <br />
        <?php
            $num = 1;
            if ($page_no == 1) {
                $num = 1;
            } else if ($page_no == 2) {
                $num = ($num) + 10;
            } else {
                $num = $page_no * 10 - 9;
            }

            echo "<div class='w3-container w3-row'>";
            echo "<center>";
            for ($page = 1; $page <= $number_of_page; $page++) {
                echo '<a href = "index.php?pageno=' . $page . '" style= "text-decoration: none">&nbsp&nbsp' . $page . ' </a>';
            }
            echo " ( " . $page_no . " )";
            echo "</center></div>";
        ?>
    </div>

    <footer class="w3-center w3-purple w3-padding">
        <p>&copy; SlumShop 2022.</p>
    </footer>
</body>
</html>