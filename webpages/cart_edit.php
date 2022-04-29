<?php

    session_start();

    if(isset($_REQUEST['unset']))
    {
        unset($_SESSION["cart"]);
    }

    if(!isset($_SESSION["cart"]))
    {
        echo "wasn't set";
        $_SESSION["cart"] = array();
    }

    $products = $_SESSION["cart"];

    echo "previous: ";
    print_r($products);

    if(isset($_REQUEST['productID']) && isset($_REQUEST['quantity']))
    {
        $id = $_REQUEST['productID'];
        $quantity = $_REQUEST['quantity'];

        $productFound = false;


        if(isset($_SESSION["cart"][$id]))
        {
            if($quantity > 0)
            {
                $_SESSION["cart"][$id]["quantity"] = $quantity;
            }
            else
            {
                unset($_SESSION["cart"][$id]);
            }
        }
        else if($quantity > 0)
        {
            echo "<br><br> product is NOT found <br><br>";
            $newProduct = [];
            $newProduct["productID"] = $id;
            $newProduct["quantity"] = $quantity;
            $_SESSION["cart"][$id] = $newProduct;
        }
    }

    echo "<br>current: ";
    print_r($_SESSION["cart"]);

    if(isset($_REQUEST['previousURL']))
    {
        if($_REQUEST['previousURL'] != "stay"){
            echo "go to previous";
            header('Location: '. $_REQUEST['previousURL']);
        }
    }
    else
    {
        echo "go to home page";
        header('Location: '. "./index.html");
    }

?>