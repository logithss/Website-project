<?php
    include 'item_handler.php';

    $users    = json_decode(file_get_contents("../JSON/users.json"));

    if(isset($_GET['id']) && isset($_GET['task']) && isset($_GET['url'])) {
        $id   = $_GET['id'];
        $task = $_GET['task'];
        $url  = $_GET['url'];
    }

    if($task == "delete") deleteItem("user", $GLOBALS['id']);
    if($task == "add")    addProduct();
    if($task == "edit")   editItem();


//    function deleteItem(){
//        $id   = $GLOBALS['id'];
//
//        $list = $GLOBALS['users'];
//        unset($list[getItemIndex("user", $id)]);
//
//        $list = array_values($list);
//        file_put_contents('../JSON/users.json', json_encode($list));
//
//        echo 'deletion successful';
//
//    }

    header('Location: '.$url);
?>


?>
