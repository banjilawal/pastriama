<?php
    namespace Shop\View;

    use Shop\Database\{ProteinBarQuery, QueryBag, CustomerQuery};

    require_once ('../bootstrap.php');
    require_once (QUERY_PATH . DIRECTORY_SEPARATOR . 'queryBag.php');

    if(session_id() == '') {
        session_start();
    }

    #echo '<p>' . $_SERVER['HTTP_REFERER'] . '</p>';
    #echo '<p>' . print_r($_SESSION['customer']) . '</p>';

    $customer = unserialize($_SESSION['customer']);
    $title = 'Hello ' . $customer->get_firstname() . '. Thanks for Visiting Us';
    $proteinBarBag = \Shop\Database\QueryBag::proteinBars(115);
?>

<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <!--<script type="text/javascript" src="script.js"></script> --> 
    <!--<script type="text/php" src="script.php"></script> --> 
      ><?php echo '<title>' .$title . '</title>'; ?>
</head>

<body>   
<header>
    <?php echo '<h1>' .$title . '</h1>'; ?>
</header>
<nav> 
    <ul>
        <li><button type="button" onclick="get_customer_items(id)">Your Previous Orders</button></li>
        <li><button type="button" onclick="change_address()">Update Your Addresss</button></li>
        <li><button type="button" onclick="change_phone()">Update Your Phone</button></li>
        <li><button type="button" onclick="new_card()">Add Credit Card</button></li>
    </ul>
</nav>

<main>
    <h1>Our Protein Bars</h1>
    <?php  echo $proteinBarBag->to_table(); ?>

    <script>
        function get_customer_items() {
            location.href = "customer-orders.php";
        }

        function change_address() {
            location.href = "../form/address-update-form.php";
        }

        function change_phone() {
            location.href = "../form/phone-update-form.php";
        }

        function new_card() {
            location.href = "../form/new-credit-card-form.php";
        }

        function send_protein_bar (row) {
            data = row.childNodes[0];
            cell = row.cells[0];
            cookie = document.cookie = "proteinBarID=" + cell.innerHTML + ""; // + "; max-age=5";

            location.href = "protein-bar.php";
        }
    </script>
</main>
</body>
<html>
