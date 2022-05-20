<?php

//require the config folder file
require_once ('../app/configure/configure.php');

//require the helpers
require_once("../app/helpers/mvc_helpers.php");

//Automatically load all the classes from libraries
spl_autoload_register(function($class){
    require_once('libraries/' .$class. '.php');
});
