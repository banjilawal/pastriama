<?php

namespace app\utils;

use app\models\concretes\Domain;
use app\models\concretes\EmailAddress;
use app\models\concretes\Phone;

class Convert {

    public static function stringToEmailAddress (string $string): EmailAddress {
        $array = explode('@', trim($string));
        $mailbox = $array[0];
        $domainParts = explode('.', $array[1]);
        $domainName = implode('.', array_slice($domainParts, 0, -1));
        $tld = $domainParts[count($domainParts) - 1];
        return new EmailAddress($mailbox, new Domain($domainName, $tld));
    }

    /**
     * @throws \Exception
     */
    public static function stringToPhone (string $string): Phone {
        $array = preg_split("/[\s.\-)]+/", trim(trim($string), '('));
        $areaCode = $array[0];
        $exchange = $array[1];
        $line = $array[2];
        return new Phone($areaCode, $exchange, $line);
    }
}