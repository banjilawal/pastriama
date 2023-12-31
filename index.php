<?php declare(strict_types=1);
require_once 'vendor\autoload.php';

use App\Mdels\Concretes\Zipcode;
use App\models\Concretes\Domain;
use App\models\Concretes\EmailAddress;
use App\Models\Concretes\Pastry;
use App\Models\Concretes\Phone;
use App\Models\Concretes\PostalAddress;
use App\Models\Concretes\State;

$phone = new Phone('865', '309', '2020');
$pastry = new Pastry(1, 'donut', 'a classic', 'donut.jpg', 1.99);
$email = new EmailAddress('gerund_snow', new Domain('yellowsnow', 'com'));
$postalAddress = new PostalAddress('2020 CLearview Ave', 'MAnzikert', new State('IA'), new Zipcode('12345') );

echo $phone  . PHP_EOL;
echo $pastry . PHP_EOL;
echo $email . PHP_EOL;
echo $postalAddress . PHP_EOL;