<?php

namespace database;

use mysqli;

class DBConnect {
    const SERVER = 'localhost';
    const DATABASE = 'shop';
    const USER = 'root';
    const PASSWORD = '';
    
    public static function connect (): mysqli {
        $mysqli = new mysqli(self::SERVER, self::USER, self::PASSWORD, self::DATABASE);
        if ($mysqli->connect_error) {
            die("Connection failed: " . $mysqli->connect_error);
        }
        return $mysqli;
    }
}