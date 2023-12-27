<?php
    namespace database;

    use DateTime, Exception;

    if(session_id() == '') {
        session_start();
    }

    class CreditCardQuery {
        private $owner;
        private $transactions = array();

        public function __construct() {
            $this->owner = new Customer();    
        }

        public function to_parent () {
            $parent = CreditCard::Card($this->get_id(), $this->get_expiration(), $this->get_cvn());    
            return $parent;
        }

        public function card_holder () {      
            $mysqli = db_connect();
            $cardID = $this->get_id();

            $result = null;
    
            $query = 'SELECT c.customerID, firstname, lastname, birthdate, phone, email, street, '
                .'city, state, zip FROM customers p INNER JOIN cards c '
                . 'ON p.id = c.customerID WHERE c.id = ?';
    
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('s', $cardID);
            $stmt->execute();
            $stmt->bind_result($customerID, $firstname, $lastname, $birthdate, $mobile, $email, $street, $city, $state, $zip);
    
            while ($stmt->fetch()) {
                if (is_null($customerID) == false) {
                    $result = Customer::build($customerID, $firstname, $lastname, $birthdate, $mobile, $email, $street, $city, $state, $zip);
                    $this->owner = $result;
                }
            }
            $mysqli->close();
            return $result;
        }

        public function orders () {
            $mysqli = db_connect();
            $customerID = $this->get_id();

            echo '<p>getting orders for customer id : ' . $customerID . '</p>';
    
            $query = 'SELECT o.id orderID, o.status, o.submitDate, c.cvn, c.expiration, c.id cardID '
                . 'FROM orders o INNER JOIN cards c ON o.creditCard = c.id WHERE o.customerID = ?';
 
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('s', $customerID);
            $stmt->execute();
            $stmt->bind_result($orderID, $status, $submitDate, $cvn, $expiration, $cardID);
    
            while ($stmt->fetch()) {
                $card = CreditCard::Card($cardID, new DateTime($expiration), $cvn);
                $order = Order::newOrder($this->to_parent(), $card, $submitDate, $orderID);

                $this->orders->add($order);
            }
            $mysqli->close();
            return $this->orders;
        }

        public function order_items ($order) {
            $mysqli = db_connect();
            $orderID = $order->get_id();
    
            $query = 'SELECT p.id, p.name, p.description, p.grams, p.retailPrice unitCost, '
                . 'i.quantity, i.charge cost FROM orders o '
                . 'INNER JOIN order_items i INNER JOIN products p '
                . 'ON i.productID = p.id WHERE o.id = ?';
    
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('s', $orderID);
            $stmt->execute();
            $stmt->bind_result($proteinBarID, $proteinBarName, $description, $grams, $price, $quantity, $cost);
    
            while ($stmt->fetch()) {    
                $orderItem = new OrderItem($proteinBarID, $proteinBarName, $description, $grams, $price, $quantity);
                $order->add($orderItem);
            }
            $mysqli->close();
            return $order;
        }

        public function all_items () {
            $mysqli = db_connect();
            $customerID = $this->get_id();

            $items = array();
            #echo 'get all items for customer id: ' . $customerID . '<br>';
    
            $query = 'SELECT p.id productID, p.name, p.description, p.grams, p.retailPrice, i.quantity, '
                . 'i.orderID, o.status, o.submitDate '
                . 'FROM orders o INNER JOIN order_items i INNER JOIN products p ON i.productID = p.id ON i.orderID = o.id '
                . 'WHERE o.customerID = ?';
    
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('s', $customerID);
            $stmt->execute();
            $stmt->bind_result($proteinBarID, $name, $description, $grams, $price, $quantity, $orderID, $status, $submitDate);
    
            while ($stmt->fetch()) {
                $orderItem = new OrderItem($proteinBarID, $name, $description, $grams, $price, $quantity);
                    $row = 
                $items[] = array (  
                    'orderID' => $orderID,
                    'submitDate' => $submitDate,
                    'status' => $status,
                    'item' => $orderItem
                );
            }
            $mysqli->close();
            return $items;
        }
  

        public static function find ($cardID) {
            $mysqli = db_connect();
    
            $query = 'SELECT id, expiration, cvn FROM cards WHERE id = ?';
    
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('s', $cardID);
            $stmt->execute();
            $stmt->bind_result($id, $expiration, $cvn);    
            
            while ($stmt->fetch()) {
                if (is_null($id) == false) {
                    $result = new CreditCardQuery();
                    $result::Card($id, $expiration, $cvn);
                    $customer = $result->card_holder();
                }
                else {
                    $result = null;
                }

            }
            $mysqli->close(); 
            return $result;         
        } 

        public static function insert ($customer, $cardID, $expiration, $cvn) {
            $card = CreditCardQuery::find($cardID);

            if (is_null($card) == false) {
                throw new \Exception('A credit card with the number ' . $cardID . ' is already in the database');
            }
            
            if (get_class($customer) == 'Shop\Database\CustomerQuery') {
                $customer = $customer->to_parent();
            }

            $customerID = $customer->get_id();
            $card = new CreditCardQuery();

            $mysqli = db_connect();

            $query = 'INSERT INTO cards (customerID, id, expiration, cvn) VALUES (?, ?, ?, ?)';
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('ssss', $customerID, $cardID, $expiration, $cvn);
            $stmt->execute(); 
            $mysqli->close();

            $card::Card($cardID, $expiration, $cvn);
            $card->owner = $customer();

            return $card;  
        }
    } // end class
?>