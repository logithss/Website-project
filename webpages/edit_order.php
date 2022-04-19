<?php
    include 'item_handler.php';

    $orders   = json_decode(file_get_contents("../JSON/orders.json"));

    if(isset($_GET['id']) && isset($_GET['task']) && isset($_GET['url'])) {
        $id   = $_GET['id'];
        $task = $_GET['task'];
        $url  = $_GET['url'];
    }

    if($task == "delete") deleteItem("order", $GLOBALS['id']);
    if($task == "add")    addProduct();
    if($task == "edit")   editItem();

//  ORDERS-------
    if(isset($_POST['save-changes-order-add'])){ //ADD

        echo $_POST['order-id'];
        echo '<br>';
        echo $_GET['orderID'];
        echo '<br>';
        echo $_POST['order-type'];
        header('Location: '.$_GET['url']);
    }

    if(isset($_POST['save-changes-order'])){ //EDIT
        echo $_POST['order-id'];
        echo '<br>';
        echo $_GET['orderID'];
        echo '<br>';
        echo $_POST['order-type'];
        header('Location: '.$_GET['url']);
    }



?>
