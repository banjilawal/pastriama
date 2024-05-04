<?php declare(strict_types=1);
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}
use app\templates\Dashboard;
use app\templates\HTMLSection;
use app\utils\Convert;




require_once '..\data_loader.php';

$email = null;
$password = null;
try {
    $email = Convert::stringToEmailAddress(sanitize_input($_POST['email']));
    $password = sanitize_input($_POST['password']);
} catch (Exception $e) { echo $e; }
//echo $email . ' , ' . $password;
$user = unserialize($_SESSION['users'])->searchByEmail($email);


if (is_null($user)) {
    echo nl2br('Incorrect login credentials.' . PHP_EOL);
} else {
    echo nl2br(PHP_EOL . 'FOUND' . PHP_EOL . $user . PHP_EOL);
    $_SESSION['user'] = serialize($user);

//
    echo nl2br(PHP_EOL . '$_SESSION[\'user\']' . ' array' . PHP_EOL);
    print_r($_SESSION['user']);

    echo HTMLSection::head('Welcome to Your Dashboard') . HTMLSection::navbar()
    . Dashboard::user($user) . HTMLSection::footer();

//    header("Location: ../userDashboard.php");
//    exit; // Ensure that subsequent code is n
}
//header("Location: ../userDashboard.php");
//exit; // Ensure that subsequent code is not executed
//$_SESSION['inventory'] = serialize($user);
//echo nl2br(PHP_EOL . print_r($_SESSION['user']) . PHP_EOL);
//echo print_r($_SESSION);
//echo print_r($_POST);//['user'];
//header("Location: ../userDashboard.php");
//exit; // Ensure that subsequent code is not executed

//$email = null;
//$password = null;
//try {
//    $email = Convert::stringToEmailAddress(sanitize_input($_POST['email']));
//} catch (Exception $e) {
//    echo $e;
//}
//try {
//    $password = sanitize_input($_POST['password']);
//} catch (Exception $e) {
//    echo $e;
//}
//echo nl2br($email . ' domain:' . $email->getDomain() . PHP_EOL);
//
//$users = unserialize($_SESSION['users']);
//$user = $users->searchByEmail($email);
//if (!is_null($user)) {
//    header("Location: userDashboard.php");
//    exit; // Ensure that subsequent code is not executed
//}
//else {
//    echo 'No user found';
//}

//$target = unserialize($_SESSION['user']);
//echo '<br>target:' . $target . '<br>' .PHP_EOL;
//foreach ($users->getItems() as $user) {
////    echo 'comparing ' . $user->getEmailAddress() . ' and ' . $email . '<br>' . PHP_EOL;
//    if ($user->getEmailAddress()->equals($email) === true) {
//        echo '\t' . $user->printName() . ' matches ' . $target->getEmailAddress() . '<br>' . PHP_EOL;
//    }
//}
//print_r(unserialize($_SESSION['users'])->getItems());
//echo 'could not find the user';
//$user = $users->searchByEmail($email);
//echo $user;
//print_r($users->getItems());

//echo nl2br(print_r($_POST) . ' ' . PHP_EOL);
//echo nl2br(print_r($_SESSION['users']) . ' ' . PHP_EOL);
//$user = $_SESSION['users']->searchByEmail($email);
//if (is_null($user)) {
//    throw new Exception('There is no account exists with email address ' . $email);
//}
//$_SESSION['user'] = serialize($user);
//echo $user;

//header("Location: userDashboard.php");
//exit; // Ensure that subsequent code is not executed