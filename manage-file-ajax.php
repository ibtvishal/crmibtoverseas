<?php
session_start(); 
include("include/config.php");
include("include/functions.php"); 
validate_user();
$requestData = $_REQUEST;
$columns = array(
    0 =>'id'
);

$sql = "SELECT $tbl_file.id as id,
        $tbl_file.file_name as file_name,
        $tbl_file.file as file,
        $tbl_file.for_student_view as for_student_view,
        $tbl_file.status as status,
        $tbl_file.country_id as country_id,
        $tbl_file.visa_id as visa_id,
        $tbl_download_subcategory.name as subcat_name,
        $tbl_download_category.name as cat_name  
        FROM $tbl_file 
        INNER JOIN $tbl_download_category ON $tbl_file.category_id = $tbl_download_category.id 
        INNER JOIN $tbl_download_subcategory ON $tbl_file.subcategory_id = $tbl_download_subcategory.id";

if (!empty($requestData['search']['value'])) {
    $sql .= " WHERE ( $tbl_file.file_name LIKE '%".$requestData['search']['value']."%' ";    
    $sql .= " OR $tbl_download_category.name LIKE '%".$requestData['search']['value']."%' ";
    $sql .= " OR $tbl_download_subcategory.name LIKE '%".$requestData['search']['value']."%' )";
}

$query = $obj->query($sql);
$totalFiltered = $totalData = $obj->numRows($query);

$data = array();
$i = 1;
while ($line = $obj->fetchNextObject($query)) { 
    $nestedData = array();
    $nestedData[] = $i;
    $nestedData[] = getField('name',$tbl_country,$line->country_id);
    $nestedData[] = get_visa_type($line->visa_id);
    $nestedData[] = $line->cat_name;
    $nestedData[] = $line->subcat_name;
    $nestedData[] = "<a href='uploads/".$line->file."' target='_blank' download>". $line->file_name ."</a>";
    $nestedData[] = '<div class="material-switch"><input id="someSwitchOptionPrimarys'.$i.'" type="checkbox" value="'.$line->id.'" '.($line->for_student_view=="1" ? "checked" : "").' onchange="change_visit_status(this)"/><label for="someSwitchOptionPrimarys'.$i.'" class="label-primary"></label></div>';
    $nestedData[] = '<div class="material-switch"><input id="someSwitchOptionPrimary'.$i.'" type="checkbox" class="chkstatus" value="'.$line->id.'" '.($line->status=="1" ? "checked" : "").' data-one="'.$tbl_file.'" /><label for="someSwitchOptionPrimary'.$i.'" class="label-primary"></label></div><script src="js/change-status.js"></script>';
    $nestedData[] = '<a href="add-file.php?id='.base64_encode(base64_encode(base64_encode($line->id))).'"><i class="fa fa-edit" style="margin-right: 6px;font-size: 16px;"></i></a>
                    <a href="controller.php?file_delete_id='.$line->id.'" class="delete_button" onclick="return confirm(\'Are you sure you want to delete record(s)\')" style="background: transparent; border: none;"><i class="fa fa-trash" style="margin-right: 6px;font-size: 16px;"></i></a>';
    $data[] = $nestedData;
    $i++;
}

$json_data = array(
    "draw"            => intval($requestData['draw']),
    "recordsTotal"    => intval($totalData),
    "recordsFiltered" => intval($totalFiltered),
    "data"            => $data
);

echo json_encode($json_data);
?>
