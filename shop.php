<?php

require "database.php";

if (!tableExists($conn, "shop")) {
    createShopTable($conn);
}

$live_cycle = array();
//Our list of $items in the shop.

$items = array(
    "feather" => array(
        "count" => 3,
        "price" => 0.4
        ),
    "bone" => array(
        "count" => 5,
        "price" => 1.1
        ),
    "heart" => array(
        "count" => 1,
        "price" => 3.2
        ),
    "jar" => array(
        "count" => 3,
        "price" => 0.2
        ),
    "ash" => array(
        "count" => 26,
        "price" => 0.1
        ),
    "virgin blood" => array(
        "count" => 1,
        "price" => 6.2
        ),
    "chicken blood" => array(
        "count" => 3,
        "price" => 0.7
        ),
    "arcane dust" => array(
        "count" => 11,
        "price" => 0.9
        ),
    "eye" => array(
        "count" => 3,
        "price" => 0.2
        ),
    "skull" => array(
        "count" => 1,
        "price" => 1.2
        ),
    "femor" => array(
        "count" => 1,
        "price" => 0.7
        ),
    "newt" => array(
        "count" => 3,
        "price" => 0.4
        ),
    "claw" => array(
        "count" => 3,
        "price" => 0.2
        ),
    "spiders leg" => array(
        "count" => 1,
        "price" => 0.1
        ),
);
    // Fetch itemList
$itemList = getShop($conn);
// Check if an item list existed at all
if ($itemList == false) {
    // There were no rows in the table so we need to pass an argument to use INSERT rather than UPDATE
    newCycle($items, $new = true ,$conn);
} 
// An item list existed, but is it time to create a new one?
else {
    if (time("now") - $itemList["timestamp"] > 5) {
        // There was a table so we need to pass an argument to use UPDATE rather than INSERT
        newCycle($items, $new = false, $conn);
    } 
    // Valid List found
    else {
        $_SESSION["shop"] = unserialize($itemList["items"]);
    }
}



//Create new Random Cycle
function newCycle($items, $new, $conn){
    
    $new_cycle = array();

    for ($i = 1; $i<=count($items); $i++) {
        /**
         * If we havent added 7 items to the array yet AND the array_key is 
         * NOT present in our cycle add the key to $new_cycle
         */
        $randomKey = array_rand($items);

        if ($i <= 7 && !array_key_exists($randomKey, $new_cycle)) {
            $new_cycle[$randomKey] = $items[$randomKey];
        }

        
    }
    // Save new cycle and current time stamp;
    saveShop($conn, serialize($new_cycle), time("now"), $new);
    $_SESSION["shop"] = $new_cycle;

}

$live_cycle = $_SESSION["shop"];
?> 

<!DOCTYPE html>
<html>
<head>
    <title>Shop</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

        
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-default">
    </nav>
    <div class="container">
        <h1 class="page-title">
            
          Shop
        </h1>
        
        <table class="table table-striped">
        <?php foreach ($live_cycle as $key => $value) : ?>
            <tr>
                <td><?php echo $key ?></td>
            <?php foreach ($value as $i => $j) : ?>
                <td><?php echo $i." : ".$j; ?></td>
            <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        </table>
        
        
    </div>
</body>
</html>


