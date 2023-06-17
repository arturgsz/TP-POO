<?php
require_once "./src/System.php";

$us = new UserAuthenticate();
$us->LogIn("Cruze","1234");

System::cleanDB();
//$user = new User("Cruze","cruze@gmail.com","1234");

