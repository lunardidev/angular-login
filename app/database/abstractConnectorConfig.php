<?php

/**
 * Abstract configurations of database connectors
 *
 * @abstract
 * @copyright Copyright (c) 2014, Felipe Lunardi Farias <ffarias.dev@gmail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
abstract class abstractConnectorConfig
{
    
    /** @var string|null Should contain the host of your database. */
    private $host = null;
    
    /** @var string|null Should contain the database name of your database. */
    private $dbname = null;
    
    /** @var string|null Should contain the username of your database. */
    private $user = null;
    
    /** @var string|null Should contain the password of your database. */
    private $password = null;
    
    /**
     * Set the initial properties
     * @param $host     host for access database
     * @param $dbname   dbname for access database
     * @param $user     user for access database
     * @param $password password for access database
     * @return void
     */
    public function __construct($host, $dbname, $user, $password)
    {
        
        $this->host     = $host;
        $this->dbname   = $dbname;
        $this->user     = $user;
        $this->password = $password;
    }
    
    public function getHost()
    {
        return $this->host;
    }
    
    public function getDbname()
    {
        return $this->dbname;
    }
    
    public function getUser()
    {
        return $this->user;
    }
    
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     *  Needs to be rewritten for each driver.
     * @abstract
     */
    abstract public function getDsn();
}