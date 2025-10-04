<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php'); ?>
</head>
<style type="text/css">
.material-switch>input[type="checkbox"] {
    display: none;
}

.material-switch>label {
    cursor: pointer;
    height: 0px;
    position: relative;
    width: 40px;
}

.material-switch>label::before {
    background: rgb(0, 0, 0);
    box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
    border-radius: 8px;
    content: '';
    height: 16px;
    margin-top: -8px;
    position: absolute;
    opacity: 0.3;
    transition: all 0.4s ease-in-out;
    width: 40px;
}

.material-switch>label::after {
    background: rgb(255, 255, 255);
    border-radius: 16px;
    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
    content: '';
    height: 24px;
    left: -4px;
    margin-top: -8px;
    position: absolute;
    top: -4px;
    transition: all 0.3s ease-in-out;
    width: 24px;
}

.material-switch>input[type="checkbox"]:checked+label::before {
    background: inherit;
    opacity: 0.5;
}

.material-switch>input[type="checkbox"]:checked+label::after {
    background: inherit;
    left: 20px;
}
</style>

<body>
    <!--Preloader-->
    <div class="preloader-it">
        <div class="la-anim-1"></div>
    </div>
    <!--/Preloader-->
    <div class="wrapper theme-1-active pimary-color-green">
        <?php include("menu.php"); ?>

        <!-- Main Content -->
        <div class="page-wrapper">
            <div class="container-fluid">
                <!-- Title -->
                <div class="row heading-bg">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <h5 class="txt-dark">Download Section</h5>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-center">
                        <h5 style="color:#2a911d;" id="sess_msg">
                            <?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
                        <h5 style="color:red;">
                            <?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
                    </div>
                    <!-- Breadcrumb -->

                </div>
                <!-- /Title -->

                <!-- Row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">

                            <form name="frm" method="post" action="category-del.php" enctype="multipart/form-data">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body">
                                        <div class="table-wrap">
                                            <div class="table-responsive">
                                                <table id="datable_3" class="table table-hover display pb-30"
                                                    style="">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr. No.</th>
                                                            <th>Country Name</th>
                                                            <th>Visa Type</th>
                                                            <th>Category Name</th>
                                                            <th>Subcategory Name</th>
                                                            <th>File Name</th>
                                                            <th>Download</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql = $obj->query("SELECT $tbl_file.id as id,
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
                                                        INNER JOIN $tbl_download_subcategory ON $tbl_file.subcategory_id = $tbl_download_subcategory.id");
                                                        $c = 1;
                                                        while($line = $obj->fetchNextObject($sql)){
                                                            ?>
                                                            <tr>
                                                                <td><?=$c++?></td>
                                                                <td><?=getField('name',$tbl_country,$line->country_id)?></td>
                                                                <td><?=get_visa_type($line->visa_id);?></td>
                                                                <td><?=$line->cat_name;?></td>
                                                                <td><?=$line->subcat_name;?></td>
                                                                <td><?="<a href='uploads/".$line->file."' target='_blank' download>". $line->file_name ."</a>"?></td>
                                                                <td><?="<a href='uploads/".$line->file."' target='_blank' download><i class='fa fa-cloud-download fa-lg'></i></a>";?></td>
                                                            </tr>
                                                            <?php
                                                        }                                                                                                        
                                                        ?>
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /Row -->

                <!-- Footer -->
                <footer class="footer container-fluid pl-30 pr-30">
                    <div class="row">
                        <div class="col-sm-12">
                            <p>2023 &copy; Powered by IBT India Pvt Ltd</p>
                        </div>
                    </div>
                </footer>
                <!-- /Footer -->

            </div>
        </div>
        <!-- /Main Content -->

    </div>
    <!-- /#wrapper -->

    <?php include("footer.php"); ?>
    
    <script>
    // $(document).ready(function() {
    //     var dataTable = $('#ApplicationList').DataTable({
    //         "processing": true,
    //         "serverSide": true,
    //         "stateSave": false,
    //         "lengthMenu": [[50, 100, 500, 1000, 1500], [50, 100, 500, 1000, 1500]],
    //         "pageLength": 50,     
    //         "aoColumnDefs": [
    //             { "bSortable": false, "aTargets": [0, 1, 2, 3, 4] }, 
    //             { "bSearchable": true, "aTargets": [0, 1, 2, 3, 4] }
    //         ],
    //         "ajax": {
    //             url: "download-section-ajax.php",
    //             type: "post",
    //             error: function() { 
    //                 $(".product-grid-error").html("");
    //                 $("#ApplicationList").append('<tbody class="product-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
    //                 $("#ApplicationList_processing").css("display", "none");
    //             }
    //         }
    //     });
    // });
</script>

</body>

</html>