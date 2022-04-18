<?php

    session_start();
    $products = $_SESSION["cart"];

    if(isset($_GET['productID']) && isset($_GET['quantity']))
    {
        $id = $_GET['productID'];
        $quantity = $_GET['quantity'];

        $selectedProduct = 0;
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
            }
        }

        $newProduct["id"] = $selectedProduct["id"]
                        $newProduct["productName"] = $selectedProduct["productName"]
                        $newProduct["quantity"] = $selectedProduct["quantity"]
                        $newProduct["aisle"] = $selectedProduct["aisle"]
                        $newProduct["price"] = $selectedProduct["price"]
                        $newProduct["sale_prc"] = $selectedProduct["sale_prc"]
                        $newProduct["description"] = $selectedProduct["description"]
                        $newProduct["img_path"] = $selectedProduct["img_path"]
    }

?>