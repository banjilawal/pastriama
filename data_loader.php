<?php declare(strict_types=1);
namespace {
    use app\models\catalogs\NewInventory;
    use app\test\NewCatalogPopulator;
    use app\test\NewEntityGenerator;
    use app\test\NewListGenerator;

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
    $users = null;
    $reviews = null;
    $inventory = null;
    try {
        $inventory = NewCatalogPopulator::inventory(NewListGenerator::products(10));
    } catch (Exception $e) { echo $e; }
//    echo $inventory;

    $_SESSION['inventory'] = serialize($inventory);
//    try {
//        $product = NewEntityGenerator::product();
//        $user = NewEntityGenerator::user();
//        $review = NewEntityGenerator::review($user, $product);
//        $order = NewEntityGenerator::order($user);
    //    echo nl2br(
    //            'product:' . $review->product->getName()
    //            . 'reviewer:' . $review->getUser()->printName()
    //            . 'title: ' . $review->getTitle()
    //            . ' rating:' . $review->getRating()->name
    //            . ' comment:' . $review->getComment()
    //            . ' submitDate:' . $review->getSubmissionTime()->format(DATE_FORMAT) . PHP_EOL
    //    );
    //    if (is_null($review)) {echo 'null';} else { echo 'not null';}
//        $products = NewListGenerator::products(19);
//        $users = NewListGenerator::users(30);
//        $reviews = NewListGenerator::reviews($users, $products);
//    } catch (Exception $e) { echo $e; }
//
//    $inventory = NewInventory::getInstance();
//    foreach ($products->getItems() as $item) {
//        try {
//            $inventory->add($item, rand(1, DEFAULT_RESTOCK_QUANTITY));
//        } catch (Exception $e) { echo $e; }
//    }
//    echo println('number of products in inventory: ' . count($inventory->getItems()));
//    try {
//        $users = NewListGenerator::shoppingCarts($users);
//    } catch (Exception $e) { echo $e; }
//
//    foreach ($users->getLIst() as $id => $user) {
//    //    echo println($user->printName() . '\'s ' . $user->getCart());
//        try {
//            $order = NewEntityGenerator::order($user);
//        } catch (Exception $e) { echo $e; }
//        echo $order;
//    }
//
//
//    //echo nl2br('' . $products . PHP_EOL . $users . PHP_EOL . $reviews);
//    echo nl2br($product . PHP_EOL . $user . PHP_EOL. $review . PHP_EOL . $user->getCart() . PHP_EOL);
}