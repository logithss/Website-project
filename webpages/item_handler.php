<?php
    $products = json_decode(file_get_contents("../JSON/products.json"));
    $users    = json_decode(file_get_contents("../JSON/users.json"));
    $orders   = json_decode(file_get_contents("../JSON/orders.json"));
//$_GET['url'])
    if(isset($_GET['type']) && isset($_GET['id'])){
        $type = $_GET['type'];
        $id   = $_GET['id'];
//        $previousURL = $_GET['url'];
    }

    function getItemIndex($type, $id): int{
        $list = $GLOBALS[$type.'s'];
        $i = 0;
        foreach ($list as $item){
            if($item->id == $id){
                return $i;
            }
            $i++;
        }
        return -1;
    }

    function getItem($type, $id): ?object{
        $list = $GLOBALS[$type.'s'];
        foreach ($list as $item){
            if($item->id == $id){
                return $item;
            }
        }
        return null;
    }

    function deleteItem($type, $id){

        $list = $GLOBALS[$type.'s'];
        unset($list[getItemIndex(''.$type, $id)]);

        $list = array_values($list);
        file_put_contents('../JSON/'.$type.'s.json', json_encode($list));

        echo 'deletion successful';

    }

    function setID(){

    }

//    header('Location : '.$previousURL);
?>