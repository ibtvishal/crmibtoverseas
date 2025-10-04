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
                        <h5 class="txt-dark">Enrolled Student Meet</h5>
                    </div>

                    <div class="breadcrumb-section col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                        </ol>
                    </div>
                    <?php
                    if(isset($_SESSION['success'])){
                    ?>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                        <h5 style="color:#2a911d;">Student deleted successfully.</h5>
                    </div>
                    <?php
                    unset($_SESSION['success']);
                    }
                    ?>
                </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="panel panel-default card-view">
                                    <div class="panel-wrapper collapse in">
                                        <div class="panel-body">
                                            <div class="table-wrap">
                                                <div class="row">
                                                    <div class="col-md-12"> Color Code: <span
                                                            style="color:red">Not Meet</span>,
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table id="datable_3" class="table table-hover display  pb-30">
                                                        <thead>
                                                            <tr>
                                                                <th>Student Id</th>
                                                                <th>Date</th>
                                                                <th>Name</th>
                                                                <th>Father Name</th>
                                                                <th>Passport No.</th>
                                                                <th>Country</th>
                                                                <th>Type</th>
                                                                <?php
                                                                    if($_SESSION['level_id'] == 11 || in_array(1, $addtional_role)){
                                                                        echo '<th>Manamgent Member</th>';
                                                                    }
                                                                ?>
                                                                <th>Issue Type</th>
                                                                <th>Issue Remark</th>
                                                                <th>Counsellor Name</th>
                                                                <th>Admission Executive</th>
                                                                <th>Branch Name</th>
                                                                <?php
                                                                    if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 19){
                                                                        ?>
                                                                <th>Action</th>
                                                                <?php } ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if($_SESSION['level_id'] == 11 || in_array(1, $addtional_role)){
                                                                $branchid = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                                                $whr=" and branch_id in ($branchid) and management_date='".date("Y-m-d")."'";
                                                            }else{
                                                                $whr=" and management_member='".$_SESSION['sess_admin_id']."' and management_date='".date("Y-m-d")."'";
                                                            }
                                                              $sql=$obj->query("select * from $tbl_student where 1=1 $whr");
                                                              while($line = $obj->fetchNextObject($sql)){
                                                                $uemail='';
                                                                $urSql = $obj->query("select offical_email from $tbl_user_recovery where student_id='".$line->id."'");
                                                                while($urResult = $obj->fetchNextObject($urSql)){
                                                                  if($urResult->offical_email!=''){
                                                                    $uemail = $urResult->offical_email;
                                                                  }
                                                                }
                                                                if($line->student_type==1){
                                                                    $student_type='New'; 
                                                                  }else if($line->student_type==6){
                                                                    $student_type='Re-apply(Defer)';
                                                                  }
                                                                  else if($line->student_type==3){
                                                                    $student_type='Refused';
                                                                  }
                                                                  else if($line->student_type==4){
                                                                    $student_type='Re-apply (Same Intake)';
                                                                  }
                                                                  else if($line->student_type==5){
                                                                    $student_type='Re-Apply(New Applications)';
                                                                  }
                                                                  else if($line->student_type==2){
                                                                    $student_type='Defer';
                                                                  }
                                                                  else if($line->student_type==7){
                                                                    $student_type='New(Outsider Refused)';
                                                                  }
                                                                  else if($line->student_type==8){
                                                                    $student_type='New (Filing Only)';
                                                                  }
                                                                  else if($line->student_type==9){
                                                                    $student_type='University Transfer';
                                                                  }
                                                                  $color = '';
                                                                  if($line->management_member_status == 0){
                                                                    $color = 'color:red';
                                                                  }
                                                                ?>
                                                                <tr>
                                                                <td style="<?=$color?>"><?=$line->student_no?></td>
                                                                <td style="<?=$color?>"><?=date("d M y",strtotime($line->cdate))?></td>
                                                                <td style="<?=$color?>"><?=$line->stu_name?></td>
                                                                <td style="<?=$color?>"><?=$rResult->name?></td>
                                                                <td style="<?=$color?>"><?=$line->passport_no?></td>
                                                                <td style="<?=$color?>"><?=getField('name',$tbl_country,$line->country_id)?></td>
                                                                <td style="<?=$color?>"><?=$student_type?></td>
                                                                <?php
                                                                    if($_SESSION['level_id'] == 11 || in_array(1, $addtional_role)){
                                                                        echo '<td style="'.$color.'">'.getField('name',$tbl_admin,$line->management_member).'</td>';
                                                                    }
                                                                ?>
                                                                <td style="<?=$color?>"><?=$line->management_type?></td>
                                                                <td style="<?=$color?>"><?=$line->management_remark?></td>
                                                                <td style="<?=$color?>"><?=getField('name',$tbl_admin,$line->c_id)?></td>
                                                                <td style="<?=$color?>"><?=getField('name',$tbl_admin,$line->am_id)?></td>
                                                                <td style="<?=$color?>"><?=getField('name',$tbl_branch,$line->branch_id)?></td>
                                                                <?php
                                                                    if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 19){
                                                                        ?>
                                                                <td style="<?=$color?>"><a target="_blank" href='student-editf.php?id=<?=base64_encode(base64_encode(base64_encode($line->id)))?>&meet'><i class='fa fa-edit' style='margin-right: 6px;font-size: 16px;'></i> </a></td>
                                                                <?php } ?>
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
</body>

</html>