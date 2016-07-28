<?php
if(!isset($_SESSION)) {
    session_start();
}
?>

<?php
include 'resize.php';
/**
 * Class item
 * This is a demo class.
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */
class Sell extends Controller
{
    /**
     * PAGE: index
     * This method handles what happens when you move to http://../register/index
     */
    public function index()
    {
        // getting all users
//        $users = $this->model->getAllUsers();

        // load views. within the views we can echo out $users
        require APP . 'view/_templates/header.php';
        require APP . 'view/sell/index.php';
        require APP . 'view/_templates/footer.php';
    }

    /**
     * ACTION: createItem -- add product with image
     */
    public function createItem()
    {
        $image1 = file_get_contents($_FILES["fileToUpload"]["tmp_name"]);

        if(($_FILES['fileToUpload2']['tmp_name']) != ""){
            $image2 = file_get_contents($_FILES['fileToUpload2']['tmp_name']);
        }else{
            $image2 = NULL;
        }
        
        if(($_FILES['fileToUpload3']['tmp_name']) != ""){
            $image3 = file_get_contents($_FILES['fileToUpload3']['tmp_name']);
        }else{
            $image3 = NULL;
        }
        
        if(($_FILES['fileToUpload4']['tmp_name']) != ""){
            $image4 = file_get_contents($_FILES['fileToUpload4']['tmp_name']);
        }else{
            $image4 = NULL;
        }

            $date = date("Y-m-d H:i:s");
            $seller_id =  $_SESSION['CurrentUser'];
//            echo $seller_id;
//            echo"model good";
            $this->model->createItem($seller_id,$_POST["Title"], $_POST["Description"], $_POST["Price"], $_POST["Condition"],$date, $_POST["Category_Id"],$image1,$image2,$image3,$image4);

//                header('location: ' . URL . 'sell/index');
        
        
    }

    public function ResetPrice($product_id, $newprice)
    {
        //check the userid
        
        
        if (isset($product_id)) {
            // do deleteUser() in model/model.php
            $this->model->editItem($product_id,$newprice);
        }

        // where to go after user has been deleted
//        header('location: ' . URL . 'item/index');
    }

    public function deleteItem($product_id)
    {
        // check the the userid if the userid == seller's id in DB execute, else return

        // if we have an id of a user that should be deleted
        if (isset($product_id)) {
            // do deleteUser() in model/model.php
            $this->model->deleteItem($product_id);
        }

        // where to go after user has been deleted
        header('location: ' . URL . 'item/index');
    }

    public function getItem($product_id)
    {
        // check the userid

        // if we have an id of a user that should be deleted
        if (isset($product_id)) {
            // do deleteUser() in model/model.php
            $this->model->getItem($product_id);
        }

        // where to go after user has been deleted
        header('location: ' . URL . 'item/index');
    }
    
}