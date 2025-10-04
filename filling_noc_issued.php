<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$_SESSION['pending']='';
$_SESSION['whr']='';
$_SESSION['whr1']='';
$_SESSION['second']='';
$whr1=" and b.status=1";
$whr2=" ";
$whr='';
$addtional_role = explode(',', $_SESSION['additional_role']);
if($_SESSION['level_id'] == 14 || $_SESSION['level_id'] == 19 || $_SESSION['level_id']==23 || $_SESSION['level_id']==25 || in_array(9, $addtional_role)){
    $branchid = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    $whr .= " and a.branch_id in ($branchid)";
    if(isset($_GET['pending'])){
    }elseif(isset($_GET['second'])){
        $whr1 .= "  and b.dtype = 39";
        $whr2 .= "  and b.dtype = 39";
    }else{
        $whr1 .= "  and b.dtype = 24";
        $whr2 .= "  and b.dtype = 24";
    }
}
if($_SESSION['level_id']==23){
    $whr1 .= "  and a.visa_id in (2,3,5) ";
    $whr2 .= "  and a.visa_id in (2,3,5) ";
}
if($_SESSION['level_id'] == 4){
    $whr .= " and a.c_id = '".$_SESSION['sess_admin_id']."'";
    if(isset($_GET['pending'])){
    }elseif(isset($_GET['second'])){
        $whr1 .= "  and b.dtype = 39";
        $whr2 .= "  and b.dtype = 39";
    }else{
        $whr1 .= "  and b.dtype = 24";
        $whr2 .= "  and b.dtype = 24";
    }
}
if($_REQUEST['branch']){
    $branchArr = $_REQUEST['branch'];
    $branch_id = implode(',',$branchArr);
    $whr .= " and a.branch_id in ($branch_id)";
    if(!isset($_GET['pending'])){
        $whr1 .= "  and b.dtype = 24";
        $whr2 .= "  and b.dtype = 24";
        }
  }
if($_REQUEST['councellor_id']){
    $councellor_id = $_REQUEST['councellor_id'];
    $whr .= " and a.c_id = '$councellor_id'";
    if(!isset($_GET['pending'])){
        $whr1 .= "  and b.dtype = 24";
        $whr2 .= "  and b.dtype = 24";
        }
  }
if($_REQUEST['country_id']){
    $country_id = $_REQUEST['country_id'];
    $whr .= " and a.country_id = '$country_id'";
    if(!isset($_GET['pending'])){
        $whr1 .= "  and b.dtype = 24";
        $whr2 .= "  and b.dtype = 24";
        }
  }
if($_REQUEST['visa_id']){
    $visa_type = $_REQUEST['visa_id'];
    $whr .= " and a.visa_id = '$visa_type'";
    if(!isset($_GET['pending'])){
        $whr1 .= "  and b.dtype = 24";
        $whr2 .= "  and b.dtype = 24";
        }
  }
  if($_REQUEST['start_date'] && $_REQUEST['end_date']){
    $start_date = $_REQUEST['start_date'];
    $end_date = $_REQUEST['end_date'];
    $whr .= " and date(f.cdate) >= '$start_date' and date(f.cdate) <= '$end_date'";
    if(isset($_GET['pending'])){
    }elseif(isset($_GET['second'])){
        $whr1 .= "  and b.dtype = 24";
        $whr2 .= "  and b.dtype = 24";
    }else{
        $whr1 .= "  and b.dtype = 24";
        $whr2 .= "  and b.dtype = 24";
    }
  }
