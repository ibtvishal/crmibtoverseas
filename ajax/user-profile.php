<?php
include('../include/config.php');
include("../include/functions.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $did = $_SESSION['sess_admin_id'];
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === 0) {
        $uploadsDir = '../uploads/';
        $fileName = uniqid() . '.png'; // Save the file as PNG
        $filePath = $uploadsDir . $fileName;

        // Ensure uploads directory exists
        if (!is_dir($uploadsDir)) {
            mkdir($uploadsDir, 0777, true);
        }

        // Move uploaded file
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $filePath)) {
            $obj->query("update $tbl_admin set img = '$fileName' where id='$did'",-1); //die; 
            $obj->query("update $tbl_support_user set img = '$fileName' where id='$did'",-1); //die; 
            echo "Image successfully uploaded: $fileName";
        } else {
            echo "Error saving the image.";
        }
    } else {
        echo "No valid image provided.";
    }
}
?>
