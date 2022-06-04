<?php

    error_reporting(0);
    
    include_once("db_connect.php");
    
    $email = $_GET['email'];
    $otp = $_GET['otp'];
    $new_otp = rand(10000,99999);
    
    $sql = "SELECT * FROM tbl_customer WHERE customer_email = '$email' AND customer_otp = '$otp'";
    $result = $conn -> query($sql);
    
    if ($result->num_rows > 0)
    {
       $verify = "UPDATE tbl_customer SET customer_otp = '$new_otp' WHERE customer_email = '$email'";
       
      if ($conn -> query($verify) === TRUE) {
            echo "<h2>Success</h2> <p>Accont Verification Success. Thank you for verifying your account.</p>";
      } else {
          echo "<h2>Failed</h2> <p>Failed to verify your account. Please try again.</p>";
      }
    }
 
?>