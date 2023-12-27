<?php
    namespace Shop\Database;

    use \DateTime, Exception;
    use \Shop\Model\Bag\{Cart, OrderItems};
    use \Shop\Model\{OrderItem, Order, Customer, CreditCard};

    require_once ('../bootstrap.php');
    require_once (MODEL_PATH . DIRECTORY_SEPARATOR . 'order.php');
    require_once (MODEL_PATH . DIRECTORY_SEPARATOR . 'customer.php');
    require_once (MODEL_PATH . DIRECTORY_SEPARATOR . 'orderItem.php');

    require_once (BAG_PATH . DIRECTORY_SEPARATOR . 'cart.php');
    require_once (BAG_PATH . DIRECTORY_SEPARATOR . 'orderItems.php');

    class OrderQuery extends Cart {


        public static function create 
        (
                String $customerID, 
                String $firstname, 
                String $lastname, 
                DateTime $birthdate, 
                String $email, 
                String $phone, 
                String $street, 
                String $city, 
                String $state, 
                String $zip, 

                String $cardID, 
                DateTime $expiration, 
                String $cvn, 

                String $orderID, 
                DateTime $submitTime, 
                String $status
        ) 
        {

                $card = new CreditCard($cardID, $expiration, $cvn);
                $customer = new Customer ($customerID, $firstname, $lastname, $birthdate, $email, $phone, $street, $city, $state, $zip);
       
                $oq = new OrderQuery ();

                $oq->id($orderID);
                $oq->card($card);
                $oq->status($status);
                $oq->customer($customer);
                $oq->submit_time($submitTime);

                return $oq;

        } // close create


        public function to_parent () {

            $parent = new Cart ();

            $parent->id($this->get_id());
            $parent->card($this->get_card());
            $parent->items($this->get_items());
            $parent->status($this->get_status());
            $parent->customer($this->get_customer());
            $parent->submit_time($this->get_submit_time());
            $parent->actual_arrival($this->get_actual_arrival());

            return $parent;

        } // close to_parent        


        public function order_items () {

            $mysqli = db_connect();
            $orderID = $this->get_id();

            $results = new OrderItems();

            $query = 'SELECT '
                . 'productID, quantity, name, description, grams, retailPrice '
                . 'FROM order_items i INNER JOIN products p '
                . 'ON i.productID = p.id WHERE i.orderID = ?';

            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('s', $orderID);
            $stmt->execute();
            $stmt->bind_result($proteinBarID, $quantity, $name, $description, $grams, $price);
    
            while ($stmt->fetch()) {
                $orderItem = new OrderItem($proteinBarID, $name, $description, $grams, $price, $quantity);
                $results->add($orderItem);
            }
            $mysqli->close();

            $this->items($results);
            return $results;
        }

        public static function find ($id) {
            $mysqli = db_connect();
            $results = null;
    
            $query = 'SELECT '
                . 'o.customerID, birthdate, firstname, lastname, email, phone, street, city, state, zip, '
                . 'o.id orderID, o.status, o.submitDate, o.actualDelivery, '
                . 'c.id card, c.expiration, cvn, '
                . 'FROM cards c INNER JOIN orders o INNER JOIN customers p '
                . 'ON p.id = o.customerID ON c.id = o.creditCard WHERE o.id = ?';
    
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $stmt->bind_result
            (
                $customerID,  
                $birthdate, 
                $firstname, 
                $lastname,
                $email, 
                $phone, 
                $street, 
                $city, 
                $state, 
                $zip, 

                $orderID, 
                $status,
                $submitDate, 
                $actualDelivery, 

                $cardID, 
                $expiration, 
                $cvn             
            );    
            
            while ($stmt->fetch()) {

                $birthdate = date_handler($birthdate);
                $expiration = date_handler($expiration);
                $submitDate = date_handler($submitDate);

                if (isset($orderID)) {
                    $result = new OrderQuery ();

                    $result = OrderQuery::create
                    (
                        $customerID, 
                        $firstname, 
                        $lastname, 
                        $birthdate, 
                        $email, 
                        $phone, 
                        $street, 
                        $city, 
                        $state, 
                        $zip, 
            
                        $cardID, 
                        $expiration, 
                        $cvn, 
            
                        $orderID, 
                        $submitDate, 
                        $status
                    ); 

                    $items = $result->order_items();
    
                    if (isset($actualDelivery)) {
                        $actualDelivery = date_handler($actualDelivery);
                        $result->actual_arrival($actualDelivery);       
                    }
                }
            }
            $mysqli->close(); 

            return $result;

        } // close find


        public static function new_id () {

            $mysqli = db_connect();
            $result = $mysqli->query('SELECT id FROM available_order_ids ORDER BY num LIMIT 1');
    
            while ($row = $result->fetch_row()) {
               $id = trim($row[0]);
            }
            $mysqli->close();
            return $id;

        } // close new_id


        public function insert () {

            $mysqli = db_connect();

            $orderID = OrderQuery::new_id();
            $customerID = $this->get_customer()->get_id();
            $cardID = $this->get_card()->get_id();

            if (is_null($this->get_card()) ) {
                $errorMessage = '<p>' . get_class($this) . ' table insert operation failed. '
                    . ' for orderID ' . $orderID . ' The credit for this transaction has not been set</p>';

                throw new \Exception($errorMessage);
            }

            if (is_null($this->get_customer())) {
                $errorMessage = '<p>' . get_class($this) . ' table insert operation failed. '
                    . ' for orderID ' . $orderID . ' No customer is associated with this order</p>';

                throw new \Exception($errorMessage);
            }

            if (count($this->get_list()) < 1) {
                $errorMessage = '<p>' . get_class($this) . ' table insert operation failed. '
                    . ' for orderID ' . $orderID . ' There are no items in the cart.</p>';

                throw new \Exception($errorMessage);
            }

            echo '<p>4 ORDERQUERY::INSERT->>></p><p> CUSTOMER WHO PLACED ORDER: ' . $this->get_customer() . '</>';
            echo '<p>5 ORDERQUERY::INSERT->>></p>CARD CHARGED<p>' . $this->get_card() . '</p>';


            echo '<p>5 ORDERQUERY::INSERT->>> ' . $cardID . ' customerID: ' . $customerID . ' orderID: ' . $orderID . '</p>';
    

            $queryA = 'INSERT INTO orders (id, customerID, creditCard) VALUES(?, ?, ?)';
            $stmtA = $mysqli->prepare($queryA);
            $stmtA->bind_param('sss', $orderID, $customerID, $creditCard);
            $stmtA->execute(); 
  
            $queryB = 'DELETE FROM available_order_ids WHERE id = ?';
            $stmtB = $mysqli->prepare($queryB);
            $stmtB->bind_param('s', $orderID);
            $stmtB->execute(); 

            $this->insert_order_items($orderID);
            $mysqli->close();

        } // close insert


        private function insert_order_items ($orderID) {

            $mysqli = db_connect();       

            foreach ($this->get_list() as $key => $value) {
                $proteinBarID = $this->get_list()[$key]->get_id();
                $quantity = $this->get_list()[$key]->get_quantity();
    
                echo 'proteinBarID: ' . $proteinBarID . ' quantity: ' .$quantity . '<br>';
    
                $query = 'INSERT INTO order_items (orderID, productID, quantity) VALUES (?, ? ?)';
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param('ssi', $orderID, $proteinBarID, $quantity);
                $stmt->execute();
             }

             $mysqli->close();
    
        } // close insert_order_items


    } // end class OrderQuery
?>