if($_REQUEST['status']){
    $status = $_REQUEST['status'];
    if($status == 2){
        $whr1 .= " and b.dtype  = 39   and b.with_financial_verify=1";
        $whr2 .= " and b.dtype  = 39   and b.with_financial_verify=1";
    }
    if($status == 3){
        $whr1 .= " and b.dtype = 39   and b.with_financial_verify=0";
        $whr2 .= " and b.dtype = 39   and b.with_financial_verify=0";
    }
    if($status == 4){
        $whr1 .= " and b.dtype = 39  and b.with_financial_verify=2";
        $whr2 .= " and b.dtype = 39  and b.with_financial_verify=2";
    }
    if($status == 5){
        $whr1 .= "  and b.dtype = 24  and b.verify=1";
        $whr2 .= "  and b.dtype = 24  and b.verify=1";
    }
    if($status == 6){
        $whr1 .= " and b.dtype = 24   and b.verify=0";
        $whr2 .= " and b.dtype = 24   and b.verify=0";
    }
    if($status == 7){
        $whr1 .= "  and b.dtype = 24  and b.verify=2";
        $whr2 .= "  and b.dtype = 24  and b.verify=2";
    }
  }
  $_SESSION['whr'] = $whr; 
  $_SESSION['whr1'] = $whr1;  
  $_SESSION['whr2'] = $whr2;  
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php'); ?>
    <style>
    .documentviewclass iframe {
        width: 100%;
        height: 450px;
    }

    .dt-buttons {
        float: none !important
    }

    .buttons-csv {
        float: right !important
    }
    </style>
