<?php declare(strict_types=1);
//if (session_status() != PHP_SESSION_ACTIVE) {
//    session_start();
//}

namespace pages;
//require_once 'WebPage.php';

use app\models\lists\Pastries;

class PastryListPage extends \WebPage {
    private Pastries $pastryList;

    public function __construct (Pastries $pastryList, string $title) {
        parent::__construct($title);
        $this->pastryList = $pastryList;
    }

    public function getPastryList (): Pastries {
        return $this->pastryList;
    }
}

$pastries = null;
//$user = null;
//try {
//    $user = EntityGenerator::user();
//} catch (Exception $e) {
//    echo $e;
//}


//try {
//    $pastries = ListGenerator::pastryList(60);
//} catch (Exception $e) {}
//$page = new PastryListPage($pastries, 'Test Pastries');
//
//$_SESSION['pastries'] = serialize($pastries);

//foreach($pastries->getItems() as $pastry) {
//    echo $pastry . PHP_EOL;
//}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
<!--    <link rel="stylesheet" href="styles.css"/>-->
    <title>
        <?php echo $page->getTitle(); ?>
    </title>
    <style>
        body {
            background-color: #E2FFEE;
            /*border-style: groove;*/
            /*border-color: darkblue;*/
            /*border-width: 10px;*/
        }

        table , th, td {
            border: 1px solid grey;
        }
    </style>
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