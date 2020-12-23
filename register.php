<?php
require_once("libraries/password_compatibility_library.php");
require_once("config/db.php");
require_once("classes/Registration.php");
$registration = new Registration();
include("views/register.php");
?>