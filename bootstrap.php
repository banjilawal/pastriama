<?php
    // directory paths
    define ('ROOT_PATH',  __DIR__ );
    define ('PROJECT_PATH',  __DIR__ .  DIRECTORY_SEPARATOR );

    define ('ASSETS_PATH', PROJECT_PATH . 'assets' .  DIRECTORY_SEPARATOR);
    define ('IMAGE_PATH', ASSETS_PATH . 'images' .  DIRECTORY_SEPARATOR);
    define ('MODEL_PATH', PROJECT_PATH . 'models' . DIRECTORY_SEPARATOR);
    define ('FACTORY_PATH', PROJECT_PATH . 'factory' .  DIRECTORY_SEPARATOR);
    define ('BAG_PATH', PROJECT_PATH . 'models' . DIRECTORY_SEPARATOR . 'bag' . DIRECTORY_SEPARATOR);
    define ('FORM_PATH', PROJECT_PATH . 'form' . DIRECTORY_SEPARATOR);
    define ('QUERY_PATH', PROJECT_PATH . 'database' . DIRECTORY_SEPARATOR);
    define ('WEB_PAGE_PATH', PROJECT_PATH . 'view' . DIRECTORY_SEPARATOR);
    define ('CONTROL_PATH', PROJECT_PATH . 'control' . DIRECTORY_SEPARATOR);

    // Constants
    define ('MIN_GRAMS', 10);
    define ('MAX_GRAMS', 100);
    define ('LOWEST_PRICE', 1.05);
    define ('HIGHEST_PRICE', 10.99);
    define ('SALES_TAX_RATE', 0.10);

    define ('WORD_PATTERN', '/[A-Z]{3,}/i');
    define ('FIRST_NAME_PATTERN', '/[A-Z]{2,}/i');
    define ('LAST_NAME_PATTERN', '/([A-Z]{3,}|[A-Z]{3,}\s[A-Z]{3,})/i');
    
    define ('LETTERS', array('A','B','C','D','E','F','G','H','J','K','L','M','N','P','Q','R','S','T','U','V','W','X','Y','Z'));

    define ('STATES', array ('AL', 'AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID', 'IL','IN','IA', 'KS','KY','LA',
        'ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK','OR','PA','RI','SC','SD',
        'TN','TX','UT','VT','VA','WA','WV','WI','WY','AS','DC','FM','GU','MH','MP','PW','PR','VI'));

    define ('ROAD_CATEGORIES', array('Ave' => 'Avenue', 'St' => 'Street', 'Rt' => 'Route', 'PL' => 'Plaza', 
        'LN' => 'Lane', 'Rd' => 'Road', 'Hwy' => 'Highway', 'PBox' => 'PO Box', 'None' => 'None'));

    define ('DB_SERVER', 'localhost');
    define ('DB_USER', 'root');
    define ('DB_PASS', '');
    define ('DB_NAME', 'shop');

    function db_connect () {
        $mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }
        return $mysqli;
    }

    function db_disconnect ($connection) {
        if (isset($connection)) {
            mysqli_close($connection);
        }
    }

    function sanitize_input ($data) {
        if (isset($data) == false) {
            Throw new \Exception($data . ' Cannot process null data');
        }
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data; 
    }

    function print_date (\DateTime $date) {
        if (($date instanceof \DateTime) != 1) {
            throw new \Exception($date . ' is not a valid DateTime object');
        }

        $default = new \DateTime('0000-01-01');

        if (is_null($date) || $date == $default) {
            return '';
        }
        else {
            return $date->format('Y-m-d hh:mm:s');
        }
    } // close print_date


    function date_handler (\DateTime $date) {
        if (is_string($date)) {
            return new \DateTime($date);
        }
        else if ($date instanceof \DateTime) {
            return $date;
        }
        else {
            return new \DateTime('0000-01-01');
        }
    } // close date_handler
?>