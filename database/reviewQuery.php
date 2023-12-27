<?php
    namespace Shop\Database;

    use DateTime;
    use \Shop\Model\Bag\{ReviewBag};
    use \Shop\Model\{Customer, ProteinBar, Review};

    require_once ('../bootstrap.php');
    require_once (MODEL_PATH . DIRECTORY_SEPARATOR . 'review.php');
    require_once (MODEL_PATH . DIRECTORY_SEPARATOR . 'customer.php');
    require_once (MODEL_PATH . DIRECTORY_SEPARATOR . 'proteinBar.php');

    require_once (BAG_PATH . DIRECTORY_SEPARATOR . 'reviewBag.php');


    class ReviewQuery extends \Shop\Model\Review {

        public function review ($review) {
            if (get_class($review) != 'Shop\Model\Review') {
                $errorMessage = get_class($this) . '->customer method cannot accept parameters of type ' . get_class($review);
                throw new \Exception($errorMessage);   
            }
            $this->parent = $review; 
        }

        private function new_id () {
            $mysqli = db_connect();
            $result = $mysqli->query('SELECT id FROM available_review_ids ORDER BY num LIMIT 1');
    
            while ($row = $result->fetch_row()) {
               $id = trim($row[0]);
            }
            $mysqli->close();
            return $id;
        }

        public function find ($id) {
            $mysqli = db_connect();

            $result = new ReviewQuery();
    
            $query = 'SELECT c.id customerID, firstname, lastname, birthdate, email, phone, street, city, '
                . 'state, zip, r.id reviewID, stars, comments, submitDate, p.id productID, p.name, '
                . 'p.description, p.grams, p.retailPrice, imagePath  FROM products p '
                . 'INNER JOIN product_reviews r INNER JOIN customers c '
                . 'ON r.customerID = c.id ON r.productID = p.id WHERE r.id = ?';
    
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $stmt->bind_result($customerID, $firstname, $lastname, $birthdate, $email, $mobile, $street, $city, $state, $zip, $reviewID, $stars, $comments, $timestamp,
            $proteinBarID, $proteinBarName, $description, $grams, $retailPrice, $imagePath );
    
            while ($stmt->fetch()) {
                $proteinBar = (new \Shop\Model\ProteinBar ())->id($proteinBarID)->name($proteinBarName)->description($description);
                $proteinBar->grams($grams)->imagePath($imagePath)->retailPrice($retailPrice);
                $customer = (new \Shop\Model\Customer())->id($customerID)->firstname($firstname)->lastname($lastname);

                $result->proteinBar($proteinBar)->
                $this->timestamp($timestamp)->comments($comments);
                $this->customer($customer)->stars($stars)->id($id);
            }
            $mysqli->close();
            return $this;
        }    

        public function new_review ($customer, $proteinBar, $stars, $comments) {
            $mysqli = db_connect();
            $id = $this->new_id();

            $queryA = 'INSERT INTO product_reviews (customerID, productID, id, stars, comments) VALUES (?, ?, ?, ? ?)'; 
            $stmtA = $mysqli->prepare($queryA);
            $stmtA->bind_param('sssss', $customer->get_id(), $proteinBar->get_id(), $id, $stars, $comments);
            $stmtA->execute(); 

            $queryB = 'DELETE FROM available_review_ids WHERE id = ?';
            $stmtB = $mysqli->prepare($queryB);
            $stmtB->bind_param('s', $id);
            $stmtB->execute(); 

            $queryC = 'SELECT submitTime FROM product_reviews WHERE id = ?';
            $stmtC = $mysqli->prepare($queryC);
            $stmtC->bind_param('s', $id);
            $stmtC->bind_result($timestamp);
            $stmtC->execute();
            $mysqli->close();

            $this->id($id)->customer($customer)->proteinBar($proteinBar)->stars($stars);
            $this->comments($comments)->timestamp($timestamp);
            $_SESSION['review'] = serialize($this->parent);
            return $this->parent;
        }
    } 
?>