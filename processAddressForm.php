<?php declare(strict_types=1);

use app\utils\Convert;
use app\models\concretes\CreditCard;
use app\models\concretes\EmailAddress;
use app\models\concretes\PostalAddress;
use app\models\concretes\State;
use app\models\concretes\User;
use app\models\concretes\Zipcode;
use app\test\EntityGenerator;
use app\utils\SerialNumber;

if (empty(session_id())) {
    session_start();
}

require_once 'bootstrap.php';

$street = null;
$city = null;
$state = null;
$zipcode = null;
$primaryAddress = null;

try {
    $street = 'MN'; //sanitize_input($_POST['street']);
} catch (Exception $e) {
    echo $e;
}
try {
    $city = sanitize_input($_POST['city']);
} catch (Exception $e) {
    echo $e;
}
try {
    $state = new State(sanitize_input($_POST['state']));
} catch (Exception $e) {
    echo $e;
}
try {
    $zipcode = new Zipcode(sanitize_input($_POST['zipcode']));
} catch (Exception $e) {
    echo $e;
}

$postalAddress = new PostalAddress($street, $city, $state, $zipcode);
$user = unserialize($_SESSION['user']);
$user->getShippingAddresses()->add($postalAddress);


$users = unserialize($_SESSION['users']);
unserialize($_SESSION['user'])->getShippingAddresses()->add(new PostalAddress($street, $city, $state, $zipcode)); //= serialize($user);
$_SESSION['users'] = serialize($users);
header("userDashboard.php");