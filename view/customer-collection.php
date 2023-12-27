<?php
    session_start();
    session_unset();
    session_destroy();
    session_write_close();
 #   setcookie(session_name(),'',0,'/');
 #   session_regenerate_id(true);
    require_once ('../bootstrap.php');
    require_once (MODEL_PATH . '/customerView.php');
    require_once ('../db/collection-queries.php');

    $customerBag = collect_customers(200);

?>

<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <!--<script type="text/javascript" src="script.js"></script> --> 
    <!--<script type="text/php" src="script.php"></script> --> 
      <title>Customer Records</title>
</head>

<body>   
<header>
    <h1>Customer Records</h1>
</header>

<nav></nav>
<main>
    <?php  $customerBag->to_table(); ?>
    <script>
        function send_customer (row) {
            //var x = row.getAttribute("id")
            //alert(x);
            data = row.childNodes[0];
            cell = row.cells[0];
            //alert(cell.innerHTML);
            cookie = document.cookie = "customerID=" + cell.innerHTML + ""; // + "; max-age=5";

            location.href = "customerView.php";
        }
    </script>
</main>
</body>
<html>