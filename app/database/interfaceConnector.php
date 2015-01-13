<?php

/**
 * Interface for PDOConnector.
 *
 * @copyright Copyright (c) 2014, Felipe Lunardi Farias <ffarias.dev@gmail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
interface interfaceConnector
{
    
    public function connect(abstractConnectorConfig $connectorConfig);
    public function disconnect();
    public function isConnected();
    public function getConnection();
    
}