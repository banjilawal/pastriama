<?php

namespace app\enums;

enum State: string {

    case AL = 'Alabama';
    case AK = 'Alaska';
    case AZ = 'Arizona';
    case AR = 'Arkansas';
    case CA = 'California';
    case CO = 'Colorado';
    case CT = 'Connecticut';
    case DE = 'Delaware';
    case FL = 'Florida';
    case GA = 'Georgia';
    case HI = 'Hawaii';
    case ID = 'Idaho';
    case IL = 'Illinois';
    case IN = 'Indiana';
    case IA = 'Iowa';
    case KS = 'Kansas';
    case KY = 'Kentucky';
    case LA = 'Louisiana';
    case ME = 'Maine';
    case MD = 'Maryland';
    case MA = 'Massachusetts';
    case MI = 'Michigan';
    case MN = 'Minnesota';
    case MS = 'Mississippi';
    case MO = 'Missouri';
    case MT = 'Montana';
    case NE = 'Nebraska';
    case NV = 'Nevada';
    case NH = 'New Hampshire';
    case NJ = 'New Jersey';
    case NM = 'New Mexico';
    case NY = 'New York';
    case NC = 'North Carolina';
    case ND = 'North Dakota';
    case OH = 'Ohio';
    case OK = 'Oklahoma';
    case OR = 'Oregon';
    case PA = 'Pennsylvania';
    case RI = 'Rhode Island';
    case SC = 'South Carolina';
    case SD = 'South Dakota';
    case TN = 'Tennessee';
    case TX = 'Texas';
    case UT = 'Utah';
    case VT = 'Vermont';
    case VA = 'Virginia';
    case WA = 'Washington';
    case WV = 'West Virginia';
    case WI = 'Wisconsin';
    case WY = 'Wyoming';
    case AS = 'American Samoa';
    case DC = 'District of Columbia';
    case FM = 'Micronesia';
    case GU = 'Guam';
    case MH = 'Marshall Islands';
    case MP = 'Northern Mariana Islands';
    case PW = 'Palau';
    case PR = 'Puerto Rico';
    case VI = 'US Virgina Island';

    public function code (): string {
        return match($this) {
            State::AL => 'AL',
            State::AK => 'AK',
            State::AZ => 'AZ',
            State::AR => 'AR',
            State::CA => 'CA',
            State::CO => 'CO',
            State::CT => 'CT',
            State::DE => 'DE',
            State::FL => 'FL',
            State::GA => 'GA',
            State::HI => 'HI',
            State::ID => 'ID',
            State::IL => 'IL',
            State::IN => 'IN',
            State::IA => 'IA',
            State::KS => 'KS',
            State::KY => 'KY',
            State::LA => 'LA',
            State::ME => 'ME',
            State::MD => 'MD',
            State::MA => 'MA',
            State::MI => 'MI',
            State::MN => 'MN',
            State::MS => 'MS',
            State::MO => 'MO',
            State::MT => 'MT',
            State::NE => 'NE',
            State::NV => 'NV',
            State::NH => 'NH',
            State::NJ => 'NJ',
            State::NM => 'NM',
            State::NY => 'NY',
            State::NC => 'NC',
            State::ND => 'ND',
            State::OH => 'OH',
            State::OK => 'OK',
            State::OR => 'OR',
            State::PA => 'PA',
            State::RI => 'RI',
            State::SC => 'SC',
            State::SD => 'SD',
            State::TN => 'TN',
            State::TX => 'TX',
            State::UT => 'UT',
            State::VT => 'VT',
            State::VA => 'VA',
            State::WA => 'WA',
            State::WV => 'WV',
            State::WI => 'WI',
            State::WY => 'WY',
            State::AS => 'AS',
            State::DC => 'DC',
            State::FM => 'FM',
            State::GU => 'GU',
            State::MH => 'MH',
            State::MP => 'MP',
            State::PW => 'PW',
            State::PR => 'PR',
            State::VI => 'VI',
        };
    }

    public static function selector (): string {
        $elem = '<label for="state">State</label>'
            . '<select id="state" name="state" required>';
        foreach (State::cases() as $state) {
            $elem .= '<option value"' . $state->code() . '">' . $state->value . '</option>';
        }
        $elem .= '</select>';
        return $elem;
    }
}