<?php
    spl_autoload_register(function ($class) {
        // convert the class namespace to a file path
        $file = str_replace('\\', '/', $class) . '.php';
        // search for the file in the root directory
        $path = __DIR__ . '/' . $file;
        if (file_exists($path)) {
            require_once $path;
        }
    });