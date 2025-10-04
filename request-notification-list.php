<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();

$whr_require="";
$whr_require1="";
$_SESSION['whr_require']='';
$_SESSION['whr_require1']='';
if($_SESSION['level_id'] == 2 || $_SESSION['level_id'] == 23 || $_SESSION['level_id'] == 22 || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 25 || $_SESSION['level_id'] == 20 || $_SESSION['level_id'] == 21){
	$branchid = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
	$whr_require .= " and b.branch_id in ($branchid)";
    if($_SESSION['level_id'] == 23){
        $whr_require .= " and b.visa_id in (2,3,5)";
    }
}
if($_SESSION['level_id'] == 3 || $_SESSION['level_id'] == 24){
	$whr_require .= " and b.am_id ='".$_SESSION['sess_admin_id']."'";
}
if($_SESSION['level_id'] == 4){
    $whr_require .= " and b.c_id  ='".$_SESSION['sess_admin_id']."'";
}
if($_REQUEST['filter_type']!=''){
    $whr_require .= " and a.type='".$_REQUEST['filter_type']."'";
}
if($_REQUEST['branch_id']){
    $branchArr = $_REQUEST['branch_id'];
    $branch_id = implode(',',$branchArr);
    $whr_require .= " and b.branch_id in ($branch_id)";
}
if($_REQUEST['councellor_id']){
  $councellor_id = $_REQUEST['councellor_id'];
    $whr_require .= " and b.c_id  ='$councellor_id'";
}
if($_REQUEST['status']){
    $status = $_REQUEST['status'];
    if($status=='Total'){
      $whr_require1.=' '; 
    }elseif($status=='Pending'){
        $whr_require1.=' and a.status=1'; 
    }elseif($status=='Done'){
        $whr_require1.=' and a.status=0'; 
    }
}
$_SESSION['whr_require']= $whr_require;
$_SESSION['whr_require1']= $whr_require1;
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

    <div class="preloader-it">
        <div class="la-anim-1"></div>
    </div>
    <div class="wrapper theme-1-active pimary-color-green">
        <?php include("menu.php"); ?>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row heading-bg">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h5 class="txt-dark">Manage Requirements</h5>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-left">
                        <h5 style="color:#2a911d;"><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
                        <h5 style="color:red;">
                            <?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
                    </div>
                    <div class="breadcrumb-section col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                        </ol>
                    </div>
                </div>
                <form action="" id="searchfrm" method="post">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="branch_id[]" id="branch_id" class="form-control select2" multiple="" onchange="submit_form()">
                                    <?php
                                                    if(!empty($_REQUEST['branch_id'])){
                                                    $branchArr = $_REQUEST['branch_id'];
                                                    if(is_array($branchArr)){
                                                        $branchArr = $branchArr;
                                                         }else{
                                                            $branchArr = array($branchArr);
                                                        }
                                                    }elseif(isset($branchids)){
                                                        $branchArr = $branchids;
                                                    }else{
                                                    $branchArr = array();
                                                    }                      
                                                    $b_con = '';
                                                    if($_SESSION['level_id']!==1){
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
                                <select name="councellor_id" id="councellor_id" class="form-control" onchange="submit_form()">
                                    <option value="">Counsellor</option>
                                    <?php
                                                if(!empty($_REQUEST['branch_id'])){
                                                $idArr = $_REQUEST['branch_id'];
                                                $idArr = $_REQUEST['branch_id'];
                                                $i=1; $whrr='';
                                                foreach($idArr as $val){
                                                    if($i==1){
                                                    $whrr .=" and ( FIND_IN_SET($val, branch_id)";
                                                    }else{
                                                    $whrr .=" or FIND_IN_SET($val, branch_id)";
                                                    }
                                                    if($i==count($idArr)){
                                                    $whrr .=" )";
                                                    }
                                                    $i++;
                                                }                          
                                                $clSql = $obj->query("select * from $tbl_admin where status=1 and level_id=4 $whrr order by name",-1);
                                                }else{
                                                $clSql = $obj->query("select * from $tbl_admin where status=1 and level_id=4  order by name",-1);
                                                }
                                                while($clResult = $obj->fetchNextObject($clSql)){?>
                                    <option value="<?php echo $clResult->id; ?>"
                                        <?php if($_REQUEST['councellor_id']==$clResult->id){?> selected <?php } ?>>
                                        <?php echo $clResult->name; ?></option>
                                    <?php }
                                               ?>
                                </select>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord('Total')">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                    $obj->query("select COUNT(*) as num_rows from $tbl_requirement_notification AS a INNER JOIN $tbl_student AS b ON a.stu_id=b.id where 1=1 $whr_require",$debug=-1);
                                                                    $line=$obj->fetchNextObject($sql);
                                                                    echo $totalVisit = $line->num_rows;
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Total
                                                            Requirements</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord('Pending')">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                    $obj->query("select COUNT(*) as num_rows from $tbl_requirement_notification AS a INNER JOIN $tbl_student AS b ON a.stu_id=b.id where 1=1  and a.status=1 $whr_require",$debug=-1);
                                                                    $line=$obj->fetchNextObject($sql);
                                                                    echo $totalVisit = $line->num_rows;
                                                                    ?>
                                                            </span></span>
                                                        <span
                                                            class="weight-500 uppercase-font block font-13">Pending</span>
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
                                                    <a href="javascript:void(0)" onclick="getAppRecord('Done')">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                    $obj->query("select COUNT(*) as num_rows from $tbl_requirement_notification AS a INNER JOIN $tbl_student AS b ON a.stu_id=b.id where 1=1  and a.status=0 $whr_require",$debug=-1);
                                                                    $line=$obj->fetchNextObject($sql);
                                                                    echo $totalVisit = $line->num_rows;
                                                                    ?>
                                                            </span></span>
                                                        <span
                                                            class="weight-500 uppercase-font block font-13">Done</span>
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

            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default card-view">
                        <div class="panel-wrapper collapse in">
                            <div class="panel-body">
                                <div class="table-wrap">
                                    <div class="table-responsive">
                                        <table id="gapList" class="table table-hover display  pb-30">
                                            <thead>
                                                <tr>
                                                    <th>TIme Stamp</th>
                                                    <th>Student Code</th>
                                                    <th>Name</th>
                                                    <th>Request Type</th>
                                                    <th>Remark</th>
                                                    <th>Counsellor</th>
                                                    <th>Requested By</th>
                                                    <th>Reponse By</th>
                                                    <?php
															if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 2 || $_SESSION['level_id'] == 3 || $_SESSION['level_id'] == 25 || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 22){
															?>
                                                    <th>Read/Unread</th>
                                                    <?php } ?>
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
    <script>
        function submit_form(){
            $("#searchfrm").submit();
        }
    </script>
    <script>
    $(".select2").select2({
        placeholder: "All Branch",
        allowClear: true
    });
    </script>
    <script>
    var dataTable = $('#gapList').DataTable({
        "processing": true,
        "serverSide": true,
        "stateSave": false,
        "lengthMenu": [
            [10, 20, 30, 40, 50],
            [10, 20, 30, 40, 50]
        ],
        "pageLength": 10,
        "ajax": {
            url: "request-notification-list-ajax.php",
            type: "post",
            error: function() {
                $(".product-grid-error").html("");
                $("#product-grid").append(
                    '<tbody class="product-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>'
                );
                $("#product-grid_processing").css("display", "none");
            }
        }
    })

    $("#filter_status").change(function() {
        $("#searchfrm").submit();
    })
    $("#filter_type").change(function() {
        $("#searchfrm").submit();
    })
    </script>
    <script src="js/change-status.js"></script>
    <script>
    function changeNotiStatusRecord(id, val) {
        if (val.checked == true) {
            status = 1;
        } else {
            status = 0;
        }
        $.ajax({
            type: "POST",
            url: 'controller.php',
            data: {
                id: id,
                requirement_status: status
            },
            success: function(response) {
                location.reload();
            }
        });
    }
    </script>
    <script>
    function getAppRecord(status) {
        $('#searchfrm').append('<input name="status" value="' + status + '" type="hidden"/>');
        $("#searchfrm").submit();
    }
    </script>
</body>

</html>