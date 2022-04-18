<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="../resources/stylesheet/style.css" />
    <link
      href="https://fonts.googleapis.com/css2?family=Nunito&display=swap"
      rel="stylesheet"
    />
    <!-- link for icons -->
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link rel="stylesheet" href="../resources/stylesheet/styling_cart.css" />
   
	  
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


    <!-- <div class="MyCart"> -->
    <div class="container">
      <div class="item-list">
          <h2 id="cart"><img src="../resources/img/products/shoppingCart.png" id="shoppingCartImage" alt="cart"></i> My cart</h2>
       <div class="productrow">

          <?php

          session_start();

          $cartItem1 = [];
          $cartItem1["productID"] = 3;
          $cartItem1["quantity"] = 6;

          $cartItem2 = [];
          $cartItem2["productID"] = 1;
          $cartItem2["quantity"] = 2;

          $cartItem3 = [];
          $cartItem3["productID"] = 2;
          $cartItem3["quantity"] = 5;

          $cartItem4 = [];
          $cartItem4["productID"] = 4;
          $cartItem4["quantity"] = 5;

          $cartItem5 = [];
          $cartItem5["productID"] = 5;
          $cartItem5["quantity"] = 5;


          $_SESSION["cart"] = [];

          array_push($_SESSION["cart"], $cartItem1);
          array_push($_SESSION["cart"], $cartItem2);
          array_push($_SESSION["cart"], $cartItem3);
          array_push($_SESSION["cart"], $cartItem4);
          array_push($_SESSION["cart"], $cartItem5);
          //print_r($_SESSION["cart"]);

          $items = json_decode(file_get_contents("../JSON/products.json"));

          $nameArray = array();

          foreach($_SESSION["cart"] as $product){

              $quant =   $product["quantity"];
              $productid = $product["productID"];

              foreach($items as $item){

                  if($product["productID"] == $item->id){

                      $imgPath = $item->img_path;
                      $productName = $item->productName;
                      $price = $item->price;
                      $nameArray[] = $productName;

                      echo '<div id="'.$productName.'" class="item">';
                      echo '<img  src= "'.$imgPath.'" alt="apple" height="100" id="item"/>';
                      echo '<div class="price-item">';
                      echo ' <h5 id="'.$productName.'-totalPrice"> Price: $'.$price.' </h5>';
                      echo '</div>';
                      echo '<input class="inputs" onclick="updateTotalItems(\''.$productName.'\', \''.$price.'\' )" type="number" id="'.$productName.'-quantity" min="0"step="1"value="'.$quant.'"/>' ;
                      echo '<div class="price-item">';
                      echo ' <h5 id="'.$productName.'-label">Total: $0,00</h5>';
                      echo '</div>';
                      echo '<form method= "post">';
                      echo '<input type="submit"  name = "deleteButton" value="&#9747" class="x" id="'.$productName.'-x" />';
                      echo '</form>';
                      echo '</div>';

                  }
              }
          }

          ?>



      </div>
      </div>
      <div class="orderSummary">
        <h2 id="order"> &#9777; Order Summary</h2>
        <h3 id="l1">Total items: 0</h3>
        <h3 id="l2">Subtotal: </h3>
        <h3 id="l3">Estimated QST(9.975): $0,00</h3>
        <h3 id="l4">Estimated GST(5%): $0,00</h3>
        <h3 id="l5">Total: $0,00</h3>
        <hr class="l6" />

        <input type="submit" value="Checkout" id="buttonCheckout" />
      </div>

        <script>
            function updateTotalItems(Product, price){

                var totalLabel = "Total: $";

                var productName = Product;
                console.log(productName);

                // var unitPriceLabel = document.getElementById(productName+"-totalPrice").textContent;
                // console.log(unitPriceLabel);
                // var unitPrice = parseInt(unitPriceLabel.substring(8, unitPriceLabel.length);
                var unitPrice = parseInt(price);
                console.log(unitPrice);
               // console.log(unitPrice);

                var quantity = parseInt(document.getElementById(productName+"-quantity").value);
                console.log(quantity);
               // console.log(quantity);
                var itemTotalPrice = parseFloat(unitPrice * quantity).toFixed(2);
                document.getElementById(productName+"-label").innerHTML = totalLabel + itemTotalPrice;

                var subtotal = 0;
                var totalQuantity = 0;
                var passedArray = <?php echo json_encode($nameArray); ?>;

                for (i=0; i<passedArray.length; i++) {
                    itemName = passedArray[i];
                    //console.log(itemName);
                    totalQuantity += parseInt(document.getElementById(itemName+"-quantity").value);
                    currentPrice = document.getElementById(productName+"-label").textContent;
                    currentPriceToNumber = parseInt(currentPrice.substring(8, currentPrice.length));
                    console.log(currentPriceToNumber);
                    subtotal += (parseInt(document.getElementById(itemName+"-quantity").value) * currentPriceToNumber);

                }
                console.log(subtotal);

                var label = "Total items: ";
                document.getElementById("l1").innerHTML = label + totalQuantity;
                var qst = (0.09975 * subtotal).toFixed(2);
                var gst = (0.05 * subtotal).toFixed(2);
                var FinalTotalPRice = parseFloat(subtotal) + parseFloat(qst) + parseFloat(gst);

                document.getElementById("l2").innerHTML = "Subtotal:" + subtotal;
                document.getElementById("l3").innerHTML = "Estimated QST(9.975%: $)" + qst;
                document.getElementById("l4").innerHTML = "Estimated GST(5%: $)" + gst;
                document.getElementById("l5").innerHTML = "total: $" + FinalTotalPRice.toFixed(2);
            }
        </script>
    </div>

