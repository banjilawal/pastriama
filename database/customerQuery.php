<?php
namespace database;


//if(session_id() == '') {
//    session_start();
//}

class CustomerQuery {
    private int $customerId;
    private string $firstname;
    private string $lastname;
    private string $birthdate;
    private string $email;
    private string $phone;
    private string $street;
    private string $city;
    private string $state;
    private string $zipcode;
    
    public function
    
    
}

//class CustomerQuery {
//
//        int $customerId;
//        string $firstname;
//        string $lastname;
//        string $birthdate;
//        string $email;
//        string $phone;
//        string $street;
//        string $city;
//        string $state;
//        string $zipcode;
//
//    public function __construct () {
//            $this->customerId = null;
//            $this->firstname = null;
//            $this->lastname = null;
//            $this->birthdate = null;
//            $this->email = null;
//            $this->phone = null;
//            $this->street = null;
//            $this->city = null;
//            $this->state = null;
//            $this->zipcode = null;
//    }

//    /**
//     * @throws Exception
//     */
//    public static function selectCustomer ($email, $password): Customer {
//        $customerId = null;
//        $firstname = null;
//        $lastname = null;
//        $birthdate = null;
//        $mobile = null;
//        $streetNumber = null;
//        $city = null;
//        $state = null;
//        $zipcode = null;
//
//        $mysqli = DBConnect::connect();
//
//        $query = 'SELECT c.id, firstname, lastname, birthdate, phone, '
//            . 'street, city, state, zip FROM shop.customer_accounts a '
//            . 'INNER JOIN shop.customers c ON a.username = c.username '
//            . 'WHERE c.email = ? AND pass = ?';
//        $stmt = $mysqli->prepare($query);
//        $stmt->bind_param('ss', $email, $password);
//        $stmt->execute();
//        $stmt->bind_result($customerId, $firstname, $lastname, $birthdate, $mobile, $streetNumber, $city, $state, $zipcode);
//
//        while ($stmt->fetch()) {
//            $phone = Phone::newPhone($mobile);
////                $address = PostalAddress::Address($street, $city, $state, $zip);
//
////                $birthdate = date_handler($birthdate);
//            $postalAddress = new PostalAddress($streetNumber, $city, new State($state), $zipcode);
//            $customer = new Customer((int) $customerId, $firstname, $lastname, $postalAddress, $email, $phone);
//        }
//        $mysqli->close();
//        return $customer;
//    }
//
///*
//    public function to_parent () {
//
//        $parent = new Customer ();
//
//        $parent->id($this->get_id());
//        $parent->cards($this->credit_cards());
//        $parent->firstname($this->get_firstname());
//        $parent->lastname($this->get_lastname());
//        $parent->birthdate($this->get_birthdate());
//        $parent->address($this->get_address());
//        $parent->phone($this->get_phone());
//        $parent->email($this->get_email());
//
//        return $parent;
//
//    } // close to_parent
//*/
//
//    public function credit_cards () {
//
//        $mysqli = db_connect();
//        $customerID = $this->get_id();
//
//        $cards = new CreditCardBag();
//
//        $query = 'SELECT c.id, c.expiration, c.cvn '
//            . 'FROM customers p INNER JOIN cards c '
//            . 'ON p.id = c.customerID WHERE p.id = ?';
//
//        $stmt = $mysqli->prepare($query);
//        $stmt->bind_param('s', $customerID);
//        $stmt->execute();
//        $stmt->bind_result($id, $expiration, $cvn);
//
//        while ($stmt->fetch()) {
//            $card = CreditCard::Card($id, $expiration, $cvn);
//            $cards->add($card);
//        }
//
//        $mysqli->close();
//        $this->cards($cards);
//
//        return $this->get_cards();
//
//    } // close credit_cards
//
//
//    public function orders () {
//
//        $result = new OrderBag();
//        $mysqli = db_connect();
//        $customerID = $this->get_id();
//
//        echo '<p>getting orders for customer id : ' . $customerID . '</p>';
//
//        $query = 'SELECT '
//            . 'o.id orderID, o.status orderStatus, o.submitDate, o.actualDelivery, '
//            . 'c.cvn, c.expiration, c.id cardID '
//            . 'FROM orders o INNER JOIN cards c ON o.creditCard = c.id WHERE o.customerID = ?';
//
//        $stmt = $mysqli->prepare($query);
//        $stmt->bind_param('s', $customerID);
//        $stmt->execute();
//        $stmt->bind_result($orderID, $status, $submitDate, $arrivalDate, $cvn, $expiration, $cardID);
//
//        while ($stmt->fetch()) {
//            $customer = $this->to_parent();
//            $card = new CreditCard($cardID, date_handler($expiration), $cvn);
//
//            $order = new Order($customer, $card, date_handler($submitDate), $orderID, $status);
//            $order->actual_arrival(date_handler($arrivalDate));
//
//            $result->add($order);
//        }
//
//        $mysqli->close();
//        $this->order = $result;
//
//        return $result;
//
//    } // close orders
//
//
//    public function order_items (Order $order) {
//
//        $mysqli = db_connect();
//        $orderID = $order->get_id();
//
//        $query = 'SELECT p.id, p.name, p.description, p.grams, p.retailPrice unitCost, '
//            . 'i.quantity, i.charge cost FROM orders o '
//            . 'INNER JOIN order_items i INNER JOIN products p '
//            . 'ON i.productID = p.id WHERE o.id = ?';
//
//        $stmt = $mysqli->prepare($query);
//        $stmt->bind_param('s', $orderID);
//        $stmt->execute();
//        $stmt->bind_result($proteinBarID, $proteinBarName, $description, $grams, $price, $quantity, $cost);
//
//        while ($stmt->fetch()) {
//            $orderItem = new OrderItem($proteinBarID, $proteinBarName, $description, $grams, $price, $quantity);
//            $order->add($orderItem);
//        }
//        $mysqli->close();
//        return $order;
//    }
//
//
//    public function all_items () {
//        $mysqli = db_connect();
//        $customerID = $this->get_id();
//
//        $items = array();
//        #echo 'get all items for customer id: ' . $customerID . '<br>';
//
//        $query = 'SELECT p.id productID, p.name, p.description, p.grams, p.retailPrice, i.quantity, '
//            . 'i.orderID, o.status, o.submitDate '
//            . 'FROM orders o INNER JOIN order_items i INNER JOIN products p ON i.productID = p.id ON i.orderID = o.id '
//            . 'WHERE o.customerID = ?';
//
//        $stmt = $mysqli->prepare($query);
//        $stmt->bind_param('s', $customerID);
//        $stmt->execute();
//        $stmt->bind_result($proteinBarID, $name, $description, $grams, $price, $quantity, $orderID, $status, $submitDate);
//
//        while ($stmt->fetch()) {
//            $orderItem = new OrderItem($proteinBarID, $name, $description, $grams, $price, $quantity);
//                $row =
//            $items[] = array (
//                'orderID' => $orderID,
//                'submitDate' => $submitDate,
//                'status' => $status,
//                'item' => $orderItem
//            );
//        }
//        $mysqli->close();
//        return $items;
//    }
//
//
//     public function reviews () {
//
//        $mysqli = db_connect();
//        $customerID = $this->get_id();
//
//        $query = 'SELECT '
//            . 'p.id productID, p.name, p.description, p.grams, p.retailPrice unitCost, '
//            . 'r.id reviewID, stars, comments, submitDate FROM products p '
//            . 'INNER JOIN product_reviews r INNER JOIN customers c '
//            . 'ON r.customerID = c.id ON r.productID = p.id WHERE c.id = ?';
//
//        $stmt = $mysqli->prepare($query);
//        $stmt->bind_param('s', $customerID);
//        $stmt->execute();
//        $stmt->bind_result($proteinBarID, $proteinBarName, $description, $grams, $retailPrice, $reviewID, $stars, $comments, $timestamp);
//
//        while ($stmt->fetch()) {
//            $proteinBar = \Shop\Model\ProteinBar::newBar($proteinBarName, $description, $retailPrice, $grams);
//            $customer = $this->to_parent();
//
//            $review = (new \Shop\Model\Review())->customer($customer)->proteinBar($proteinBar)->stars($stars);
//            $review->comments($comments)->timestamp($timestamp);
//            $this->reviews->add($review);
//        }
//        $mysqli->close();
//        return $this->reviews;
//    }
//
//    public function update_address (String $street, String $city, String $state, String $zip) {
//
//        $mysqli = db_connect();
//        $customerID = $this->get_id();
//
//        $query = 'UPDATE customers SET street = ?, city = ?, state = ?, zip = ? WHERE id = ?';
//
//        $stmt = $mysqli->prepare($query);
//        $stmt->bind_param('sssss', $street, $city, $state, $zip, $customerID);
//        $stmt->execute();
//
//        $mysqli->close();
//
//    } // close update_address
//
//    public function update_phone (String $phone) {
//
//        $mysqli = db_connect();
//        $customerID = $this->get_id();
//
//        $query = 'UPDATE customers SET phone = ? WHERE id = ?';
//
//        $stmt = $mysqli->prepare($query);
//        $stmt->bind_param('ss', $phone, $customerID);
//        $stmt->execute();
//
//        $mysqli->close();
//
//    } // close update_phone
//
//
//    public function new_card (String $number, DateTime $expiration, String $cvn) {
//
//        $mysqli = db_connect();
//        $customerID = $this->get_id();
//
//        $query = 'INSERT INTO cards (customerID, id, expiration, cvn) VALUES (?, ?, ?, ?)';
//
//        $stmt = $mysqli->prepare($query);
//        $stmt->bind_param('ssss', $customerID, $number, $expiration, $cvn);
//        $stmt->execute();
//
//        $mysqli->close();
//
//    } // close new_card
//
//
//    public static function new_id () {
//
//        $result = null;
//        $mysqli = db_connect();
//        $query = 'SELECT id FROM available_customer_ids ORDER BY num LIMIT 1';
//
//        $stmt = $mysqli->prepare($query);
//        $stmt->execute();
//        $stmt->bind_result($id);
//
//        while ($stmt->fetch()) {
//            $result = $id;
//        }
//
//        $mysqli->close();
//        return $result;
//
//    } // close new_id
//
//
//    public static function find (String $customerID) {
//
//        $mysqli = db_connect();
//        $result = null;
//
//        $query = 'SELECT '
//            . 'birthdate, id, firstname, lastname, email, phone, street, city, state, zip '
//            . 'FROM customers WHERE id = ?';
//
//        $stmt = $mysqli->prepare($query);
//        $stmt->bind_param('s', $customerID);
//        $stmt->execute();
//        $stmt->bind_result($birthdate, $id, $firstname, $lastname, $birthdate, $email, $phone, $street, $city, $state, $zip);
//
//        while ($stmt->fetch()) {
//
//            if (is_null($id) == false) {
//                $build = new Build();
//
//                $result = $build->customer('CustomerQuery', $birthdate, $id, $firstname, $lastname, $email, $phone, $street, $city, $state, $zip);
//                $cards = $result->credit_cards();
//            }
//        }
//
//        $mysqli->close();
//        return $result;
//
//    } // close find
//
//
//    public static function insert
//    (
//        String $firstname,
//        String $lastname,
//        DateTime $birthdate,
//        String $telephone,
//        String $email,
//
//        String $street,
//        String $city,
//        String $state,
//        String $zip,
//
//        String $password,
//
//        String $cardID,
//        DateTime $expiration,
//        String $cvn
//    )
//    {
//
//        $mysqli = db_connect();
//
//        $username = $prefix = substr($email, 0, strrpos($email, '@'));
//        $customerID = CustomerQuery::new_id();
//
//        $phone = Phone::build($telephone);
//        $card = new CreditCard ($cardID, $expiration, $cvn);
//        $address = new PostalAddress ($street, $city, $state, $zip);
//
//        echo '<p>INSIDE NEW CUSTOMER METHOD'  . '<br>';
//        echo 'customer will be issued id ' . $customerID . '</p>';
//        $customer = new CustomerQuery();
//
//        echo '<p>recieved as input:<br>' . $firstname . '<br>'.  $lastname . '<br>' . $birthdate . '<br>'. $mobile . '<br>'
//            . $email . '<br>' . $street . '<br>' .  $city . '<br>' . $state . '<br>' . $zip . '<br>' . $password . '<br>'
//            . $cardID . '<br>' . $expiration . '<br>' . $cvn . '</p>';
//
//        $queryA = 'INSERT INTO customers (id, firstname, lastname, birthdate, phone, email, street, city, state, zip) '
//            . 'VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
//        $stmtA = $mysqli->prepare($queryA);
//        $stmtA->bind_param('ssssssssss', $customerID, $firstname, $lastname, $birthdate, $mobile, $email, $street, $city, $state, $zip);
//        $stmtA->execute();
//
//        $queryB = 'DELETE FROM available_customer_ids WHERE id = ?';
//        $stmtB = $mysqli->prepare($queryB);
//        $stmtB->bind_param('s', $customerID);
//        $stmtB->execute();
//
//        $queryC = 'INSERT INTO customer_accounts (username, pass) VALUES (?, ?)';
//        $stmtC = $mysqli->prepare($queryC);
//        $stmtC->bind_param('ss', $username, $password);
//        $stmtC->execute();
//
//        $queryD = 'UPDATE customers SET username = ? WHERE id = ?';
//        $stmtD = $mysqli->prepare($queryD);
//        $stmtD->bind_param('ss', $username, $customerID);
//        $stmtD->execute();
//
//        $card = CreditCardQuery::find($cardID);
//
//        if (is_null($card)) {
//            $card = CreditCardQuery::insert($customer->to_parent(), $cardID, $expiration, $cvn);
//        }
//
//        if ($card)
///*
//        $queryD = 'INSERT INTO cards (id, expiration, cvn, customerID) VALUES (?, ?, ?, ?)';
//        $stmtD = $mysqli->prepare($queryD);
//        $stmtD->bind_param('ssss', $cardID, $expiration, $cvn, $customerID);
//        $stmtD->execute();
//        $mysqli->close();
//*/
//        $address->street($street)->city($city)->state($state)->zip($zip);
//        $phone->string_to_phone($mobile);
//
//        $customer->birthdate(new \DateTime($birthdate));
//        $customer->firstname($firstname);
//        $customer->lastname($lastname);
//        $customer->address($address);
//        $customer->id($customerID);
//        $customer->email($email);
//        $customer->phone($phone);
//        $customer->new_card($cardID, $expiration, $cvn);
//
//        echo 'created customer :' . $customer->to_table();
//
//        return $customer;
//    }
//
//    public static function validate_user ($email, $password) {
//        $mysqli = dbConnect();
//
//        $query = 'SELECT c.id, firstname, lastname, birthdate, email, phone, '
//            . 'street, city, state, zip FROM shop.customer_accounts a '
//            . 'INNER JOIN shop.customers c ON a.username = c.username '
//            . 'WHERE c.email = ? AND pass = ?';
//
//        $stmt = $mysqli->prepare($query);
//        $stmt->bind_param('ss', $email, $password);
//        $stmt->execute();
//
//        $stmt->bind_result($id, $firstname, $lastname, $birthdate, $email, $mobile, $street, $city, $state, $zip);
//
//        while ($stmt->fetch()) {
//            $phone = Phone::newPhone($mobile);
//            $address = PostalAddress::Address($street, $city, $state, $zip);
//
//            $birthdate = date_handler($birthdate);
//
//            $customer->id($id);
//            $customer->phone($phone);
//            $customer->email($email);
//            $customer->address($address);
//            $customer->birthdate($birthdate);
//            $customer->firstname($firstname)->lastname($lastname);
//        }
//        $mysqli->close();
//        return $customer;
//    }
//} // end class