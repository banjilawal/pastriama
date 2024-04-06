<?php declare(strict_types=1);

require_once 'WebPage.php';

use app\models\lists\PastryList;
use app\test\ListGenerator;

class PastryListPage extends WebPage {
    private PastryList $pastryList;

    public function __construct (PastryList $pastryList, string $title) {
        parent::__construct($title);
        $this->pastryList = $pastryList;
    }

    public function getPastryList (): PastryList {
        return $this->pastryList;
    }
}

$pastries = null;
try {
    $pastries = ListGenerator::pastryList(30);
} catch (Exception $e) {}




$page = new PastryListPage($pastries, 'Test Pastries');



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
    echo $page->getPastryList()->toTable();
    ?>
</main>
<footer>
</footer>
</body>
</html>