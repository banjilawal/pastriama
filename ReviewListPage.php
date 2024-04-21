<?php declare(strict_types=1);

require_once 'WebPage.php';

use app\models\lists\Reviews;
use app\test\ListGenerator;

class ReviewListPage extends WebPage {
    private Reviews $reviewList;

    public function __construct (Reviews $reviewList, string $title) {
        parent::__construct($title);
        $this->reviewList = $reviewList;
    }

    public function getReviewList (): Reviews {
        return $this->reviewList;
    }
}


$pastries = null;
try {
    $pastries = ListGenerator::pastries(30);
} catch (Exception $e) {
}
echo 'total pastries:' . count($pastries->getList()) . '<br>' . PHP_EOL;

$users = null;
try {
    $users = ListGenerator::users(15);
} catch (Exception $e) {
}
echo 'total users:' . count($users->getList()) . '<br>' . PHP_EOL;

$reviews = null;
try {
    $reviews = ListGenerator::reviews($pastries, $users);
} catch (Exception $e) {}
echo 'number of reviews:' . count($reviews->getList());

$page = new ReviewListPage($reviews, 'Pastry Reviews');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="styles.css"/>
    <title>
        <?php echo $page->getTitle(); ?>
    </title>
</head>
<body>
<header>
</header>
<main>
    <?php
    echo count($page->getReviewList()->getList());
    echo $page->getReviewList()->toTable();
    ?>
</main>
<footer>
</footer>
</body>
</html>