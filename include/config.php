<?php  
ob_start();
@session_start();
error_reporting(0);
//error_reporting(E_ALL);
$hostname = 'localhost';

$username = 'root';
$password ='';
$db_name = 'ibt';

global $obj;
		
ini_set('date.timezone', 'Asia/Kolkata');
require_once("db.class.php");
require_once("variable.php");
$obj = new DB($hostname, $username, $password, $db_name); 
@define('SITE_URL',"http://localhost/admissioncrm/");
@define('SITE_TITLE',"IBT CRM");
//header('Content-Type: text/html; charset=iso-8859-1');
	
?>
