<?php
session_start(); 
include("../include/config.php");
include("../include/functions.php"); 
validate_user(); // Ensure the user is validated before fetching the data

$month = date('m');
$year = date('Y');
$status = isset($_GET['status']) ? $_GET['status'] : ''; // Get the status parameter

if (!empty($status)) {
    // Query to fetch data based on the status
    $query = "SELECT a.am_id, COUNT(*) as total 
              FROM `$tbl_student` as a
              left JOIN $tbl_student_application as b 
              ON b.stu_id=a.id
              WHERE a.am_id != 0 
              AND YEAR(b.cdate) = $year 
              AND MONTH(b.cdate) = $month
              AND b.status='$status'
              AND b.parent_id='0'
              GROUP BY a.am_id ORDER BY  COUNT(*) desc";
    
    $result = $obj->query($query, -1);

    $dataPoints = [];
    while ($res = $obj->fetchNextObject($result)) {
        $name = addslashes(getField('name', $tbl_admin, $res->am_id));
        $dataPoints[] = [
            "y" => (int)$res->total,
            "label" => $name
        ];
    }

    // Return the data as JSON
    header('Content-Type: application/json');
    echo json_encode($dataPoints);
} else {
    // Return an error if status is not provided
    echo json_encode(["error" => "No status provided"]);
}
?>
