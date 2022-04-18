<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SIGN UP</title>
        
        <!--FONT-->
        <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet" />

        <!-- CSS -->
        <link rel="stylesheet" href="../resources/stylesheet/signupStyle.css">

        <!-- JS for header/footer -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script>
            $(function () {
                $('#header').load('header.html');
                $('#footer').load('footer.html');
            });
        </script>
        
        
    </head>

    <body>
        <!-- HEADER -->
        <div id="header"></div>
        
        <!-- CONTENT -->
        <main>
            <form action="signup.php" method="post" class="form">
                <div class="signup-text">
                    <img class="homey-logo" src="../resources/img/logo_simplified.png" alt="aroma simplified logo" width="100px">
                    <p>
                        <b>Create a Homey Market&#8482; ID</b><br>
                        Sign up to support your local Homey Market
                    </p>
                </div>

                <div class="form-item first-name">
                    <input type="text" class="form-input complete-name" placeholder="First Name" id="first-name" name="firstName" required>
                </div>

                <div class="form-item last-name">
                    <input type="text" class="form-input complete-name" placeholder="Last Name" id="last-name" name="lastName" required>
                </div>

                <div class="form-item mail">
                    <input type="email" class="form-input" placeholder="example@gmail.com" id="email" name="email" required>
                </div>

                <div class="form-item zip-code">
                    <input type="text" class="form-input" placeholder="Zip Code" id="zip-code" name="zipCode" required>
                </div>

                <div class="form-item password">
                    <input type="password" class="form-input" placeholder="Password" id="password" name="password" required>
                </div>

                <div class="form-item confirm-password">
                    <input type="password" class="form-input" placeholder="Confirm Password" id="confirm-password" name="confirmPassword" required>
                </div>

                <input type="submit" value="SIGN UP" class="signup-button" id="signup" name = "submit">
                <input type="reset" value="RESET" class="reset-button">
            </form>
            
        </main>

        <!-- FOOTER -->
        <div id="footer"></div>

        <script src="../JS/signup.js"></script>

        <?php
            /*
            resubmit->data unset
            auto login
            */
            function inputSet(){
                return  isset($_POST["firstName"])&&isset($_POST["lastName"])
                        &&isset($_POST["email"])&&isset($_POST["zipCode"])
                        &&isset($_POST["password"])&&isset($_POST["confirmPassword"]);
            }
        
            function checkMail($mail){
                $strJsonFileContents = file_get_contents("../JSON/users.json");
                // Convert to array 
                $array = json_decode($strJsonFileContents, true);
            //    var_dump($array);
            
                foreach($array as $data){
                    if($data["email"]==$mail){
                        return true;
                    }
                }
                return false;
            }


            if(inputSet()){
                if(!checkMail($_POST["email"])){
                    if($_POST["password"]==$_POST["confirmPassword"]){
                        echo '<script>alert("ok")</script>';
                        
                        if(isset($_POST['submit'])){
                            
                        $new_message = array(
                            "userId" => rand(),
                            "firstName" => $_POST['firstName'],
                            "lastName" => $_POST['lastName'],
                            "email" => $_POST['email'],
                            "zipCode" => $_POST['zipCode'],
                            "password" => $_POST['password']
                        );
                        
                        if(filesize("../JSON/users.json") == 0){
                            $first_record = array($new_message);
                            $data_to_save = $first_record;
                        }else{
                            $old_records = json_decode(file_get_contents("../JSON/users.json"));
                            array_push($old_records, $new_message);
                            $data_to_save = $old_records;
                        }
                        
                        $encoded_data = json_encode($data_to_save, JSON_PRETTY_PRINT);
                        
                        if(!file_put_contents("../JSON/users.json", $encoded_data, LOCK_EX)){
                            echo '<script>alert("signup ERROR")</script>';
                        }else{
                            echo '<script>alert("signup SUCCESS")</script>';
                            }
                        }
                        

                    }else{
                        echo '<script>alert("Passwords Not Matching")</script>';
                    }

                /*
                if(isset($_REQUEST["submit"])){
                    $xml  = new DOMDocument("1.0","UTF-8");
                    $xml->load("users.xml");

                    $rootTag = $xml->getElementsByTagName("document")->item(0);

                    $dataTag = $xml->createElement("users");

                    $fNameTag = $xml->createElement("firstName",$_REQUEST['firstName']);
                    $lNameTag = $xml->createElement("lastName",$_REQUEST['lastName']);
                    $emailTag = $xml->createElement("email",$_REQUEST['email']);
                    $zipCodeTag = $xml->createElement("zipCode",$_REQUEST['zipCode']);
                    $passwordTag = $xml->createElement("password",$_REQUEST['password']);

                    
                    $dataTag->appendChild($fNameTag);
                    $dataTag->appendChild($lNameTag);
                    $dataTag->appendChild($emailTag);
                    $dataTag->appendChild($zipCodeTag);
                    $dataTag->appendChild($passwordTag);

                    $rootTag->appendChild($dataTag);

                    $xml->save("users.xml");
                }
                */
                }else{
                    echo '<script>alert("USER ALREADY REGISTERED")</script>';
                }
            }
            
        ?>

    </body>

</html>
