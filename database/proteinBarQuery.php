<?php
    namespace Shop\Database;
    
    use \DateTime, \Exception;
    use \Shop\Model\Bag\{ReviewBag};
    use \Shop\Model\{Customer, ProteinBar, Order, OrderItem, Review};


    require_once ('../bootstrap.php');

    require_once (MODEL_PATH . DIRECTORY_SEPARATOR . 'customer.php');
    require_once (MODEL_PATH . DIRECTORY_SEPARATOR . 'proteinBar.php');
    require_once (MODEL_PATH . DIRECTORY_SEPARATOR . 'review.php');

    require_once (BAG_PATH . DIRECTORY_SEPARATOR . 'reviewBag.php');

    class ProteinBarQuery extends ProteinBar {
        private ReviewBag $reviews;


        public function to_parent () {

            $parent = new ProteinBar(
                $this->get_id(),
                $this->get_name(), 
                $this->get_description(), 
                $this->get_price(), 
                $this->get_grams()
            );

            return $parent;

        } // close to_parent


        public function reviews () {

            $mysqli = db_connect();
            $proteinBarID = $this->get_id();

            $results = new ReviewBag();

            echo 'reviews for bar id ' . $proteinBarID;
    
            $query = 'SELECT '
                . 'r.customerID, birthdate, firstname, lastname, email, phone, street, city, state, zip, '
                . 'r.id reviewID, r.stars, comments, timestamp '
                . 'FROM product_reviews r INNER JOIN customers c '
                . 'ON r.customerID = c.id WHERE r.productID = ?';
    
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('s', $proteinBarID);
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

                $reviewID, 
                $stars, 
                $comments, 
                $timestamp
            );
    
            while ($stmt->fetch()) {

                $timestamp = date_handler($timestamp);

                $review = Review::build
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
        
                    $this->get_id(), 
                    $this->get_name(), 
                    $this->get_description(), 
                    $this->get_grams(), 
                    $this->get_price(),
        
                    $reviewID,
                    $timestamp,
                    $stars,
                    $comments                  
                );
                $results->add($review);
            }

            $mysqli->close();
            $this->reviews = $results;

            return $results;

        }   // close reviews


        public function update_name (String $name) {

            $mysqli = db_connect();
            $id = $this->get_id();

            $query = 'UPDATE products SET name = ? WHERE id = ?';
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('ss', $name, $id);
            $stmt->execute();

            $mysqli->close();

        } // close update_name


        public function update_description (String $description) {

            $mysqli = db_connect();
            $id = $this->get_id();           

            $query = 'UPDATE products SET description = ? WHERE id = ?';
            $stmt = $mysqli->prepare($query);
            $stmt ->bind_param('ss', $description, $id);
            $stmt->execute();

            $mysqli->close();

        } // close update_description


        public function update_grams (int $grams) {

            $mysqli = db_connect();
            $id = $this->get_id();

            $query = 'UPDATE products SET grams = ? WHERE id = ?';
            $stmt = $mysqli->prepare($query);  
            $stmt ->bind_param('is', $grams, $id);
            $stmt->execute();

            $mysqli->close();

        } // close update_grams


        public function update_price (float $price) {

            $mysqli = db_connect();
            $id = $this->get_id();

            $query = 'UPDATE products SET retailPrice = ? WHERE id = ?';
            $stmt = $mysqli->prepare($query);
            $stmt ->bind_param('ds', $price, $id);
            $stmt->execute();

            $mysqli->close();

        } // close update_price


        public static function find (String $proteinBarID) {

            $mysqli = db_connect();
            $result = null;
    
            $query = 'SELECT id, name, description, grams, retailPrice FROM products WHERE id = ?';

            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('s', $proteinBarID);
            $stmt->execute();
            $stmt->bind_result($id, $name, $description, $grams, $price);
   
            while ($stmt->fetch()) {
                if (!is_null($id)) {
                    $result = new ProteinBarQuery($id, $name, $description, $grams, $price);
                    $reviews = $result->reviews();
                }
            }
            $mysqli->close();

            return $result;

        } // close find


        private static function new_id () {

            $mysqli = db_connect();
            $result = $mysqli->query('SELECT id FROM available_product_ids ORDER BY num LIMIT 1');
    
            while ($row = $result->fetch_row()) {
               $id = trim($row[0]);
            }
            $mysqli->close();

            return $id;

        } // close new_id


        public static function insert (String $name, String $description, int $grams, float $price) {

            $mysqli = db_connect();
            $id = ProteinBarQuery::new_id();

            $queryA = 'INSERT INTO products (id, name, description, grams, retailPrice) VALUES (?, ?, ?, ?, ?)'; 
            $stmtA = $mysqli->prepare($queryA);
            $stmtA->bind_param('sssss', $id, $name, $description, $grams, $price);
            $stmtA->execute(); 

            $queryB = 'DELETE FROM available_product_ids WHERE id = ?';
            $stmtB = $mysqli->prepare($queryB);
            $stmtB->bind_param('s', $id);
            $stmtB->execute(); 

            $proteinBar = new ProteinBar ($id, $name, $description, $grams, $price);

            return $proteinBar;

        } // close insert
    } 
?>