<?php
    namespace Shop\View;
    
    use Shop\Database\{OrderQuery, CustomerQuery};

    require_once ('../bootstrap.php');
    require_once (QUERY_PATH . DIRECTORY_SEPARATOR . 'customerQuery.php');
    require_once (QUERY_PATH . DIRECTORY_SEPARATOR . 'orderQuery.php');

    if(session_id() == '') {
        session_start();
    }

    $customer = unserialize($_SESSION['customer']);
    $items = $customer->all_items();

    function to_table($items) {
        $elem = '<table><thead>'
                . '<tr>'
                    . '<th>OrderID</th>'
                    . '<th>Submit Date</th>'
                    . '<th>Status</th>'
                    . '<th>Picture</th>'
                    . '<th>Name</th>'
                    . '<th>Description</th>'
                    . '<th>Mass (grams)</th>'
                    . '<th>Unit Price</th>'
                    . '<th>Quantity</th>'
                    . '<th>Cost</th>'
                . '</tr>'
            . '</thead>'
            . '<tbody>';

        foreach ($items as $index => $key) {
            foreach ($key as $field => $values) {
                $elem .= '<tr>'
                    . '<td>' . $key['orderID'] . '</td>'
                    . '<td>' . $key['submitDate'] . '</td>'
                    . '<td>' . $key['status'] . '</td>'
                    . '<td>' . $key['item']->load_image(60, 70)  . '</td>'   
                    . '<td>' . $key['item']->get_name() . '</td>'   
                    . '<td>' . $key['item']->get_description() . '</td>'   
                    . '<td>' . $key['item']->get_grams() . '</td>'   
                    . '<td>' . $key['item']->get_price() . '</td>'   
                    . '<td>' . $key['item']->get_quantity() . '</td>'   
                    . '<td>' . $key['item']->get_cost() . '</td>'                                       
                .'</tr>';
            }  
        }   
  /*          
        foreach ($items as $item) {
           $elem .= '<tr>'
                . '<td>' . $item->load_image(90, 120) . '</td>'
                . '<td>' . $item->get_name() . '</td>' 
                . '<td>' . $item->get_description() . '</td>'
                . '<td>' . $item->get_grams() . '</td>'   
                . '<td>' . $item->get_price() . '</td>'
                . '<td>' . $item->get_quantity() . '</td>' 
                . '<td>' . $item->get_cost() . '</td>'
           .'</tr>';
        }    
*/
        $elem .= '</tbody></table>';
        return $elem;    
    }    

    $title = 'Your Order History, ' . $customer->get_firstname();
?>


<!DOCTYPE html>
<html lang="en-us">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <?php echo '<title>' . $title .  '</title>'; ?>
</head>

<body>   
<header>
    <?php echo '<h1>' . $title .  '</h1>'; ?>
</header>

<main>
    <?php
        echo to_table($items);
    ?>

</main>

</body>
</html>