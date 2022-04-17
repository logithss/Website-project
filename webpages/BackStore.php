<?php
$products = json_decode(file_get_contents("../JSON/products.json"));
$users    = json_decode(file_get_contents("../JSON/users.json"));
$orders   = json_decode(file_get_contents("../JSON/orders.json"));

function printProducts(){
    foreach ($GLOBALS['products'] as $product) {
        addProduct($product);
    }
}

function printUsers(){
    foreach ($GLOBALS['users'] as $user) {
        addUser($user);
    }
}

function printOrders(){
    foreach ($GLOBALS['orders'] as $order) {
//        addOrder($order);
    }
}

function addProduct($product){
    $productName = $product->productName;
    $imgPath = $product->img_path;
    $quantity = $product->quantity;
    $availability = "In stock";
    $color = "#009927";
    if($quantity == 0){
        $availability = "Out of stock";
        $color = "#b42e3b";
    }
    $price = $product->price;
    echo '<div class="product">';
    echo '    <div class="product-info">';
    echo '        <div class="product-img">';
    echo '             <img src="'.$imgPath.'">';
    echo '        </div>';
    echo '        <div class="product-middle">';
    echo '            <div class="product-label">';
    echo '                <div class="product-name">'.$productName.'</div>';
    echo '                <div class="product-price">'.$price.'$</div>';
    echo '                <div class="product-quantity">Qt: '.$quantity.'</div>';
    echo '            </div>';
    echo '            <div class="product-btns">';
    echo '                <button class ="edit-product-btn" onclick="changeEditContent(\'product\')">Edit</button>';
    echo '                <button class ="delete-btn delete-product-btn" onClick="alertDeletion(\''.$product->id.'\')">Delete</button>';
    echo '            </div>';
    echo '        </div>';
    echo '        <div class="product-availability" style="color:'.$color.'">'.$availability.'</div>';
    echo '    </div>';
    echo '</div>';
}

function addUser($user){
    echo '<div class="user">';
    echo '    <div class="user-profile">';
    echo '        <span class="user-icon material-icons-outlined">person_outline</span>';
    echo '        <div class="user-name">'.$user->firstName.' '.$user->lastName.'</div>';
    echo '    </div>';
    echo '    <div class="user-btns">';
    echo '        <button href="./BackStore.php?type=user&id='.$user->id.'" class ="edit-user-btn" onclick="changeEditContent(\'user\')">Edit user</button>';
    echo '        <button class ="delete-btn delete-user-btn onClick="alertDeletion(\''.$user->id.'\')"">Delete user</button>';
    echo '    </div>';
    echo '</div>';
}

function addOrder($order){

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
            <a class="tab inventory-tab" onclick="changeMainContent('product')" >
                <h1><span class="tab-icon material-icons-outlined">
                        inventory</span>
                    Inventory
                </h1>
            </a>
            <a class="tab user-tab" onclick="changeMainContent('user')">
                <h1>
                    <span class="tab-icon material-icons-outlined">
                        portrait
                    </span>
                    Users
                </h1>
            </a>
            <a class="tab order-tab" onclick="changeMainContent('order')">
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
                <button class="add-product-btn">
                    <div class="add-product-img">
                        <img class="box-img" src ="https://icon-library.com/images/inventory-icon-png/inventory-icon-png-17.jpg" >
                        <img class="plus-img" src="https://img.icons8.com/ios-glyphs/30/000000/plus-math.png"/>
                    </div>
                    <h3>Add a new product</h3>
                </button>
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
                <button class="add-user-btn">
                    <span class="add-person-icon material-icons-outlined">
                    person_add
                    </span>
                    Add new User
                </button>
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
                <button class="add-order-btn">
                <span class="material-icons-outlined">
                    note_add
                </span>
                    <h3>Add a new order</h3>
                </button>
                <ul class="unordered-list" id="ul-order">
                <div class="order">
                    <div class="order-icon">
                <span class="material-icons-outlined">
                receipt_long
            </span>
                    </div>
                    <div class="order-id">
                        <h3>Order id: </h3>
                        123456
                    </div>
                    <div class="order-btns">
                        <button class ="edit-order-btn" onclick="changeEditContent('order')">Edit</button>
                        <button class ="delete-order-btn">Delete</button>
                    </div>
                </div>
            </div>
            <div class="edit-container">
                <div class="edit edit-order-container">
                    <div class="field num-field">
                        <div class="previous-value">
                            (Current: 123456)
                        </div>
                        <input type="number" placeholder="Order id (6 digits)" class="user-input num-input">
                    </div>
                    <div class="order-type" >
                        <select>
                            <option value="" disabled selected>Order type</option>
                            <option value="Pickup">Pickup</option>
                            <option value="Delivery">Delivery</option>
                        </select>
                    </div>
                    <button class="save-changes-btn">
                        Save changes
                    </button>
                </div>
                <div class="edit edit-product-container">
                    <div id="product-name" class="field txt-field">
                        <div class="previous-value">
                            (Current: Apple)
                        </div>
                        <input type="text" placeholder="Product name" class="user-input txt-input">
                    </div>
                    <div id="unit-price" class="field txt-field">
                        <div class="previous-value">
                            (Current: 1.99$)
                        </div>
                        <input type="number" placeholder="Unit price" class="user-input num-input">
                    </div>
                    <div id="quantity" class="field txt-field">
                        <div class="previous-value">
                            (Current: 100)
                        </div>
                        <input type="number" placeholder="Quantity" class="user-input num-input">
                    </div>
                    <div id="item-description" class="field txt-field">
                        <div class="field-title">Description:</div>
                        <textarea placeholder="Product description" class="user-input description-input" oninput='this.style.height = "";this.style.height = this.scrollHeight + "px"'></textarea>
                    </div>
                    <div id="upload-image-container" class="field txt-field">
                        <div class="field-title">Change image:</div>
                        <img class="image-box" src="https://i.stack.imgur.com/x3KMH.jpg">
                    </div>
                    <button class="save-changes-btn">
                        Save changes
                    </button>
                </div>
                <div class="edit edit-user-container">
                    <div id="user-firstname" class="field txt-field">
                        <div class="previous-value">
                            (Current: Ismail)
                        </div>
                        <input type="text" placeholder="First name" class="user-input txt-input">
                    </div>
                    <div id="user-lastname" class="field txt-field">
                        <div class="previous-value">
                            (Current: Feham)
                        </div>
                        <input type="text" placeholder="Last name" class="user-input txt-input">
                    </div>
                    <div id="user-email" class="field txt-field">
                        <div class="previous-value">
                            (Current: ismailfeham@gmail.com)
                        </div>
                        <input type="text" placeholder="Email address" class="user-input txt-input">
                    </div>
                    <div id="user-location-address" class="field txt-field">
                        <div class="previous-value">
                            (Current: 124 Conch St., Bikini Bottom)
                        </div>
                        <input type="text" placeholder="Home address" class="user-input txt-input">
                    </div>
                    <button class="save-changes-btn">
                        Save changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="footer"></div>
<?php
//if($filtered){
//    echo '<script>changeMainContent("'.$type.'")</script>';
//}
?>

</body>
</html>
