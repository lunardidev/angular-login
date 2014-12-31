<?php

/**
 * This class is responsible for: Sign up, Sign up and logout for the users service.
 *
 * @copyright Copyright (c) 2014, Felipe Lunardi Farias <ffarias.dev@gmail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class users extends Rest implements interfaceApi{

    /** @var string|null Should contain the name of this class. */
    public $class  = null;

    /** @var string|null Should contain a method of this API (users). */
    public $method = null;

    public function __construct($class,$method){
       $this->class  = $class;
       $this->method = $method;
    }

    public function loginApi(){
        
        if($this->get_request_method() != "POST"){
                $this->response('',406);
        }

        // open session
        
        return true;
    }

    /**
    * Login
    * @param $username username for login
    * @param $password password for login
    * @return true valid username, false invalid username
    */
    public function login($username, $password){

        // validate username and password
        if ($this->validateUsername($username) == false) {
            return $this->responseAPI("error", "Sorry, this username is invalid.", 200);
        }
        if ($this->validadePassword($password) == false) {
            return $this->responseAPI("error", "Sorry, this password is invalid.", 200);
        }

        /* @todo This could be abstracted. */
        require(APP_DIR."/database/databaseConnector.php");

        try {
            $PDOConnector = new PDOConnector( $mysql );

        } catch (Exception $e) {

            return $this->responseAPI("error", $e->getMessage(), 200);
        }

        $connector = $PDOConnector->getConnection();
        
        try {

            $getLoginData = $connector->prepare("SELECT de_user, de_mail from adm_users WHERE de_user=:de_user AND de_pass=:de_pass");
            $getLoginData->bindParam(':de_user', $username, PDO::PARAM_STR);
            $getLoginData->bindParam(':de_pass', $password, PDO::PARAM_STR);
            $getLoginData->execute();

            $resultData = $getLoginData->fetch(PDO::FETCH_ASSOC);

            if( $resultData == false ){
                return $this->responseAPI("error", "Login fail!", 200);
            }
            
        } catch (Exception $e) {
            return $this->responseAPI("error", $e->getMessage(), 200);
        }
                    
        return $this->responseAPI("success", "Login success!", 200);

    }

    /**
    * Validate signUp and insert new user to database.
    * @param $username username of new user
    * @param $fullName full name of new user
    * @param $password password of new user
    * @param $email    email of new user
    * @return object of $this->responseAPI()
    */
    public function signUp($fullName, $username, $password, $email){

        // validate username, password and email
        if ($this->validateUsername($username) == false) {
            return $this->responseAPI("error", "Sorry, this username is invalid.", 200);
        }

        if ($this->validadePassword($password) == false) {
            return $this->responseAPI("error", "Sorry, this password is invalid.", 200);
        }
        if ($this->validadeEmail($email) == false) {
            return $this->responseAPI("error", "Sorry, this email is invalid.", 200);
        }

        if ($this->validateUserAlreadyRegistered($username, $email) == true) {
            return $this->responseAPI("error", "Sorry, this username/email is already registered.", 200);
        }

        /* @todo This could be abstracted. */
        require(APP_DIR."/database/databaseConnector.php");

        try {
            $PDOConnector = new PDOConnector( $mysql );

        } catch (Exception $e) {

            return $this->responseAPI("error", $e->getMessage(), 200);
        }

        $connector = $PDOConnector->getConnection();
        
        try {
            
            $insert = $connector->prepare("INSERT INTO adm_users ( de_name, de_user, de_pass, de_mail ) values ( ?, ?, ?, ? )");

            $insert->bindParam(1, $fullName);
            $insert->bindParam(2, $username);
            $insert->bindParam(3, $password);
            $insert->bindParam(4, $email);

            $insert->execute();
            
        } catch (Exception $e) {
            return $this->responseAPI("error", $e->getMessage(), 200);
        }
                    
        return $this->responseAPI("success", "New user registered with success!", 200);
    }

    /**
    * Checks if the user already exists
    * @param $username username for validate
    * @param $email    email for validate
    * @return true (don't registered) false (already exists)
    */
    public function validateUserAlreadyRegistered($username, $email){

        /* @todo This could be abstracted. */
        require(APP_DIR."/database/databaseConnector.php");

        try {
            $PDOConnector = new PDOConnector( $mysql );

        } catch (Exception $e) {

            return $this->responseAPI("error", $e->getMessage(), 200);
        }

        $connector = $PDOConnector->getConnection();

        try {

            $getUserData = $connector->prepare("SELECT de_user, de_mail from adm_users WHERE de_user=:de_user OR de_mail=:de_mail");
            $getUserData->bindParam(':de_user', $username, PDO::PARAM_STR);
            $getUserData->bindParam(':de_mail', $email   , PDO::PARAM_STR);
            $getUserData->execute();

            $resultData = $getUserData->fetch(PDO::FETCH_ASSOC);

            if (empty($resultData)){
                return false;
            }

        } catch (Exception $e) {
            return $this->responseAPI("error", $e->getMessage(), 200);
        }

        return true;
    }

    /**
    * Validate username
    * @param $username username for validation
    * @return true valid username, false invalid username
    */
    public function validateUsername($username){

        // Username must be between 8 and 24 characters.
        if( strlen($username) < 8 || strlen($username) > 24 ){
            return false;
        }

        // Checks if all of the characters in the provided username are alphanumeric [A-Z or a-z or decimal numbers].
        if ( !ctype_alnum($username) ) {
            return false;
        }

        // The first Character of username must be uppercase.
        if ( !ctype_upper($username{0}) ) {
            return false;
        }

        return true;

    }

    /**
    * Validate password with regular expression
    * @param $password password for validation
    * @return true valid password, false invalid password
    */
    public function validadePassword($password){

        // must contains one digit from 0-9
        // must contains one lowercase characters
        // must contains one uppercase characters
        // must contains one special symbols in the list "@#$%"
        // match anything with previous condition checking length at least 6 characters and maximum of 20
        $passwordRules = "((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%]).{6,20})";

        if(!preg_match($passwordRules, $password)) {
            return false;
        }

        return true;

    }

    /**
    * Validate email with regular expression
    * @param $email email for validation
    * @return true valid email or false invalid email
    */
    public function validadeEmail($email){

        $emailRule = "(^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$)";

        if(!preg_match($emailRule, $email)) {
            return false;
        }

        return true;

    }
    
    /**
    * Logout
    */
    public function logout(){

        // return
        $this->responseAPI("success", "Logout Success!", 200);
    }

    /**
    * A simple response for this API (how do you prefer)
    * @param $status  status (error, success)
    * @param $message message/response
    * @param $code    HTTP status codes (200, 201, 204, 404, 406)
    * @return true valid email, false invalid email
    */
    public function responseAPI($status, $message, $code){

        $responseApi = json_encode(array("status"=>$status, "api"=>"$this->class|$this->method", "message"=>$message));

        if( !$this->is_test ){
            $this->response($responseApi, $code);
        } else{
            return $responseApi;
        }
    }
    
    public function __destruct(){
        return true;
    }
}