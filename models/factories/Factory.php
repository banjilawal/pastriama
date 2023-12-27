<?php

namespace Shop\Model;

use exceptions\EmptyStringException;
use models\concretes\Domain;
use models\concretes\EmailAddress;
use models\concretes\Phone;

class Factory {
    
    /**
     * @throws \Exception
     */
    public static function buildPhone (string $string): Phone {
        $areaCode = substr($string, (strpos($string,'(') + 1 ),  (strpos($string,')') - 1 ) );
        $exchange = substr($string, (strpos($string,' ') + 1 ),  (strpos($string,')') - 1 ) );
        $number = substr($string, (strpos($string,'-') + 1 ) );
        return new Phone($areaCode, $exchange, $number);
    }
    
    
    /**
     * @throws EmptyStringException
     */
    public static function buildEmail (string $string): EmailAddress {
        $array = explode('@', $string);
        $mailbox = $array[0];
        $domainParts = explode('.', $array[1]);
        $name = implode(array_slice($domainParts, (sizeof($domainParts) - 1)));
        $tld = $domainParts[(sizeof($domainParts) - 1)];
        return new EmailAddress($mailbox, new Domain($name, $tld));
    }
} // end class