<?php
include 'item_handler.php';
$url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$products = json_decode(file_get_contents("../JSON/products.json"));
$users    = json_decode(file_get_contents("../JSON/users.json"));
$orders   = json_decode(file_get_contents("../JSON/orders.json"));
$isEditing = false;
$change_content = false;
$add = false;

if(isset($_GET['type']) && isset($_GET['id'])){
    $type = $_GET['type'];
    $id   = $_GET['id'];
    $itemToEdit = getItem($type, $id);
    $isEditing = true;
}

if(isset($_GET['add']) && $_GET['type']){
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
                                onClick="someFunction()">Delete</button>';
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
                  "redirectEdit(\'user\', \''.$user->firstName.' '.$user->lastName.'\')">Edit user</button>';
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
                <div class="edit edit-order-container">
                    <div class="field num-field">
                        <label for="order-id" class="field-title">Order id:</label>
                        <form><input name="order-id" type="number" placeholder="<?=$itemToEdit->id?>" class="user-input num-input"></form>
                    </div>
                    <ul class="order-items">
                        <?=printOrderItems($itemToEdit)?>
                    </ul>
                    <div class="order-type">
                        <form><label>
                                <select name="order-type">
                                        <option value="" disabled selected>Order type</option>
                                        <option value="Pickup">Pickup</option>
                                        <option value="Delivery">Delivery</option>
                                    </select>
                        </label></form>
                    </div>
                    <div class="error-txt" style="display: none">Error Submitting. Make sure all fields have valid inputs.</div>
                    <form>
                        <button name="save-changes" class="save-changes-btn">Save changes</button>
                    </form>
                </div>
                <div class="edit edit-product-container">
                    <div id="product-name" class="field txt-field">
                        <label for="product-name" class="field-title">
                            Product name:
                        </label>
                        <form><input name="product-name" type="text" placeholder="<?=$itemToEdit->productName?>" class="user-input txt-input"></form>
                    </div>
                    <div id="unit-price" class="field txt-field">
                        <label for="product-price" class="field-title">
                            Product price:
                        </label>
                        <form><input name="product-price" type="number" placeholder="<?=$itemToEdit->price?>" class="user-input num-input"></form>
                    </div id="unit-price">
                    <div id="quantity" class="field txt-field">
                        <label for="quantity" class="field-title">
                            Quantity:
                        </label>
                        <form><input type="number" name="quantity" placeholder="<?= $itemToEdit->quantity ?>"
                                     class="user-input num-input"></form>
                    </div>
                    <div id="item-description" class="field txt-field">
                        <label for="description" class="field-title">Description:</label>
                        <form><textarea name="description" placeholder="<?= $itemToEdit->description ?>"
                              class="user-input description-input" oninput='this.style.height = "";
                              this.style.height = this.scrollHeight + "px"'></textarea>
                        </form>
                    </div>
                    <div id="image-url" class="field txt-field">
                        <label for="image-url" class="field-title">Change image:</label>
                        <form><input type="url" name="image-url" placeholder="<?= $itemToEdit->img_path?>"
                                     class="user-input num-input"></form>
                    </div>
                    <div class="error-txt" style="display: none">Error Submitting. Make sure all fields have valid inputs.</div>
                    <button class="save-changes-btn">
                        Save changes
                    </button>
                </div>
                <div class="edit edit-user-container">
                    <div id="user-firstname" class="field txt-field">
                        <label for="first-name" class="field-title">
                            First name:
                        </label>
                        <input type="text" name="first-name" placeholder="<?=$itemToEdit->firstName?>" class="user-input txt-input">
                    </div>
                    <div id="user-lastname" class="field txt-field">
                        <label for="last-name" class="field-title">
                            Last name:
                        </label>
                        <input type="text" name="last-name" placeholder="<?=$itemToEdit->lastName?>" class="user-input txt-input">
                    </div>
                    <div id="user-email" class="field txt-field">
                        <label for="email" class="field-title">
                            Email address:
                        </label>
                        <input type="text" name="email" placeholder="<?=$itemToEdit->email?>" class="user-input txt-input">
                    </div>
                    <div id="user-location-address" class="field txt-field">
                        <label for="address" class="field-title">
                            Home address:
                        </label>
                        <input type="text" name="address" placeholder="<?=$itemToEdit->address?>" class="user-input txt-input">
                    </div>
                    <div class="error-txt" style="display: none">Error Submitting. Make sure all fields have valid inputs.</div>
                    <button class="save-changes-btn">
                        Save changes
                    </button>
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
                window.location = 'http://homeymarket.epizy.com/webpages/edit_'+
                    type + '.php?task=delete&id='+id+
                    '&url=http://homeymarket.epizy.com/webpages/BackStore.php'+content;
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
