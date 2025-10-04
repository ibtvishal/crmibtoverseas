<?php
session_start();
include("../include/config.php");
include("../include/functions.php"); 
validate_user();
  
//Image Crop
include("./thumb_functions.php");
define('IMAGE_SMALL_DIR', '../upload_images/category/thumb/');
define('IMAGE_SMALL_SIZE', 800);


error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the file was uploaded without errors
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
		$id = $_POST['id']; 
$file = $_FILES['file'];

// Define a directory to save the uploaded file
$uploadDir = '../uploads/pdf/'; // Ensure this directory exists and is writable
$filePath = $uploadDir . basename($file['name']);
$fileInfo = pathinfo($file['name']);
$fileType = $fileInfo['extension'];
$desiredExt = 'pdf';

if ($fileType !== $desiredExt) {
    die('Error: Only PDF files are allowed.');
}

// Generate a new file name
$fileNameNew = rand(333, 999) . time() . ".$desiredExt";

if (move_uploaded_file($file['tmp_name'], $uploadDir . $fileNameNew)) {
	 	$sql=" update tbl_visit_fee set pdf_path='$fileNameNew' where id='$id'";
	   	$obj->query($sql);

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

    }
} else {
    // Respond with an error if the request method is not POST
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}


?>