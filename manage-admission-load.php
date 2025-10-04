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
td a:hover{
    color:blue !important;
    text-decoration:underline !important;
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
                        <h5 class="txt-dark">New Admission Load</h5>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                        <h5 style="color:#2a911d;"><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
                        <h5 style="color:red;">
                            <?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
                    </div>
                    <div class="breadcrumb-section col-lg-4 col-sm-8 col-md-4 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                            <li class="active"><span><a href="#">New Admission Load</a></span></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <div class="table-wrap">
                                        <div class="table-responsive">
                                            <table id="datable_3" class="table table-hover display  pb-30">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Account Executive</th>
                                                        <th>Details</th>
                                                        <th>Total Students</th>
                                                        <th>No i-20 Received</th>
                                                        <th>1 i-20 Received</th>
                                                        <th>2 i-20 Received</th>
                                                        <th>3 or more i-20 Received</th>
                                                        <th>Total Active Student</th>
                                                        <th>Final Load</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Account Executive</th>
                                                        <th>Details</th>
                                                        <th>Total Students</th>
                                                        <th width="25%">No i-20 Received</th>
                                                        <th width="25%">1 i-20 Received</th>
                                                        <th width="25%">2 i-20 Received</th>
                                                        <th width="25%">3 or more i-20 Received</th>
                                                        <th>Load Active Student</th>
                                                        <th>Final Load</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php
                                                    if($_SESSION['level_id'] == 2 || $_SESSION['level_id']==25){
                                                        $sqls = $obj->query("SELECT * FROM $tbl_admin WHERE id='".$_SESSION['sess_admin_id']."' and status=1 ORDER BY id DESC", $debug = -1);
                                                         $gets = $obj->fetchNextObject($sqls);
                                                        $branch = explode(',',$gets->branch_id);
                                                        foreach($branch as $r_branch){
                                                        $sql = $obj->query("SELECT * FROM $tbl_admin WHERE level_id=3 and branch_id LIKE '%$r_branch' and status=1 group by id ORDER BY id DESC", $debug = -1);
                                                        while ($line = $obj->fetchNextObject($sql)) {
                                                        $query = "SELECT
                                                            (SELECT COUNT(*) FROM $tbl_student WHERE am_id = '{$line->id}' and student_type in (3,44,43)) AS total_students,
                                                            SUM(CASE WHEN subquery.total_i = 0 THEN 1 ELSE 0 END) AS total_i0,
                                                            SUM(CASE WHEN subquery.total_i = 1 THEN 1 ELSE 0 END) AS total_i1,
                                                            SUM(CASE WHEN subquery.total_i = 2 THEN 1 ELSE 0 END) AS total_i2,
                                                            SUM(CASE WHEN subquery.total_i > 2 THEN 1 ELSE 0 END) AS total_i3
                                                        FROM (
                                                            SELECT stu_id, COUNT(*) as total_i
                                                            FROM $tbl_student_application AS sa
                                                            INNER JOIN $tbl_student AS s ON sa.stu_id = s.id
                                                            WHERE s.am_id = '{$line->id}'  and s.student_type in (3,44,43)
                                                                AND sa.status = 'I-20 Received' 
                                                                AND sa.parent_id = '0'
                                                                AND s.work_status=1
                                                                AND sa.stu_id NOT IN (
                                                                    SELECT ss.stu_id 
                                                                    FROM tbl_student_status AS ss
                                                                    WHERE ss.cstatus IN ('Visa Approved', 'Visa Refused', 'On Hold','Back-Out','Maximum I-20 Received') 
                                                                    GROUP BY ss.stu_id
                                                                )
                                                            GROUP BY sa.stu_id
                                                        ) AS subquery";
                                                        $result = $obj->query($query);
                                                        $data = $obj->fetchNextObject($result);
                                                        
                                                        
                                                        $query0 = $obj->query("SELECT count(*) as total_i0
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
                                                        WHERE s.am_id = '{$line->id}'
                                                            and student_type in (3,44,43)
                                                             AND s.work_status=1
                                                        AND filtered_students.stu_id IS NULL
                                                        AND ss.stu_id IS NULL");
                                                        $data0 = $obj->fetchNextObject($query0);

                                                        $total_i0 = $data0->total_i0;
                                                        $total = $data->total_students;
                                                        $total_i1 = $data->total_i1;
                                                        $total_i2 = $data->total_i2;
                                                        $total_i3 = $data->total_i3;

                                                        $zero1 = $total - $total_i1 - $total_i2 - $total_i3;
                                                        $i201 = $total_i1 / 2;
                                                        $i202 = $total_i2 / 4;
                                                        ?>
                                                    <tr>
                                                        <td><?=$line->id?></td>
                                                        <td><?=$line->name?></td>
                                                        <td>
                                                            <p>Number: <?=$line->phone?></p>
                                                            <p>Email: <?=$line->email?></p>
                                                        </td>
                                                        <td><a
                                                        target="_blank" href="manage-admission-load-student.php?am_id=<?=base64_encode(base64_encode(base64_encode($line->id)))?>&types=new&type=all"><?=$total !='' ? $total : 0?></a></td>
                                                        <td><a
                                                                target="_blank" href="manage-admission-load-student.php?am_id=<?=base64_encode(base64_encode(base64_encode($line->id)))?>&types=new&type=no"><?=$total_i0?></a>
                                                        </td>
                                                        <td>
                                                            <a
                                                                target="_blank" href="manage-admission-load-student.php?am_id=<?=base64_encode(base64_encode(base64_encode($line->id)))?>&types=new&type=1">
                                                                <p>Total Students: <?=$total_i1?></p>
                                                                <p>Load(1/2): <?=$i201?></p>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a
                                                                target="_blank" href="manage-admission-load-student.php?am_id=<?=base64_encode(base64_encode(base64_encode($line->id)))?>&types=new&type=2">
                                                                <p>Total Students: <?=$total_i2?></p>
                                                                <p>Load(1/4): <?=$i202?></p>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a
                                                                target="_blank" href="manage-admission-load-student.php?am_id=<?=base64_encode(base64_encode(base64_encode($line->id)))?>&types=new&type=3">
                                                                <p>Total Students: <?=$total_i3?></p>
                                                                <p>Load(0): 0</p>
                                                            </a>
                                                        </td>
                                                        <td><a
                                                        target="_blank" href="manage-admission-load-student.php?am_id=<?=base64_encode(base64_encode(base64_encode($line->id)))?>&types=new&type=total"><?=$total_i0 + $total_i1 + $total_i2?></a></td>
                                                        <td><a
                                                        target="_blank" href="manage-admission-load-student.php?am_id=<?=base64_encode(base64_encode(base64_encode($line->id)))?>&types=new&type=total"><?=$total_i0 + $i201 + $i202?></a></td>
                                                    </tr>
                                                    <?php
                                                    } } } else{
                                                    if($_SESSION['level_id'] == 3){
                                                        $sql = $obj->query("SELECT * FROM $tbl_admin WHERE id='".$_SESSION['sess_admin_id']."'  and status=1 ORDER BY id DESC", $debug = -1);
                                                    }else{
                                                    $sql = $obj->query("SELECT * FROM $tbl_admin WHERE level_id=3  and status=1 ORDER BY id DESC", $debug = -1);
                                                    }
                                                    while ($line = $obj->fetchNextObject($sql)) {
                                                        $query = "SELECT
                                                            (SELECT COUNT(*) FROM $tbl_student WHERE am_id = '{$line->id}' and student_type in (3,44,43)) AS total_students,
                                                            SUM(CASE WHEN subquery.total_i = 0 THEN 1 ELSE 0 END) AS total_i0,
                                                            SUM(CASE WHEN subquery.total_i = 1 THEN 1 ELSE 0 END) AS total_i1,
                                                            SUM(CASE WHEN subquery.total_i = 2 THEN 1 ELSE 0 END) AS total_i2,
                                                            SUM(CASE WHEN subquery.total_i > 2 THEN 1 ELSE 0 END) AS total_i3
                                                        FROM (
                                                            SELECT stu_id, COUNT(*) as total_i
                                                            FROM $tbl_student_application AS sa
                                                            INNER JOIN $tbl_student AS s ON sa.stu_id = s.id
                                                            WHERE s.am_id = '{$line->id}'  and s.student_type in (3,44,43)
                                                                AND sa.status = 'I-20 Received' 
                                                                AND sa.parent_id = '0'
                                                                AND s.work_status=1
                                                                AND sa.stu_id NOT IN (
                                                                    SELECT ss.stu_id
                                                                    FROM tbl_student_status AS ss
                                                                    WHERE ss.cstatus IN ('Visa Approved', 'Visa Refused', 'On Hold','Back-Out','Maximum I-20 Received') 
                                                                    GROUP BY ss.stu_id
                                                                )
                                                            GROUP BY sa.stu_id
                                                        ) AS subquery";
                                                        $result = $obj->query($query);
                                                        $data = $obj->fetchNextObject($result);
                                                        
                                                        
                                                        $query0 = $obj->query("SELECT count(*) as total_i0
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
                                                        WHERE s.am_id = '{$line->id}'
                                                        and student_type in (3,44,43)
                                                           AND s.work_status=1
                                                        AND filtered_students.stu_id IS NULL
                                                        AND ss.stu_id IS NULL");
                                                        $data0 = $obj->fetchNextObject($query0);

                                                        $total_i0 = $data0->total_i0;
                                                        $total = $data->total_students;
                                                        $total_i1 = $data->total_i1;
                                                        $total_i2 = $data->total_i2;
                                                        $total_i3 = $data->total_i3;

                                                        $zero1 = $total - $total_i1 - $total_i2 - $total_i3;
                                                        $i201 = $total_i1 / 2;
                                                        $i202 = $total_i2 / 4;
                                                        ?>
                                                    <tr>
                                                        <td><?=$line->id?></td>
                                                        <td><?=$line->name?></td>
                                                        <td>
                                                            <p>Number: <?=$line->phone?></p>
                                                            <p>Email: <?=$line->email?></p>
                                                        </td>
                                                        <td><a
                                                        target="_blank" href="manage-admission-load-student.php?am_id=<?=base64_encode(base64_encode(base64_encode($line->id)))?>&types=new&type=all"><?=$total !='' ? $total : 0?></a></td>
                                                        <td><a
                                                                target="_blank" href="manage-admission-load-student.php?am_id=<?=base64_encode(base64_encode(base64_encode($line->id)))?>&types=new&type=no"><?=$total_i0?></a>
                                                        </td>
                                                        <td>
                                                            <a
                                                                target="_blank" href="manage-admission-load-student.php?am_id=<?=base64_encode(base64_encode(base64_encode($line->id)))?>&types=new&type=1">
                                                                <p>Total Students: <?=$total_i1?></p>
                                                                <p>Load(1/2): <?=$i201?></p>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a
                                                                target="_blank" href="manage-admission-load-student.php?am_id=<?=base64_encode(base64_encode(base64_encode($line->id)))?>&types=new&type=2">
                                                                <p>Total Students: <?=$total_i2?></p>
                                                                <p>Load(1/4): <?=$i202?></p>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a
                                                                target="_blank" href="manage-admission-load-student.php?am_id=<?=base64_encode(base64_encode(base64_encode($line->id)))?>&types=new&type=3">
                                                                <p>Total Students: <?=$total_i3?></p>
                                                                <p>Load(0): 0</p>
                                                            </a>
                                                        </td>
                                                        <td><a
                                                        target="_blank" href="manage-admission-load-student.php?am_id=<?=base64_encode(base64_encode(base64_encode($line->id)))?>&types=new&type=total"><?=$total_i0 + $total_i1 + $total_i2?></a></td>
                                                        <td><a
                                                        target="_blank" href="manage-admission-load-student.php?am_id=<?=base64_encode(base64_encode(base64_encode($line->id)))?>&types=new&type=total"><?=$total_i0 + $i201 + $i202?></a></td>
                                                    </tr>
                                                    <?php
                                                    } }
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