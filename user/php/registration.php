<?php

    if (isset($_POST['submit'])) {
        include_once("db_connect.php");

        $custname = addslashes($_POST['name']);
        $custemail = addslashes($_POST['email']);
        $custphone = addslashes($_POST['phone']);
        $custstate = addslashes($_POST['state']);
        $custaddr = addslashes($_POST['address']);
        $custpass = sha1($_POST['password']);
        $custotp = rand(10000,99999);
        $custcredit = 5;

        $sql_register = "INSERT INTO `tbl_customer` (`customer_name`, `customer_email`, `customer_phone`, `customer_state`, `customer_address`, `customer_pass`, `customer_otp`, `customer_credit`) VALUES ('$custname', '$custemail', '$custphone', '$custstate', '$custaddr', '$custpass', '$custotp', '$custcredit')";

        try {
            $conn -> exec($sql_register);
            sendEmail($custemail, $custotp);
            echo "<script>alert('Registration successful')</script>";
            echo "<script>window.location.replace('index.php')</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Registration' failed')</script>";
            echo "<script>window.location.replace('registration.php')</script>";
        }
    } 

    function sendEmail($email, $otp)
    {
        $to = $email;
        $subject = "SlumShop - Verify Your Account";
            
        $message = "
        <html>
        <head>
        <title>Verify Your Account</title>
        </head>
        <body>
        <h2>Welcome to SlumShop</h2><br />
        <p>Thank you for registering your account.<br/>To complete your registration, please click the following link to verify your account.<p><br />
        <p><a href ='localhost/slumshop/user/php/verify.php?email=$email&otp=$otp'><button>Verify Here</button></a></p>
        </body>
        </html>
        ";
        
        $headers =  'MIME-Version: 1.0' . "\r\n"; 
        $headers .= 'From: SlumShop <slumshop@localhost.com>' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        mail($to, $subject, $message, $headers);
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
                <br />
            </div>
        </div>

        <div class="w3-bar w3-purple">
            <a onclick="history.go(-1);" class="w3-bar-item w3-button w3-right">Back</a>
        </div>

        <div class="w3-content w3-padding-32">
            <form class="w3-container w3-padding-32 w3-margin w3-card" action="registration.php" method="post" onsubmit="return confirm('Are you sure?')">
                <div class="w3-container w3-purple">
                    <h3>New User Registration</h3>
                </div>
                <div class="w3-container w3-padding w3-center">
                    <img class="w3-image w3-margin" src="../res/new_user.png" style="max-height: 25%; max-width: 25%" /><hr />
                </div>
                <div class="w3-padding">
                    <div class="w3-row">
                        <div class="w3-half" style="padding-right: 10px">
                            <p>
                                <label><b>Name</b></label>
                                <input class="w3-input w3-border w3-round" name="name" required />
                            </p>
                        </div>
                        <div class="w3-half" style="padding-right: 10px">
                            <p>
                                <label><b>E-mail</b></label>
                                <input class="w3-input w3-border w3-round" name="email" required />
                            </p>
                        </div>
                    </div>
                    <div class="w3-row">
                        <div class="w3-half" style="padding-right: 10px">
                            <p>
                                <label><b>Phone</b></label>
                                <input class="w3-input w3-border w3-round" name="phone" type="number" required />
                            </p>
                        </div>
                        <div class="w3-half" style="padding-right: 10px">
                            <p>
                                <label><b>States</b></label>
                                <select class="w3-input w3-border w3-round" name="state">
                                    <option value="Selangor">Selangor</option>
                                    <option value="Kedah">Kedah</option>
                                </select>
                            </p>
                        </div>
                    </div>
                    <div class="w3-row">
                        <div class="w3-half" style="padding-right: 10px">
                            <p>
                                <label><b>Password</b></label>
                                <input class="w3-input w3-border w3-round" name="password" type="password" required />
                            </p>
                        </div>
                        <div class="w3-half" style="padding-right: 10px">
                            <p>
                                <label><b>Confirm Password</b></label>
                                <input class="w3-input w3-border w3-round" name="confirm_password" type="password" required />
                            </p>
                        </div>
                    </div>
                    <p>
                        <label><b>Address</b></label>
                        <textarea class="w3-input w3-border w3-round" rows="4" width="100%" name="address" placeholder="Enter Address Here" required></textarea>
                    </p>
                    <div class="w3-row">
                        <div class="w3-half" style="padding-right: 10px">
                            <p>
                                <input class="w3-check" name="agree" type="checkbox" value="Agree" required />
                                <label>Agree to T&C</label>
                            </p>
                        </div>
                        <div class="w3-half" style="padding-right: 10px">
                            <p class="w3-center">
                                <button class="w3-button w3-purple w3-round" type="submit" name="submit">Register</button>
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <footer class="w3-center w3-purple w3-padding">
            <p>&copy; SlumShop 2022.</p>
        </footer>
</body>

</html>