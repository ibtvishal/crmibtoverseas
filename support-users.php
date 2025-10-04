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
    <style>
    .center-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .image-border {
        display: inline-block;
        position: relative;
        padding: 10px;
        background-image: url('img/side.png');
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
        border-radius: 10px;
    }
    .image-border img {
        display: block;
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
                        <h5 class="txt-dark">Manage Support User</h5>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                        <h5 style="color:#2a911d;"><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']=''; ?></h5>
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
                                                <?php
                                                $c = 1; 
                                                $branch = explode(',',getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']));
                                                foreach($branch as $branch_id){
                                                    $user_id = getField('users',$tbl_branch,$branch_id);
                                                    if($user_id != ''){
                                                    $sql=$obj->query("select * from $tbl_support_user where 1=1 and id in ($user_id) ORDER BY display_order asc",$debug=-1);
                                                    if($obj->numRows($sql) > 0){
                                                ?>
                                                <h3><?=getField('name',$tbl_branch,$branch_id)?></h3>
                                                <table class="table table-bordered display pb-30">
                                                    <?php
                                                    if($c == 1){
                                                    ?>
                                                    <thead>
                                                        <tr>
                                                            <th>Image</th>
                                                            <th>Name</th>
                                                            <th>Department</th>
                                                            <th>Designation</th>
                                                            <th>Phone</th>
                                                            <th>Email</th>
                                                        </tr>
                                                    </thead>
                                                    <?php } ?>
                                                    <tbody>
                                                        <?php
														while($line=$obj->fetchNextObject($sql)){?>
                                                        <?php if ($line->id != 1) { ?>
                                                        <tr>
                                                            <td> <?php if($line->img!= ''){ ?><a href="#"
                                                                    class="image-border"><img
                                                                        src="uploads/<?=$line->img?>" height="100px"
                                                                        loading="lazy"></a> <?php } ?></td>
                                                            <td><?php echo $line->name ?></td>
                                                            <td><?php echo getField('name',$tbl_department,$line->designation) ?>
                                                            </td>
                                                            <td><?=get_user_role($line->level_id, $line->director)?>
                                                            </td>
                                                            <td><?php echo $line->phone ?></td>
                                                            <td><?php echo $line->email ?></td>
                                                        </tr>
                                                        <?php ++$i;} ?>
                                                    </tbody>
                                                    <?php } ?>
                                                </table>
                                                <?php } }  $c++;  } ?>
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


    <div class="modal" id="document_view" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xl" role="document" style="width: 1200px; height: 500px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Image </h5>
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
    <script>
    function show_model(val) {
        $('#document_view').modal('show');

        $('.documentviewclass').html('<div class="center-container"><div class="image-border"><img src="' + val +
            '" style="height:100%;height: 400px;"></div></div>');
    }
    </script>
</body>


</html>