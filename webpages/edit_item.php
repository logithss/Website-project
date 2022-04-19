<?php
    include 'item_handler.php';

    $products = json_decode(file_get_contents("../JSON/products.json"));
    $users    = json_decode(file_get_contents("../JSON/users.json"));
    $orders   = json_decode(file_get_contents("../JSON/orders.json"));

    //Delete item (product, order, user)
    if(isset($_GET['delete']) && isset($_GET['type']) && isset($_GET['id'])){
        deleteItem($_GET['type'], $_GET['id']);
    }
    //Delete order item (product specific to the order)
    if(isset($_GET['delete']) && isset($_GET['orderID']) && isset($_GET['productID'])){
        $list = $GLOBALS['orders'];
        $orderItems = getItem('order', $_GET['orderID'])->items;
        $i = 0;
        $itemFound = false;
        foreach ($orderItems as $item){
            if(!$itemFound){
                if($item->id == $_GET['productID']){
                    $itemFound = true;
                    unset($orderItems[$i]);
                    $orderItems = array_values($orderItems);
                    getItem('order', $_GET['orderID'])->items = $orderItems;
                    file_put_contents('../JSON/orders.json', json_encode($list));
                }
                $i++;
            }
        }
        $_GET['url'] = $_GET['url'] . '&id=' . $_GET['orderID'];
    }

//  ORDERS-------
    if(isset($_POST['save-changes-order'])){ //EDIT
        $list = $GLOBALS['orders'];
        $itemToEdit = getItem('order', $_GET['orderID']);
        if(!empty($_POST['order-id'])){
            $itemToEdit->id = $_POST['order-id'];
        }
        if(!empty($_POST['order-type'])){
            $isDelivery = $_POST['order-type'] == "Delivery";
            $itemToEdit->isDelivery = $isDelivery;
        }
        file_put_contents('../JSON/orders.json', json_encode($list));
    }

    if(isset($_POST['save-changes-order-add'])){ //ADD ORDER
        $ordersArray = json_decode(file_get_contents("../JSON/orders.json"), true);
        $isDelivery = $_POST['order-type'] == "Delivery";
        print_r($ordersArray);
        var_dump($isDelivery);
        $ordersArray[] = ['id' => $_POST['order-id'], 'isDelivery' => $isDelivery, 'items' => array()];
        file_put_contents('../JSON/orders.json', json_encode($ordersArray));
    }

    if(isset($_POST['add-order-item'])){ //ADD ORDER ITEM
        $item_id  = $_POST['item-id'];
        $quantity = $_POST['item-quantity'];
        $order_id = $_GET['orderID'];
        getItem('order', $order_id)->items[] = array("id" => $item_id, "quantity" => $quantity);
        file_put_contents('../JSON/orders.json', json_encode($GLOBALS['orders']));
        $_GET['url'] = $_GET['url'] . '&id=' . $_GET['orderID'];
    }

//  PRODUCTS-----
    if(isset($_POST['save-changes-product'])){
        $list = $GLOBALS['products'];
        $itemToEdit = getItem('product', $_GET['orderID']);
        if(!empty($_POST['order-id'])){
            $itemToEdit->id = $_POST['order-id'];
        }
        if(!empty($_POST['order-type'])){
            $isDelivery = $_POST['order-type'] == "Delivery";
            $itemToEdit->isDelivery = $isDelivery;
        }
        file_put_contents('../JSON/orders.json', json_encode($list));
    }

    if(isset($_POST['save-changes-product-add'])){

    }

    if(isset($_GET['url'])) header('Location: '.$_GET['url']);

?>