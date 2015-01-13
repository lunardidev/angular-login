<?php


/**
 * Interface for the API classes
 *
 * @copyright Copyright (c) 2014, Felipe Lunardi Farias <ffarias.dev@gmail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
interface interfaceApi
{
    
    /**
     * This method should be written in your API class (for example api/users.php)
     */
    public function responseAPI($status, $message, $code);
    
}