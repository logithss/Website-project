<?php
    include 'item_handler.php';

    $products = json_decode(file_get_contents("../JSON/products.json"));

    if(isset($_GET['id']) && isset($_GET['task']) && isset($_GET['url'])) {
        $id   = $_GET['id'];
        $task = $_GET['task'];
        $url  = $_GET['url'];
    }

    if($task == "delete") deleteItem("product", $GLOBALS['id']);
    if($task == "add")    addProduct();
    if($task == "edit")   editItem();

    function addProduct(){

    }

    function editItem(){

    }


//    function deleteItem(){
//        $id   = $GLOBALS['id'];
//
//        $list = $GLOBALS['products'];
//        unset($list[getItemIndex("product", $id)]);
//
//        $list = array_values($list);
//        file_put_contents('../JSON/products.json', json_encode($list));
//
//        echo 'deletion successful';
//
//    }

    header('Location: '.$url);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>EDIT ITEM PAGE</title>
</head>
<body></body>
</html>
