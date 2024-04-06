<?php declare(strict_types=1);

require_once 'bootstrap.php';
require_once 'WebPage.php';

use app\models\concretes\Review;
use app\test\EntityGenerator;
use app\test\ListGenerator;


class ReviewPage extends WebPage {

    private Review $review;

    public function __construct (Review $review) {
        parent::__construct($review->getTitle());
        $this->review = $review;
    }

    public function getReview (): Review {
        return $this->review;
    }
}

$pastries = null;
try {
    $pastries = ListGenerator::pastryList(30);
} catch (Exception $e) {
}
echo 'Number of pastries:' . count($pastries->getItems()) . '<br>' . PHP_EOL;

$users = null;
try {
    $users = ListGenerator::userList(15);
} catch (Exception $e) {
}
echo 'Number of users:' . count($users->getItems()) . '<br>' . PHP_EOL;
////$index = array_rand($users->getItems());
$user = $users->searchById(array_rand($users->getItems())); //$index);
$pastry = $pastries->getItems()[(array_rand($pastries->getItems()))];
//

$reviews = null;
try {
    $reviews = ListGenerator::reviewList($pastries, $users);
} catch (Exception $e) {
}
$review = $reviews->getItems()[(array_rand($reviews->getItems()))];
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