<!-- FOOTER -->
        <div id="footer"></div>

  </body>

<!--	-->
<!--  <script>-->
<!--    function updateTotalItems(idToUse){-->
<!--      -->
<!--      var quantity1 = parseInt(document.getElementById("strawberries-quantity").value);-->
<!--      var quantity2 = parseInt(document.getElementById("oranges-quantity").value);-->
<!--      var quantity3 = parseInt(document.getElementById("grapes-quantity").value);-->
<!--      var quantity4 = parseInt(document.getElementById("Banana-quantity").value);-->
<!--      let totalItems = parseInt(quantity1 += quantity2 += quantity3 += quantity4);-->
<!--      -->
<!--      var label = "Total items: ";-->
<!--      document.getElementById("l1").innerHTML = label + totalItems;-->
<!--      var PriceLabel = "Price: $"-->
<!--      var Subtotal = 0;-->
<!--      -->
<!--      if(idToUse = strawberries){-->
<!--        -->
<!--        let unitPrice = 4.50;-->
<!--        var quantity = parseInt(document.getElementById("strawberries-quantity").value);-->
<!--        var itemTotalPrice = unitPrice * quantity;-->
<!--        Subtotal +=itemTotalPrice;-->
<!--        document.getElementById("strawberries-totalPrice").innerHTML = PriceLabel + itemTotalPrice;-->
<!--      }-->
<!--      if(idToUse = oranges){-->
<!--        let unitPrice = 5.75;-->
<!--        var quantity = parseInt(document.getElementById("oranges-quantity").value);-->
<!--        var itemTotalPrice = unitPrice * quantity;-->
<!--        Subtotal +=itemTotalPrice;-->
<!--        document.getElementById("oranges-totalPrice").innerHTML = PriceLabel + itemTotalPrice;-->
<!--      }-->
<!--      if(idToUse = grapes){-->
<!--        let unitPrice = 5;-->
<!--        var quantity = parseInt(document.getElementById("grapes-quantity").value);-->
<!--        var itemTotalPrice = unitPrice * quantity;-->
<!--        Subtotal +=itemTotalPrice;-->
<!--        document.getElementById("grapes-totalPrice").innerHTML = PriceLabel + itemTotalPrice;-->
<!--      }-->
<!--      if(idToUse = Banana){-->
<!--        let unitPrice = 3.75;-->
<!--        var quantity = parseInt(document.getElementById("Banana-quantity").value);-->
<!--        var itemTotalPrice = unitPrice * quantity;-->
<!--        Subtotal += itemTotalPrice;-->
<!--        document.getElementById("Banana-totalPrice").innerHTML = PriceLabel + itemTotalPrice;-->
<!--      }-->
<!--      var qst = (0.09975 * Subtotal).toFixed(2);-->
<!--      var gst = (0.05 * Subtotal).toFixed(2);-->
<!--      var FinalTotalPRice = parseFloat(Subtotal) + parseFloat(qst) + parseFloat(gst);-->
<!--      -->
<!--      document.getElementById("l3").innerHTML = "Estimated QST(9.975%: $)" + qst;-->
<!--      document.getElementById("l4").innerHTML = "Estimated GST(5%: $)" + gst;-->
<!--      document.getElementById("l5").innerHTML = "total: $" + FinalTotalPRice.toFixed(2);-->
<!--    }-->
<!--  </script>-->
<!-- <script>-->
<!--  function removeItem(btnParent){-->
<!---->
<!--    if(btnParent = oranges){-->
<!--      console.log(btnParent);-->
<!--      var divToRemove = document.getElementById("oranges");-->
<!--      divToRemove.parentNode.removeChild(divToRemove);-->
<!--    }-->
<!--    if(btnParent = strawberries){-->
<!--      console.log(btnParent);-->
<!--      var divToRemove = document.getElementById("oranges");-->
<!--      divToRemove.parentNode.removeChild(divToRemove);-->
<!--    -->
<!--    }-->
<!--    -->
<!--    if(btnParent = grapes){-->
<!--      console.log(btnParent);-->
<!--      var divToRemove = document.getElementById("grapes");-->
<!--      divToRemove.parentNode.removeChild(divToRemove);-->
<!--    -->
<!--    }-->
<!--    if(btnParent = Banana){-->
<!--      console.log(btnParent);-->
<!--      var divToRemove = document.getElementById("Banana");-->
<!--      divToRemove.parentNode.removeChild(divToRemove);-->
<!--    -->
<!--    }-->
<!---->
<!---->
<!--      -->
<!--    }-->
<!---->
<!---->
<!--  </script>-->
</html>
