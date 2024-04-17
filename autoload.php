<?php declare(strict_types=1);
//    const ASSETS = '';
//    echo 'project root:' . $_SERVER['PROJECT_ROOT'];

const PROJECT_ROOT = __DIR__;
const APP_PATH = PROJECT_ROOT . '/app';
const ASSETS_PATH =  PROJECT_ROOT . '/food_images';

spl_autoload_register(function ($class) {
    // convert the class namespace to a file path
    $file = str_replace('\\', '/', $class) . '.php';
    // search for the file in the root directory
    $path = __DIR__ . '/' . $file;
    if (file_exists($path)) {
        require_once $path;
    }
});