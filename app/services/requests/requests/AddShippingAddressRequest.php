<?php declare(strict_types=1);

namespace app\services\requests\requests;

use app\enums\MailingCategory;
use app\enums\State;
use app\models\concretes\PostalAddress;
use app\models\concretes\User;
use app\models\concretes\Zipcode;
use app\services\requests\Request;
use Exception;

class AddShippingAddressRequest extends Request {

    private User $user;
    private PostalAddress $address;

    /**
     * @param User $user
     * @param string $street
     * @param string $city
     * @param string $stateCode
     * @param string $zipcodeString
     * @param string $mailingAddressCategory
     * @throws Exception
     */
    public function __construct (
        User $user,
        string $street,
        string $city,
        string $stateCode,
        string $zipcodeString,
        string $mailingAddressCategory
    ) {
        parent::__construct();
        $this->user = $user;
        $this->address = new PostalAddress(
            sanitize_input($street),
            sanitize_input($city),
            State::from(sanitize_input($stateCode)),
            new Zipcode(sanitize_input($zipcodeString)),
            MailingCategory::from(sanitize_input($mailingAddressCategory))
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