<?php

spl_autoload_register(function ($className) {
    $path = trim(__DIR__, 'core');

    require $path . "/models/" . $className . ".php";
});

require "Config.php";
require "functions.php";
require "Database.php";
require "Model.php";
require "Controller.php";
require "App.php";
require "Pager.php";
