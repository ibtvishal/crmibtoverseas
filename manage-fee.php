<?php
ob_start();
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$_SESSION['whr1'] = '';
$_SESSION['tbl_visa_sub_type_join'] = '';
$_SESSION['condition_of_visa_sub_type'] = '';
$whr1 = '';
$addtional_role = explode(',',$_SESSION['additional_role']);
if(isset($_REQUEST['branch_id'])){
    $branchArr = $_REQUEST['branch_id'];
    if(is_array($branchArr)){
        $branch_id = implode(',',$branchArr);
      }else{
            $branch_id = $_REQUEST['branch_id'];
        }
    $whr1 .= " and a.branch_id in ($branch_id)";
}else{
    if($_SESSION['level_id']!=1){
        $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
        $whr1 .= " and a.branch_id in ($branch_id)";
    }
  }
  if($_REQUEST['country_id']){
    $country_id = $_REQUEST['country_id'];
    $whr1 .= " and a.pre_country_id=$country_id"; 
  }
  if($_REQUEST['payment_type']){
    $payment_type = $_REQUEST['payment_type'];
    $whr1 .= " and a.visa_sub_type=$payment_type";
  }
  
  if($_REQUEST['visa_type']){
    $visa_type = $_REQUEST['visa_type'];
    $whr1 .= " and FIND_IN_SET('$visa_type',a.visa_type)";
  }
  if($_REQUEST['filter_start_date'] && $_REQUEST['filter_end_date']){
    $filter_start_date = $_REQUEST['filter_start_date'];
    $filter_end_date = $_REQUEST['filter_end_date'];
    $whr1 .= " and date(b.payment_date) >= '$filter_start_date' and date(b.payment_date) <= '$filter_end_date'";
    $tbl_visa_sub_type_join = " inner join $tbl_visa_sub_type as c on a.visa_sub_type=c.id";
    $condition_of_visa_sub_type = " and c.enrollment_count=1";
}else{
      $tbl_visa_sub_type_join = "";
      $condition_of_visa_sub_type = " ";
  }
  $_SESSION['whr1'] = $whr1;
  $_SESSION['tbl_visa_sub_type_join'] = $tbl_visa_sub_type_join;
  $_SESSION['condition_of_visa_sub_type'] = $condition_of_visa_sub_type;
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
                    <?php echo $_SESSION['sess_msg'];
                    $_SESSION['sess_msg'] = '';  ?></h5>
                <h5 style="color:red;"><?php echo $_SESSION['sess_msg_error'];
                                        $_SESSION['sess_msg_error'] = '';  ?></h5>
                <div class="row heading-bg">
                    <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12"> 
                        <h5 class="txt-dark">Enrolled Students
                            <?php if ($_REQUEST['status']) {
                                echo "<span style='color:#2e0cdd;'>of " . $stauscontent . "</span>";
                            } ?>
                        </h5>
                    </div>

                    <div class="breadcrumb-section col-lg-6 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                        </ol>
                    </div>
                </div>
                <form method="post" name="searchfrm" id="searchfrm" action="manage-fee.php">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default card-view">
                                <div class="panel-wrapper">

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select name="branch_id[]" id="branch_id" class="form-control select2"
                                                multiple="">
                                                <?php
                        if(!empty($_REQUEST['branch_id'])){
                          $branchArr = $_REQUEST['branch_id'];
                          if(is_array($branchArr)){
                            $branchArr = $branchArr;
                             }else{
                                $branchArr = array($branchArr);
                            }
                        }elseif(isset($branchids)){
                            $branchArr = $branchids;
                        }else{
                          $branchArr = array();
                        }                      
                        if($_SESSION['level_id']!=1){
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
                                            <select name="country_id" id="country_id" class="form-control">
                                                <option value="">Country</option>
                                                <?php                       
                          $clSql = $obj->query("select * from $tbl_country where status=1 order by displayorder asc");
                          while($clResult = $obj->fetchNextObject($clSql)){?>
                                                <option value="<?php echo $clResult->id; ?>"
                                                    <?php if($_REQUEST['country_id']==$clResult->id){?> selected
                                                    <?php } ?>><?php echo $clResult->name; ?></option>
                                                <?php }
                        ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control" id="visa_type" name="visa_type">
                                                <option value="">Visa Type</option>
                                                <option value="Study" <?php if($_REQUEST['visa_type']=='Study'){?>
                                                    selected <?php }?>>Study</option>
                                                <option value="Visitior/tourist"
                                                    <?php if($_REQUEST['visa_type']=='Visitior/tourist'){?> selected
                                                    <?php }?>>Visitior/tourist</option>
                                                <option value="Spouse" <?php if($_REQUEST['visa_type']=='Spouse'){?>
                                                    selected <?php }?>>Spouse</option>
                                                <option value="Work" <?php if($_REQUEST['visa_type']=='Work'){?>
                                                    selected <?php }?>>Work</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control" id="payment_type" name="payment_type">
                                                <option value="">Payment Type</option>
                                                <?php
                                                $conn = '';
                                                if($_REQUEST['country_id'] && $_REQUEST['visa_type']){
                                                    $conn .= " and country_id='".$_REQUEST['country_id']."' and visa_type='".$_REQUEST['visa_type']."'"; 
                                                $stateSqls = $obj->query("select * from $tbl_enrolled_fee where 1 = 1 $conn order by displayorder asc", -1);
                                                while ($stateResult = $obj->fetchNextObject($stateSqls)) { ?>
                                                <option value="<?php echo $stateResult->visa_sub_type ?>"
                                                    <?php if ($_REQUEST['payment_type'] ==  $stateResult->visa_sub_type) { ?> selected <?php } ?>>
                                                    <?php echo getField('visa_sub_type',$tbl_visa_sub_type,$stateResult->visa_sub_type);?>
                                                </option>
                                                <?php } } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <button type="submit" name="subit"
                                                class="btn btn-primary download_csv_button"
                                                style="width: 170px; height: 40px;">Submit</button>
                                        </div>
                                    </div>

                                </div>
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
                                                <div class="col-md-2">Color Code: <span style="color:green">Enrolled</span>, <span style="color:red">Visa Refused</span></div>
                                            </div>
                                        <div class="table-responsive">
                                            <table id="ApplicationList" class="table table-hover display  pb-30">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Date</th>
                                                        <th>Student Code</th>
                                                        <th>Name</th>
                                                        <th>Father Name</th>
                                                        <th>Country</th>
                                                        <th>Visa Type</th>
                                                        <th>Payment Type</th>
                                                        <th>Contact</th>
                                                        <th>Branch</th>
                                                        <th>After Visa Fee Commitment</th>
                                                        <th>Registration Receipt</th>
                                                        <th>Enrolled Receipt</th>
                                                        <?php
                                                        if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 14 || in_array(6,$addtional_role)){
                                                        ?>
                                                        <th>Pay After Visa Fee</th>
                                                        <?php } ?>
                                                        <th>Payment History</th>
                                                        <?php
                                                        if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 4 || $_SESSION['level_id'] == 11 || in_array(1,$addtional_role)){
                                                        ?>
                                                        <th>Update Profile</th>
                                                        <?php } ?>
                                                        <?php
                                                        if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 14 || in_array(6,$addtional_role)){
                                                        ?>
                                                    <th>Reapply</th>
                                                        <?php } ?>
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


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pay Now</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="add-fee.php" method="get">
                    <div class="modal-body" style="text-align: center;">
                        <input type="hidden" class="form-control" id="get_id" name="id" required>
                        <input type="hidden" class="form-control" id="get_type" value="After Visa" name="type" required>
                        <center>
                            <div class="row">
                                <div class="style-radio col-md-6">
                                    <label for="after_visa">After Visa</label>
                                    <input type="radio" name="types" id="after_visa" value="After Visa" onchange="change_radio(this.value)" checked required>
                                </div>
                            </div>
                        </center>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Pay Now</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- model table -->

    <div id="invoiceModel" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content bg-white">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">
                        <img src="img/logo.svg" alt="logo" height="50px">
                        <span style="font-weight: 700; color: black;">Student Fee Details</span>
                        <span></span>
                    </h4>
                </div>
                <div class="modal-body bg-light px-0" id="get_modal_data">
                 
                </div>

            </div>
        </div>


        <?php include("footer.php"); ?>
        <script src="js/select2.full.min.js"></script>
        <script src="js/select2.full.min.js"></script>
        <script type="text/javascript">
            $(".select2").select2({
                placeholder: "All Branch",
                allowClear: true
            });

            var dataTable = $('#ApplicationList').DataTable({
                "processing": true,
                "serverSide": true,
                "stateSave": false,
                "lengthMenu": [
                    [50, 100, 500, 1000, 1500],
                    [50, 100, 500, 1000, 1500]
                ],
                "pageLength": 50,
                "aoColumnDefs": [{
                        "bSortable": false,
                        "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                    },
                    {
                        "bSearchable": false,
                        "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
                    }
                ],
                "ajax": {
                    url: "manage-fee-ajax.php",
                    type: "post",
                    error: function() {
                        $(".product-grid-error").html("");
                        $("#product-grid").append(
                            '<tbody class="product-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>'
                        );
                        $("#product-grid_processing").css("display", "none");
                    }
                },
        "createdRow": function(row, data, dataIndex) {
            $('td', row).eq(-5).css('text-align', 'center');
            $('td', row).eq(-4).css('text-align', 'center');
            $('td', row).eq(-3).css('text-align', 'center');
            $('td', row).eq(-2).css('text-align', 'center');
            $('td', row).eq(-1).css('text-align', 'center');
        }
            })


            $("#branch_id").change(function() {
                $("#searchfrm").submit();
            })
            $("#country_id").change(function() {
                $("#searchfrm").submit();
            })
            $("#councellor_id").change(function() {
                $("#searchfrm").submit();
            })
            $("#telecaller_id").change(function() {
                $("#searchfrm").submit();
            })
            $("#visa_type").change(function() {
                $("#searchfrm").submit();
            })
            $("#payment_type").change(function() {
                $("#searchfrm").submit();
            })


            function getAppRecord(status) {
                $('#searchfrm').append('<input name="status" value="' + status + '" type="hidden"/>');
                $("#searchfrm").submit();
            }
        </script>
        <script>
            function get_modal(id) {
                $("#get_id").val(id);
                $("#exampleModal").modal('show');
            }

            function change_radio(val) {
                $("#get_type").val(val);
                $("#exampleModal").modal('show');
            }
        </script>
           <script>
        function get_modal_data(id,payment_type){
            $.ajax({
                method:"POST",
                url:"controller.php",
                data:{id:id,type:payment_type,get_modal_data_fee:1},
                success:function(data){
                    $("#get_modal_data").html(data);
                }
            })
        }
    </script>
        <script src="js/change-status.js"></script>
</body>

</html>