</head>

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
                        <?php
                        if(isset($_GET['pending'])){
                            echo '<h5 class="txt-dark">Affidavit By Pass</h5>';
                        }elseif(isset($_GET['second'])){
                            echo '<h5 class="txt-dark">Affidavit Verification 2</h5>';
                        }else{
                        ?>
                        <h5 class="txt-dark">Affidavit Verification 1</h5>
                        <?php } ?>
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
                <?php
                if(isset($_GET['pending'])){
                    $_SESSION['pending'] = 'pending';
                    ?>


                <form action="" id="submit_form" method="post">
                    <div class="row">
                        <div class="col-md-3" style="margin-bottom:10px">
                            <select name="branch[]" id="branch_id" class="form-control select2" multiple
                                onchange="submit_form()">
                                <?php
                                        if(!empty($_REQUEST['branch'])){
                                        $branchArr = $_REQUEST['branch'];
                                        if(is_array($branchArr)){
                                            $branchArr = $branchArr;
                                        }else{
                                            $branchArr = explode(',',$branchArr);
                                        }
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
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="councellor_id" id="councellor_id" class="form-control"
                                    onchange="submit_form()">
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
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="country_id" id="country_id" class="form-control" onchange="submit_form()">
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
                                <select name="visa_id" id="visa_id" class="form-control" onchange="submit_form()">
                                    <option value="">Select Visa</option>
                                    <option value="1"
                                        <?php if(isset($_POST['statuss1'])){ echo 'selected'; }else{ if($_REQUEST['visa_id']==1){?>
                                        selected <?php } } ?>>Study Visa</option>
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
                                <input type="text" name="start_date" id="start_date" class="form-control"
                                    style="height: 36px;" value="<?php echo $_REQUEST['start_date']; ?>"
                                    placeholder="Start Date" onfocus="(this.type='date')" onblur="(this.type='text')">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="end_date" id="end_date" class="form-control"
                                    style="height: 36px;" value="<?php echo $_REQUEST['end_date']; ?>"
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
            </div>
            </form>
            <?php
                }elseif(isset($_GET['second'])){
                    $_SESSION['second'] = 1;
                    ?>
            <form action="" id="submit_form" method="post">
                <div class="row">
                    <div class="col-md-3" style="margin-bottom:10px">
                        <select name="branch[]" id="branch_id" class="form-control select2" multiple
                            onchange="submit_form()">
                            <?php
                                        if(!empty($_REQUEST['branch'])){
                                        $branchArr = $_REQUEST['branch'];
                                        if(is_array($branchArr)){
                                            $branchArr = $branchArr;
                                        }else{
                                            $branchArr = explode(',',$branchArr);
                                        }
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
                                <?php if(sizeof($branchArr)>0){ if(in_array($branchResult->id,$branchArr)){?> selected
                                <?php }} ?>><?php echo $branchResult->name; ?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="councellor_id" id="councellor_id" class="form-control"
                                onchange="submit_form()">
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
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="country_id" id="country_id" class="form-control" onchange="submit_form()">
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
                            <select name="visa_id" id="visa_id" class="form-control" onchange="submit_form()">
                                <option value="">Select Visa</option>
                                <option value="1"
                                    <?php if(isset($_POST['statuss1'])){ echo 'selected'; }else{ if($_REQUEST['visa_id']==1){?>
                                    selected <?php } } ?>>Study Visa</option>
                                <option value="2" <?php if($_REQUEST['visa_id']==2){?> selected <?php } ?>>Tourist Visa
                                </option>
                                <option value="3" <?php if($_REQUEST['visa_id']==3){?> selected <?php } ?>>Visitor Visa
                                </option>
                                <option value="4" <?php if($_REQUEST['visa_id']==4){?> selected <?php } ?>>Work Visa
                                </option>
                                <option value="5" <?php if($_REQUEST['visa_id']==5){?> selected <?php } ?>>Spouse Visa
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                            <a href="javascript:void(0)" onclick="getAppRecord(2)">
                                                <span class="txt-dark block counter"><span class="counter-anim">
                                                        <?php
                                                                $sql=$obj->query("select a.id as num_rows from $tbl_student as a inner join $tbl_student_document as b on a.id = b.stu_id  where 1=1 and b.dtype in (39) and b.with_financial_verify=1 $whr group by a.id",$debug=-1);
                                                                $lines=$obj->numRows($sql);
                                                                    echo $lines;
                                                                     ?>
                                                    </span></span>
                                                <span class="weight-500 uppercase-font block font-13">
                                                    Second Verified Financial</span>
                                            </a>
                                        </div>
                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                            <i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
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
                                            <a href="javascript:void(0)" onclick="getAppRecord(3)">
                                                <span class="txt-dark block counter"><span class="counter-anim">
                                                        <?php
                                                                $sql=$obj->query("select a.id as num_rows from $tbl_student as a inner join $tbl_student_document as b on a.id = b.stu_id  where 1=1 and b.dtype = 39 and b.with_financial_verify=0 $whr group by a.id",$debug=-1);
                                                                $lines=$obj->numRows($sql);
                                                                    echo $lines;
                                                                     ?>
                                                    </span></span>
                                                <span class="weight-500 uppercase-font block font-13">
                                                    Second Pending Verified Financial</span>
                                            </a>
                                        </div>
                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                            <i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
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
                                            <a href="javascript:void(0)" onclick="getAppRecord(4)">
                                                <span class="txt-dark block counter"><span class="counter-anim">
                                                        <?php
                                                                $sql=$obj->query("select a.id as num_rows from $tbl_student as a inner join $tbl_student_document as b on a.id = b.stu_id  where 1=1 and b.dtype in (39) and b.with_financial_verify=2 $whr group by a.id",$debug=-1);
                                                                $lines=$obj->numRows($sql);
                                                                    echo $lines;
                                                                     ?>
                                                    </span></span>
                                                <span class="weight-500 uppercase-font block font-13">
                                                    Second Disapproved Financial</span>
                                            </a>
                                        </div>
                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                            <i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                }else{
                ?>
            <form action="" id="submit_form" method="post">
                <div class="row">
                    <div class="col-md-3" style="margin-bottom:10px">
                        <select name="branch[]" id="branch_id" class="form-control select2" multiple
                            onchange="submit_form()">
                            <?php
                                        if(!empty($_REQUEST['branch'])){
                                        $branchArr = $_REQUEST['branch'];
                                        if(is_array($branchArr)){
                                            $branchArr = $branchArr;
                                        }else{
                                            $branchArr = explode(',',$branchArr);
                                        }
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
                                <?php if(sizeof($branchArr)>0){ if(in_array($branchResult->id,$branchArr)){?> selected
                                <?php }} ?>><?php echo $branchResult->name; ?></option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="councellor_id" id="councellor_id" class="form-control"
                                onchange="submit_form()">
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
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="country_id" id="country_id" class="form-control" onchange="submit_form()">
                                <option value="">Country</option>
                                <?php                       
                                        $clSql = $obj->query("select * from $tbl_country where status=1 order by displayorder asc");
                                        while($clResult = $obj->fetchNextObject($clSql)){?>
                                <option value="<?php echo $clResult->id; ?>"
                                    <?php if($_REQUEST['country_id']==$clResult->id){?> selected <?php } ?>>
                                    <?php echo $clResult->name; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="visa_id" id="visa_id" class="form-control" onchange="submit_form()">
                                <option value="">Select Visa</option>
                                <option value="1"
                                    <?php if(isset($_POST['statuss1'])){ echo 'selected'; }else{ if($_REQUEST['visa_id']==1){?>
                                    selected <?php } } ?>>Study Visa</option>
                                <option value="2" <?php if($_REQUEST['visa_id']==2){?> selected <?php } ?>>Tourist Visa
                                </option>
                                <option value="3" <?php if($_REQUEST['visa_id']==3){?> selected <?php } ?>>Visitor Visa
                                </option>
                                <option value="4" <?php if($_REQUEST['visa_id']==4){?> selected <?php } ?>>Work Visa
                                </option>
                                <option value="5" <?php if($_REQUEST['visa_id']==5){?> selected <?php } ?>>Spouse Visa
                                </option>
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
                                                <a href="javascript:void(0)" onclick="getAppRecord(1)">
                                                    <span class="txt-dark block counter"><span class="counter-anim">
                                                            <?php
                                                                $sql=$obj->query("select a.id as num_rows from $tbl_student as a inner join $tbl_student_document as b on a.id = b.stu_id  where 1=1 and b.dtype in (24) $whr group by a.id",$debug=-1);
                                                                $lines=$obj->numRows($sql);
                                                                    echo $lines;
                                                                     ?>
                                                        </span></span>
                                                    <span class="weight-500 uppercase-font block font-13">
                                                        Total</span>
                                                </a>
                                            </div>
                                            <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                <i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
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
                                                <a href="javascript:void(0)" onclick="getAppRecord(5)">
                                                    <span class="txt-dark block counter"><span class="counter-anim">
                                                            <?php
                                                                $sql=$obj->query("select a.id as num_rows from $tbl_student as a inner join $tbl_student_document as b on a.id = b.stu_id  where 1=1 and b.dtype in (24) and b.verify=1 $whr group by a.id",$debug=-1);
                                                                $lines=$obj->numRows($sql);
                                                                    echo $lines;
                                                                     ?>
                                                        </span></span>
                                                    <span class="weight-500 uppercase-font block font-13">
                                                        Verified</span>
                                                </a>
                                            </div>
                                            <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                <i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
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
                                                <a href="javascript:void(0)" onclick="getAppRecord(6)">
                                                    <span class="txt-dark block counter"><span class="counter-anim">
                                                            <?php
                                                                $sql=$obj->query("select a.id as num_rows from $tbl_student as a inner join $tbl_student_document as b on a.id = b.stu_id  where 1=1 and b.dtype in (24) and b.verify=0 $whr group by a.id",$debug=-1);
                                                                $lines=$obj->numRows($sql);
                                                                    echo $lines;
                                                                     ?>
                                                        </span></span>
                                                    <span class="weight-500 uppercase-font block font-13">
                                                        Pending Verified</span>
                                                </a>
                                            </div>
                                            <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                <i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
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
                                                <a href="javascript:void(0)" onclick="getAppRecord(7)">
                                                    <span class="txt-dark block counter"><span class="counter-anim">
                                                            <?php
                                                                $sql=$obj->query("select a.id as num_rows from $tbl_student as a inner join $tbl_student_document as b on a.id = b.stu_id  where 1=1 and b.dtype in (24) and b.verify=2 $whr group by a.id",$debug=-1);
                                                                $lines=$obj->numRows($sql);
                                                                    echo $lines;
                                                                     ?>
                                                        </span></span>
                                                    <span class="weight-500 uppercase-font block font-13">
                                                        Disapproved</span>
                                                </a>
                                            </div>
                                            <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                <i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php } ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default card-view">
                        <div class="panel-wrapper collapse in">
                            <div class="panel-body">
                                <div class="table-wrap">
                                    <div class="table-responsive">
                                        <?php
                                            if(isset($_GET['pending'])){
                                                echo 'Affidavit By pass';
                                            }
                                            ?>
                                        <table id="datable_3s" class="table table-hover display pb-30">
                                            <thead>
                                                <tr>
                                                    <th>Student Id</th>
                                                    <th>Date</th>
                                                    <th>Name</th>
                                                    <th>Primary Number</th>
                                                    <th>Alternate Number</th>
                                                    <th>Passport No.</th>
                                                    <th>Country</th>
                                                    <th>Counsellor</th>
                                                    <th>Visa Type</th>
                                                    <?php
                                                          if(!isset($_GET['pending'])){
                                                            ?>
                                                    <th>Uploaded by</th>
                                                    <?php }else{
                                                            echo '<th>Affidavit By Paased By</th>';
                                                        } ?>
                                                    <th>Branch Name</th>
                                                    <?php
                                                    if(isset($_GET['second'])){
                                                        ?>
                                                    <th>Second Affidavit Financial</th>
                                                    <th>Second Verified Financial</th>
                                                    <th>Second Verification Manager Remarks Financial</th>
                                                    <?php
                                                    }elseif(isset($_GET['pending'])){

                                                    }else{
                                                    ?>
                                                    <th>Affidavit</th>
                                                    <th>Verified</th>
                                                    <th>Verification Manager Remarks</th>
                                                    <?php } ?>
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

    <div id="invoiceModel" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content bg-white">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <img src="img/logo.svg" alt="logo" height="50px">
                        <span style="font-weight: 700; color: black;">Student Payment Details</span>
                        <span></span>
                    </h4>
                </div>
                <div class="modal-body bg-light px-0" id="get_modal_data">

                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="document_view" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document" style="width: 1200px; height: 500px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Document </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group documentviewclass"></div>
                </div>
            </div>
        </div>
    </div>
    <?php include("footer.php"); ?>
    <script src="js/select2.full.min.js"></script>
    <script src="js/change-status.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script type="text/javascript">
    $(".select2").select2({
        placeholder: "All Branch",
        allowClear: true
    });
    </script>

    <script>
    function submit_form() {
        $("#submit_form").submit();
    }
    </script>
    <script>
    function change_hide_status(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to approve it?",
            icon: "warning",
            showDenyButton: true,
            showCloseButton: true,
            confirmButtonColor: "#2ecd99",
            confirmButtonText: "Yes, Approve it!",
            denyButtonText: `Disapprove`,
            denyButtonColor: "#ed6f56"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "post",
                    url: "controller.php",
                    data: {
                        change_noc_id: id
                    },
                    success: function(data) {
                        if (data == 1) {
                            // $("#change_hide_status" + id).hide();
                            $(".change_color" + id).removeAttr('style');
                            $("#change_hide_status" + id).html('Verfied');
                            $("#change_hide_status" + id).removeAttr('class');
                            $("#change_hide_status" + id).attr('class', 'btn btn-success');
                        }
                    }
                })
            } else if (result.isDenied) {
                $.ajax({
                    method: "post",
                    url: "controller.php",
                    data: {
                        change_noc_id_dis: id
                    },
                    success: function(data) {
                        if (data == 1) {
                            // $("#change_hide_status" + id).hide();
                            $(".change_color" + id).removeAttr('style');
                            $("#change_hide_status" + id).html('Disapproved');
                            $("#change_hide_status" + id).removeAttr('class');
                            $("#change_hide_status" + id).attr('class', 'btn btn-danger');
                        }
                    }
                })
            }
        });
    }
    </script>
    <script>
    function change_hide_status1(id) {
        Swal.fire({
            title: "Are you sure?",
            text: "Do you want to approve it?",
            icon: "warning",
            showDenyButton: true,
            showCloseButton: true,
            confirmButtonColor: "#2ecd99",
            confirmButtonText: "Yes, Approve it!",
            denyButtonText: `Disapprove`,
            denyButtonColor: "#ed6f56"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "post",
                    url: "controller.php",
                    data: {
                        change_noc_id1: id
                    },
                    success: function(data) {
                        if (data == 1) {
                            // $("#change_hide_status" + id).hide();
                            $(".change_color" + id).removeAttr('style');
                            $("#change_hide_status1" + id).html('Verfied');
                            $("#change_hide_status1" + id).removeAttr('class');
                            $("#change_hide_status1" + id).attr('class', 'btn btn-success');
                        }
                    }
                })
            } else if (result.isDenied) {
                $.ajax({
                    method: "post",
                    url: "controller.php",
                    data: {
                        change_noc_id_dis1: id
                    },
                    success: function(data) {
                        if (data == 1) {
                            // $("#change_hide_status" + id).hide();
                            $(".change_color" + id).removeAttr('style');
                            $("#change_hide_status1" + id).html('Disapproved');
                            $("#change_hide_status1" + id).removeAttr('class');
                            $("#change_hide_status1" + id).attr('class', 'btn btn-danger');
                        }
                    }
                })
            }
        });
    }
    </script>
    <script type="text/javascript">
    $(".select2").select2({
        placeholder: "All Branch",
        allowClear: true
    });

    var dataTable = $('#datable_3s').DataTable({
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
                "aTargets": [0, 1, 2, 3]
            },
            {
                "bSearchable": false,
                "aTargets": [0, 1, 2, 3]
            }
        ],
        "ajax": {
            url: "filling_noc_issued_ajax.php",
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
            if(isset($_GET['pending'])){
            ?> "dom": '<"top"lfB>rt<"bottom"ip><"clear">', // Include this line to add the buttons container
        "buttons": [{
            extend: 'csvHtml5',
            text: 'Download CSV',
            title: 'Affidavit By Pass',
            exportOptions: {
                columns: ':not(:last-child)' // Exclude last three columns
            }
        }],
        <?php } ?> "createdRow": function(row, data, dataIndex) {
            $('td', row).eq(-5).css('text-align', 'center');
            $('td', row).eq(-4).css('text-align', 'center');
            $('td', row).eq(-3).css('text-align', 'center');
            $('td', row).eq(-2).css('text-align', 'center');
            $('td', row).eq(-1).css('text-align', 'center');
        }
    })
    </script>
    <script>
    function get_modal_data(id) {
        $.ajax({
            method: "POST",
            url: "controller.php",
            data: {
                id: id,
                type: 'Registration',
                get_modal_data_fee: 1
            },
            success: function(data) {
                $("#get_modal_data").html(data);
            }
        })
    }
    </script>
    <script>
    function change_remakrs(val, id) {

        $.ajax({
            method: "POST",
            url: "controller.php",
            data: {
                id: id,
                remark: val,
                update_remark_of_affidavit: 1
            },
            success: function(data) {
                $(".text-success").html('');
                $("#success" + id).html('Remarks Saved');
            }
        })
    }
    </script>
    <script>
    function change_remakrs1(val, id) {

        $.ajax({
            method: "POST",
            url: "controller.php",
            data: {
                id: id,
                remark: val,
                update_remark_of_affidavit1: 1
            },
            success: function(data) {
                $(".text-success").html('');
                $("#success1" + id).html('Remarks Saved');
            }
        })
    }
    </script>
    <script>
    function documentview(type, id) {
        $.ajax({
            type: "GET",
            url: 'ajax/submitData.php',
            data: {
                id: id,
                action: 'getDocumentView',
                type: type
            },
            beforeSend: function() {},
            success: function(data) {
                $(".documentviewclass").html(data);
                $("#document_view").modal('show');
            }
        });
    }
    </script>
    <script>
    function getAppRecord(status) {
        $('#submit_form').append('<input name="status" value="' + status + '" type="hidden"/>');
        $("#submit_form").submit();
    }
    </script>
</body>


</html>