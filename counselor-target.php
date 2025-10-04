<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php'); ?>
</head>
<style type="text/css">
.select2-search__field {
    width: 100% !important;
}

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
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
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
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <h5 class="txt-dark">Manage User</h5>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                        <h5 style="color:#2a911d;"><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
                        <h5 style="color:red;">
                            <?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
                    </div>
                    <div class="breadcrumb-section col-lg-4 col-sm-8 col-md-4 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">
                            <form name="frm" method="post" action="user-del.php" enctype="multipart/form-data">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body">
                                        <div class="table-wrap">
                                            <div class="table-responsive">
                                                <table id="datable_3" class="table table-hover display  pb-30">
                                                    <thead>
                                                        <tr>
                                                            <th>Branch</th>
                                                            <th>Name</th>
                                                            <th>Personal Email</th>
                                                            <th>Today Target</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Branch</th>
                                                            <th>Name</th>
                                                            <th>Personal Email</th>
                                                            <th>Today Target</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        <?php
														$i=1; $whr='';
														if($_SESSION['level_id'] == 25){
                                                            $branchid = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
															$whr .= " and branch_id in ($branchid)";
														}
														if($_SESSION['level_id'] == 4){
															$whr .= " and id='{$_SESSION['sess_admin_id']}'";
														}
														$sql=$obj->query("select * from $tbl_admin where 1=1 and level_id=4 $whr ORDER BY id DESC ",$debug=-1);
														while($line=$obj->fetchNextObject($sql)){
                                                            $get = $obj->fetchNextObject($obj->query("SELECT * FROM tbl_target where counsellor_id='{$line->id}' and target_date='".date("Y-m-d")."'"))
                                                            ?>
                                                        <tr>
                                                            <td><?php echo getField('name',$tbl_branch,$line->branch_id) ?></td>
                                                            <td><?php echo $line->name ?></td>
                                                            <td><?php echo $line->email ?></td>
                                                            <td><input type="number" class="form-control" <?php if($_SESSION['level_id'] == 25 || $_SESSION['level_id'] == 1){ ?>onkeyup="change_target(this.value,<?=$line->id?>)"<?php } ?> value="<?=$get->counsellor_target?>"></td>
                                                        </tr>
                                                        <?php } ?>
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
    <script>
        function change_target(val, id){
            $.ajax({
                method:"POST",
                url:"controller.php",
                data:{counsellor_target:val, user_id:id},
                success:function(data){
                    // alert(data);
                }
            })
        }
    </script>
</body>


</html>