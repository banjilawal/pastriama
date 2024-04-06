<?php declare(strict_types=1);

namespace webpages;

use app\test\EntityGenerator;

 = new EntityGenerator()->$pastry;

$title = '<title>This is the search</title>';
$heading = '<h1>Search</h1>';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php echo $title ?>
</head>
<body>
<header>
</header>
<main>
    <?php echo $heading; ?>
    <input type="search" id="Search" name="search" />
</main>
<footer>
</footer>
</body>
</html>