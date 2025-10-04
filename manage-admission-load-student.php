<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
if($_GET['types'] == 'new'){
    $student_type = ' AND s.work_status=1 and s.student_type in (3,44,43)';
    $load_c = 3;
}else{
    $student_type = ' AND s.work_status=1 and s.student_type in (64,20,47,48,50,42)';
    $load_c = 2;
}
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
                        <h5 class="txt-dark">Admission Load Students</h5>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                        <h5 style="color:#2a911d;"><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
                        <h5 style="color:red;">
                            <?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
                    </div>
                    <div class="breadcrumb-section col-lg-4 col-sm-8 col-md-4 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                            <li class="active"><span><a href="#">Admission Load Students</a></span></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <div class="table-wrap">
                                    <div class="row">
                                    <div class="col-md-12"> Color Code:  <span style="color:red"><?php if($_SESSION['level_id']==1 ){ ?>AM Not Selected <?php } elseif($_SESSION['level_id']==3){?>  Project not accepted <?php } elseif($_SESSION['level_id']==7 || $_SESSION['level_id']==8 ){ echo "Filling Creadentials not added"; }elseif($_SESSION['level_id']==10){ echo "Appointment not added"; } ?></span>, <span style="color:green">I-20 Received</span>, <span style="color:blue">New Application added</span>, <span style="color:purple">Time Stamp not updated</span>,  <span style="color:white;background:red">Visa Refused / Back-Out</span>, <span style="color:white;background:green">Visa Approved</span></div>
                                            </div>
                                        <div class="table-responsive">
                                            <table id="datable_3" class="table  display  pb-30">
                                                <thead>
                                                    <tr>
                                                        <?php  
                                                         if ($_SESSION['level_id']==1 || $_SESSION['level_id']==14 && base64_decode(base64_decode(base64_decode($_GET['transfer'])))==1){?>
                                                        <!-- <th></th> -->
                                                        <?php }?>
                                                        <th>Student Id</th>
                                                        <th>Date</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Father Name</th>
                                                        <th>Passport No.</th>
                                                        <th>Country</th>
                                                        <th>Type</th>
                                                        <th>Counsellor Name</th>
                                                        <th>Admission Executive</th>
                                                        <th>Branch Name</th>
                                                        <th>Profile Status</th>
                                                        <?php  
                                                            if ($_SESSION['level_id']==1 || $_SESSION['level_id']==14 || in_array(6,$addtional_role)){?>
                                                        <th>Filling Executive</th>
                                                        <th>Status</th>
                                                        <?php } ?>
                                                        <?php if($_SESSION['level_id']==1 || $_SESSION['level_id']==14 || in_array(6,$addtional_role) || $_SESSION['level_id'] == 2 || $_SESSION['level_id']==25 || $_SESSION['level_id']==3 || $_SESSION['level_id']==4 || $_SESSION['level_id']==7 || $_SESSION['level_id']==8 || $_SESSION['level_id']==10){ ?>
                                                        <th>Action</th>
                                                        <?php } ?>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>Student Id</th>
                                                        <th>Date</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Father Name</th>
                                                        <th>Passport No.</th>
                                                        <th>Country</th>
                                                        <th>Type</th>
                                                        <th>Counsellor Name</th>
                                                        <th>Account Manager</th>
                                                        <th>Branch Name</th>
                                                        <th>Profile Status</th>
                                                        <?php  
                                                            if ($_SESSION['level_id']==1 || $_SESSION['level_id']==14 || in_array(6,$addtional_role)){?>
                                                        <th>Filling Executive</th>
                                                        <th>Status</th>
                                                        <?php } ?>
                                                        <?php if($_SESSION['level_id']==1 || $_SESSION['level_id']==14 || in_array(6,$addtional_role) || $_SESSION['level_id'] == 2 || $_SESSION['level_id']==25 || $_SESSION['level_id']==3 || $_SESSION['level_id']==4 || $_SESSION['level_id']==7 || $_SESSION['level_id']==8 || $_SESSION['level_id']==10){?>
                                                        <th>Action</th>
                                                        <?php } ?>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php
                                                        $vcstatus = "cstatus in ('Visa Approved', 'Visa Refused', 'Back-Out')";
                                                        $id = base64_decode(base64_decode(base64_decode($_GET['am_id'])));
                                                        if($_GET['type']== 'no'){
                                                        $query = $obj->query("SELECT s.*
                                                            FROM $tbl_student AS s
                                                            LEFT JOIN (
                                                                SELECT sa.stu_id
                                                                FROM $tbl_student_application AS sa
                                                                WHERE sa.status = 'I-20 Received' AND sa.parent_id = '0'
                                                                AND sa.stu_id NOT IN (
                                                                    SELECT ss.stu_id
                                                                    FROM tbl_student_status AS ss
                                                                    WHERE ss.cstatus IN ('Visa Approved', 'Visa Refused', 'On Hold','Back-Out','Maximum I-20 Received')
                                                                )
                                                                GROUP BY sa.stu_id
                                                            ) AS filtered_students ON s.id = filtered_students.stu_id
                                                            LEFT JOIN tbl_student_status AS ss ON s.id = ss.stu_id AND ss.cstatus IN ('Visa Approved', 'Visa Refused', 'On Hold','Back-Out','Maximum I-20 Received')
                                                            WHERE s.am_id = '$id' $student_type
                                                            AND filtered_students.stu_id IS NULL
                                                            AND ss.stu_id IS NULL");
                                                        }
                                                        elseif($_GET['type']=='all'){
                                                            $query = $obj->query("SELECT s.* FROM $tbl_student AS s WHERE s.am_id = '$id' $student_type");
                                                        }
                                                        elseif($_GET['type']=='total'){
                                                            $query = $obj->query("SELECT s.*
                                                            FROM $tbl_student AS s
                                                            LEFT JOIN (
                                                                SELECT sa.stu_id, COUNT(*) as total_i
                                                                FROM $tbl_student_application AS sa
                                                                WHERE sa.status = 'I-20 Received' 
                                                                    AND sa.parent_id = '0'
                                                                    AND sa.stu_id NOT IN (
                                                                        SELECT ss.stu_id 
                                                                        FROM tbl_student_status AS ss
                                                                        WHERE ss.cstatus IN ('Visa Approved', 'Visa Refused', 'On Hold','Back-Out','Maximum I-20 Received')
                                                                    )
                                                                GROUP BY sa.stu_id
                                                            ) AS filtered_students ON s.id = filtered_students.stu_id
                                                            LEFT JOIN tbl_student_status AS ss ON s.id = ss.stu_id AND ss.cstatus IN ('Visa Approved', 'Visa Refused', 'On Hold','Back-Out','Maximum I-20 Received')
                                                            WHERE s.am_id = '$id' $student_type
                                                             AND (filtered_students.stu_id IS NULL OR filtered_students.total_i < $load_c)
                                                            AND ss.stu_id IS NULL
                                                        ");
                                                        }
                                                        else{
                                                            if($_GET['types']== 'new'){
                                                           if($_GET['type']== '3'){
                                                                $cou = '>  2';
                                                            }else{
                                                                $cou = '= '.$_GET['type'];
                                                            }
                                                        }else{
                                                            if($_GET['type']== '2'){
                                                                 $cou = '>  1';
                                                             }else{
                                                                 $cou = '= '.$_GET['type'];
                                                             }
                                                        }
                                                            $query = $obj->query("SELECT s.*
                                                            FROM $tbl_student AS s
                                                            INNER JOIN (
                                                                SELECT stu_id
                                                                FROM $tbl_student_application
                                                                INNER JOIN $tbl_student ON $tbl_student_application.stu_id = $tbl_student.id
                                                                WHERE $tbl_student.am_id = '$id' AND $tbl_student_application.status = 'I-20 Received' AND $tbl_student_application.parent_id = '0'
                                                                 AND $tbl_student_application.stu_id NOT IN (
                                                                                SELECT ss.stu_id 
                                                                                FROM tbl_student_status AS ss
                                                                                WHERE ss.cstatus IN ('Visa Approved', 'Visa Refused', 'On Hold','Back-Out','Maximum I-20 Received') 
                                                                                GROUP BY ss.stu_id
                                                                            )
                                                                GROUP BY stu_id
                                                                HAVING COUNT(*) $cou
                                                            ) AS filtered_students ON s.id = filtered_students.stu_id  WHERE s.am_id = '$id' $student_type");
                                                        }
                                                    while($line=$obj->fetchNextObject($query)) {
                                                        if($line->country_id==1 && $_SESSION['level_id']==7){
                                                            $showval = 0;
                                                    if($line->stage_id==3 && $line->cstatus=='Tuition Fees Paid'){
                                                    $rsql = $obj->query("select stage_id,cstatus from
                                                    $tbl_student_status where stu_id='".$line->id."'");
                                                    $rResult = $obj->fetchNextObject($rsql);
                                                    if($rResult->stage_id==16 && $rResult->cstatus=='GIC Paid'){
                                                    $showval = 1;
                                                }
                                                    }else if($line->stage_id==16 && $line->cstatus=='GIC Paid'){
                                                    $rsql = $obj->query("select stage_id,cstatus from
                                                    $tbl_student_status where stu_id='".$line->id."'");
                                                    $rResult = $obj->fetchNextObject($rsql);
                                                    if($rResult->stage_id==3 && $rResult->cstatus=='Tuition Fees Paid'){
                                                    $showval = 1;
                                                    }
                                                    }
                                                    }else{
                                                    $showval = 1;
                                                }
                                                if($showval == 1){
                                                    $color='';
                                                    if($_SESSION['level_id'] == 2 || $_SESSION['level_id']==25){
                                                    if($line->am_id==0){
                                                    $color = "style='color:red'";
                                                }
                                            }else if($_SESSION['level_id']==3){
                                                    if($line->application_check==1){
                                                    $color = "style='color:blue'";
                                                    }else if($line->accept_student==0 || $line->am_id==0){
                                                    $color = "style='color:red'";
                                                    }
                                                    
                                                    }else if($_SESSION['level_id']==7){
                                                    $sqlf = $obj->query("select fe_id,pstatus from
                                                    $tbl_filing_credentials where student_id='".$line->id."'",-1);
                                                    //die;
                                                    $ResultF = $obj->fetchNextObject($sqlf);
                                                    if($ResultF->fe_id==0){
                                                    $color = "style='color:red'";
                                                    }
                                                }else if($_SESSION['level_id']==8){

                                                    $sqlf = $obj->query("select pstatus from $tbl_filing_credentials
                                                    where student_id='".$line->id."'",-1); //die;
                                                    $ResultF = $obj->fetchNextObject($sqlf);
                                                    if($ResultF->pstatus==0)
                                                    {
                                                    $color = "style='color:red'";
                                                    }
                                                    }else if($_SESSION['level_id']==10){
                                                    $sqlf = $obj->query("select id from $tbl_appointment where
                                                    student_id='".$line->id."'",-1); //die;
                                                    $ResultNum = $obj->numRows($sqlf);
                                                    if($ResultNum>0){
                                                    $color = "";
                                                }else{
                                                    $color = "style='color:red'";
                                                }
                                                
                                            }
                                            
                                            
                                                    $chk = "";
                                                    //--------------------------------Father Name Start-------------------------------------------
                                                    $rSql = $obj->query("select name from $tbl_student_relation where
                                                    sutdent_id='".$line->id."' and relation=1");
                                                    $rResult = $obj->fetchNextObject($rSql);
                                                    //--------------------------------Father Name End-------------------------------------------
                                                    //--------Check Status Start-----------------------------------------------------------------
                                                    $chk='';
                                                    $chk = '<div class="material-switch"><input
                                                            id="someSwitchOptionPrimary'.$i.'" type="checkbox"
                                                            class="chkstatus" value="'.$tbl_student.'"';
                                                                if($line->status=="1"){
                                                                $chk .= ' checked ';
                                                                }
                                                                $chk .= ' onclick="return changeStatusRecord('.$line->id.',this.checked,this.value);" /><label
                                                            for="someSwitchOptionPrimary'.$i.'"
                                                            class="label-primary"></label></div>';
                                                            //-------------------------------------------------------------------------------------------
                                                            if ($_SESSION['level_id']==1 || $_SESSION['level_id']==14 &&
                                                            base64_decode(base64_decode(base64_decode($_SESSION['transfer'])))==1){
                                                                // '<th><input type="checkbox" name="userIdarr[]" value="'.$line->id.'"></th>';
                                                            }
                                                            $student_type = getField('visa_sub_type',$tbl_visa_sub_type,$line->student_type);
                                                          

                                                    $uemail='';
                                                    $urSql = $obj->query("select offical_email from $tbl_user_recovery
                                                    where student_id='".$line->id."'");
                                                    while($urResult = $obj->fetchNextObject($urSql)){
                                                    if($urResult->offical_email!=''){
                                                    $uemail = $urResult->offical_email;
                                                    }
                                                    }
                                                    $addtional_role = explode(',',$_SESSION['additional_role']);
                                                    if($_SESSION['level_id']==1 || $_SESSION['level_id']==14 ||
                                                    $_SESSION['level_id'] == 2 || $_SESSION['level_id']==25 || $_SESSION['level_id']==3 ||
                                                    in_array(2,$addtional_role)){
                                                    $get_time = $obj->query("select cdate from $tbl_student_updated_time where stu_id='".$line->id."' and user_id='".$_SESSION['sess_admin_id']."'",-1);//die();
                                                    $timeResult=$obj->fetchNextObject($get_time);
                                                    if($obj->numRows($get_time)>0){
                                                        $cdate = strtotime($timeResult->cdate);
                                                    $today = time();
                                                    $datetime1 = new DateTime(date("Y-m-d", $cdate));
                                                    $datetime2 = new DateTime(date("Y-m-d", $today));
                                                    $interval = $datetime1->diff($datetime2);
                                                    $difference = $interval->format('%a');
                                                    if($difference > 3){
                                                    $color = "style='color:purple'";
                                                    }else{
                                                    $color = $color;
                                                    }
                                                    }else{
                                                    $color = $color;
                                                }

                                                    // $stageSql = $obj->query("select * from $tbl_student_status where
                                                    // stu_id='".$line->id."' and stage_id=36");
                                                    // if($obj->numRows($stageSql)>0){
                                                    // $color = "style='color:red'";
                                                    // }

                                                    
                                                    $stageSql = $obj->query("select * from $tbl_student_application
                                                    where stu_id='".$line->id."' and status='I-20 Received' and parent_id='0'");
                                                    if($obj->numRows($stageSql)>1){
                                                    $color = "style='color:green'";
                                                    }
                                                    }
                                                    $stageSql2 = $obj->query("select * from $tbl_student_status where
                                                    stu_id='".$line->id."' order by cdate desc");
                                                    $timeResult2=$obj->fetchNextObject($stageSql2);
                                                    
                                                    $stageSql1 = $obj->query("select * from $tbl_student_status where
                                                    stu_id='".$line->id."' and $vcstatus order by cdate desc");
                                                    $timeResult1=$obj->fetchNextObject($stageSql1);
                                                    if($timeResult1->cstatus=='Visa Approved' ||
                                                    $timeResult1->cstatus=='Visa Refused' || $timeResult1->cstatus == 'Back-Out'){
                                                        $color = 'style="color:white"';
                                                        $status_v = $timeResult1->cstatus;
                                                    }else{
                                                        $status_v = $timeResult2->cstatus;
                                                    }
                                                    $last_student = $obj->fetchNextObject($obj->query("select * from $tbl_student where student_no='".$line->student_no."' order by id desc"));
                                                    ?>
                                                    <tr <?php if($status_v == 'Visa Approved'){ ?>style="background:green"
                                                        <?php }elseif($status_v == 'Visa Refused' || $status_v == 'Back-Out'){ ?>style="background:red"
                                                        <?php } ?>>
                                                        <td><span <?=$color?>><?=$line->student_no?></span></td>
                                                        <td> <span <?=$color?>><?=date("d M
                                                        y",strtotime($line->cdate))?></span></td>
                                                        <td> <span <?=$color?>><?=$line->stu_name?></span></td>
                                                        <td> <span <?=$color?>><?=$uemail?></span></td>
                                                        <td> <span <?=$color?>><?=$rResult->name?></span></td>
                                                        <td> <span <?=$color?>><?=$line->passport_no?></span></td>
                                                        <td> <span
                                                                <?=$color?>><?=getField('name',$tbl_country,$line->country_id)?></span>
                                                        </td>
                                                        <td> <span <?=$color?>><?=$student_type?></span></td>
                                                        <td> <span
                                                                <?=$color?>><?=getField('name',$tbl_admin,$line->c_id)?></span>
                                                        </td>
                                                        <td> <span
                                                                <?=$color?>><?=getField('name',$tbl_admin,$line->am_id)?></span>
                                                        </td>
                                                        <td> <span
                                                                <?=$color?>><?=getField('name',$tbl_branch,getField('branch_id',$tbl_admin,$line->c_id))?></span>
                                                        </td>
                                                        <td> <?=$status_v;?></td>
                                                        <?php
                                                    if($_SESSION['level_id']==1 || $_SESSION['level_id']==14 ||
                                                    in_array(6,$addtional_role)){
                                                        ?>
                                                        <td> </td>
                                                        <td><?=$chk?> </td>
                                                        <?php
                                                    }
                                                    if($_SESSION['level_id']==1 || $_SESSION['level_id'] == 2 || $_SESSION['level_id']==25 ||
                                                    $_SESSION['level_id']==3 || $_SESSION['level_id']==4 ||
                                                    $_SESSION['level_id']==7 || $_SESSION['level_id']==8 ||
                                                    $_SESSION['level_id']==10 || $_SESSION['level_id']==14 ||
                                                    in_array(6,$addtional_role)){
                                                    ?>
                                                        <td> <a
                                                                href='student-editf.php?id=<?=base64_encode(base64_encode(base64_encode($last_student->id)))?>'><i
                                                                    class='fa fa-edit'
                                                                    style='margin-right: 6px;font-size: 16px;'></i> </a>
                                                        </td>
                                                        <?php
                                                    }
                                                    }
                                                    ?>
                                                    </tr>
                                                    <?php
                                                    $i++;
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
    <script src="js/change-status.js"></script>
</body>


</html>