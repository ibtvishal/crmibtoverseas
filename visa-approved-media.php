<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$whr = '';
$whr1 = '';
$join = '';
$group = '';
$_SESSION['whr']='';
if($_SESSION['level_id'] == 26){
    $branchid = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    $whr .= " and a.branch_id in ($branchid)";
  }
  if($_REQUEST['branch_id']){
    $branchArr = $_REQUEST['branch_id'];
    $branch_id = implode(',',$branchArr);
    $whr .= " and a.branch_id in ($branch_id)";
  }
  if($_REQUEST['filter_start_date'] && $_REQUEST['filter_end_date']){
    $filter_start_date = $_REQUEST['filter_start_date'];
    $filter_end_date = $_REQUEST['filter_end_date'];
    $whr .= " and date(b.cdate) >= '$filter_start_date' and date(b.cdate) <= '$filter_end_date'";
  }
  
if($_REQUEST['country_id']){
    $country_id = $_REQUEST['country_id'];
    $whr .= " and a.country_id=$country_id";
}

if($_REQUEST['status']){
    $status = $_REQUEST['status'];
    if($status == 'Pending Review'){
        $join = " LEFT JOIN $tbl_student_passport_noc AS c ON a.id = c.stu_id AND c.value = 'google'";
        $whr1 .= " and c.stu_id IS NULL";
    }
    if($status == 'Pending Video'){
        $join = " LEFT JOIN $tbl_student_passport_noc AS c ON a.id = c.stu_id AND c.value = 'Video'";
        $whr1 .= " and c.stu_id IS NULL";
    }
    if($status == 'All Done'){
        $join = " INNER JOIN $tbl_student_passport_noc AS c ON a.id = c.stu_id";
        $whr1 .= " and c.value IN ('google', 'video')";
        $group = " GROUP BY a.id HAVING COUNT(DISTINCT c.value) = 2";
    }
  }

  $_SESSION['whr']=$whr;
  $_SESSION['whr1']=$whr1;
  $_SESSION['join']=$join;
  $_SESSION['group']=$group;
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

    .dt-buttons {
        float: none !important;
        margin-top: 15px !important;
    }

    .buttons-csv {
        float: right !important;
        margin-top: 15px !important;
    }

    .text-pagination {
        width: 304px;
        position: absolute;
        top: 1.5%;
        left: 15%;
    }
</style>

