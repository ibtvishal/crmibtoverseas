<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_admin();

if(isset($_GET['id'])){
    $id = base64_decode(base64_decode(base64_decode($_GET['id'])));
    $sql=$obj->query("select * from $tbl_file where id='$id' order by id desc");
	$res=$obj->fetchNextObject($sql);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php'); ?>
</head>

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
                        <h5 class="txt-dark"><?=isset($_GET['id']) ? 'Update' : 'Add'?> File</h5>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-center">
                        <h5 style="color:#2a911d;" id="sess_msg">
                            <?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
                        <h5 style="color:red;">
                            <?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
                    </div>
                    <!-- Breadcrumb -->

                    <div class="breadcrumb-section col-lg-4 col-sm-8 col-md-8 col-xs-12">
                        <ol class=" breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                            <li class="active"><span><a href="manage-file.php">Manage File</a></span></li>

                        </ol>
                    </div>
                    <!-- /Breadcrumb -->
                </div>
                <!-- /Title -->

                <!-- Row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">

                            <form action="controller.php" id="form-validate" enctype="multipart/form-data"
                                method="post">
                                <div class="row" style="padding: 15px;">
                                    <div class="col-md-4">
                                        Select Country
                                        <select class="form-control" name="country_id" id="country_id">
                                            <option value="">Select Country</option>
                                            <?php
											$i=1;
											$sql=$obj->query("select * from $tbl_country where status=1 order by displayorder",$debug=-1);
											while($line=$obj->fetchNextObject($sql)){?>
                                            <option value="<?php echo $line->id ?>"
                                                <?php if($res->country_id==$line->id){?>selected<?php } ?>>
                                                <?php echo $line->name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        Select visa Type
                                        <select class="form-control" name="visa_id" id="visa_id">
                                             <option value="">Select Visa Type</option>
                                             <option value="1" <?php if($res->visa_id==1){?> selected <?php } ?>>
                                                 Study Visa</option>
                                             <option value="2" <?php if($res->visa_id==2){?> selected <?php } ?>>
                                                 Tourist Visa</option>
                                             <option value="3" <?php if($res->visa_id==3){?> selected <?php } ?>>
                                                 Visitor Visa</option>
                                             <option value="4" <?php if($res->visa_id==4){?> selected <?php } ?>>Work
                                                 Visa</option>
                                             <option value="5" <?php if($res->visa_id==5){?> selected <?php } ?>>
                                                 Spouse Visa</option>
                                         </select>
                                    </div>
                                    <div class="col-md-4">
                                        Select Category
                                        <select name="category_id" id="" class="required form-control form-select"
                                            onchange="get_subcat('<?=$tbl_download_subcategory?>',this.value)">
                                            <option value="">Select Category</option>
                                            <?php
													$sql=$obj->query("select * from $tbl_download_category where status='1'  order by id desc");
													while($line=$obj->fetchNextObject($sql)){ ?>
                                            <option value="<?=$line->id?>"
                                                <?=$res->category_id == $line->id ? "selected" : ''?>><?=$line->name?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        Select SubCategory
                                        <select name="subcat_id" id="subcat_id"
                                            class="required form-control form-select">
                                            <option value="">Select SubCategory</option>
                                            <?php
													$sql=$obj->query("select * from $tbl_download_subcategory where status='1'  order by id desc");
													while($line=$obj->fetchNextObject($sql)){ ?>
                                            <option value="<?=$line->id?>"
                                                <?=$res->subcategory_id == $line->id ? "selected" : ''?>>
                                                <?=$line->name?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        File Name
                                        <input type="text" class="required form-control" name="file_name"
                                            placeholder="File Name" value=" <?=$res->file_name?>">
                                    </div>
                                    <div class="col-md-4">
                                        File
                                        <?php
                                        if(isset($_GET['id'])){
                                            ?>
                                        <img src="uploads/<?=$res->file?>" alt="image" style="height:30px">
                                        <input type="hidden" value="<?=$res->id?>" class="form-control" name="id">
                                        <input type="hidden" value="<?=$res->file?>" class="form-control"
                                            name="old_file">

                                        <input type="file" class="form-control" name="file">
                                        <?php
                                        }else{
                                            ?>
                                        <input type="file" class="required form-control" name="file">
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                              
                                <?php
                                        if(isset($_GET['id'])){
                                            ?>
                                <button class="btn btn-success" type="submit" style="margin: 15px;"
                                    name="btn_update_file">Update File</button>
                                <?php }else{ ?>
                                <button class="btn btn-success" type="submit" style="margin: 15px;"
                                    name="btn_add_file">Add
                                    File</button>
                                <?php } ?>
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
    <script type="text/javascript" src="js/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="calender/css/jquery-ui.css">
    <script src="calender/js/jquery-ui.js"></script>
    <script>
    $(document).ready(function() {
        $("#form-validate").validate();
    });

    function get_subcat(tbl, id) {
        $.ajax({
            method: 'post',
            url: 'ajax/ajax.php',
            data: {
                tbl: tbl,
                id: id
            },
            success: function(data) {
                $("#subcat_id").html(data);
            }
        })
    }
    </script>
    <script src="js/change-status.js"></script>
</body>

</html>