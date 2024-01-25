<?php declare(strict_types=1);
    require_once 'bootstrap.php';
    //session_start();
    //
    //require_once 'vendor\autoload.php';

    use app\global\SerialNumberGenerator;
    use app\models\concretes\CreditCard;
    use app\models\Concretes\Domain;
    use app\models\concretes\EmailAddress;
    use app\models\Concretes\Pastry;
    use App\Models\Concretes\Phone;
    use App\Models\Concretes\PostalAddress;
    use App\Models\Concretes\State;
    use app\models\concretes\User;
    use app\models\concretes\Zipcode;
    use app\models\lists\PastryList;

    //const USER_PAGE_ROOT = 'app\webpages\user';
    //$page = USER_PAGE_ROOT . DIRECTORY_SEPARATOR . 'user_home.php';

    //$serialNumber = SerialNumberGenerator::getInstance();
//
//
//    $firstname = 'john';
//    $lastname = 'madeira';
//    $phone = new Phone('865', '309', '2020');
//    //$pastry0 = new Pastry(0, 'donut', 'a classic', 'donut.jpg', 1.99);
//    $email = new EmailAddress(($firstname . '.' . $lastname), new Domain('wargame', 'com'));
//    $postalAddress = new PostalAddress('2020 Clearview Ave', 'Manzikert', new State('IA'), new Zipcode('12345') );
//    $creditCard = null;
//    try {
//        $creditCard = new CreditCard(1, '0123-4567-8910-9870', new DateTime('2027-06-01'), '206');
//    } catch (Exception $e) { }
    //echo 'phone' . $phone . '<br>' . PHP_EOL;
    //echo 'pastry:' . $pastry . '<br>' . PHP_EOL;
    //echo 'email:' . $email . '<br>' . PHP_EOL;
    //echo 'mailing address:' . $postalAddress . '<br>' . PHP_EOL;
    //echo 'credit card:' . $creditCard . '<br>' .  PHP_EOL;

    //$creditCard
    //$user = new User(
    //    1, //$serialNumber->nextUserId(),
    //    $firstname,
    //    $lastname,
    //    new DateTime('1978-06-25'),
    //    $phone,
    //    $email,
    //    'p',
    //    $postalAddress
    //);
    $user = null;
    try {
        $user = RandomUserBuilder::getInstance()->createUser();
    } catch (Exception $e) {
    }


    $pastries = new PastryList();
    //$pastry1 = new Pastry(1,
    //    'Glazed Ginger-Almond Donut',
    //    'We have a fresh take of the glazed donut with our barrel aged ginger extract sourced locally
    //        with hints of almond that does not overwhelm the honey.',
    //    ASSETS . '\1.jpg',
    //    1.99);
    try {
        $pastries->add(
            new Pastry(1,
                'Raspberry Filled Donut',
                'Raspberry with an almond and vanilla infusion inside. Powdered sugar outside.',
                '..\assets\1.jpg',
                1.99)
        );
    } catch (Exception $e) {}
    try {
        $pastries->add(
            new Pastry(2,
            'Glazed Ginger-Almond Donut',
            'We have a fresh take of the glazed donut with our barrel aged ginger extract sourced locally 
            with hints of almond that does not overwhelm the honey.',
            '..\assets\2.jpg',
            2.99)
        );
    } catch (Exception $e) {}
    try {
        $pastries->add(
            new Pastry(
                3,
                'croissant',
                'Our croissants are made from buttery filo dough. Baked into delicate flakes that melt in your mouth',
                '..\assets\3.jpg',
                3.99)
        );
    } catch (Exception $e) {}
    try {
        $pastries->add(
            new Pastry(4,
                'Olive Savory Croissant',
                'Olives in a mushroom reduction and pesto make this a wonderful treat',
                '..\assets\4.jpg',
                4.99)
        );
    } catch (Exception $e) {}
    try {
        $pastries->add(
            new Pastry(
                5,
                'brandy and ginger cheesecake',
                'Our Zagat five star cheesecake',
                '..\assets\5.jpg',
                5.99)
        );
    } catch (Exception $e) {}

    $_SESSION['pastries'] = serialize($pastries);

    #echo 'from Index' . '<br>' . PHP_EOL . $user . '<br>' .PHP_EOL;
    //echo PHP_EOL . 'session save path: ' . ini_get('session.save_path') . PHP_EOL . PHP_EOL;

    $serialized_user = serialize($user);
    $_SESSION['user'] = $serialized_user;
    $_SESSION['firstname'] = $user->getFirstname();
    header('Location: webpages\user_home.php');
    exit();