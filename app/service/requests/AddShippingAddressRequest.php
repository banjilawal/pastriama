<?php declare(strict_types=1);

namespace app\service\requests;

use app\models\concretes\PostalAddress;
use app\models\concretes\State;
use app\models\concretes\User;
use app\models\concretes\Zipcode;
use app\processors\Process;
use app\services\requests\Request;
use DateTime;
use Exception;

class AddShippingAddressRequest extends Request {
    publi const ADRRES_CATEGORIES = ['primary', 'billing',]
    private User $user;
    private PostalAddress $address;
    private string $category;


    /**
     * @param User $user
     * @throws Exception
     */
    public function __construct (User $user, string $street, string $city, string $statePostalCode,  string $zipcodeString) {
        parent::__construct();
        $this->user = $user;
        $this->address = new PostalAddress(
            sanitize_input($street),
            sanitize_input($city),
            new State(sanitize_input($statePostalCode)),
            new Zipcode(sanitize_input($zipcodeString))
        );
    }

    public function getUser (): User {
        return $this->user;
    }

    public function getAddress (): PostalAddress {
        return $this->address;
    }
}
//$user = $_SESSION['user'];
//$address = $_POST['address'];
//$nameOnCard = $_POST['name'];
//
//$request = new AddShippingAddressRequest($user, $address);
//try {
//    Process::addShippingAddress($request);
//} catch (Exception $e) {
//    echo 'Add credit card request failed ' . $e;
//}