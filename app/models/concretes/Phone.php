<?php declare(strict_types=1);

namespace app\models\concretes;

use app\models\abstracts\Model;
use Exception;

class Phone extends Model {

    public const AREA_CODE_PATTERN = '/([0-9]{3}|\([0-9]{3}\))/';
    private  const EXCHANGE_PATTERN = '/[0-9]{3}/';
    public const LINE_NUMBER_PATTERN = '/[0-9]{4}/';
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

        if (preg_match(self::AREA_CODE_PATTERN, $areaCode) != 1) {
            throw new Exception(( $areaCode . ' is not a valid area code.'));
        }

        if (preg_match(self::EXCHANGE_PATTERN, $exchange) != 1) {
            throw new Exception(($exchange . ' not a valid phone exchange.'));
        }

        if (preg_match(self::LINE_NUMBER_PATTERN, $lineNumber) != 1) {
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
        if (preg_match(self::AREA_CODE_PATTERN, $areaCode) != 1) {
            throw new Exception(( $areaCode . ' is not a valid area code.'));
        }
        $this->areaCode = $areaCode;
    }

    /**
     * @throws Exception
     */
    public function setExchange (string $exchange): void {
        if (preg_match(self::EXCHANGE_PATTERN, $exchange) != 1) {
            throw new Exception(($exchange . ' not a valid phone exchange.'));
        }
        $this->exchange = $exchange;
    }

    /**
     * @throws Exception
     */
    public function setLineNumber (string $lineNumber): void {
        if (preg_match(self::LINE_NUMBER_PATTERN, $lineNumber) != 1) {
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

    public function toRow (): string {
        return '<tr>'
            . '<td>' . $this->areaCode . '</td>'
            . '<td>' . $this->exchange . '</td>'
            . '<td>' . $this->lineNumber . '</td>'
            . '</tr>';
    }

    public function toTable (): string {
        return '<table id="phoneTable">'
            . '<thead>'
            . '<tr>'
            . '<th>Area Code</th>'
            . '<th>Exchange</th>'
            . '<th>Number</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>'
            . '<tr>'
            . '<td>' . $this->areaCode . '</td>'
            . '<td>' . $this->exchange . '</td>'
            . '<td>' . $this->lineNumber . '</td>'
            . '</tr>'
            . '</tbody>'
            . '</table>';
    }
}