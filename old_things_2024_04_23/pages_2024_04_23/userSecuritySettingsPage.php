<?php declare(strict_types=1);
if (empty(session_id())) {
    session_start();
}

require_once 'bootstrap.php';

$user = unserialize($_SESSION['user']);
$pageTitle = 'Manage Your Postal Addresses and Phone Number ' . $user->printName();

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
        <table id="telephoneTable">
            <tr id="telephoneRow">
                <td>Your login</td>
                <td> <?php echo $user->getEmailAddress(); ?></td>
            </tr>
        </table>
    </div>
    <div>
        <h2>Change Your Password</h2>
        <form id="changePassWordForm" method="post" action="processPasswordChangeForm.php">
           <p>
               <label for="oldPassword"></label>
               <input type="password" id="oldPassword" size="30" required>
           </p>
            <p>
                <label for="newPassword"></label>
                <input type="password" id="newPassword" size="30" required>
            </p>
            <p>
                <label for="confirmPassword"></label>
                <input type="password" id="confirmPassword" size="30" required>
            </p>
            <input type="submit" value="Submit">
        </form>
    </div>
</main>
<footer>
</footer>
</body>
</html>