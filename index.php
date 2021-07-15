<?php

//Connecting basic scripts from a folder scripts/
include_once "scripts/main_scripts.php";

//Start session
session_start();

session_destroy();

//Connecting a script for loading page content
include_once get_path_to_page();

?>