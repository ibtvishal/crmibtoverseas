<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$whr1 = "  ";
$_SESSION['whr1'] = '';
if($_SESSION['level_id'] == 35 || $_SESSION['level_id'] == 25){
    $branchid = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    $whr1 .= " and a.branch_id in ($branchid)";
}
if($_SESSION['level_id'] == 4 ){
    $branchid = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    $whr1 .= " and a.c_id='{$_SESSION['sess_admin_id']}'";
  }
if($_REQUEST['branch_id']){
    $branchArr = $_REQUEST['branch_id'];
    $branch_id = implode(',',$branchArr);
    $whr1 .= " and a.branch_id in ($branch_id)";
  }
  if($_REQUEST['country_id']){
    $country_id = $_REQUEST['country_id'];
    $whr1 .= " and a.country_id=$country_id";
  }
  if($_REQUEST['councellor_id']){
    $councellor_id = $_REQUEST['councellor_id'];
    $whr1 .= " and a.c_id=$councellor_id";
  }
  if($_REQUEST['value']){
    $value = $_REQUEST['value'];
    $whr1 .= " and b.value='$value'";
  }


  if($_REQUEST['filter_start_date'] && $_REQUEST['filter_end_date']){
    $filter_start_date = $_REQUEST['filter_start_date'];
    $filter_end_date = $_REQUEST['filter_end_date'];
    $whr1 .= " and date(b.cdate) >= '$filter_start_date' and date(b.cdate) <= '$filter_end_date'";
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
                        <h5 class="txt-dark">
                            Funding Report Student Wise
                        </h5>
                    </div>
                    <div class="breadcrumb-section col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                            <li class="active">
                                <span><a>Funding Report Student Wise</a></span>
                            </li>
                        </ol>
                    </div>
                </div>
                <form action="" method="post" id="searchfrm">
                    <input type="hidden" name="status1" id="status1">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="branch_id[]" id="branch_id" onchange="form_submit()"
                                    class="form-control select2" multiple="">
                                    <?php
                        if(!empty($_REQUEST['branch_id'])){
                          $branchArr = $_REQUEST['branch_id'];
                        }elseif(isset($branchids)){
                            $branchArr = $branchids;
                        }else{
                          $branchArr = array();
                        }                      
                        $b_con = '';
                        if($_SESSION['level_id']!==1){
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
                                <select name="country_id" id="country_id" onchange="form_submit()" class="form-control">
                                    <option value="">Country</option>
                                    <?php                       
                          $clSql = $obj->query("select * from $tbl_country where status=1 order by displayorder asc");
                          while($clResult = $obj->fetchNextObject($clSql)){?>
                                    <option value="<?php echo $clResult->id; ?>"
                                        <?php if($_REQUEST['country_id']==$clResult->id){?> selected <?php } ?>>
                                        <?php echo $clResult->name; ?></option>
                                    <?php }
                        ?>
                                </select>
                            </div>
                        </div>
                        <?php
                        if($_SESSION['level_id'] != 4){
                        ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="councellor_id" id="councellor_id" class="form-control" onchange="form_submit()">
                                    <option value="">Counsellor</option>
                                    <?php
                                                if(!empty($_REQUEST['branch_id'])){
                                                $idArr = $_REQUEST['branch_id'];
                                                $idArr = $_REQUEST['branch_id'];
                                                $i=1; $whrr='';
                                                foreach($idArr as $val){
                                                    if($i==1){
                                                    $whrr .=" and ( FIND_IN_SET($val, branch_id)";
                                                    }else{
                                                    $whrr .=" or FIND_IN_SET($val, branch_id)";
                                                    }
                                                    if($i==count($idArr)){
                                                    $whrr .=" )";
                                                    }
                                                    $i++;
                                                }                          
                                                $clSql = $obj->query("select * from $tbl_admin where status=1 and level_id=4 $whrr order by name",-1);
                                                }else{
                                                $clSql = $obj->query("select * from $tbl_admin where status=1 and level_id=4  order by name",-1);
                                                }
                                                while($clResult = $obj->fetchNextObject($clSql)){?>
                                    <option value="<?php echo $clResult->id; ?>"
                                        <?php if($_REQUEST['councellor_id']==$clResult->id){?> selected <?php } ?>>
                                        <?php echo $clResult->name; ?></option>
                                    <?php }
                                               ?>
                                </select>
                            </div>
                        </div>
                        <?php } ?>

                          <div class="col-md-3">
                            <div class="form-group">
                                <select name="value" id="value" onchange="form_submit()" class="form-control">
                                    <option value="">Funding Type</option>
                                    <option <?=$_REQUEST['value'] == 'Self' ? 'selected' : ''?> value="Self">Self</option>
                                    <option <?=$_REQUEST['value'] == 'Outsider Financer' ? 'selected' : ''?> value="Outsider Financer">Outsider Financer</option>
                                    <option <?=$_REQUEST['value'] == 'Own Financer' ? 'selected' : ''?> value="Own Financer">Own Financer</option>
                                   
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="filter_start_date" id="filter_start_date" class="form-control"
                                    style="height: 36px;" value="<?php echo $_REQUEST['filter_start_date']; ?>"
                                    placeholder="Start Date" onfocus="(this.type='date')" onblur="(this.type='text')">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <input type="text" name="filter_end_date" id="filter_end_date" class="form-control"
                                    style="height: 36px;" value="<?php echo $_REQUEST['filter_end_date']; ?>"
                                    placeholder="End Date" onfocus="(this.type='date')" onblur="(this.type='text')">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" name="subit" class="btn btn-primary download_csv_button"
                                    style="width: 170px; height: 40px;">Submit</button>
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
                                        <div class="table-responsive">
                                            <table id="studentList" class="table table-hover display pb-30">
                                                <div class="choose_prog" style="">
                                                </div>
                                                <thead>
                                                    <tr>
                                                        <th>Sr. No.</th>
                                                        <th>Name</th>
                                                        <th>Student Id</th>
                                                        <th>DOB</th>
                                                        <th>Passport No.</th>
                                                        <th>Country</th>
                                                        <th>Branch</th>
                                                        <th>Counsellor</th>
                                                        <th>Funding Type</th>
                                                        <th>Action</th>
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
    var dataTable = $('#studentList').DataTable({
        "processing": true,
        "serverSide": true,
        "stateSave": false,
        "lengthMenu": [
            [10, 50, 100, 500, 1000, 1500],
            [10, 50, 100, 500, 1000, 1500]
        ],
        "pageLength": 10,
        "aoColumnDefs": [{
                "targets": 0, // First column (Sr. No.)
                "render": function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                "bSortable": false,
                "aTargets": [0, 1, 2, 3, 4]
            },
            {
                "bSearchable": false,
                "aTargets": [0, 1, 2, 3, 4]
            }
        ],
        "ajax": {
            url: "funding-report-ajax.php",
            type: "post",
            error: function() {
                $(".product-grid-error").html("");
                $("#product-grid").append(
                    '<tbody class="product-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>'
                );
                $("#product-grid_processing").css("display", "none");
            }
        }
    });
    </script>
    <script src="js/change-status.js"></script>
    <script>
    function form_submit() {
        $("#searchfrm").submit();
    }
    $(".select2").select2({
        placeholder: "All Branch",
        allowClear: true
    });
    </script>

</body>

</html>