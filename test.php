<?php
    require_once ('bootstrap.php');
echo MODEL_PATH . '<p></p>';
    #require_once (MODEL_PATH . 'postalAddress.php');

    #echo '<p>' . print_r($_SERVER) . '</p>';
    #echo '<p>' . CUSTOMER_ID_PATTERN . '</p>';

    echo get_class(new DateTime());


/*
    $address = new PostalAddress();
    $addres->street('18740 Farmstead Circle')->city('Eden Prairie')->state('MN')->zip('55347');
    echo $address->to_table();
*/
?>

<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" type="text/css" href="style.css" media=”screen"/> --> 
    <!--<script type="text/javascript" src="script.js"></script> --> 
    <!--<script type="text/php" src="script.php"></script> --> 
    
    <title>The Template Title</title>
</head>

<body>   
        <hi>The Template Page Heading</hi>
        <p></p>
        <?php
            $items = array();

            for ($index = 0; $index < 10; $index++) {
                $items[$index] = LETTERS[$index] . LETTERS[$index + 1];
            }

            foreach ($items as $key => $value) {
                echo 'items[' . $key . ']-> ' . $items[$key] . '<br>';
            }

            $elem = '<table><thead><tr><th>Row</th><th>Characters<?th></tr></thead>'
                . '<tbody>';

            foreach ($items as $key => $value) {
                $elem .= '<tr onclick="test_func(this)"><td>' . $key . '</td><td>' . $items[$key] . '</td></tr>'; 
            }
            $elem .= '</tbody></table>';

            echo '<p>' . $elem. '</p>';

        ?>

    <script>
        function test_func($row) {
            alert("hello");
        }
    </script>
</body>
<html>