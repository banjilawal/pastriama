<?php declare(strict_types=1);
namespace {
    use app\models\catalogs\Inventory;
    use app\test\NewCatalogPopulator;
    use app\test\EntityGenerator;
    use app\test\ListGenerator;

    if (session_status() === PHP_SESSION_ACTIVE) {
        session_unset();
        session_destroy();
    }
    else {
        session_start();
    }

    require_once 'bootstrap.php';

    $product = null;
    $user = null;
    $review = null;
    $order = null;
    $products = null;
    $orders = null;
    $users = null;
    $reviews = null;
    $inventory = null;
    try {
        $products = ListGenerator::products(40);
        $inventory = NewCatalogPopulator::inventory($products);
        $users = ListGenerator::users(15);
        $reviews = ListGenerator::reviews($users, $products);
//        $orders = ListGenerator::orders($users);
    } catch (Exception $e) { echo $e; }
//    echo $inventory;
//    echo $users->getUsers();
//    echo $reviews->getReviews();
//    foreach ($users->getList() as $id => $user) {
//        echo nl2br($user->printName() . PHP_EOL . 'Shopping Cart' . PHP_EOL . $user->getCart() . PHP_EOL);
//    }

    $_SESSION['inventory'] = serialize($inventory);
    $_SESSION['users'] = serialize($users);
    $_SESSION['reviews'] = serialize($reviews);

//    try {
//        $product = EntityGenerator::product();
//        $user = EntityGenerator::user();
//        $review = EntityGenerator::review($user, $product);
//        $order = EntityGenerator::order($user);
    //    echo nl2br(
    //            'product:' . $review->product->getName()
    //            . 'reviewer:' . $review->getUser()->printName()
    //            . 'title: ' . $review->getTitle()
    //            . ' rating:' . $review->getRating()->name
    //            . ' comment:' . $review->getComment()
    //            . ' submitDate:' . $review->getSubmissionTime()->format(DATE_FORMAT) . PHP_EOL
    //    );
    //    if (is_null($review)) {echo 'null';} else { echo 'not null';}
//        $products = ListGenerator::products(19);
//        $users = ListGenerator::users(30);
//        $reviews = ListGenerator::reviews($users, $products);
//    } catch (Exception $e) { echo $e; }
//
//    $inventory = Inventory::getInstance();
//    foreach ($products->getItems() as $item) {
//        try {
//            $inventory->add($item, rand(1, DEFAULT_RESTOCK_QUANTITY));
//        } catch (Exception $e) { echo $e; }
//    }
//    echo println('number of products in inventory: ' . count($inventory->getItems()));
//    try {
//        $users = ListGenerator::shoppingCarts($users);
//    } catch (Exception $e) { echo $e; }
//
//    foreach ($users->getLIst() as $id => $user) {
//    //    echo println($user->printName() . '\'s ' . $user->getCart());
//        try {
//            $order = EntityGenerator::order($user);
//        } catch (Exception $e) { echo $e; }
//        echo $order;
//    }
//
//
//    //echo nl2br('' . $products . PHP_EOL . $users . PHP_EOL . $reviews);
//    echo nl2br($product . PHP_EOL . $user . PHP_EOL. $review . PHP_EOL . $user->getCart() . PHP_EOL);
}