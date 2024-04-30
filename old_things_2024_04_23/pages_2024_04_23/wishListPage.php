<?php declare(strict_types=1);
if (empty(session_id())) {
    session_start();
}

require_once 'bootstrap.php';

$user = unserialize($_SESSION['user']);
$pageTitle = 'Manage Your Wish List ' . $user->printName();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../../styles.css"/>
    <title>
        <?php echo $pageTitle; ?>
    </title>
</head>
<body>
<header>
</header>
<?php echo '<h1>' . $pageTitle . '</h1>'; ?>
<main>
    <div>
        <h2> <?php echo $user->getWishes(); ?> </h2>
    </div>
</main>
<footer>
</footer>
</body>
</html>