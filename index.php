<?php
//Connecting basic scripts from folder scripts/
include_once "scripts/main_scripts.php";
include_once "scripts/database_scripts.php";
include_once "scripts/profile_scripts.php";
include_once "scripts/goods_scripts.php";

//Start session
session_start();

user_register($connect);
user_login($connect);
ses_destroy();
buy_goods($connect);

//Connecting a script for loading page content
include_once get_path_to_page();
