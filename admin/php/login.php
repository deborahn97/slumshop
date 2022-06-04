<?php

    include("db_connect.php");

    if(isset($_POST['submit'])) {
        $email = $_POST['email'];
        $pass = sha1($_POST['password']);
        // $rememberme = $_POST['rememberme'];

        $sql_login = "SELECT * FROM tbl_admins WHERE admin_email = '$email' AND admin_pass = '$pass'";

        $stmt = $conn -> prepare($sql_login);
        $stmt -> execute();

        $num_of_rows = $stmt -> fetchColumn();

        if($num_of_rows > 0) {
            session_start();
            $_SESSION["sessionid"] = session_id();
            $_SESSION['email'] = $email;
            
            echo "<script>alert('Login Success');</script>";
            echo "<script>window.location.replace('index.php');</script>";
        } else {
            echo "<script>alert('Login Failed');</script>";
            echo "<script>window.location.replace('login.php');</script>";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SlumShop - Admin Login</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />
    <script src="../js/login.js"></script>
</head>

<body onload="loadCookies()">
    <header class="w3-header w3-purple w3-center w3-padding">
        <h3>SlumShop Admin Login Page</h3>
        <p>Login Page</p>
    </header>
    <div style="display: flex; justify-content: center">
        <div class="w3-card w3-padding w3-margin" style="width: 600px">
            <form name="loginform" action="login.php" method="post">
                <p>
                    <label>Email</label>
                    <input class="w3-input w3-round w3-border" type="email" name="email" id="idemail" placeholder="Your Email" required />
                </p>
                <p>
                    <label>Password</label>
                    <input class="w3-input w3-round w3-border" type="password" name="password" id="idpass" placeholder="Your Password" required />
                </p>
                <p>
                    <input class="w3-check" type="checkbox" name="rememberme" id="idremember" onclick="rememberMe()" />
                    <label>Remember Me</label>
                </p>
                <p>
                    <input class="w3-button w3-round w3-border w3-purple" type="submit" name="submit" value="Login" id="idsubmit" />
                </p>
            </form>
        </div>
    </div>

    <div id="cookieNotice" class="w3-right w3-padding w3-block" style="display: none;">
        <div class="w3-purple">
            <h4>Cookie Consent</h4>
            <p>This website uses cookies or similar technologies, to enhance your browsing experience and provide personalized recommendations.
            By continuing to use our website, you agree to our <a style="color:#115cfa;" href="/privacy-policy">Privacy Policy</a>.</p>
            <div class="w3-button">
                <button onclick="acceptCookieConsent();">Accept</button>
            </div>
        </div>
    </div>

    <footer class="w3-center w3-purple w3-padding">
        <p>&copy; SlumShop 2022.</p>
    </footer>
</body>

<script>
    let cookie_consent = getCookie("user_cookie_consent");
    
    if (cookie_consent != "") {
        document.getElementById("cookieNotice").style.display = "none";
    } else {
        document.getElementById("cookieNotice").style.display = "block";
    }
</script>

</html>