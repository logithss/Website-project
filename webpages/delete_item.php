<?php
$products = json_decode(file_get_contents("../JSON/products.json"));
$users    = json_decode(file_get_contents("../JSON/users.json"));
$orders   = json_decode(file_get_contents("../JSON/orders.json"));

if(isset($_GET['type']) && isset($_GET['id'])) {
    $type = $_GET['type'];
    $id   = $_GET['id'];
//    $task = $_GET['task'];
}

//if($task == "delete")
    deleteItem();
//if($task == "edit")   editItem();

function deleteItem(){
    $type = $GLOBALS['type'];
    $id   = $GLOBALS['id'];
    if($type == "product") $list = $GLOBALS['products'];
    if($type == "user")    $list = $GLOBALS['users'];
    if($type == "order")   $list = $GLOBALS['orders'];

    $i = 0;
    foreach($list as $item){
        if($item->id == $id){
            echo $item->productName;
            unset($list[$i]);
        }
        $i++;
    }

    $list = array_values($list);
    file_put_contents('../JSON/'.$type.'s.json', json_encode($list));
    echo 'Item successfully deleted.';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>EDIT ITEM PAGE</title>
</head>
