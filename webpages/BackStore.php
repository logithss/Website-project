<?php
include 'item_handler.php';
$url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$products = json_decode(file_get_contents("../JSON/products.json"));
$users    = json_decode(file_get_contents("../JSON/users.json"));
$orders   = json_decode(file_get_contents("../JSON/orders.json"));
$isEditing = false;
$change_content = false;
$add = false;
$base_url = 'http://homeymarket.epizy.com/webpages/BackStore.php';

if(isset($_GET['type']) && isset($_GET['id'])){
    $add_button_text = 'Submit Changes';
    $type = $_GET['type'];
    $id   = $_GET['id'];
    $itemToEdit = getItem($type, $id);
    $isEditing = true;
}

if(isset($_GET['add']) && $_GET['type']){
    $add_button_text = 'Add ' . $_GET['type'];
    $type = $_GET['type'];
    $add = true;
}

if(isset($_GET['content'])){
    $change_content = true;
    $content = $_GET['content'];
}

function printProducts(){
    foreach ($GLOBALS['products'] as $product) {
        insertProduct($product);
    }
}

function printUsers(){
    foreach ($GLOBALS['users'] as $user) {
        insertUser($user);
    }
}

function printOrders(){
    foreach ($GLOBALS['orders'] as $order) {
        insertOrder($order);
    }
}

function printOrderItems($order){
    foreach($order->items as $item){
        $product = getItem("product", $item->id);
    echo '<div class="product">';
    echo '    <div class="product-info">';
    echo '        <div class="product-img">';
    echo '             <img src="'.$product->img_path.'">';
    echo '        </div>';
    echo '        <div class="product-middle">';
    echo '            <div class="product-label">';
    echo '                <div class="product-name">'.$product->productName.'</div>';
    echo '                <div class="product-price">'.$product->price.'$</div>';
    echo '                <div class="product-quantity">Qt: '.$item->quantity.'</div>';
    echo '            </div>';
    echo '            <div class="product-btns">';
    echo '                <button class ="delete-btn delete-product-btn" style="width: unset"
                                onClick="deleteOrderItem(\''.$order->id.'\',\''.$product->id.'\')">Delete</button>';
    echo '            </div>';
    echo '        </div>';
    echo '        <div class="product-availability"> </div>';
    echo '    </div>';
    echo '</div>';
    }
}

function insertProduct($product){
    $quantity = $product->quantity;
    $availability = "In stock";
    $color = "#009927";
    if($quantity == 0){
        $availability = "Out of stock";
        $color = "#b42e3b";
    }
    echo '<div class="product">';
    echo '    <div class="product-info">';
    echo '        <div class="product-img">';
    echo '             <img src="'.$product->img_path.'">';
    echo '        </div>';
    echo '        <div class="product-middle">';
    echo '            <div class="product-label">';
    echo '                <div class="product-name">'.$product->productName.'</div>';
    echo '                <div class="product-price">'.$product->price.'$</div>';
    echo '                <div class="product-quantity">Qt: '.$quantity.'</div>';
    echo '            </div>';
    echo '            <div class="product-btns">';
    echo '                <button class ="edit-product-btn" onclick="redirectEdit(\'product\', \''.$product->id.'\')">Edit</button>';
    echo '                <button class ="delete-btn delete-product-btn" 
                                onClick="alertDeletion(\'product\',\''.$product->id.'\',\''.$product->productName.'\')">Delete</button>';
    echo '            </div>';
    echo '        </div>';
    echo '        <div class="product-availability" style="color:'.$color.'">'.$availability.'</div>';
    echo '    </div>';
    echo '</div>';
}

function insertUser($user){
    echo '<div class="user">';
    echo '    <div class="user-profile">';
    echo '        <span class="user-icon material-icons-outlined">person_outline</span>';
    echo '        <div class="user-name">'.$user->firstName.' '.$user->lastName.'</div>';
    echo '    </div>';
    echo '    <div class="user-btns">';
    echo '        <button  class ="edit-user-btn" onclick=
                  "redirectEdit(\'user\', \''.$user->id.'\')">Edit user</button>';
    echo '        <button class ="delete-btn delete-user-btn" 
                       onClick="alertDeletion(\'user\',\''.$user->id.'\',\''.$user->firstName.' '.$user->lastName.'\')">Delete user</button>';
    echo '    </div>';
    echo '</div>';
}

