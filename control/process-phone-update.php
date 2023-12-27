<?php
    if(session_id() == '') {
        session_start();
    }
    require_once ('../bootstrap.php');
    require_once (MODEL_PATH . '/customerView.php');
    require_once (QUERY_PATH . '/customer-queries.php'); #'../db/customer-queries.php');

    $phone = sanitize_input($_POST['phone']);
    
    $customer = unserialize($_SESSION['customer']);
    $id = $customer->get_id();

    echo '<p>old phone: ' . $customer->get_phone() . '</p>'; 

    update_phone($customer, $phone);
    $customer = customer_query($id);

    echo $customer->to_table();
?>