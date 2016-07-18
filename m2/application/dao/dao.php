<?php
/**
 * Created by PhpStorm.
 * User: guoyiruan
 * Date: 7/13/16
 * Time: 10:21 PM
 */

class Dao {
    /**
     * @var null Database Connection
     */
    public $db = null;

    function __construct()
    {
        $this->openDatabaseConnection();
    }
    
    /**
     * Open the database connection with the credentials from application/config/config.php
     */
    private function openDatabaseConnection()
    {
        // set the (optional) options of the PDO connection. in this case, we set the fetch mode to
        // "objects", which means all results will be objects, like this: $result->user_name !
        // For example, fetch mode FETCH_ASSOC would return results like this: $result["user_name] !
        // @see http://www.php.net/manual/en/pdostatement.fetch.php
        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);

        // generate a database connection, using the PDO connector
        // @see http://net.tutsplus.com/tutorials/php/why-you-should-be-using-phps-pdo-for-database-access/
        try {
            $this->db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS, $options);
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
    // CRUD create read update and delete to database
    public function create($parameters, $target) {
        if ($target == "user") {
            $sql = "INSERT INTO user (Email, Password, Username, Firstname, Lastname) VALUES (:email, :password, :username, :firstname, :lastname)";
            $query = $this->db->prepare($sql);
            try {
                if ($query->execute($parameters)) {
                    return true;
                } else {
                    return false;
                }
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        } else {
            return false;
        }
    }

    public function get($parameters, $target)
    {
        if ($target == "allUsers") {
            $sql = "SELECT User_id, Username, Email, Firstname, Lastname FROM user";
            $query = $this->db->prepare($sql);
            $query->execute();
            return $query->fetchAll();
        }

        else if ($target == "allProducts") {
            $keyword = array_shift($parameters);
            $sql = "SELECT * FROM product WHERE Title LIKE '%" . $keyword . "%' or Description LIKE '%." . $keyword . "%'";
            $query = $this->db->prepare($sql);
            try {
                if ($query->execute()) {
                    return $query->fetchAll();
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }

        else if ($target == "ProductsByCategory") {
            $keyword = array_shift( $parameters );
            $category =  $parameters[":category"];
            $sql = "SELECT * FROM product p1 WHERE p1.Category_Id = (SELECT pc.Category_id FROM productCategory pc WHERE pc.Category_name = '".$category."') AND (p1.Title LIKE '%".$keyword."%'OR p1.Description LIKE '%".$keyword."%')";

            $query = $this->db->prepare($sql);
            try {
                if ($query->execute()) {
                    return $query->fetchAll();
                } else {
                    return false;
                }
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

    public function update($parameters, $target) {

    }

    public function delete ($parameters, $target) {
        if($target == "user") {
            $sql = "DELETE FROM user WHERE (User_id) = (:user_id)";
            $query = $this->db->prepare($sql);
            try {
                if ($query->execute($parameters)) {
                    return true;
                } else {
                    return false;
                }
            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        } else {
            return false;
        }
        
    }
}