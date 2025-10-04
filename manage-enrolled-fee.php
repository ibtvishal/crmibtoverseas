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
                        <h5 class="txt-dark">Manage Enrolled Fee</h5>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                        <h5 style="color:#2a911d;"><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
                        <h5 style="color:red;">
                            <?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
                    </div>
                    <div class="breadcrumb-section col-lg-4 col-sm-8 col-md-4 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                            <?php
                            if($_SESSION['level_id'] == 1){
                            ?>
                            <li class="active"><span><a href="add-enrolled-fee.php">Add
                            Enrolled Fee</a></span></li>
                            <?php } ?>
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
                                                            <th>Id</th>
                                                            <th>Country</th>
                                                            <th>Visa Type</th>
                                                            <th>Payment Type</th>
                                                            <th>Type</th>
                                                            <!-- <th>Registration (%)</th> -->
                                                            <th>Amount</th>
                                                            <th>After Visa Amount</th>
                                                            <?php
                                                            if($_SESSION['level_id'] == 1){
                                                            ?>
                                                            <th>Display Order</th>
                                                            <th>Action</th>
                                                            <?php } ?>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Country</th>
                                                            <th>Visa Type</th>
                                                            <th>Payment Type</th>
                                                            <th>Type</th>
                                                            <!-- <th>Registration (%)</th> -->
                                                            <th>Amount</th>
                                                            <th>After Visa Amount</th>
                                                            <?php
                                                                if($_SESSION['level_id'] == 1){
                                                                ?>
                                                            <th>Display Order</th>
                                                            <th>Action</th>
                                                            <?php } ?>
                                                        </tr>
                                                    </tfoot>
                                                   <tbody>
                                                     <?php
                                                    $i = 1;
                                                    $sql=$obj->query("SELECT * FROM $tbl_enrolled_fee ORDER BY id DESC",$debug=-1);
                                                    while($line=$obj->fetchNextObject($sql)){ 
                                                        ?>
                                                        <tr>
                                                            <td><?=$line->id?></td>
                                                            <td><?=getField('name',$tbl_country,$line->country_id)?></td>
                                                            <td><?=$line->visa_type?></td>
                                                            <td><?=getField('visa_sub_type',$tbl_visa_sub_type,$line->visa_sub_type)?></td>
                                                            <td><?php if($line->type != ''){ echo $line->type == 'Fresh' ? 'Update' : 'Upgrage'; }?></td>
                                                            <!-- <td><?=$line->registration_percentage?>%</td> -->
                                                            <td>
                                                                <p><b>Amount: </b><?=$line->amount?></p>
                                                                <p><b>GST: </b><?=$line->gst?>%</p>
                                                                <p><b>Amount After GST: </b><?=intval($line->amount+$line->amount*18/100)?></p>
                                                                <p><b>Discount: </b><?=$line->discount?></p>
                                                            </td>
                                                            <td>
                                                                <p><b>Amount: </b><?=$line->after_visa_amount?></p>
                                                                <p><b>GST: </b><?=$line->after_visa_gst?>%</p>
                                                                <p><b>Amount After GST: </b><?=intval($line->after_visa_amount+$line->after_visa_amount*18/100)?></p>
                                                                <p><b>Discount: </b><?=$line->after_visa_discount?></p>
                                                            </td>
                                                            <?php
                                                                if($_SESSION['level_id'] == 1){
                                                                ?>
                                                            <td> <input type="text" size="5" maxlength="2" value="<?php echo $line->displayorder ?>" onchange="chagnedisplayOrder(<?php echo $line->id; ?>,this.value)"></td>
                                                            <td>
                                                            <a href="add-enrolled-fee.php?id=<?=base64_encode(base64_encode(base64_encode($line->id)))?>"><i
                                                                        class="fa fa-edit"
                                                                        style="margin-right: 6px;font-size: 16px;"></i>
                                                                </a>
                                                                <a href="controller.php?delete_enrolled_fee=<?php echo $line->id ?>" value="Delete" type="submit" class="delete_button" onclick="return confirm('Are you sure you want to delete record(s)')" style=" background: transparent;
	                                                            border: none;"><i class="fa fa-trash"  style="margin-right: 6px;font-size: 16px;" ></i> </a> 
                                                            </td>
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
        
function chagnedisplayOrder(id,ival) 
{	
	$.ajax({
        type: "GET", 
        url: 'ajax/getModalData.php',
        data: {id:id,ival:ival,type:'changefeeDisplayOrder'}, //set data
        beforeSend: function () {
        },
        success: function (response) {
        	$("#sess_msg").html("Order successfully updated.");
        	setTimeout(function(){ $("#sess_msg").hide(); }, 1000);        	
        }
    });

}
    </script>
</body>


</html>