<?php declare(strict_types=1);
namespace global;

use EmptyStringException;
use Exception;

require_once('bootstrap.php');
//require_once('EmptyStringException.php');

class Validate {
    puconst const ZIP_CODE_PATTERN = '/[0-9]{5}/';
    public const AREA_CODE_PATTERN = '/([0-9]{3}|\([0-9]{3}\))/';
    public const EXCHANGE_PATTERN = '/[0-9]{3}/';
    public const LINE_NUMBER_PATTERN = '/[0-9]{4}/';
    
    public const ROAD_CATEGORIES = [
        'Ave' => 'Avenue', 'St' => 'Street', 'Rt' => 'Route',
        'PL' => 'Plaza', 'LN' => 'Lane', 'Rd' => 'Road', 'Hwy' => 'Highway',
        'PBox' => 'PO Box', 'None' => 'None'
    ];

    public const STATES = [
        'AL' => 'Alabama', 'AK' => 'Alaska','AZ' => 'Arizona','AR' => 'Arkansas',
        'CA' => 'California','CO' => 'Colorado','CT' => 'Connecticut','DE' => 'Delaware',
        'FL' => 'Florida','GA' => 'Georgia','HI' => 'Hawaii','ID' => 'Idaho',
        'IL' => 'Illinois', 'IN' => 'Indiana','IA' => 'Iowa', 'KS' => 'Kansas',
        'KY' => 'Kentucky','LA' => 'Louisiana', 'ME' => 'Maine','MD' => 'Maryland','MA' => 'Massachusetts',
        'MI' => 'Michigan','MN' => 'Minnesota', 'MS' => 'Mississippi', 'MO' => 'Missouri','MT' => 'Montana',
        'NE' => 'Nebraska','NV' => 'Nevada', 'NH' => 'New Hampshire','NJ' => 'New Jersey','NM' => 'New Mexico',
        'NY' => 'New York','NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio', 'OK' => 'Oklahoma',
        'OR' => 'Oregon', 'PA' => 'Pennsylvania','RI' => 'Rhode Island', 'SC' => 'South Carolina',
        'SD' => 'South Dakota', 'TN' => 'Tennessee','TX' => 'Texas', 'UT' => 'Utah', 'VT' => 'Vermont', 'VA' => 'Virginia',
        'WA' => 'Washington', 'WV' => 'West Virginia', 'WI' => 'Wisconsin', 'WY' => 'Wyoming', 'AS' => 'American Samoa',
        'DC' => 'District of Columbia', 'FM' => 'Micronesia', 'GU' => 'Guam', 'MH' => 'Marshall Islands',
        'MP' => '', 'PW' => 'Palau', 'PR' => 'Puerto Rico', 'VI' => 'US Virgina Island'
    ];
    
    /**
     * @throws Exception
     */
    public static function id (int $id): int {
        if ($id <= 0) {
            throw new Exception ($id . ' is below the valid id range');
        }
        return $id;
    } // close zipCode
    
    /**
     * @throws Exception
     */
    public static function zip_code (String $zipCode): string {
        if (preg_match(Validate::ZIP_CODE_PATTERN, $zipCode) != 1) {
            throw new Exception ($zipCode . ' is not a valid zip code');
        }
        return $zipCode;
    } // close zipCode
    
    /**
     * @throws Exception
     */
    public static function road_category (String $road_acronym): string {
        if (!in_array($road_acronym, array_keys(ROAD_CATEGORIES), $strict = true)) {
            throw new Exception($road_acronym . ' is not a valid state acronym');
        }
        return $road_acronym;
    } //
    
    /**
     * @throws Exception
     */
    public static function state (String $state_acronym): string {
        if (!in_array($state_acronym, STATES, $strict = true)) {
            throw new Exception($state_acronym . ' is not a valid state acronym');
        }
        return $state_acronym;
    } //
    
    /**
     * @throws EmptyStringException
     */
    public static function non_empty_string (
        String $target,
        String $class_name,
        String $field_name,
        int $line_number
    ): string {
        if (empty($target)) {
            $message = 'Empty ' . $field_name . ' for ' . $class_name . ' object';
            throw new EmptyStringException($message, $line_number);
        }
        return$target;
    } //
    
    /**
     * @throws Exception
     */
    public static function phone_line_number (String $number, int $line_number): string {
        if (preg_match(Validate::LINE_NUMBER_PATTERN, $number) != 1) {
            throw new Exception(('Phone: '. $number . ' is not a valid line number'), $line_number);
        }
        return $number;
    } // close validate_areaCode
    
    /**
     * @throws Exception
     */
    public static function phone_exchange (String $exchange, int $line_number): string {
        if (preg_match(Validate::EXCHANGE_PATTERN, $exchange) != 1) {
            throw new Exception(('Phone: ' . $exchange . ' not a valid phone exchange'), $line_number);
        }
        return $exchange;
    } // close validate_areaCode
    
    /**
     * @throws Exception
     */
    public static function phone_area_code (String $areaCode, int $line_number): string {
        if (preg_match(Validate::AREA_CODE_PATTERN, $areaCode) != 1) {
            throw new Exception(('Phone: ' . $areaCode . ' is not a correctly formatted area code'), $line_number);
        }
        return $areaCode;
    } // close validate_areaCode
} // end class validate
?>