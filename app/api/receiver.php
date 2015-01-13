<?php

/**
 * This class is responsible for receiver of requests HTTP ou HTTPS
 *
 * @copyright Copyright (c) 2014, Felipe Lunardi Farias <ffarias.dev@gmail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class receiver extends Rest
{
    
    /**
     * Search and execute the request of API service.
     * @return void
     */
    public function __construct($is_test = false)
    {
        
        $this->is_test = $is_test;
        
        $class = explode("/", $_REQUEST['api']);
        $func  = strtolower(trim($class[1]));
        $class = strtolower(trim($class[0]));
        
        if (file_exists(APP_DIR . "/api/{$class}.php")) {
            
            require_once(APP_DIR . "/api/{$class}.php");
            
            if ((int) method_exists($class, $func) > 0) {
                $class = new $class($class, $func);
                $class->$func();
            } else {
                $this->response(json_encode(array(
                    "error" => 404,
                    "api" => $class . "." . $func,
                    "message" => "API not found."
                )), 404);
            }
            
        } else {
            $this->response(json_encode(array(
                "error" => 404,
                "api" => $class . "." . $func,
                "message" => "API not found."
            )), 404);
        }
    }
    
}

$receiver = new receiver;

?>