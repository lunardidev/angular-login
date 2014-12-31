<?php

    require_once(APP_DIR."/database/PDOConnector.php");

    // Organize your connections for mysql (oracle or whatever)
    $mysql = new mySQLConnectorConfig( '127.0.0.1','angular-login', 'root', '' );