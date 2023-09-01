<?php
    require_once ('bootstrap.php');
    echo 'Today Is<br>' . print_date(new \DateTime());
    $var = '';

    if (empty($var)) 
        echo '$var is empty';
?>