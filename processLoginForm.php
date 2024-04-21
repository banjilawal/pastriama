<?php declare(strict_types=1);

use app\requests\requests\LoginRequest;
use app\service\responses\Response;

if (empty(session_id())) {
    session_start();
}

require_once 'bootstrap.php';

$user = null;
//$request = new LoginRequest($_POST['email'], $_POST['email']);
try {
    $user = Response::login(unserialize($_SESSION['users']), new LoginRequest($_POST['email'], $_POST['password']));
} catch (Exception $e) {
    echo $e;
}
$_SESSION['user'] = serialize($user);
header("Location: userDashboard.php");
exit; // Ensure that subsequent code is not executed

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