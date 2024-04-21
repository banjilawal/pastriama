<?php declare(strict_types=1);
namespace app\requests\requests;

use app\models\concretes\EmailAddress;
use app\services\requests\Request;
use app\utils\Convert;
use Exception;

class LoginRequest extends Request {
    private EmailAddress $email;
    private string $password;

    /**
     * @param string $emailString
     * @param string $password
     * @throws Exception
     */
    public function __construct (string $emailString, string $password) {
        parent::__construct();
        $this->email = Convert::stringToEmailAddress(sanitize_input($emailString));
        $this->password = sanitize_input($password);
    }

    public function getEmail (): EmailAddress {
        return $this->email;
    }

    public function getPassword (): string {
        return $this->password;
    }
}