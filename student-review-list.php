<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$half = "";
$_SESSION['whr1'] = '';
$_SESSION['half'] = '';
$whr1 = " and date(b.cdate)='".date('Y-m-d')."'";
if($_SESSION['level_id']==25){
    $branchid = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    $whr1 .= " and a.branch_id in ($branchid)";
  }
if($_REQUEST['branch_id']){
    $branchArr = $_REQUEST['branch_id'];
    $branch_id = implode(',',$branchArr);
    $whr1 .= " and a.branch_id in ($branch_id)";
  }
  if($_REQUEST['country_id']){
    $country_id = $_REQUEST['country_id'];
    $whr1 .= " and a.country_id=$country_id";
  }
  if($_REQUEST['r_id']){
    $r_id = $_REQUEST['r_id'];
    $whr1 .= " and b.user_id=$r_id";
  }
  if($_REQUEST['account_manager_id']){
    $account_manager_id = $_REQUEST['account_manager_id'];
    $whr1 .= " and a.am_id=$account_manager_id";
  }
  if($_REQUEST['visa_id']){
    $visa_id = $_REQUEST['visa_id'];
    $whr1 .= " and a.visa_id=$visa_id";
  }
  if($_REQUEST['counsellor_id']){
    $counsellor_id = $_REQUEST['counsellor_id'];
    $whr1 .= " and a.c_id = $counsellor_id";
  }
