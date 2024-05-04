<?php declare(strict_types=1);

namespace app\models\concretes;

use app\models\abstracts\Model;
use Exception;

class Phone extends Model {

    private string $areaCode;
    private string $exchange;
    private string $lineNumber;

    /**
     * @param string $areaCode
     * @param string $exchange
     * @param string $lineNumber
     * @throws Exception
     */
    public function __construct (string $areaCode, string $exchange, string $lineNumber) {
        parent::__construct();

        if (preg_match(AREA_CODE_PATTERN, $areaCode) != 1) {
            throw new Exception(( $areaCode . ' is not a valid area code.'));
        }

        if (preg_match(EXCHANGE_PATTERN, $exchange) != 1) {
            throw new Exception(($exchange . ' not a valid phone exchange.'));
        }

        if (preg_match(LINE_NUMBER_PATTERN, $lineNumber) != 1) {
            throw new Exception(( $lineNumber . ' is not a valid phone line number.'));
        }
        $this->areaCode = $areaCode;
        $this->exchange = $exchange;
        $this->lineNumber = $lineNumber;
    }

    public function getAreaCode (): string {
        return $this->areaCode;
    }

    public function getExchange (): string {
        return $this->exchange;
    }

    public function getLineNumber (): string {
        return $this->lineNumber;
    }

    /**
     * @throws Exception
     */
    public function setAreaCode (string $areaCode): void {
        if (preg_match(AREA_CODE_PATTERN, $areaCode) != 1) {
            throw new Exception(( $areaCode . ' is not a valid area code.'));
        }
        $this->areaCode = $areaCode;
    }

    /**
     * @throws Exception
     */
    public function setExchange (string $exchange): void {
        if (preg_match(EXCHANGE_PATTERN, $exchange) != 1) {
            throw new Exception(($exchange . ' not a valid phone exchange.'));
        }
        $this->exchange = $exchange;
    }

    /**
     * @throws Exception
     */
    public function setLineNumber (string $lineNumber): void {
        if (preg_match(LINE_NUMBER_PATTERN, $lineNumber) != 1) {
            throw new Exception(( $lineNumber . ' is not a valid phone line number.'));
        }
        $this->lineNumber = $lineNumber;
    }

    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof Phone) {
            return $this->areaCode === $object->getAreaCode()
                && $this->exchange === $object->getExchange()
                && $this->lineNumber == $object->getLineNumber();
        }
        return false;
    }

    public function __toString ():string {
        return parent::__toString() . '(' . $this->areaCode . ') ' . $this->exchange . '-' . $this->lineNumber;
    }
}