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
#change_country h4{
    text-align: center;
    background: #edf1f5;
    font-weight: bold;
    border-radius: 5px;
    padding: 5px;
    margin: 10px 0;
}
#change_country label{
    font-size: small;
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
                        <h5 class="txt-dark">Enrollment Setting</h5>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                        <h5 style="color:#2a911d;"><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
                        <h5 style="color:red;">
                            <?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
                    </div>
                    <div class="breadcrumb-section col-lg-4 col-sm-8 col-md-4 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                            <li class="active"><span>Enrollment Setting</span></li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <select name="country_id" id="country_id" class="select2 form-control" multiple onchange="change_country(this.value)">
                                <?php                       
                                                    $clSql = $obj->query("select * from $tbl_country where status=1 order by displayorder asc");
                                                    while($clResult = $obj->fetchNextObject($clSql)){ 
                                                        $stateSqls = $obj->query("select * from $tbl_visa_sub_type where country_id='$clResult->id' and  enrollment_count='1'", -1);
                                                        $count = $obj->numRows($stateSqls);
                                                        ?>
                                <option value="<?php echo $clResult->id; ?>"
                                    <?php if($count > 0){?> selected <?php } ?>>
                                    <?php echo $clResult->name; ?></option>
                                <?php }
                                                    ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body" id="change_country">
                                       <?php
                                       $stateSqls = $obj->query("select * from $tbl_visa_sub_type where enrollment_count='1' group by country_id", -1);
                                       while($ress = $obj->fetchNextObject($stateSqls)){
                                        ?>
                                        <h4>Choose <?=getField('name',$tbl_country,$ress->country_id)?> Payment Type</h4>
                                        <div class="row">
                                            <?php
                                            $stateSqls1 = $obj->query("select * from $tbl_visa_sub_type where country_id='$ress->country_id'", -1);
                                            while($res1 = $obj->fetchNextObject($stateSqls1)){
                                            ?>
                                            <div class="col-md-4">
                                            <input type="checkbox" value="1" onchange="change_status(this, <?=$res1->id?>)" id="chechbox<?=$res1->id?>" <?=$res1->enrollment_count == 1 ? 'checked' : ''?>>    
                                            <label for="chechbox<?=$res1->id?>"><?=$res1->visa_sub_type?></label></div>
                                            <?php } ?>
                                        </div>
                                        <?php
                                       }
                                       ?>
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
    <script>
    $(".select2").select2({
        placeholder: "Select Country",
        allowClear: true
    });
    </script>
    <script>
        function change_country(val){
            var selectElement = document.getElementById("country_id");
            var selectedValues = [];
            
            for (var i = 0; i < selectElement.options.length; i++) {
                if (selectElement.options[i].selected) {
                    selectedValues.push(selectElement.options[i].value);
                }
            }
            $.ajax({
                method:"POST",
                url:"controller.php",
                data:{country_wise_visa_subtype1: selectedValues},
                success:function(data){
                    $("#change_country").html(data);
                }
            })
        }
    </script>
    <script>
        function change_status(val,id){
            if(val.checked == 1){
                checkbox = 1;
            }else{
                checkbox = 0;
            }
            $.ajax({
                method:"POST",
                url:"controller.php",
                data:{subtype_checkbox1: checkbox,id:id},
                success:function(data){
                   
                }
            })
        }
    </script>
   
</body>


</html>