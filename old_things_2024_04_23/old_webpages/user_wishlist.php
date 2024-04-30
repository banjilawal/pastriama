<?php declare(strict_types=1);

namespace webpages;

//require_once 'user_home.php';

session_start();
if(session_id() == '') {
    session_start();
}


$title = '<title>Wishlist</title>';
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