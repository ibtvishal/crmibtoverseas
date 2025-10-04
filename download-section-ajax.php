<?php
session_start(); 
include("include/config.php");
include("include/functions.php"); 
$requestData = $_REQUEST;
$columns = array(
    0 =>'id'
);

$sql = "SELECT $tbl_file.id as id,
        $tbl_file.file_name as file_name,
        $tbl_file.file as file,
        $tbl_file.status as status,
        $tbl_file.country_id as country_id,
        $tbl_file.visa_id as visa_id,
        $tbl_download_subcategory.name as subcat_name,
        $tbl_download_category.name as cat_name  
        FROM $tbl_file 
        INNER JOIN $tbl_download_category ON $tbl_file.category_id = $tbl_download_category.id 
        INNER JOIN $tbl_download_subcategory ON $tbl_file.subcategory_id = $tbl_download_subcategory.id
        WHERE $tbl_file.status = '1'";

if (!empty($requestData['search']['value'])) {
    $sql .= " AND ( $tbl_file.file_name LIKE '%".$requestData['search']['value']."%' ";    
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
    $nestedData[] = "<a href='uploads/".$line->file."' target='_blank' download><i class='fa fa-cloud-download fa-lg'></i></a>";
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
