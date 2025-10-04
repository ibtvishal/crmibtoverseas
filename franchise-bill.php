<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$_SESSION['whr']='';
$whr=" and date(b.cdate) >= '2025-02-01'";
$b_con='';
$status = 0;
if($_SESSION['level_id']!=1){
    $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    $b_con = " and id in ($branch_id)";
}
$branchSql = $obj->query("select * from $tbl_branch where status=1 and franchise_bill=1 $b_con");
$id = [];
while($branchResult = $obj->fetchNextObject($branchSql)){
$id[] = $branchResult->id;
}
$branch_id = implode(',',$id);
    $whr .= " and a.branch_id in ($branch_id)";

    if($_REQUEST['branch_id']){
        $branchArr = $_REQUEST['branch_id'];
        $branch_id = implode(',',$branchArr);
        $whr .= " and branch_id in ($branch_id)";
      }
  $_SESSION['whr'] = $whr;
  $_SESSION['status'] = $status;
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
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <h5 class="txt-dark">Franchise Bill</h5>
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
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="branch_id[]" id="branch_id" class="form-control select2" multiple="">
                                    <?php
                                     if(!empty($_REQUEST['branch_id'])){
                                        $branchArr = $_REQUEST['branch_id'];
                                      }else{
                                        $branchArr = array();
                                      }                       
                                      $b_con = '';
                                      if($_SESSION['level_id']!==1){
                                          $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                          $b_con = " and id in ($branch_id)";
                                      }
                                $branchSql = $obj->query("select * from $tbl_branch where status=1 and franchise_bill=1 $b_con");
                                while($branchResult = $obj->fetchNextObject($branchSql)){?>
                                    <option value="<?php echo $branchResult->id; ?>"
                                        <?php if(sizeof($branchArr)>0){ if(in_array($branchResult->id,$branchArr)){?>
                                        selected <?php }} ?>>
                                        <?php echo $branchResult->name; ?>
                                    </option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary" name="btn_submit_branch">Submit</button>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-lg-3 col-md-2 col-sm-2 col-xs-12">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                    $obj->query("select sum(b.total_amount) as total from $tbl_visit as a inner join $tbl_visit_fee as b on a.id = b.visit_id where 1=1 $whr",$debug=-1);
                                                                    $line=$obj->fetchNextObject($sql);
                                                                    echo $totalVisit = $line->total;
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Total Before Visa Amount</span>
                                                    </a>
                                                </div>
                                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                    <i
                                                        class="icon-user-following data-right-rep-icon txt-light-grey"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-3 col-md-2 col-sm-2 col-xs-12">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <a href="javascript:void(0)">
                                                        <span class="txt-dark block counter"><span class="counter-anim">
                                                                <?php
                                                                    $obj->query("select sum(b.total_amount) as total from $tbl_visit as a inner join $tbl_visit_fee as b on a.id = b.visit_id where 1=1 and payment_type in('After Visa') $whr",$debug=-1);
                                                                    $line=$obj->fetchNextObject($sql);
                                                                    echo $totalVisit = $line->total;
                                                                    ?>
                                                            </span></span>
                                                        <span class="weight-500 uppercase-font block font-13">Total After Visa Amount</span>
                                                    </a>
                                                </div>
                                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                    <i
                                                        class="icon-user-following data-right-rep-icon txt-light-grey"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <div class="table-wrap">
                                        <div class="table-responsive">
                                            <table id="datable_3s" class="table table-hover display  pb-30">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Date</th>
                                                        <th>Student Code</th>
                                                        <th>Name</th>
                                                        <th>Father Name</th>
                                                        <th>Country</th>
                                                        <th>Payment Type</th>
                                                        <th>Branch</th>
                                                        <th>Payment Type</th>
                                                        <th>Amount Received</th>
                                                        <th>Slip</th>
                                                        <!-- <th>Enrollment Slip</th>
                                                        <th>After Visa Slip</th> -->
                                                        <!-- <th>Payment History</th> -->
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
    <?php include("footer.php"); ?>
    <script src="js/select2.full.min.js"></script>
    <script src="js/change-status.js"></script>
    <script src="js/select2.full.min.js"></script>
    <script src="js/select2.full.min.js"></script>
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
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Approve it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    method: "post",
                    url: "controller.php",
                    data: {
                        change_audit_id: id
                    },
                    success: function(data) {
                        if (data == 1) {
                            // $("#change_hide_status" + id).hide();
                            $(".change_color" + id).removeAttr('style');
                            $("#change_hide_status" + id).html('Approved');
                            $("#change_hide_status" + id).removeAttr('class');
                            $("#change_hide_status" + id).attr('class', 'btn btn-success');
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
        "stateSave": true,
        "lengthMenu": [
            [50, 100, 500, 1000, 1500],
            [50, 100, 500, 1000, 1500]
        ],
        "pageLength": 50,
        "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7]
            },
            {
                "bSearchable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7]
            }
        ],
        "ajax": {
            url: "franchise-bill-ajax.php",
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
                update_remark: 1
            },
            success: function(data) {
                $(".text-success").html('');
                $("#success" + id).html('Remarks Saved');
            }
        })
    }
    </script>
</body>


</html>