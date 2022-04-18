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


//    function deleteItem($type){
//        $id   = $GLOBALS['id'];
//
//        $list = $GLOBALS[''.$type.'s'];
//        unset($list[getItemIndex(''.$type, $id)]);
//
//        $list = array_values($list);
//        file_put_contents('../JSON/'.$type.'s.json', json_encode($list));
//
//        echo 'deletion successful';
//
//    }

    header('Location: '.$url);

?>
