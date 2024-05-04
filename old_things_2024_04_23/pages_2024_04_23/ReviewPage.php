<?php declare(strict_types=1);

namespace old_things_2024_04_23\pages_2024_04_23;
require_once 'bootstrap.php';
require_once 'WebPage.php';

use app\models\concretes\review;
use app\test\ListGenerator;


class ReviewPage extends WebPage {

    private review $review;

    public function __construct (review $review) {
        parent::__construct($review->getTitle());
        $this->review = $review;
    }

    public function getReview (): review {
        return $this->review;
    }
}

$lists = null;
try {
    $lists = ListGenerator::lists(30, 60);
} catch (Exception $e) {
    echo $e;
}
//$pastry = $lists['pastries']->getItems()[array_rand($lists['pastries']->getItems())];
$review = $lists['reviews']->getItems()[array_rand($lists['reviews']->getItems())];
$page = new ReviewPage($review);

//
//$pastries = null;
//try {
//    $pastries = ListGenerator::pastryList(30);
//} catch (Exception $e) {
//}
//echo 'Number of pastries:' . count($pastries->getItems()) . '<br>' . PHP_EOL;
//
//$users = null;
//try {
//    $users = ListGenerator::userList(15);
//} catch (Exception $e) {
//}
//echo 'Number of users:' . count($users->getItems()) . '<br>' . PHP_EOL;
//////$index = array_rand($users->getItems());
//$user = $users->searchById(array_rand($users->getItems())); //$index);
//$pastry = $pastries->getItems()[(array_rand($pastries->getItems()))];
////
//
//$reviews = null;
//try {
//    $reviews = ListGenerator::reviewList($pastries, $users);
//} catch (Exception $e) {
//}
//$review = $reviews->getItems()[(array_rand($reviews->getItems()))];
//try {
//    $review = EntityGenerator::review($user, $pastry);
//} catch (Exception $e) {
//}

$page = new ReviewPage($review);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../styles.css"/>
    <title>
        <?php echo $page->getTitle(); ?>
    </title>
</head>
<body>
<header>
</header>
<?php echo '<h1>' . $page->getTitle() . '</h1>'; ?>
<main>
    <?php
    echo $page->getReview()->toTable();
    ?>
</main>
<footer>
</footer>
</body>
</html>