<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$_SESSION['whr1']='';
$whr1=' and a.approve_review=0';
if($_REQUEST['branch_id']){
  $branchArr = $_REQUEST['branch_id'];
  $branch_id = implode(',',$branchArr);
  $whr1 .= " and a.branch_id in ($branch_id)";
}
if($_REQUEST['account_manager_id']){
  $account_manager_id = $_REQUEST['account_manager_id'];
  $whr1 .= " and a.am_id = $account_manager_id";
}

$_SESSION['whr1'] = $whr1;
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
                    <?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
                <h5 style="color:red;"><?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
                <div class="row heading-bg">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h5 class="txt-dark">Manage Review Student</h5>
                    </div>

                    <div class="breadcrumb-section col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                        </ol>
                    </div>
                </div>

                <form action="" method="post" id="submit_form">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="branch_id[]" id="branch_id" class="form-control select2" multiple="" onchange="submit_form()">
                                    <?php
                        if(!empty($_REQUEST['branch_id'])){
                          $branchArr = $_REQUEST['branch_id'];
                        }else{
                          $branchArr = array();
                        }                        
                        $b_con = '';
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
                      <select name="account_manager_id" id="account_manager_id" class="form-control" onchange="submit_form()">
                        <option value="">Admission Executive</option>
                        <?php
                      $account_manager = getField('account_manager', $tbl_admin, $_SESSION['sess_admin_id']);
                      if($account_manager != ''){
                          $amSql = $obj->query("select a.id,a.name from $tbl_admin as a where a.id in($account_manager)",-1);
                          while($amResult = $obj->fetchNextObject($amSql)){?>
                            <option value="<?php echo $amResult->id; ?>" <?php if($_REQUEST['account_manager_id']==$amResult->id){?> selected <?php } ?>><?php echo $amResult->name; ?></option>
                          <?php }
                      }
                        ?>
                      </select>
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
                                                <div class="col-md-12"> Color Code:  <span style="color:red">Time stamp not updated</span>, <span style="color:#fd00f5">Application not submitted</span></div>
                                            </div>
                                        <div class="table-responsive">
                                            <table id="studentList" class="table table-hover display  pb-30">
                                                <div class="choose_prog" style="">
                                                </div>
                                                <thead>
                                                    <tr>
                                                        <th>Student Id</th>
                                                        <th>Date</th>
                                                        <th>Name</th>
                                                        <th>Passport No.</th>
                                                        <th>Country</th>
                                                        <th>Type</th>
                                                        <th>Counsellor Name</th>
                                                        <th>Admission Executive</th>
                                                        <th>Branch Name</th>
                                                        <th>Action</th>
                                                        <th>Approve</th>
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
    <?php include("footer.php"); ?>
    <script src="js/select2.full.min.js"></script>

    <script>
    $(".select2").select2({
        placeholder: "All Branches",
        allowClear: true
    });
    </script>
    <script>
    var dataTable = $('#studentList').DataTable({
        "processing": true,
        "serverSide": true,
        "stateSave": false,
        "lengthMenu": [
            [50, 100, 500, 1000, 1500],
            [50, 100, 500, 1000, 1500]
        ],
        "pageLength": 50,
        <?php  
      if ($_SESSION['level_id']==1){?> "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
            },
            {
                "bSearchable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
            }
        ],
        <?php }else{?> "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
            },
            {
                "bSearchable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
            }
        ],
        <?php }?> "ajax": {
            url: "review-student-list-ajax.php",
            type: "post",
            error: function() {
                $(".product-grid-error").html("");
                $("#product-grid").append(
                    '<tbody class="product-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>'
                    );
                $("#product-grid_processing").css("display", "none");
            }
        }
    })
    </script>
    <script>
      function submit_form(){
        $("#submit_form").submit();
      }
    </script>
    <script src="js/change-status.js"></script>
    <script>
        function change_review(id){
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
            method: "POST",
            url: "controller.php",
            data: {
                id: id,
                change_review: 1
            },
            success: function(data) {
                $("#change_review"+id).removeClass('btn-danger');
                $("#change_review"+id).addClass('btn-success');
                $("#change_review"+id).html('Approved');
                location.reload();
            }
        })
    }
});
        }
    </script>
</body>

</html>