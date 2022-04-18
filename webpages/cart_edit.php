<?php

    session_start();
    $products = $_SESSION["cart"];

    if(isset($_REQUEST['productID']) && isset($_REQUEST['quantity']))
    {
        $id = $_GET['productID'];
        $quantity = $_GET['quantity'];

        $productFound = false;
        foreach($products as $product)
        {
            if($product->id == $id)
            {
                if($quantity <= 0){
                    unset($product);
                }
                else
                {
                    if($quantity > 0)
                    {
                        $product["quantity"] = $quantity;
                    }
                }
                $productFound = true;
                break;
            }
        }

        if($productFound == false)
        {
            $newProduct = [];
            $newProduct["productID"] = $_REQUEST['productID'];
            $newProduct["quantity"] = $_REQUEST['quantity'];

            push_array($_SESSION["cart"], $newProduct);
        }
    }

    print_r();

    if(isset($_REQUEST['previousURL']))
    {
        //header('Location: '. $_REQUEST['previousURL']);
    }
    else
    {
        //header('Location: '. "./index.html");
    }

?>