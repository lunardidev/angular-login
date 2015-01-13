<?php

// Dependencies
require_once(APP_DIR . "/database/interfaceConnector.php");
require_once(APP_DIR . "/database/abstractConnectorConfig.php");

// @todo: implement and add all drivers that you need.
require_once(APP_DIR . "/database/drivers/pdo_mysql.php");

/**
 * The PDOConnector should be implemented following this interface
 *
 * @copyright Copyright (c) 2014, Felipe Lunardi Farias <ffarias.dev@gmail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class PDOConnector implements interfaceConnector
{
    
    /**
     * Active instance for access your database.
     * @var instance 
     */
    private $instance;
    
    public function __construct(abstractConnectorConfig $connectorConfig)
    {
        $this->connect($connectorConfig);
    }
    
    /**
     * Connect into your DataBase
     *
     */
    public function connect(abstractConnectorConfig $connectorConfig)
    {
        if (!$this->isConnected()) {
            
            try {
                $this->instance = new PDO($connectorConfig->getDsn(), $connectorConfig->getUser(), $connectorConfig->getPassword());
            }
            catch (PDOException $e) {
                throw new Exception("Error to connect on your database." . $e->getMessage());
            }
            
            $this->instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }
    
    /**
     * Simple method for disconnect to database
     */
    public function disconnect()
    {
        if ($this->isConnected()) {
            $this->instance = null;
        }
    }
    
    /**
     * Test your connection
     */
    public function isConnected()
    {
        return ($this->instance instanceof PDO);
    }
    
    /**
     * Test your connection
     */
    public function getConnection()
    {
        return $this->instance;
    }
}

// Organize your connections for mysql (oracle or whatever)
$mysql = new mySQLConnectorConfig('localhost', 'angular-login', 'root', '');
