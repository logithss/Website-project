<?php
    $products = json_decode(file_get_contents("../JSON/products.json"));

    if(isset($_GET['productID']) && isset($_GET['quantity']))
    {
        $id = $_GET['productID'];
        $quantity = $_GET['quantity'];

        if($quantity == 0) //remove product
        {
            foreach($products as $product)
            {
                if($product->id == $id)
                {
                    echo "Name: " . $product->productName;
                }
            }
        }
        else //edit
        {

        }
    }

?>