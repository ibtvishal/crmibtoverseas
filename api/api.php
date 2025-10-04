<?php 
session_start();
include('../include/config.php');
include("../include/functions.php");

$code = 400;
$status = false;
$msg = 'No Found';
if(isset($_POST['submit_enquiry'])){
    if($_POST['api_key'] == 'APIofIBT@147#8520'){
        $res = $obj->fetchNextObject($obj->query("select * from $tbl_admin where level_id=9 and status=1 order by rand() limit 1"));
        
        $name = $obj->escapestring($_POST['name']);
        $number = $obj->escapestring($_POST['number']);
        $country = $obj->escapestring($_POST['country']);
        $visa_type = $obj->escapestring($_POST['visa_type']);
        $url = $obj->escapestring($_POST['url']);
        
        $insert = $obj->query("insert $tbl_enquiry set `crm_executive_id`='171',`name`='$name',`number`='$number',`country`='$country',`visa_type`='$visa_type',`url`='$url'");
        
        $status = true;
        $code = 200;
        $msg = 'API Key matched';
        
    }else{
        $status = false;
        $code = 400;
        $msg = 'API Key not matching';
    }
}


$array = [
    'status' => $status,
     'message' => $msg
];
http_response_code($code);
echo json_encode($array);

?>