<body>
    <div class="preloader-it">
        <div class="la-anim-1"></div>
    </div>
    <div class="wrapper theme-1-active pimary-color-green">
        <?php include("menu.php"); ?>

        <div class="page-wrapper">
            <div class="container-fluid">
                <h5 style="color:#2a911d; text-align: center;">
                    <?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
                <h5 style="color:red;"><?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
                <div class="row heading-bg">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h5 class="txt-dark">Visa Approved</h5>
                    </div>
                    <div class="breadcrumb-section col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                            <li class="active"><span><a href="#">Visa Approved</a></span></li>
                        </ol>
                    </div>
                </div>

                <form action="" method="post" id="form_submit">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="branch_id[]" id="branch_id" class="form-control select2" multiple=""
                                    onchange="submit_form()">
                                    <?php
                                        if(!empty($_REQUEST['branch_id'])){
                                        $branchArr = $_REQUEST['branch_id'];
                                        }elseif(isset($branchids)){
                                        $branchArr = $branchids;
                                        }else{
                                        $branchArr = array();
                                        }                      
                                        $b_con = '';
                                        if($_SESSION['level_id']!=1){
                                        $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                        $b_con = " and id in ($branch_id)";
                                        }
                                        $branchSql = $obj->query("select * from $tbl_branch where status=1 $b_con");
                                        while($branchResult = $obj->fetchNextObject($branchSql)){?>
                                    <option value="<?php echo $branchResult->id; ?>"
                                        <?php if(sizeof($branchArr)>0){ if(in_array($branchResult->id,$branchArr)){?>
                                        selected <?php }} ?>><?php echo $branchResult->name; ?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="country_id" id="country_id" class="form-control" onchange="submit_form()">
                                    <option value="">Select Country</option>
                                    <?php
                                    $cSql = $obj->query("select * from $tbl_country where status=1 and id in (1,2,3,6) order by displayorder asc");
                                    while($cResult = $obj->fetchNextObject($cSql)){?>
                                    <option value="<?php echo $cResult->id; ?>"
                                        <?php if($_REQUEST['country_id']==$cResult->id){?> selected <?php }  ?>>
                                        <?php echo $cResult->name; ?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="filter_start_date" id="filter_start_date" class="form-control"
                                    style="height: 36px;" value="<?php echo $_REQUEST['filter_start_date']; ?>"
                                    placeholder="Start Date" onfocus="(this.type='date')" onblur="(this.type='text')">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="filter_end_date" id="filter_end_date" class="form-control"
                                    style="height: 36px;" value="<?php echo $_REQUEST['filter_end_date']; ?>"
                                    placeholder="End Date" onfocus="(this.type='date')" onblur="(this.type='text')">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" name="subit" class="btn btn-primary download_csv_button"
                                    style="width: 170px; height: 40px;">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                   $sql= $obj->query("SELECT COUNT(a.id) as num_rows FROM $tbl_student AS a INNER JOIN $tbl_student_status AS b on a.id = b.stu_id WHERE 1=1 and b.cstatus = 'Visa Approved' $whr",$debug=-1);
                                                                    $line=$obj->fetchNextObject($sql);
                                                                    echo $line->num_rows;
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Total Students</span>
                                                    </a>
                                                </div>
                                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                    <i
                                                        class="icon-user-following data-right-rep-icon txt-light-grey"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord('Pending Review')">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                   $sql = $obj->query("SELECT COUNT(a.id) as num_rows FROM $tbl_student AS a INNER JOIN $tbl_student_status AS b on a.id = b.stu_id LEFT JOIN $tbl_student_passport_noc AS c ON a.id = c.stu_id AND c.value = 'google' WHERE 1=1 and c.stu_id IS NULL and b.cstatus = 'Visa Approved' $whr",$debug=-1);
                                                                    $line=$obj->fetchNextObject($sql);
                                                                    echo $line->num_rows;
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Pending Review</span>
                                                    </a>
                                                </div>
                                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                    <i
                                                        class="icon-user-following data-right-rep-icon txt-light-grey"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord('Pending Video')">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                   $sql = $obj->query("SELECT COUNT(a.id) as num_rows FROM $tbl_student AS a INNER JOIN $tbl_student_status AS b on a.id = b.stu_id LEFT JOIN $tbl_student_passport_noc AS c ON a.id = c.stu_id AND c.value = 'video' WHERE 1=1 and c.stu_id IS NULL and b.cstatus = 'Visa Approved' $whr",$debug=-1);
                                                                    $line=$obj->fetchNextObject($sql);
                                                                    echo $line->num_rows;
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Pending Video</span>
                                                    </a>
                                                </div>
                                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                    <i
                                                        class="icon-user-following data-right-rep-icon txt-light-grey"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)" onclick="getAppRecord('All Done')">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                   $sql =  $obj->query("SELECT COUNT(a.id) as num_rows FROM $tbl_student AS a INNER JOIN $tbl_student_status AS b on a.id = b.stu_id INNER JOIN $tbl_student_passport_noc AS c ON a.id = c.stu_id WHERE 1=1 and c.value IN ('google', 'video') and b.cstatus = 'Visa Approved' $whr GROUP BY a.id HAVING COUNT(DISTINCT c.value) = 2",$debug=-1);
                                                                    echo $obj->numRows($sql);
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">All Done</span>
                                                    </a>
                                                </div>
                                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                    <i
                                                        class="icon-user-following data-right-rep-icon txt-light-grey"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <div class="table-wrap">
                                        <div class="table-responsive">
                                            <table id="studentList" class="table table-hover display  pb-30">
                                                <div class="choose_prog" style="">
                                                </div>
                                                <thead>
                                                    <tr>
                                                        <th>Student Id</th>
                                                        <th>Visa Approval Date</th>
                                                        <th>Name</th>
                                                        <th>Father Name</th>
                                                        <th>Passport No.</th>
                                                        <th>Country</th>
                                                        <th>Counsellor Name</th>
                                                        <th>Branch Name</th>
                                                        <th>Review Status</th>
                                                        <th>Video Status</th>
                                                        <th>Profile Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-white">
                                <h5 class="modal-title pull-left" id="exampleModalLabel">Managemnet Meet</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="controller.php" method="post" id="get_modal_data">

                            </form>
                        </div>
                    </div>
                </div>
                <footer class="footer container-fluid pl-30 pr-30">
                    <div class="row">
                        <div class="col-sm-12">
                            <p>2023 &copy; Powered by IBT India Pvt Ltd</p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <?php include("footer.php"); ?>
    <script src="js/select2.full.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script>
    $(".select2").select2({
        placeholder: "Select Branch",
        allowClear: true
    });

    var dataTable = $('#studentList').DataTable({
        "processing": true,
        "serverSide": true,
        "stateSave": false,
        "lengthMenu": [
            [10, 50, 100, 500, 1000, 1500],
            [10, 50, 100, 500, 1000, 1500]
        ],
        "pageLength": 10,
        "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0, 1, 2, 3, 4, 5]
            },
            {
                "bSearchable": false,
                "aTargets": [0, 1, 2, 3, 4, 5]
            }
        ],
       "ajax": {
            url: "visa-approved-media-ajax.php",
            type: "post",
            error: function() {
                $(".product-grid-error").html("");
                $("#product-grid").append(
                    '<tbody class="product-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>'
                );
                $("#product-grid_processing").css("display", "none");
            }
        },
        <?php  
    if ($_SESSION['level_id']==1){?> "dom": '<"top"lfB>rt<"bottom"ip><"clear">',
        "buttons": [{
            extend: 'csvHtml5',
            text: 'Download CSV',
            title: 'Student List',
            exportOptions: {
                columns: ':not(:last-child):not(:nth-last-child(2))'
            }
        }],
        <?php } ?>
    });

    $("div.top").append(
        '<div class="text-pagination"><label for="page-input">Go to page: </label><input id="usermobile" type="text" min="1" style="width: 60px;"></div>'
    );

    $('#usermobile').on('change', function() {
        var page = $(this).val();
        if (page > 0 && page <= dataTable.page.info().pages) {
            dataTable.page(page - 1).draw(false);
        } else {
            alert('Invalid page number.');
        }
    });
    </script>
    <script src="js/change-status.js"></script>
    <script>
    function submit_form() {
        $("#form_submit").submit();
    }
    function getAppRecord(status) {
        $('#form_submit').append('<input name="status" value="' + status + '" type="hidden"/>');
        $("#form_submit").submit();
    }
    </script>
</body>

</html>