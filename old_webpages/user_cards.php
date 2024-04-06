<?php declare(strict_types=1);

namespace webpages;

session_start();
if(session_id() == '') {
    session_start();
}

$title = '<title>Payment Methods</title>';
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
</main>
<footer>
</footer>
</body>
</html>