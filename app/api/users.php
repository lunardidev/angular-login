<?php

/**
 * This class is responsible for sign up, sign in and logout.
 *
 * @copyright Copyright (c) 2014, Felipe Lunardi Farias <ffarias.dev@gmail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class users extends Rest implements interfaceApi
{
    
    /** @var string|null Should contain the name of this class. */
    public $class = null;
    
    /** @var string|null Should contain a method of this API (users). */
    public $method = null;
    
    public function __construct($class, $method)
    {
        
        parent::__construct();
        
        $this->class  = $class;
        $this->method = $method;
    }
    
    /**
     * A simple response for this API
     * @param $status  status (error, success)
     * @param $message message/response
     * @param $code    HTTP status codes (200, 201, 204, 404, 406)
     * @param $data    
     * @return object array (for test) or json (for javascript response)
     */
    public function responseAPI($status, $message, $code, $data = array())
    {
        
        $responseApi = json_encode(array(
            "status" => $status,
            "api" => "$this->class|$this->method",
            "message" => $message,
            "data" => $data
        ));
        
        if (!$this->is_test) {
            $this->response($responseApi, $code);
        } else {
            return $responseApi;
        }
    }
    
    /**
     * Check if user was authenticated.  
     * @return object of $this->responseAPI()
     */
    public function authenticated()
    {
        
        session_start();
        
        $resultData = array(
            "deUser" => "",
            "deMail" => "",
            "authenticated" => false
        );
        
        if (isset($_SESSION['de_user']) && isset($_SESSION['de_mail']) && isset($_SESSION['authenticated'])) {
            
            $resultData = array(
                "deName" => $_SESSION['de_name'],
                "deUser" => $_SESSION['de_user'],
                "deMail" => $_SESSION['de_mail'],
                "authenticated" => $_SESSION['authenticated']
            );
            
            return $this->responseAPI("success", "Login success!", 200, $resultData);
        } else {
            return $this->responseAPI("error", "", 200, $resultData);
        }
        
    }
    
    /**
     * Check if email is already registered 
     * @return object of $this->responseAPI()
     */
    public function verifyEmailIsRegistered()
    {
        
        if ($this->get_request_method() != "POST") {
            return $this->responseAPI("error", "Not allowed.", 406);
        }
        
        $postData = json_decode(file_get_contents("php://input"), true);
        
        $email = $postData["email"];
        
        // email is already registered
        if ($this->validateUserAlreadyRegistered('', $email) == true) {
            return $this->responseAPI("error", "", 200);
        }
        
        return $this->responseAPI("success", " ", 200);
        
    }
    
    /**
     * Check if username is already registered 
     * @return object of $this->responseAPI()
     */
    public function verifyUsernameIsRegistered()
    {
        
        if ($this->get_request_method() != "POST") {
            return $this->responseAPI("error", "Not allowed.", 406);
        }
        
        $postData = json_decode(file_get_contents("php://input"), true);
        
        $username = $postData["username"];
        
        // username is already registered
        if ($this->validateUserAlreadyRegistered($username, '') == true) {
            return $this->responseAPI("error", "", 200);
        }
        
        return $this->responseAPI("success", " ", 200);
        
    }
    
    /**
     * Login of users to api
     * @return object of $this->responseAPI()
     */
    public function loginApi()
    {
        
        if ($this->get_request_method() != "POST") {
            return $this->responseAPI("error", "Not allowed.", 406);
        }
        
        $postLogin = json_decode(file_get_contents("php://input"), true);
        
        $username = $postLogin["login"]["username"];
        $password = $postLogin["login"]["password"];
        
        $this->login($username, $password);
    }
    
    /**
     * Register a new user to api
     * @return object of $this->responseAPI()
     */
    public function signUpApi()
    {
        
        if ($this->get_request_method() != "POST") {
            return $this->responseAPI("error", "Not allowed.", 406);
        }
        
        $postData = json_decode(file_get_contents("php://input"), true);
        
        $deName   = $postData["signUp"]["deName"];
        $username = $postData["signUp"]["username"];
        $email    = $postData["signUp"]["email"];
        $password = $postData["signUp"]["password"];
        
        $this->signUp($deName, $username, $password, $email);
    }
    
    /**
     * Simple method for Logout
     */
    public function logout()
    {
        
        session_start();
        session_destroy();
        
        unset($_SESSION['de_name']);
        unset($_SESSION['de_user']);
        unset($_SESSION['de_mail']);
        unset($_SESSION['authenticated']);
        
        // return
        $this->responseAPI("success", "Logout Success!", 200);
    }
    
    
    /**
     * Login
     * @param $username username for login
     * @param $password password for login
     * @return object of $this->responseAPI()
     */
    public function login($username, $password)
    {
        
        // validate username and password
        if ($this->validateUsername($username) == false) {
            return $this->responseAPI("error", "Sorry, this username is invalid.", 200);
        }
        if ($this->validatePassword($password) == false) {
            return $this->responseAPI("error", "Sorry, this password is invalid.", 200);
        }
        
        /* @todo This could be abstracted. */
        require(APP_DIR . "/database/databaseConnector.php");
        
        try {
            $PDOConnector = new PDOConnector($mysql);
            
        }
        catch (Exception $e) {
            
            return $this->responseAPI("error", $e->getMessage(), 200);
        }
        
        $connector = $PDOConnector->getConnection();
        
        try {
            
            $resultData         = null;
            $encrypted_password = md5($password);
            
            $getLoginData = $connector->prepare("SELECT de_user, de_mail, de_name from adm_users WHERE de_user=:de_user AND de_pass=:de_pass");
            $getLoginData->bindParam(':de_user', $username, PDO::PARAM_STR);
            $getLoginData->bindParam(':de_pass', $encrypted_password, PDO::PARAM_STR);
            $getLoginData->execute();
            
            $resultData = $getLoginData->fetch(PDO::FETCH_ASSOC);
            
            if ($resultData == false) {
                return $this->responseAPI("error", "Login fail!", 200);
            }
            
        }
        catch (Exception $e) {
            return $this->responseAPI("error", $e->getMessage(), 200);
        }
        
        if (isset($resultData['de_user']) && isset($resultData['de_mail'])) {
            
            session_start();
            
            $_SESSION['de_name']       = $resultData['de_name'];
            $_SESSION['de_user']       = $resultData['de_user'];
            $_SESSION['de_mail']       = $resultData['de_mail'];
            $_SESSION['authenticated'] = true;
            
            return $this->responseAPI("success", "Login success!", 200, $resultData);
        } else {
            return $this->responseAPI("error", "Login fail!", 200);
        }
        
    }
    
    /**
     * Validate signUp and insert new user to database.
     * @param $username username of new user
     * @param $fullName full name of new user
     * @param $password password of new user
     * @param $email    email of new user
     * @return object of $this->responseAPI()
     */
    public function signUp($fullName, $username, $password, $email)
    {
        
        // validate username, password and email
        if ($this->validateUsername($username) == false) {
            return $this->responseAPI("error", "Sorry, this username is invalid.", 200);
        }
        
        if ($this->validatePassword($password) == false) {
            return $this->responseAPI("error", "Sorry, this password is invalid.", 200);
        }
        if ($this->validateEmail($email) == false) {
            return $this->responseAPI("error", "Sorry, this email is invalid.", 200);
        }
        
        if ($this->validateUserAlreadyRegistered($username, $email) == true) {
            return $this->responseAPI("error", "Sorry, this username/email is already registered.", 200);
        }
        
        /* @todo This could be abstracted. */
        require(APP_DIR . "/database/databaseConnector.php");
        
        try {
            $PDOConnector = new PDOConnector($mysql);
            
        }
        catch (Exception $e) {
            
            return $this->responseAPI("error", $e->getMessage(), 200);
        }
        
        $connector = $PDOConnector->getConnection();
        
        $encrypted_password = md5($password);
        
        try {
            
            $insert = $connector->prepare("INSERT INTO adm_users ( de_name, de_user, de_pass, de_mail ) values ( ?, ?, ?, ? )");
            
            $insert->bindParam(1, $fullName);
            $insert->bindParam(2, $username);
            $insert->bindParam(3, $encrypted_password);
            $insert->bindParam(4, $email);
            
            $insert->execute();
            
        }
        catch (Exception $e) {
            return $this->responseAPI("error", $e->getMessage(), 200);
        }
        
        // login through of right way       
        $this->login($username, $password);
    }
    
    /**
     * Checks if the user already exists
     * @param $username username for validate
     * @param $email    email for validate
     * @return true (don't registered) false (already exists)
     */
    public function validateUserAlreadyRegistered($username, $email)
    {
        
        /* @todo This could be abstracted. */
        require(APP_DIR . "/database/databaseConnector.php");
        
        try {
            $PDOConnector = new PDOConnector($mysql);
            
        }
        catch (Exception $e) {
            
            return $this->responseAPI("error", $e->getMessage(), 200);
        }
        
        $connector = $PDOConnector->getConnection();
        
        try {
            
            $getUserData = $connector->prepare("SELECT de_user, de_mail from adm_users WHERE de_user=:de_user OR de_mail=:de_mail");
            $getUserData->bindParam(':de_user', $username, PDO::PARAM_STR);
            $getUserData->bindParam(':de_mail', $email, PDO::PARAM_STR);
            $getUserData->execute();
            
            $resultData = $getUserData->fetch(PDO::FETCH_ASSOC);
            
            if (empty($resultData)) {
                return false;
            }
            
        }
        catch (Exception $e) {
            return $this->responseAPI("error", $e->getMessage(), 200);
        }
        
        return true;
    }
    
    /**
     * Validate username
     * @param $username username for validation
     * @return true valid username, false invalid username
     */
    public function validateUsername($username)
    {
        
        // The first Character of username must be uppercase.
        // Username must be between 8 and 24 characters.
        // Checks if all of the characters in the provided username are alphanumeric [A-Z or a-z or decimal numbers].
        $usernameRules = "(^[A-Z][a-zA-Z0-9]{8,24}$)";
        
        if (!preg_match($usernameRules, $username)) {
            return false;
        }
        
        return true;
        
    }
    
    /**
     * Validate password with regular expression
     * @param $password password for validation
     * @return true valid password, false invalid password
     */
    public function validatePassword($password)
    {
        
        // must contains one digit from 0-9
        // must contains one lowercase characters
        // must contains one uppercase characters
        // must contains one special symbols in the list "@#$%"
        // match anything with previous condition checking length at least 6 characters and maximum of 20
        $passwordRules = "((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%]).{6,20})";
        
        if (!preg_match($passwordRules, $password)) {
            return false;
        }
        
        return true;
        
    }
    
    /**
     * Validate email with regular expression
     * @param $email email for validation
     * @return true valid email or false invalid email
     */
    public function validateEmail($email)
    {
        
        /* @todo need be improved. */
        $emailRule = "(^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$)";
        
        if (!preg_match($emailRule, $email)) {
            return false;
        }
        
        return true;
        
    }
    
    public function __destruct()
    {
        return true;
    }
}
