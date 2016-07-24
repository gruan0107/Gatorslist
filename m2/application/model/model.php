<?php

class Model
{
    /**
     * @var null Data access object
     */
    public $dao = null;

    /**
     * @param object $db A PDO database connection
     */
    function __construct()
    {
        require APP . 'dao/dao.php';
        $this->dao = new Dao();
    }
    
    public function getAllUsers()
    {
        return $this->dao->get([], "allUsers");
    }

    public function createUser($email, $username, $password, $firstname, $lastname) {
        $parameters = [
            ":email" => $email,
            ":username" => $username,
            ":password" => $password,
            ":firstname" => $firstname,
            ":lastname" => $lastname,
        ];
        $this->dao->create($parameters, "user");
    }

    public function deleteUser($user_id)
    {
        $parameters = [
            ":user_id" => $user_id,
        ];
        $this->dao->delete($parameters, "user");

    }

    public function getAllProducts($searchinput, $category)
    {
        if($category == "") {
            $parameters = [
                ":searchinput" => $searchinput,
            ];
            return $this->dao->get($parameters, "allProducts");
        } else {
            $parameters = [
                ":searchinput" => $searchinput,
                ":category" => $category,
            ];
            return $this->dao->get($parameters, "ProductsByCategory");
        }
        
    }

    public function getAllHighProducts()
    {
            return $this->dao->get([], "allHighProducts");	
    }
    
    public function getAllLowProducts()
    {
            return $this->dao->get([], "allLowProducts");
    }

    public function getAllNewestProducts()
    {
            return $this->dao->get([], "allNewestProducts");
    }
}
