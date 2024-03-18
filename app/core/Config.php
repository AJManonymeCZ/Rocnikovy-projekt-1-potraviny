<?php

/**
 * app info
 */
define('APP_NAME', 'Potraviny');
define('APP_DESC', '');


/**
 * database config
 */

if ($_SERVER['SERVER_NAME'] == 'localhost') {
    //database config for your local server
      define("DBHOST", "localhost");
      define("DBNAME", "potraviny");
      define("DBUSER", "root");
      define("DBPASS", "root");
      define("DBDRIVER", "mysql");
      define("DBCHARSET", "utf8");
      define("MYEMAIL", 'fidakaleja@seznam.cz');

  // root path e.g localhost
    define('ROOT', 'http://localhost/projekt-potraviny/public');
} else {
  //database config for your live server

}
