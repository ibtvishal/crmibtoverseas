<?php 
include('include/config.php');
include("include/functions.php");
validate_user();

if($_REQUEST['submitForm']=='yes'){

    $stu_name=$obj->escapestring($_POST['stu_name']);
    $father_name=$obj->escapestring($_POST['father_name']);
    $dob=$obj->escapestring($_POST['dob']);
    $passport_no=$obj->escapestring($_POST['passport_no']);
    $country_id=$obj->escapestring($_POST['country_id']);
    $visa_id=$obj->escapestring($_POST['visa_id']);
    $c_id=$obj->escapestring($_POST['c_id']);

    $branch_id = getField('branch_id','tbl_admin',$c_id);

    $sql=$obj->query("select * from $tbl_student where 1=1 order by id desc");
    $result=$obj->fetchNextObject($sql);
    $parts = explode("IBT", $result->student_no);
    $student_no=codeGenerate($parts[1]);

        if($_REQUEST['id']=='' ){
        $obj->query("insert into $tbl_student set student_no='$student_no',stu_name='$stu_name',father_name='$father_name',dob='$dob',passport_no='$passport_no',country_id='$country_id',visa_id='$visa_id',branch_id='$branch_id',c_id='$c_id'",-1);//     die;
        $_SESSION['sess_msg']='Student added sucessfully';

        }else{ 
        $obj->query("update $tbl_student set stu_name='$stu_name',father_name='$father_name',dob='$dob',passport_no='$passport_no',country_id='$country_id',visa_id='$visa_id' where id=".$_REQUEST['id']);
        $_SESSION['sess_msg']='Student updated sucessfully';   
        }
        header("location:student-list.php");
        exit();
        }      

if($_REQUEST['id']!=''){
    $sql=$obj->query("select * from $tbl_student where id=".$_REQUEST['id']);
    $result=$obj->fetchNextObject($sql);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('head.php'); ?>
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
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h5 class="txt-dark">Manage Student</h5>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                            <li class="active"><span><a href="student-list.php">Manage Student</a></span></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">
                            <div class="panel-heading">
                                <div class="pull-left">
                                    <h6 class="panel-title txt-dark"><?php if($_REQUEST['id']==''){?> Add <?php }else{?> Update <?php }?> Student</h6>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <div class="form-wrap">
                                        <form action="" method="post">
                                            <input type="hidden" name="submitForm" value="yes">

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="control-label mb-10 text-left">Name :</label>
                                                    <input type="text" class="form-control" placeholder="Name" name="stu_name" id="stu_name" value="<?php echo stripslashes($result->stu_name); ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="control-label mb-10 text-left">Father Name :</label>
                                                    <input type="text" class="form-control" placeholder="Father Name" name="father_name" id="father_name" value="<?php echo stripslashes($result->father_name); ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="control-label mb-10 text-left">Date of Birth :</label>
                                                    <input type="date" class="form-control" placeholder="Date Of Birth" name="dob" id="dob" value="<?php echo stripslashes($result->dob); ?>" required>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-3">
                                                <div class="form-group" >
                                                    <label class="control-label mb-10 text-left">Passport No. :</label>
                                                    <input type="text" class="form-control" placeholder="Passport No." name="passport_no" id="passport_no" value="<?php echo stripslashes($result->passport_no); ?>" required maxlength="8" size="8">
                                                </div>
                                                 <p id="showSearchResult" style="color:red;"></p>
                                            </div>

                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="control-label mb-10 text-left">Country :</label>
                                                    <select class="form-control" name="country_id" id="country_id">
                                                        <option>--Select your Country--</option>
                                                        <?php
                                                        $i=1;
                                                        $sql=$obj->query("select * from $tbl_country where status=1",$debug=-1);
                                                        while($line=$obj->fetchNextObject($sql)){?>
                                                            <option value="<?php echo $line->id ?>" <?php if($result->country_id==$line->id){?>selected<?php } ?>><?php echo $line->name ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="control-label mb-10 text-left">Visa Type :</label>
                                                    <select class="form-control" name="visa_id" id="visa_id">
                                                        <option>--Select your Visa Type--</option>
                                                        <option value="1" <?php if($result->visa_id==1){?> selected <?php } ?>>Study Visa</option>
                                                        <option value="2" <?php if($result->visa_id==2){?> selected <?php } ?>>Tourist Visa</option>
                                                        <option value="3" <?php if($result->visa_id==3){?> selected <?php } ?>>Visitor Visa</option>
                                                        <option value="4" <?php if($result->visa_id==4){?> selected <?php } ?>>Work Visa</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php  if ($_SESSION['level_id']==1 || $_SESSION['level_id']==2 ) { 
                                              if ($_SESSION['level_id']==1) {
                                                $whr = "";
                                              }else if($_SESSION['level_id']==2){
                                                $brand_id=getField('branch_id','tbl_admin',$_SESSION['sess_admin_id']);
                                                $brachArr = explode(',', $brand_id);
                                                $m=1;
                                                foreach($brachArr as $val){
                                                    if($m==1){
                                                        $whr .=" AND ( FIND_IN_SET ($val,branch_id)";
                                                    }else{
                                                        $whr .=" OR FIND_IN_SET ($val,branch_id)";
                                                    }
                                                    if($m==count($brachArr)){
                                                        $whr .=")";
                                                    } 
                                                    $m++;
                                                }
                                                                
                                              }

                                                ?>
                                                <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="control-label mb-10 text-left">Counseller : </label>
                                                    <select class="form-control" name="c_id" id="c_id">
                                                        <option>--Select Counseller--</option>
                                                        <?php
                                                        $sql=$obj->query("select * from $tbl_admin where status=1 and level_id=4 $whr",$debug=-1);
                                                        while($line=$obj->fetchNextObject($sql)){?>
                                                            <option value="<?php echo $line->id ?>" <?php if($result->c_id==$line->id){?>selected<?php } ?>><?php echo $line->name ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                               
                                          <?php   }else{?>
                                          <?php $username=getField('name','tbl_admin',$_SESSION['sess_admin_id']);?>
                                               <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="control-label mb-10 text-left"> Counseller Name :</label>
                                                    <input type="text" class="form-control" value="<?php echo $username; ?>" readonly>
                                                    <input type="hidden" name="c_id" id="c_id" value="<?php echo $_SESSION['sess_admin_id']; ?>">
                                                </div>
                                            </div>


                                          <?php } ?>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label class="control-label mb-10 text-left">&nbsp;</label>
                                                    <button type="submit" class="btn btn-success " style="position: absolute;margin-left: 14px; margin-top: 31px;
                                                    ">Submit</button>
                                                </div>
                                            </div>
                                        </form>
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
    <?php include("footer.php"); ?>

    <script type="text/javascript">
        $(document).ready(function(){
  $("#passport_no").keyup(function(){

    var value = $('#passport_no').val();

var action='getpasport'
    $.ajax({
        type:"post",
        url:"ajax/getModalData.php",
        data :{
                'key' : value,'action': action              
            },          
        success:function(res){
            if (res==0) {

            }else{
               $('#showSearchResult').show().html('This passprot number already add'); 
            }
            
            }
       });

  });
});
        $("#passport_no").keypress(function(){
    $("#showSearchResult").hide();
})
    </script>
</body>
</html>