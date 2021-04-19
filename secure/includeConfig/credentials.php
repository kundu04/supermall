<?php

#################################### SERVER CONFIGURATION ####################################
date_default_timezone_set("Asia/Dhaka");
define("BASE_URL", "http://127.0.0.1/SSLN/novostar.novocare.com/");

define("MAIL_HOST_1", "ssl://smtp.gmail.com");
define("MAIL_PORT_1", "465");
define("OUTGOING_MAIL_ID_1", "dipanlawyer@gmail.com");
define("OUTGOING_MAIL_PASS_1", "advocate2016");

#################################### PATH CONFIGURATION ####################################
define('PDF_DLD_PATH', 'download/pdf/');  

#################################### INCLUDE CONFIGURATION ####################################
require_once('novaLibrary/MPDF54/mpdf.php');

#################################### DATABASE CONFIGURATION ####################################
define('HOSTNAME_1', 'localhost');  
define('USERNAME_1', 'root'); 
define('PASSWORD_1', ''); 
define('DATABASE_1', 'supermall'); 

?>