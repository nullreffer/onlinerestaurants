<?php

/**
 * database.php
 *
 * application database configuration
 *
 * @package		TinyMVC
 * @author		Monte Ohrt
 */

$config['default']['plugin'] = 'TinyMVC_PDO'; // plugin for db access
$config['default']['type'] = 'mysql';      // connection type
$config['default']['host'] = 'localhost';  // db hostname
$config['default']['name'] = 'iamjayde_food';     // db name
$config['default']['user'] = 'iamjayde_food';     // db username
$config['default']['pass'] = 'f00d!st1';     // db password
$config['default']['persistent'] = false;  // db connection persistence?

?>
