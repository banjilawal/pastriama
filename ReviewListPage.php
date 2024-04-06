<?php declare(strict_types=1);

require_once 'WebPage.php';

use app\models\lists\ReviewList;
use app\test\ListGenerator;

class ReviewListPage extends WebPage {
    private ReviewList $reviewList;

    public function __construct (ReviewList $reviewList, string $title) {
        parent::__construct($title);
        $this->reviewList = $reviewList;
    }

    public function getReviewList (): ReviewList {
        return $this->reviewList;
    }
}


$pastries = null;
try {
    $pastries = ListGenerator::pastryList(30);
} catch (Exception $e) {
}
echo 'total pastries:' . count($pastries->getItems()) . '<br>' . PHP_EOL;

$users = null;
try {
    $users = ListGenerator::userList(15);
} catch (Exception $e) {
}
echo 'total users:' . count($users->getItems()) . '<br>' . PHP_EOL;

$reviews = null;
try {
    $reviews = ListGenerator::reviewList($pastries, $users);
} catch (Exception $e) {}
echo 'number of reviews:' . count($reviews->getItems());

$page = new ReviewListPage($reviews, 'Pastry Reviews');
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
<main>
    <?php
    echo count($page->getReviewList()->getItems());
    echo $page->getReviewList()->toTable();
    ?>
</main>
<footer>
</footer>
</body>
</html>