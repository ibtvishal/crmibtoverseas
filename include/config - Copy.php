<?php  
ob_start();
@session_start();
error_reporting(0);
//error_reporting(E_ALL);
$hostname = '172.16.109.88';

$username = 'admibt';
$password ='QWr3RESR$E$^%D';
$db_name = 'admibtovs';

global $obj;
		
ini_set('date.timezone', 'Asia/Kolkata');
require_once("db.class.php");
require_once("variable.php");
$obj = new DB($hostname, $username, $password, $db_name); 
@define('SITE_URL',"http://admission.ibtoverseas.com/");
@define('SITE_TITLE',"IBT CRM");

//header('Content-Type: text/html; charset=iso-8859-1');
	
?>
