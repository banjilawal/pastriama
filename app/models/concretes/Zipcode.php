<?php declare(strict_types=1);

namespace app\models\concretes;

use app\models\abstracts\Model;

class Zipcode extends Model {
    private const  ZIP_CODE_PATTERN = '/[0-9]{5}/';
    private string $zipcode;

    public function __construct (string $zipcode) {
        parent::__construct();
        if (preg_match(self::ZIP_CODE_PATTERN, $zipcode) != 1) {
            throw new Exception ($zipcode . ' is not a valid zip code');
        }
        $this->zipcode = $zipcode;
    }

    public function getZipcode (): string {
        return $this->zipcode;
    }

    public function setZipcode (string $zipcode): void {
        if (preg_match(self::ZIP_CODE_PATTERN, $zipcode) != 1) {
            throw new Exception ($zipcode . ' is not a valid zip code');
        }
        $this->zipcode = $zipcode;
    }

    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof Zipcode) {
            return $this->zipcode === $object->getZipcode();
        }
        return false;
    }

    public function __toString (): string {
        return $this->zipcode;
    }
}