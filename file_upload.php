<?php

include('include/config.php');
include("include/functions.php");
//validate_user();
// print_r($_FILES);
$dtype = $obj->escapestring($_REQUEST['dtype']);
$stu_id = $obj->escapestring($_REQUEST['stu_id']);

$studentid = getField('student_no',$tbl_student,$stu_id);
$fileData="";

if (isset($_FILES['file']['name'][0])) {
  foreach ($_FILES['file']['name'] as $keys => $values) {
      $fileName = pathinfo($_FILES['file']['name'][$keys], PATHINFO_FILENAME);

      $fileName = preg_replace('/[^a-zA-Z0-9-_]/', '_', $fileName); 
      $fileName = str_replace(' ', '_', $fileName);
      $fileName = generateSlug($obj->escapestring($fileName)); 
      $file = pathinfo($_FILES['file']['name'][$keys]);
      $fileType = $file["extension"];

      $desiredExt = match ($fileType) {
          'docx', 'doc', 'xlsx', 'xls', 'pdf' => $fileType,
          default => $fileType,
      };

      if ($dtype == 24 || $dtype == 39) {
          $col = 4;
          $style = "width: 100%; height: 150px;";
      } else {
          $col = 2;
          $style = "width: 130px; height: 150px;";
      }

      $fileNameNew = $fileName . "_" . $studentid . "." . $desiredExt;

      $suffix = 1;
      while ($obj->numRows($obj->query("SELECT * FROM $tbl_student_document WHERE name='$fileNameNew' AND status=1")) > 0) {
          $fileNameNew = $fileName . "_" . $studentid . "($suffix)." . $desiredExt;
          $suffix++;
      }

      // Move uploaded file
      if (move_uploaded_file($_FILES['file']['tmp_name'][$keys], 'uploads/' . $fileNameNew)) {
          $fileData .= '<div class="col-md-' . $col . ' col-12 documnt">';
          
          if (in_array($desiredExt, ['docx', 'doc'])) {
              $fileData .= '<a href="uploads/' . $fileNameNew . '" download><img src="uploads/docs.jpg" class="thumbnail" style="' . $style . '" /></a>';
          } elseif (in_array($desiredExt, ['xlsx', 'xls'])) {
              $fileData .= '<a href="uploads/' . $fileNameNew . '" download><img src="uploads/xlx.jpg" class="thumbnail" style="' . $style . '" /></a>';
          } elseif ($desiredExt === 'pdf') {
              $fileData .= '<a href="uploads/' . $fileNameNew . '" download><img src="uploads/download.png" class="thumbnail" style="' . $style . '" /></a>';
          } else {
              $fileData .= '<img src="uploads/' . $fileNameNew . '" class="thumbnail" style="' . $style . '" />';
          }

          if($dtype == 44){
              $obj->query("DELETE FROM $tbl_student_document WHERE stu_id='$stu_id' and dtype='44'");
          }
          $obj->query("INSERT INTO $tbl_student_document SET stu_id='$stu_id', dtype='$dtype', name='$fileNameNew', user_id='" . $_SESSION['sess_admin_id'] . "', desiredExt='$desiredExt'");
          $lastId = $obj->lastInsertedId();
          
          $fileData .= '<p style="font-size:10px;">' . substr($fileNameNew, 0, 10) . '.' . $desiredExt . '</p>';
          $fileData .= '<a href="javascript:void(0);" class="documnet-view" onclick="documentview(1,' . $lastId . ')"></a>';
          $fileData .= '<a href="javascript:void(0);" class="documnet-del" onclick="documentdel(this,' . $lastId . ')"></a>';
          $fileData .= '</div>';
          if($dtype == 43){
              $get = $obj->numRows($obj->query("SELECT * FROM $tbl_student_passport_noc WHERE stu_id='$stu_id' and `value`='form'"));
                if($get == 0){
              $obj->query("INSERT INTO $tbl_student_passport_noc SET stu_id='$stu_id',user_id='".$_SESSION['sess_admin_id']."', `value`='form'");
                }
            }elseif($dtype == 27){
              $get = $obj->numRows($obj->query("SELECT * FROM $tbl_student_passport_noc WHERE stu_id='$stu_id' and `value`='visa'"));
                if($get == 0){
              $obj->query("INSERT INTO $tbl_student_passport_noc SET stu_id='$stu_id',user_id='".$_SESSION['sess_admin_id']."', `value`='visa'");
                }
          }
      }
  }
}

echo $fileData;

?>