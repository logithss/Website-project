
<?php
        if(isset($_REQUEST['email']) && isset($_REQUEST['password']))
        {
            $em = $_GET['email'];
            $pass = $_GET['password'];

            $userList = json_decode(file_get_contents("../JSON/users.json"));

            foreach($userList as $currentUser)
            {
                if($currentUser->email == $em && $currentUser->password == $pass)
                {
                    echo "top<br>";
                    print_r($currentUser);
                    setcookie("userID", $currentUser->id, time() + (86400 * 30));
                    header('Location: '. "http://homeymarket.epizy.com/webpages/index.html");
                    break;
                }
            }
        }

?>


<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- my font-->
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet">

    <!-- my css-->
    <link rel="stylesheet" href="../resources/stylesheet/loginStyle.css">


    <title>LogIn</title>

    <!-- JS for header/footer -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
            $(function () {
                $('#header').load('header.html');
                $('#footer').load('footer.html');
            });
    </script>

    <script>
        function login() {
            var username = document.getElementById("username").value;
            var password = document.getElementById("password").value;

            var errorText = document.getElementById("errorText");
            console.log(errorText);

            if (username === "" || password === "") {
                console.log("login failed");
                if (errorText.style.display == "block") {
                    errorText.style.display = "none";
                    //display after delay if message was already shown
                    setTimeout(() => { errorText.style.display = "block"; }, 100);
                }
                else {
                    errorText.style.display = "block";
                }
            }
            else
            {
                window.location.href = "login.php?email="+username+"&password=" + password;
            }
        }
    </script>

</head>

  <body>

  <!-- HEADER -->
  <div id="header"></div>

    <div class="main-box">


        <!---left side-->
        <img class="logo-hide" src="../resources/img/logo_simplified_big.png">

        <!---right side-->
        <div class="login-box">

            <h1>Login</h1>
            <!-- username input -->
            <input class="form-input" type="email" id="username" placeholder="Enter a valid email address" value="<?php echo $em; ?>"/>
            <p class="label-form">Email address</p>


            <!-- Password input -->
            <input class="form-input" type="password" id="password" placeholder="Enter a valid email address" value="<?php echo $pass; ?>"/>
            <p class="label-form">Password</p>
            <a href="login_passwordForgotten.html">Forgot password?</a>

            <!-- Login error Label -->
            <br />
            <?php

                if(isset($_REQUEST['email']) && isset($_REQUEST['password']))
                {
                    echo "<h4 class=\"label-error\" style=\"display: block\" id=\"errorText\"> Your login information is incorrect</h4>";
                }
                else
                    echo "<h4 class=\"label-error\" id=\"errorText\"> Your login information is incorrect</h4>";
            ?>

            <!-- submit input -->
            <br />
            <input class="form-button" type="submit" value="Login" onclick="login()" /><br>

        </div>
    </div>
    </body>
</html>