$_SESSION['whr1'] = $whr1;
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
                <h5 style="color:#2a911d; text-align: center;">
                    <?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
                <h5 style="color:red;"><?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
                <div class="row heading-bg">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h5 class="txt-dark">Review Students</h5>
                    </div>

                    <div class="breadcrumb-section col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>

                        </ol>
                    </div>
                </div>
                <form action="" method="post" id="searchfrm">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="branch_id[]" id="branch_id" onchange="form_submit()"
                                    class="form-control select2" multiple="">
                                    <?php
                        if(!empty($_REQUEST['branch_id'])){
                          $branchArr = $_REQUEST['branch_id'];
                        }elseif(isset($branchids)){
                            $branchArr = $branchids;
                        }else{
                          $branchArr = array();
                        }                      
                        $b_con = '';
                        if($_SESSION['level_id']!==19){
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
                                <select name="r_id" id="r_id" class="form-control" onchange="form_submit()">
                                    <option value="">Admission Review Manager</option>
                                    <?php
                                                if(!empty($_REQUEST['branch_id'])){
                                                $idArr = $_REQUEST['branch_id'];
                                                $i=1; $whrr='';
                                                foreach($idArr as $val){
                                                    if($i==1){
                                                    $whrr .=" and ( FIND_IN_SET($val, a.branch_id)";
                                                    }else{
                                                    $whrr .=" or FIND_IN_SET($val, a.branch_id)";
                                                    }
                                                    if($i==count($idArr)){
                                                    $whrr .=" )";
                                                    }
                                                    $i++;
                                                }
                                                }
                                                $amSql = $obj->query("select a.id,a.name from $tbl_admin as a  where a.status=1 and a.level_id=22 $whrr group by a.id",-1);
                                                while($amResult = $obj->fetchNextObject($amSql)){?>
                                    <option value="<?php echo $amResult->id; ?>"
                                        <?php if($_REQUEST['r_id']==$amResult->id){?> selected <?php } ?>>
                                        <?php echo $amResult->name; ?></option>
                                    <?php }
                     
                                             ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="account_manager_id" id="account_manager_id" class="form-control"
                                    onchange="form_submit()">
                                    <option value="">Admission Executive</option>
                                    <?php
                                                if(!empty($_REQUEST['branch_id'])){
                                                $idArr = $_REQUEST['branch_id'];
                                                $i=1; $whrr='';
                                                foreach($idArr as $val){
                                                    if($i==1){
                                                    $whrr .=" and ( FIND_IN_SET($val, b.branch_id)";
                                                    }else{
                                                    $whrr .=" or FIND_IN_SET($val, b.branch_id)";
                                                    }
                                                    if($i==count($idArr)){
                                                    $whrr .=" )";
                                                    }
                                                    $i++;
                                                }
                                                }
                                                $amSql = $obj->query("select a.id,a.name from $tbl_admin as a inner join $tbl_student as b on a.id=b.am_id where a.status=1 and a.level_id=3 and b.am_id!=0 $whrr group by a.id",-1);
                                                while($amResult = $obj->fetchNextObject($amSql)){?>
                                    <option value="<?php echo $amResult->id; ?>"
                                        <?php if($_REQUEST['account_manager_id']==$amResult->id){?> selected <?php } ?>>
                                        <?php echo $amResult->name; ?></option>
                                    <?php }
                     
                                             ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="country_id" id="country_id" onchange="form_submit()" class="form-control">
                                    <option value="">Country</option>
                                    <?php                       
                          $clSql = $obj->query("select * from $tbl_country where status=1 order by displayorder asc");
                          while($clResult = $obj->fetchNextObject($clSql)){?>
                                    <option value="<?php echo $clResult->id; ?>"
                                        <?php if($_REQUEST['country_id']==$clResult->id){?> selected <?php } ?>>
                                        <?php echo $clResult->name; ?></option>
                                    <?php }
                        ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="counsellor_id" id="counsellor_id" class="form-control"
                                    onchange="form_submit()">
                                    <option value="">Counsellor</option>
                                    <?php
                                                     // if(!empty($_REQUEST['branch_id'])){      
                                                        if(!empty($_REQUEST['branch_id'])){
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
                                                        }                     
                                                        $clSql = $obj->query("select * from $tbl_admin where status=1 and level_id=4 $whrr");
                                                        while($clResult = $obj->fetchNextObject($clSql)){?>
                                    <option value="<?php echo $clResult->id; ?>"
                                        <?php if($_REQUEST['counsellor_id']==$clResult->id){?> selected <?php } ?>>
                                        <?php echo $clResult->name; ?></option>
                                    <?php 
                                                    // }
                                                    }
                                                 ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="visa_id" id="visa_id" class="form-control" onchange="form_submit()">
                                    <option value="">Select Visa</option>
                                    <option value="1" <?php  if($_REQUEST['visa_id']==1){ ?> selected <?php }  ?>>Study
                                        Visa</option>
                                    <option value="2" <?php if($_REQUEST['visa_id']==2){?> selected <?php } ?>>Tourist
                                        Visa</option>
                                    <option value="3" <?php if($_REQUEST['visa_id']==3){?> selected <?php } ?>>Visitor
                                        Visa</option>
                                    <option value="4" <?php if($_REQUEST['visa_id']==4){?> selected <?php } ?>>Work Visa
                                    </option>
                                    <option value="5" <?php if($_REQUEST['visa_id']==5){?> selected <?php } ?>>Spouse
                                        Visa</option>
                                </select>
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
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <div class="table-wrap">
                                        <div class="row">
                                        </div>
                                        <div class="table-responsive">
                                            <table id="studentList" class="table table-hover display  pb-30">
                                                <div class="choose_prog" style="">
                                                </div>
                                                <thead>
                                                    <tr>
                                                        <th>Student Id</th>
                                                        <th>Name</th>
                                                        <th>Date & Time Last Updated</th>
                                                        <th>Admission Review Manager</th>
                                                        <th>Passport No.</th>
                                                        <th>Student/Case Type</th>
                                                        <th>Counsellor Name</th>
                                                        <th>Admission/Travel Executive</th>
                                                        <th>Branch Name</th>
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
                </form>

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
    var dataTable = $('#studentList').DataTable({
        "processing": true,
        "serverSide": true,
        "stateSave": false,
        "lengthMenu": [
            [500, 50000, 1500],
            [500, 50000, 1500]
        ],
        "pageLength": 50,
        <?php  
      if ($_SESSION['level_id']==1  || $_SESSION['level_id'] == 19 || $_SESSION['level_id']==25){?> "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
            },
            {
                "bSearchable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
            }
        ],
        <?php }else{?> "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
            },
            {
                "bSearchable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
            }
        ],
        <?php }?> "ajax": {
            url: "student-review-list-ajax.php",
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
    </script>
    <script src="js/change-status.js"></script>
    <script>
    function form_submit() {
        $("#searchfrm").submit();
    }
    $(".select2").select2({
        placeholder: "All Branch",
        allowClear: true
    });
    </script>
    <script>
    function submit_data(val) {
        $("#status").val(val);
        $("#searchfrm").submit();
    }
    </script>
</body>

</html>