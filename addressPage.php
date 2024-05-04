<?php declare(strict_types=1);

use app\templates\Dashboard;
use app\templates\HTMLForm;
use app\templates\HTMLList;
use app\templates\HTMLSection;
use app\templates\Script;

if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
}

require_once 'data_loader.php';


echo HTMLSection::head('Please Register') . HTMLSection::navbar()
    . HTMLForm::postalAddressForm() . HTMLSection::footer();