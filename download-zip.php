<?php
session_start();
include('include/config.php');
include("include/functions.php");
validate_admin();

error_reporting(0);
ob_start();
$get = $obj->query("SELECT * FROM tbl_student ORDER BY id ASC LIMIT ".$_GET['from'].", ".$_GET['limit']);

if ($obj->numRows($get) > 0) {
    // Create a new ZIP archive
    $zip = new ZipArchive();
    $zip_filename = tempnam(sys_get_temp_dir(), 'student_documents') . '.zip';

    if ($zip->open($zip_filename, ZipArchive::CREATE) !== TRUE) {
        die("Could not open ZIP file for writing.");
    }

    // Flag to check if any file has been added
    $file_added = false;

    while ($res = $obj->fetchNextObject($get)) {
        $sql = "SELECT * FROM $tbl_student_document WHERE stu_id = '$res->id'";
        $result = $obj->query($sql);

        while ($row = $obj->fetchNextObject($result)) {
            $stu_id = $res->student_no;
            $document_url = 'https://crm.ibtoverseas.com/uploads/' . $row->name;

            // Download the file
            $file_content = file_get_contents($document_url);
            if ($file_content !== false) {
                // Create a temp file and write the content
                $temp_file = tempnam(sys_get_temp_dir(), 'document_');
                file_put_contents($temp_file, $file_content);
                
                // Add the file to the zip archive
                $zip->addFile($temp_file, $stu_id . '/' . $row->name);
                $file_added = true; // Mark that a file was added
            } else {
                error_log("Failed to download file: " . $document_url);
            }
        }
    }

    if ($file_added) {
        $zip->close();
        ob_end_clean();

        // Set headers for download
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="student_documents.zip"');
        header('Content-Length: ' . filesize($zip_filename));

        readfile($zip_filename);
        unlink($zip_filename); // Remove the zip file after download
    } else {
        ob_end_clean();
        echo "No valid files to add to ZIP!";
    }
} else {
    ob_end_clean();
    echo "No documents found!";
}
?>
