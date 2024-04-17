<?php declare(strict_types=1);

namespace app\models\concretes;

use app\models\abstracts\Model;
use Exception;

class State extends Model {
    public const STATES = [
        'AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas',
        'CA' => 'California', 'CO' => 'Colorado',' CT' => 'Connecticut', 'DE' => 'Delaware',
        'FL' => 'Florida','GA' => 'Georgia', 'HI' => 'Hawaii','ID' => 'Idaho',
        'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa', 'KS' => 'Kansas',
        'KY' => 'Kentucky', 'LA' => 'Louisiana', 'ME' => 'Maine', 'MD' => 'Maryland',
        'MA' => 'Massachusetts', 'MI' => 'Michigan','MN' => 'Minnesota', 'MS' => 'Mississippi',
        'MO' => 'Missouri', 'MT' => 'Montana', 'NE' => 'Nebraska', 'NV' => 'Nevada',
        'NH' => 'New Hampshire', 'NJ' => 'New Jersey', 'NM' => 'New Mexico', 'NY' => 'New York',
        'NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio', 'OK' => 'Oklahoma',
        'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island', 'SC' => 'South Carolina',
        'SD' => 'South Dakota', 'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah',
        'VT' => 'Vermont', 'VA' => 'Virginia', 'WA' => 'Washington', 'WV' => 'West Virginia',
        'WI' => 'Wisconsin', 'WY' => 'Wyoming', 'AS' => 'American Samoa', 'DC' => 'District of Columbia',
        'FM' => 'Micronesia', 'GU' => 'Guam', 'MH' => 'Marshall Islands', 'MP' => 'Northern Mariana Islands',
        'PW' => 'Palau', 'PR' => 'Puerto Rico', 'VI' => 'US Virgina Island'
    ];
    private string $name;
    private string $postalCode;

    /**
     * @param string $postalCode
     * @throws Exception
     */
    public function __construct (string $postalCode) {
        parent::__construct();
        if (!array_key_exists($postalCode, self::STATES)) {
            throw new Exception('There is no state whose acronym is ' . $postalCode . '.');
        }
        $this->postalCode = $postalCode;
        $this->name = self::STATES[$postalCode];
    }

    public function getName (): string {
        return $this->name;
    }

    public function getPostalCode (): string {
        return $this->postalCode;
    }


//    /**
//     * @throws Exception
//     */
//    public function setPostalCode (string $postalCode): void {
//        if (!array_key_exists($postalCode, self::STATES)) {
//            throw new Exception('There is no state whose acronym is ' . $postalCode . '.');
//        }
//        $this->postalCode = $postalCode;
//        $this->name = self::STATES[$postalCode];
//    }

    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof State) {
            return parent::equals($object)
                && $this->name === $object->getName()
                && $this->postalCode === $object->getPostalCode();
        }
        return false;
    }

    public function __toString (): string {
        return $this->postalCode . ': ' . $this->name;
    }

    public static function getSelector (): string {
        $elem = '<label for ="state"">State</label>'
            . '<select id="state" name="state">';
        foreach (self::STATES as $postalCode => $name) {
            $elem .= '<option value="' . $postalCode . '">' . $name . '<option>';
        }
        $elem .= '</select>';
        return $elem;
    }
}