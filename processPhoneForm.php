<?php declare(strict_types=1);

use app\utils\Convert;
use app\models\concretes\CreditCard;
use app\models\concretes\EmailAddress;
use app\models\concretes\PostalAddress;
use app\models\concretes\StateClass;
use app\models\concretes\User;
use app\models\concretes\Zipcode;
use app\test\EntityGenerator;
use app\utils\SerialNumber;

if (empty(session_id())) {
    session_start();
}

require_once 'bootstrap.php';

$phone = null;
try {
    $phone = Convert::stringToPhone(sanitize_input($_POST['phone']));
} catch (Exception $e) {
    echo $e;
}
$user = unserialize($_SESSION['user']);
$users = unserialize($_SESSION['users']);
$user->setPhone($phone);
$users->searchById($user->getId())->setPhone($phone);
$_SESSION['user'] = serialize($user);
$_SESSION['users'] = serialize($users);

header("Location: userContactDetailsPage.php");
//header("Location: {$_SERVER['PHP_SELF']}");
exit();