function insertOrder($order){
    echo '<div class="order">';
    echo '    <div class="order-icon">';
    echo '        <span class="material-icons-outlined">';
    echo '          receipt_long';
    echo '        </span>';
    echo '    </div>';
    echo '    <div class="order-id">';
    echo '        <h3>Order id:</h3>';
    echo '         '.$order->id;
    echo '    </div>';
    echo '    <div class="order-btns">';
    echo '        <button class ="edit-order-btn" 
                          onclick="redirectEdit(\'order\', \''.$order->id.'\')">Edit</button>';
    echo '        <button class ="delete-order-btn" 
                          onclick="alertDeletion(\'order\',\''.$order->id.'\',\'Order: '.$order->id.'\')">Delete</button>';
    echo '    </div>';
    echo '</div>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>BACKSTORE</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../resources/stylesheet/backstore-mainstyle.css">
    <link rel="stylesheet" href="../resources/stylesheet/backstore-editstyle.css">
    <link rel="stylesheet" href="../resources/stylesheet/backstore-users.css">
    <link rel="stylesheet" href="../resources/stylesheet/backstore-inventory-list.css">
    <link rel="stylesheet" href="../resources/stylesheet/backstore-orders.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../resources/stylesheet/header-footer.css">
    <meta name ="viewport" content="width-device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="../JS/backstore.js"></script>
</head>
<body>
<div id="header"></div>
<div class="container">
    <div class = "content">
        <div class="nav-bars">
            <a class="current-tab"><button id="current-button" onclick="toggleTabsVisibility()">Inventory</button></a>
            <a class="tab inventory-tab" onclick="redirectContent('product')" >
                <h1><span class="tab-icon material-icons-outlined">
                        inventory</span>
                    Inventory
                </h1>
            </a>
            <a class="tab user-tab" onclick="redirectContent('user')">
                <h1>
                    <span class="tab-icon material-icons-outlined">
                        portrait
                    </span>
                    Users
                </h1>
            </a>
            <a class="tab order-tab" onclick="redirectContent('order')">
                <h1>
                    <span class="tab-icon material-icons-outlined">
                        list_alt
                    </span>
                    Orders
                </h1>
            </a>
            <a class="tab settings-tab disable" >
                <h1><span class="tab-icon material-icons-outlined">
                        settings
                        </span>
                    Settings
                </h1>
            </a>
        </div>
        <div class="main-content">
            <div id="content-title">
                Inventory
            </div>
            <div class="list product-list">
                <div class="search-box">
                    <input id="search-product" class="search-txt" type="text" onkeyup="filterItems('product')" placeholder="Search by product name">
                    <a class="search-btn">
                        <span class="search-icon material-icons-outlined">
                            search
                        </span>
                    </a>
                </div>
                <a href="BackStore.php?type=product&add=1">
                    <button class="add-product-btn">
                    <div class="add-product-img">
                        <img class="box-img" src ="https://icon-library.com/images/inventory-icon-png/inventory-icon-png-17.jpg" >
                        <img class="plus-img" src="https://img.icons8.com/ios-glyphs/30/000000/plus-math.png"/>
                    </div>
                    <h3>Add a new product</h3>
                </button></a>
                <ul class="unordered-list" id="ul-product">
                    <?=printProducts()?>
                </ul>
            </div>
            <div class="list user-list">
                <div class="search-box">
                    <input id="search-user" class="search-txt" type="text" onkeyup="filterItems('user')" placeholder="Search by user name">
                    <a class="search-btn" href="#">
                        <span class="search-icon material-icons-outlined">
                            search
                        </span>
                    </a>
                </div>
                <a href="BackStore.php?type=user&add=1">
                    <button class="add-user-btn">
                    <span class="add-person-icon material-icons-outlined">
                    person_add
                    </span>
                    Add new User
                    </button>
                </a>
                <ul class="unordered-list" id="ul-user">
                    <?=printUsers()?>
                </ul>
            </div>
            <div class="list order-list">
                <div class="search-box">
                    <input id="search-order" class="search-txt" type="text" onkeyup="filterItems('order')" placeholder="Search by order ID">
                    <a class="search-btn" href="#">
                        <span class="search-icon material-icons-outlined">
                            search
                        </span>
                    </a>
                </div>
                <a href="BackStore.php?type=order&add=1">
                    <button class="add-order-btn">
                    <span class="material-icons-outlined">
                    note_add
                    </span>
                        <h3>Add a new order</h3>
                    </button>
                </a>
                <ul class="unordered-list" id="ul-order">
                    <?=printOrders()?>
            </div>
            <div class="edit-container">
                <div class="edit edit-product-container">
                    <form id="form-product" action="edit_item.php?id=<?=$itemToEdit->id?>&url=<?=$base_url?>" method="post"></form>
                    <div class="edit-select-container">
                        <select name="aisle-type" form="form-order">
                            <option value="" disabled selected>Aisle:</option>
                            <?php
                                $aisles = array("Fruit", "Vegetable", "Bakery", "Meat", "Snacks", "Dairy");
                                foreach ($aisles as $aisle){
                                    $selected = "";
                                    if($itemToEdit->aisle == strtolower($aisle))$selected = "selected=\"selected\"";
                                    echo '<option value="'.$aisle.'"'.$selected.'">'.$aisle.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div id="product-name" class="field txt-field">
                        <label for="product-name" class="field-title">Product name:</label>
                        <input name="product-name" type="text" placeholder="<?=$itemToEdit->productName?>"
                               class="user-input txt-input" form="form-product">
                    </div>
                    <div id="unit-price" class="field txt-field">
                        <label for="product-price" class="field-title">Product price:</label>
                        <input name="product-price" type="number" placeholder="<?=$itemToEdit->price?>"
                               class="user-input num-input" form="form-product">
                    </div id="unit-price">
                    <div id="quantity" class="field txt-field">
                        <label for="quantity" class="field-title">Quantity:</label>
                        <input type="number" name="quantity" placeholder="<?= $itemToEdit->quantity ?>"
                               class="user-input num-input" form="form-product">
                    </div>
                    <div id="item-description" class="field txt-field">
                        <label for="description" class="field-title">Description:</label>
                        <textarea name="description" placeholder="<?= $itemToEdit->description ?>"
                                  class="user-input description-input" oninput='this.style.height = "";
                              this.style.height = this.scrollHeight + "px"' form="form-product"></textarea>
                    </div>
                    <div id="image-url" class="field txt-field">
                        <label for="image-url" class="field-title">Image url:</label>
                        <input type="url" name="image-url" placeholder="<?= $itemToEdit->img_path?>"
                               class="user-input num-input" form="form-product">
                    </div>
                    <div class="error-txt" style="display: none">Error Submitting. Make sure all fields have valid inputs.</div>
                    <input type="submit" name="save-changes-product<?php if($add) echo '-add';?>"
                           value="<?=$add_button_text?>" class="save-changes-btn" form="form-product">
                </div>
                <div class="edit edit-user-container">
                    <form id="form-user" action="edit_item.php?id=<?=$itemToEdit->id?>&url=<?=$base_url?>" method="post"></form>
                    <div id="user-firstname" class="field txt-field">
                        <label for="first-name" class="field-title">First name:</label>
                        <input type="text" name="first-name" placeholder="<?=$itemToEdit->firstName?>"
                               class="user-input txt-input" form="form-user">
                    </div>
                    <div id="user-lastname" class="field txt-field">
                        <label for="last-name" class="field-title">Last name:</label>
                        <input type="text" name="last-name" placeholder="<?=$itemToEdit->lastName?>"
                               class="user-input txt-input" form="form-user">
                    </div>
                    <div id="user-email" class="field txt-field">
                        <label for="email" class="field-title">Email address:</label>
                        <input type="text" name="email" placeholder="<?=$itemToEdit->email?>"
                               class="user-input txt-input" form="form-user">
                    </div>
                    <div id="user-zipcode" class="field txt-field">
                        <label for="zipcode" class="field-title">Zip code:</label>
                        <input type="text" name="zipcode" placeholder="<?=$itemToEdit->zipcode?>"
                               class="user-input txt-input" form="form-user">
                    </div>
                    <div id="user-admin" class="field txt-field">
                        <label for="isAdmin" class="field-title">Is Administrator?</label>
                        <input type="checkbox" name="isAdmin" checked="<?php if($itemToEdit->isAdmin)echo 'checked';?>"
                               class="checkbox-input" form="form-user">
                    </div>
                    <div class="error-txt" style="display: none">Error Submitting. Make sure all fields have valid inputs.</div>
                    <input type="submit" name="save-changes-users<?php if($add) echo '-add';?>" class="save-changes-btn"
                           value="<?=$add_button_text?>" form="form-user">
                </div>
                <div class="edit edit-order-container">
                    <form id="form-order" action="edit_item.php?orderID=<?=$itemToEdit->id?>&url=<?=$base_url?>?content=order"
                          method="post"></form>
                    <?php
                        if(!$add){
                            echo'<form id="form-add-order-item" 
                            action="edit_item.php?orderID='.$itemToEdit->id.'&url='.$base_url.'?type=order&id='.$itemToEdit->id.'"method="post">';
                            echo '</form>';
                        }
                    ?>
                    <div class="field num-field">
                        <label for="order-id" class="field-title">Order id:</label>
                        <input name="order-id" type="number" placeholder="<?=$itemToEdit->id?>"
                               class="user-input num-input" form="form-order">
                    </div>
<!--                ADD PRODUCT FUNCTIONALITY-->
                    <?php
                        if(!$add){
                            echo '<div class="field add-order-item-container">';
                            echo '    <label for="order-id" class="field-title">Add Product:</label>';
                            echo '    <div class="add-order-item-box">';
                            echo '    <label for="order-id" class="field-title">P_ID: </label>';
                            echo '    <input name="item-id" type="number" placeholder="Product ID"
                                        class="user-input num-input" form="form-add-order-item">';
                            echo '    <label for="order-id" class="field-title">Qt: </label>';
                            echo '    <input name="item-quantity" type="number" placeholder="Quantity"
                                        class="user-input num-input" form="form-add-order-item">';
                            echo '    <input type="submit" name="add-order-item" value="Add Item" id="add-order-item-btn"
                                        class="save-changes-btn" form="form-add-order-item">';
                            echo '</div>';
                            echo '</div>';
                        }
                    ?>
                    <div class="order-items-container">
                        <ul class="order-items">
                            <?=printOrderItems($itemToEdit)?>
                        </ul>
                    </div>
                    <div class="edit-select-container">
                            <select name="order-type" form="form-order">
                                <option value="" disabled selected>Order type</option>
                                <?php
                                    if($itemToEdit->isDelivery){
                                        echo '<option value="Pickup">Pickup</option>';
                                        echo '<option value="Delivery" selected="selected">Delivery</option>';
                                    }else{
                                        echo '<option value="Pickup" selected="selected">Pickup</option>';
                                        echo '<option value="Delivery">Delivery</option>';
                                    }
                                ?>
                             </select>
                    </div>
                    <div class="error-txt" style="display: none">Error Submitting. Make sure all fields have valid inputs.</div>
                        <input type="submit" name="save-changes-order<?php if($add) echo '-add';?>"
                               value="<?=$add_button_text?>" class="save-changes-btn" form="form-order">
                </div>
            </div>
        </div>
    </div>
</div>
<div id="footer"></div>

<script>
    <?php
        if($isEditing){
            $title = "";
            if($type == "product") $title = $itemToEdit->productName;
            if($type == "user")    $title = $itemToEdit->firstName.' '.$itemToEdit->lastName;
            if($type == "order")   $title = 'Order id: '.$itemToEdit->id;
            echo 'changeEditContent("'.$type.'", "'.$title.'");';
        }
        if($add){
            echo 'changeEditContent("'.$type.'", "Adding new '.$type.'");';
        }
        if($change_content){
            echo 'changeMainContent("'.$content.'");';
        }
    ?>
    function alertDeletion(type, id, name) {
        let text = 'Are you sure you want to delete this ' + type + ': ' + name + '?';
        let content = '?content=' + type;
        if(type === 'product') content = '';
        if (confirm(text)){
                window.location = 'http://homeymarket.epizy.com/webpages/edit_item.php?'
                    + 'delete=1&id=' +id + '&type=' + type
                    + '&url=http://homeymarket.epizy.com/webpages/BackStore.php'+content;
        }
    }
    function deleteOrderItem(orderID, productID) {
        let text = 'Are you sure you want to delete this order item?';
        if (confirm(text)){
            window.location = 'http://homeymarket.epizy.com/webpages/edit_item.php?'
                + 'delete=1&orderID=' + orderID + '&productID=' + productID
                + '&url=http://homeymarket.epizy.com/webpages/BackStore.php?type=order';
        }
    }
    function redirectContent(content){
        window.location.href = 'http://homeymarket.epizy.com/webpages/BackStore.php?content='+ content;
    }

    function redirectEdit(type, id){
        window.location.href = 'http://homeymarket.epizy.com/webpages/BackStore.php?type='+ type + '&id=' + id;
    }
</script>
</body>
</html>
