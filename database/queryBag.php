<?php
    namespace Shop\Database;

    use \Exception;
    use Shop\Model\Bag\{CustomerBag, OrderBag, ProteinBarBag};
    use Shop\Database\{CustomerQuery, OrderQuery, ProteinBarQuery};

    require_once ('../bootstrap.php');

    require_once (BAG_PATH . DIRECTORY_SEPARATOR . 'orderBag.php');
    require_once (BAG_PATH . DIRECTORY_SEPARATOR . 'customerBag.php');
    require_once (BAG_PATH . DIRECTORY_SEPARATOR . 'proteinBarBag.php');

    require_once (QUERY_PATH . DIRECTORY_SEPARATOR . 'orderQuery.php');
    require_once (QUERY_PATH . DIRECTORY_SEPARATOR . 'customerQuery.php');
    require_once (QUERY_PATH . DIRECTORY_SEPARATOR . 'proteinBarQuery.php');

    class QueryBag {

        public static function customers (int $count) {

            $bag = new CustomerBag();
            $mysqli = db_connect();
    
            $query = 'SELECT id FROM customers ORDER BY id LIMIT ?';  
    
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('i', $count);
            $stmt->execute();
            $stmt->bind_result($id);
            
            while ($stmt->fetch()) {
                $customer = CustomerQuery::find($id);            
                $bag->add($customer->to_parent());
            }

            $mysqli->close();
            return $bag;

        } // close customers 


        public static function proteinBars (int $count) {

            $bag = new ProteinBarBag();
            $mysqli = db_connect();
        
            $query = 'SELECT id FROM products ORDER BY id LIMIT ?';  
        
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('i', $count);
            $stmt->execute();
            $stmt->bind_result($id);
            
            while ($stmt->fetch()) {
                $proteinBar = \Shop\Database\ProteinBarQuery::find($id);    
                $bag->add($proteinBar->to_parent());
            }

            $mysqli->close();
            return $bag;

        } // close proteinBars


        public static function orders ($count) {

            $bag = new OrderBag();
            $mysqli = db_connect();
        
            $query = 'SELECT id FROM orders ORDER BY id LIMIT ?';  
        
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('i', $count);
            $stmt->execute();
            $stmt->bind_result($id);
            
            while ($stmt->fetch()) {
                $order = \Shop\Database\OrderQuery::find($id);            
                $bag->add($order->to_parent());
            }

            $mysqli->close();
            return $bag;

        } // close orders

    } // end class QueryBag
?>
