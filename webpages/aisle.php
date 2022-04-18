<?php
//    Opening the json file
    $jsonProducts = file_get_contents("../JSON/products.json");
    $products = json_decode($jsonProducts);

//    Initializing variables
    if(isset($_GET['aisle'])) {
        $aisle = $_GET['aisle'];
    }
    if(isset($_GET['sort'])) {
        $sort_type = $_GET['sort'];
        $sort_order = $_GET['order'];
        sortProducts();
    }

    function printProducts(){
        foreach ($GLOBALS['products'] as $product) {
            if ($product->aisle == $GLOBALS['aisle']){
                addProduct($product);
            }
        }
    }

    function sortProducts(){
        usort($GLOBALS['products'], function($a, $b){
            global $sort_type, $sort_order;
            if($sort_type == "name"){
                if($sort_order == "increasing"){
                    return strcmp($a->productName, $b->productName);}
                else{return strcmp($b->productName, $a->productName);}
            }
            if($sort_type == "price"){
                if($sort_order == "increasing"){
                    return int_cmp($a->price, $b->price);}
                else{return int_cmp($b->price, $a->price);}
            }return 0;
        });
    }

    function int_cmp($a,$b){
        return ($a-$b) ? ($a-$b)/abs($a-$b) : 0;
    }
    function addProduct($product){
        $productName = $product->productName;
        $imgPath = $product->img_path;
        $price = $product->price;
        $priceOnSale = $product->sale_prc;
        $finalPrice = $price * (1 - $priceOnSale/100);
        echo '<li>';
        echo '    <a class ="item-anchor" href="./aisle.php?aisle=fruit&sort=name&order=increasing">';
        echo '        <div class="item">';
        echo '            <img class="product-image" src="'.$imgPath.'">';
        echo '            <h3>'.$productName.'</h3>';
        echo '            <h2>'.number_format($finalPrice, 2).'$</h2>';
        echo '            <div class="quantity">';
        echo '                <button class="btn minus-btn disabled" type="button">-</button>';
        echo '                <input type="text" value="1" id="'.$productName.'">';
        echo '                <button class="btn plus-btn" type="button">+</button>';
        echo '            </div>';
        echo '           <button class="add_button">';
        echo '                Add to Cart';
        echo '            </button>';
        echo '      </div>';
        echo '    </a>';
        echo '</li>';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../resources/stylesheet/aisles.css">
    <meta name ="viewport" content="width-device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Nunito&display=swap"rel="stylesheet"/>
    <title><?=strtoupper(substr($aisle, 0,1)) . substr($aisle,1,strlen($aisle))?> Aisle</title>
    <!-- JS for header/footer -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $(function () {
            $('#header').load('header.html');
            $('#footer').load('footer.html');
        });
    </script>

</head>

<body>

<!-- HEADER -->
<div id="header"></div>
<section class="aisle-header">
    <img class="aisle-banner-image" src="../resources/img/banners/<?=$aisle?>_banner.png">
    <div class="aisle-title"><?=strtoupper(substr($aisle, 0,1)) . substr($aisle,1,strlen($aisle))?></div>
</section>
<div class="container">
    <div class="aisle_sorting">
        <div class="sort-select">
            <select id="sort-box" onchange="location = this.value;">
                <option value="./aisle.php?aisle=<?=$aisle?>"
                        id="default">Default:</option>
                <option value="./aisle.php?aisle=<?=$aisle?>&sort=name&order=increasing"
                        id="name-inc">Name (A -> Z)</option>
                <option value="./aisle.php?aisle=<?=$aisle?>&sort=name&order=decreasing"
                        id="name-dec">Name (Z -> A)</option>
                <option value="./aisle.php?aisle=<?=$aisle?>&sort=price&order=increasing"
                        id="price-inc">Price (Low > High)</option>
                <option value="./aisle.php?aisle=<?=$aisle?>&sort=price&order=decreasing"
                        id="price-dec">Price (High > Low)</option>
            </select>
        </div>
        <div id="sort-text">
            Sort By:
        </div>
    </div>
    <ul class="product-list">
        <?php
            printProducts();
        ?>
    </ul>
</div>

<!-- FOOTER -->
<div id="footer"></div>
<script src="../JS/aisles.js"></script>
<script>
    function updateSort(type, order){
        let newValue = "./aisle.php?aisle=<?=$aisle?>"
        if(type === "name"){
            if(order === "increasing")
                newValue = "./aisle.php?aisle=<?=$aisle?>&sort=name&order=increasing"
            else newValue = "./aisle.php?aisle=<?=$aisle?>&sort=name&order=decreasing"
        }if(type === "price"){
            if(order === "increasing")
                newValue = "./aisle.php?aisle=<?=$aisle?>&sort=price&order=increasing"
            else newValue = "./aisle.php?aisle=<?=$aisle?>&sort=price&order=decreasing"
        }
        document.getElementById('sort-box').value = newValue;
    }
</script>
<?php
    if(isset($_GET['sort'])){
        echo    '<script>',
                'updateSort("'.$sort_type.'","'.$sort_order.'");',
                '</script>';}
?>
</body>
</html>