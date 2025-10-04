<?php   
ob_start();
@session_start();
error_reporting(0);
//error_reporting(E_ALL);
$hostname = '172.16.109.88';

$username = 'ibtindiaerp';
$password ='Oohe5#Ood9s@haip6Phier';
$db_name = 'ibtindiaerp';

global $obj;
ini_set('date.timezone', 'Asia/Kolkata');
require_once("db.class.php");
require_once("variable.php");
$obj = new DB($hostname, $username, $password, $db_name); 
@define('SITE_URL',"http://erp1.ibtindia.com/");
@define('SITE_TITLE',"ERP SOLUTIONS");

$website_currency_code='₹';
$website_currency_symbol="<i class='fa fa-inr'></i>";


$config_aws_buckect_name    =    "english-prep";
$config_aws_s3_key          =    "AKIA2UNV7J4PN3HG7MHO";
$config_aws_secret_key      =    "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";
$config_aws_s3_region       =    "asdwqdqwd";
$config_aws_emailer_key     =    "qwdwqd";
$config_aws_emailer_region  =    "wqdqwd";


define("AMS_BUCKET_NAME",$config_aws_buckect_name);
define("AWS_SES_KEY",$config_aws_s3_key);
define("AWS_SECRET",$config_aws_secret_key);

?>
