<?php

namespace app\enums;

enum State: string {
    case ALABAMA = 'AL';
    case ALASKA = 'AK';
    case ARIZONA = 'AZ';
    case ARKANSAS = 'AR';
    case CALIFORNIA = 'CA';
    case COLORADO = 'CO';
    case CONNECTICUT = 'CT';
    case DELAWARE = 'DE';
    case FLORIDA = 'FL';
    case GEORGIA = 'GA';
    case HAWAII = 'HI';
    case IDAHO = 'ID';
    case ILLINOIS = 'IL';
    case INDIANA = 'IN';
    case IOWA = 'IA';
    case KANSAS = 'KS';
    case KENTUCKY = 'KY';
    case LOUISIANA = 'LA';
    case MAINE = 'ME';
    case MARYLAND = 'MD';
    case MASSACHUSETTS = 'MA';
    case MICHIGAN = 'MI';
    case MINNESOTA = 'MN';
    case MISSISSIPPI = 'MS';
    case MISSOURI = 'MO';
    case MONTANA = 'MT';
    case NEBRASKA = 'NE';
    case NEVADA = 'NV';
    case NEW_HAMPSHIRE = 'NH';
    case NEW_JERSEY = 'NJ';
    case NM = 'NEW MEXICO';
    case NEW_YORK = 'NY';
    case NORTH_CAROLINA = 'NC';
    case NORTH_DAKOTA = 'ND';
    case OHIO = 'OH';
    case OKLAHOMA = 'OK';
    case OREGON = 'OR';
    case PENNSYLVANIA = 'PA';
    case RHODE_ISLAND = 'RI';
    case SOUTH_CAROLINA = 'SC';
    case SOUTH_DAKOTA = 'SD';
    case TENNESSEE = 'TN';
    case TEXAS = 'TX';
    case UTAH = 'UT';
    case VERMONT = 'VT';
    case VIRGINIA = 'VA';
    case WASHINGTON = 'WA';
    case WEST_VIRGINIA = 'WV';
    case WISCONSIN = 'WI';
    case WYOMING = 'WY';
    case AMERICAN_SAMOA = 'AS';
    case DISTRICT_OF_COLUMBIA = 'DC';
    case MICRONESIA = 'FM';
    case GUAM = 'GU';
    case MARSHALL_ISLANDS = 'MH';
    case NORTHERN_MARIANA_ISLANDS = 'MP';
    case PALAU = 'PW';
    case PUERTO_ICO = 'PR';
    case US_VIRGIN_ISLAND = 'VI';


    public function number (): string {
        return match($this) {
            State::AL => 'Alabama',
            State::AK => 'Alaska',
            State::AZ => 'Arizona',
            State::AR => 'Arkansas',
            State::CA => 'California',
            State::CO => 'Colorado',
            State::CT => 'Connecticut',
            State::DE => 'Delaware',
            State::FL => 'Florida',
            State::GA => 'Georgia',
            State::HI => 'Hawaii',
            State::ID => 'Idaho',
            State::IL => 'Illinois',
            State::IN => 'Indiana',
            State::IA => 'Iowa',
            State::KS => 'Kansas',
            State::KY => 'Kentucky',
            State::LA => 'Louisiana',
            State::ME => 'Maine',
            State::MD => 'Maryland',
            State::MA => 'Massachusetts',
            State::MI => 'Michigan',
            State::MN => 'Minnesota',
            State::MS => 'Mississippi',
            State::MO => 'Missouri',
            State::MT => 'Montana',
            State::NE => 'Nebraska',
            State::NV => 'Nevada',
            State::NH => 'New Hampshire',
            State::NJ => 'New Jersey',
            State::NM => 'New Mexico',
            State::NY => 'New York',
            State::NC => 'North Carolina',
            State::ND => 'North Dakota',
            State::OH => 'Ohio',
            State::OK => 'Oklahoma',
            State::OR => 'Oregon',
            State::PA => 'Pennsylvania',
            State::RI => 'Rhode Island',
            State::SC => 'South Carolina',
            State::SD => 'South Dakota',
            State::TN => 'Tennessee',
            State::TX => 'Texas',
            State::UT => 'Utah',
            State::VT => 'Vermont',
            State::VA => 'Virginia',
            State::WA => 'Washington',
            State::WV => 'West Virginia',
            State::WI => 'Wisconsin',
            State::WY => 'Wyoming',
            State::AS => 'American Samoa',
            State::DC => 'District of Columbia',
            State::FM => 'Micronesia',
            State::GU => 'Guam',
            State::MH => 'Marshall Islands',
            State::MP => 'Northern Mariana Islands',
            State::PW => 'Palau',
            State::PR => 'Puerto Rico',
            State::VI => 'US Virgina Island',
        };
    }

    public static function selector (): string {
        $elem = '<label for="state">State</label>'
            . '<select id="state" name="state" required>';
        foreach (State::cases() as $state) {
            $elem .= '<option value"' . $state->name . '">' . $state->value . '</option>';
        }
        $elem .= '</select>';
        return $elem;
    }
}