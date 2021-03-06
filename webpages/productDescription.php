
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Change TITLE-->
    <title>ITEM</title>
    <!--CHNAGE-->
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap" rel="stylesheet" />
    <!--CSS-->
    <link rel="stylesheet" href="../resources/stylesheet/productDescriptionStyle.css">

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

    <main>
        <div class="container">
            <div class="content1">
                <div class="wrap">
                    <p class="unofficial-logo">HOMEY MARKET</p>
                </div>

                <div class="product-description">

                    <img src="" alt="Item Image (will be added accordingly)" class="product-img">

                    <ul class="description-ul">
                        <li>
                            <h1 id="top">Product Name</h1>
                            <!--CHNAGE-->
                        </li>
                        <li class="price-details">
                            <span id="unit-price">4.99</span>$ /
                            <span>Details</span>
                            <!--CHNAGE-->
                        </li>
                        <li>
                            <p>Quantity:</p>
                        </li>
                        <li>
                            <!-- change php action -->
                            <form action="productDescription.php" method="post" class="form">
                                <div class="quantity-control">
                                    <input class="minus-button" type="button" value="-" id="minus-button">
                                    <input class="quantity" type="number" name="quantity" id="quantity" min="1"
                                    value="1">
                                    <input class="plus-button" type="button" value="+" id="plus-button">
                                </div>

                                <input class="add-button" type="submit" value="ADD" id="add-button" name="add">
                                <br>
                                <div class="price">
                                    <span class="total-ptice-label">
                                        <b>$<span id="total-price"></span></b>
                                    </span>
                                </div>
                                <br>

                                <details>
                                    <summary>Product Description</summary>
                                    <p class="description-text">
                                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Corrupti cumque atque
                                        ipsum enim architecto mollitia, quod odit ipsam, labore quam quidem dolores
                                        quis, tenetur soluta. Assumenda tenetur eum sunt nobis.
                                    </p>
                                </details>
                            </form>
                        </li>
                    </ul>
                </div>


            </div>
        </div>

    </main>



    <!-- FOOTER -->
    <div id="footer"></div>

    <script src="../JS/productDescription.js"></script>

    <?php
        function inputSet(){
            return  isset($_POST['quantity']);
        }

        if(inputSet()){
            $quantity = $_POST['quantity'];
            if(isset($_POST['add'])&&($quantity>0)){
                //$productName=$_POST[''];
                //$productImg=$_POST['']; use GET
            
                //add to cart()
            }else{
                echo '<script>alert("Put a valid quantity")</script>';
            }
        }
    ?>
</body>

</html>