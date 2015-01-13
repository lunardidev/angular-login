<?php

/**
 * Driver for connect to MySQL.
 *
 * @copyright Copyright (c) 2014, Felipe Lunardi Farias <ffarias.dev@gmail.com>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */
class mySQLConnectorConfig extends abstractConnectorConfig
{
    public function getDsn()
    {
        return sprintf('mysql:host=%s;dbname=%s', $this->getHost(), $this->getDbname());
    }
}