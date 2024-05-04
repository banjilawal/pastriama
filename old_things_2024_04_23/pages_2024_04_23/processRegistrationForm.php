<?php declare(strict_types=1);

use app\utils\Convert;
use app\models\concretes\CreditCard;
use app\models\concretes\Email;
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

$firstname = null;
$lastname = null;
$birthdate = DateTime::createFromFormat('Y-m-d', '1978-01-01');
$phone = null;
$street = null;
$city = null;
$state = null;
$zipcode = null;
$vendor = null;
$nameOnCard = null;
$cardNumber = null;
$expirationMonth = null;
$expirationYear = null;
$cvn = null;
$email = null;
$password = null;
try {
    $firstname = sanitize_input($_POST['firstname']);
} catch (Exception $e) {
    echo $e;
}
try {
    $lastname = sanitize_input($_POST['lastname']);
} catch (Exception $e) {
    echo $e;
}
try {
    $phone = sanitize_input($_POST['phone']);
} catch (Exception $e) {
    echo $e;
}
try {
    $email = Convert::stringToEmailAddress(sanitize_input($_POST['email']));
} catch (Exception $e) {
    echo $e;
}
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
    $state = sanitize_input($_POST['state']);
} catch (Exception $e) {
    echo $e;
}
try {
    $zipcode = new Zipcode(sanitize_input($_POST['zipcode']));
} catch (Exception $e) {
    echo $e;
}
try {
    $vendor = sanitize_input($_POST['vendor']);
} catch (Exception $e) {
    echo $e;
}
try {
    $nameOnCard = sanitize_input($_POST['nameOnCard']);
} catch (Exception $e) {
    echo $e;
}
try {
    $cardNumber = sanitize_input($_POST['cardNumber']);
} catch (Exception $e) {
    echo $e;
}
try {
    $expirationMonth = sanitize_input($_POST['expirationMonth']);
} catch (Exception $e) {
    echo $e;
}
try {
    $expirationYear = sanitize_input($_POST['expirationYear']);
} catch (Exception $e) {
    echo $e;
}
try {
    $cvn = sanitize_input($_POST['cvn']);
} catch (Exception $e) {
    echo $e;
}
try {
    $password = sanitize_input($_POST['password']);
} catch (Exception $e) {
    echo $e;
}

$creditCard = null;
try {
    $creditCard = new CreditCard(
        EntityGenerator::nextCreditCardId(),
        $vendor,
        $nameOnCard,
        $cardNumber,
        DateTime::createFromFormat(
            'Y-m',
            $expirationYear . '-' . $expirationMonth
        ),
        $cvn
    );
} catch (Exception $e) {
    echo $e;
}

$postalAddress = new PostalAddress(
    $street,
    $city,
    new StateClass('MN'),
    $zipcode
);

$user = null;
try {
    $user = new User(
        SerialNumber::nextUserId(),
        $firstname,
        $lastname,
        EntityGenerator::someDateTime(
            DateTime::createFromFormat('Y-m-d', '1927-01-01'),
            DateTime::createFromFormat('Y-m-d', '2002-01-01')
        ),
        EntityGenerator::phone(),
        $email, //EntityGenerator::email($firstname, $lastname),
        $password,
        $postalAddress,
        $creditCard
    );
} catch (Exception $e) {
    echo $e;
}
$users = unserialize($_SESSION['users']);
$users->add($user);
$_SESSION['user'] = serialize($user);
$_SESSION['users'] = serialize($users);
header("userDashboard.php");