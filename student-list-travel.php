<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$whr = '';
$_SESSION['whr']='';
if($_SESSION['level_id'] == 23){
    $branchid = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
    $whr .= " and b.branch_id in ($branchid)";
  }
if($_SESSION['level_id'] == 24){
    $whr .= " and b.work_status=1 and b.am_id = '{$_SESSION['sess_admin_id']}'";
  }

  if($_REQUEST['branch_id']){
    $branchArr = $_REQUEST['branch_id'];
    $branch_id = implode(',',$branchArr);
    $whr .= " and b.branch_id in ($branch_id)";
  }
  if($_REQUEST['sraccount_manager_id']){
    $sraccount_manager_id = $_REQUEST['sraccount_manager_id'];
    $whr .= " and b.am_id=$sraccount_manager_id and sam_assign=1";
  }
  if($_REQUEST['account_manager_id']){
    $account_manager_id = $_REQUEST['account_manager_id'];
    $whr .= " and b.am_id in ($account_manager_id)";
  }
  if($_REQUEST['counsellor_id']){
    $counsellor_id = $_REQUEST['counsellor_id'];
    $whr .= " and b.c_id in ($counsellor_id)";
  }
  if($_REQUEST['filter_start_date'] && $_REQUEST['filter_end_date']){
    $filter_start_date = $_REQUEST['filter_start_date'];
    $filter_end_date = $_REQUEST['filter_end_date'];
    $whr .= " and date(b.cdate) >= '$filter_start_date' and date(b.cdate) <= '$filter_end_date'";
  }
  
if($_REQUEST['country_id']){
    $country_id = $_REQUEST['country_id'];
    $whr .= " and b.country_id=$country_id";
  }
if($_REQUEST['visa_type']){
    $visa_type = $_REQUEST['visa_type'];
    $whr .= " and a.visa_sub_type=$visa_type";
  }
  if($_REQUEST['visa_id']){
    $visa_id = $_REQUEST['visa_id'];
    $whr .= " and b.visa_id=$visa_id";
}
if($_REQUEST['travel_type']){
    if($_REQUEST['travel_type'] == 'Allocated'){
        $whr .= " and b.am_id!=0";
    }else{
        $whr .= " and b.am_id=0";
    }
  }
  if($_REQUEST['accept_student']){
    if($_REQUEST['accept_student'] == 'Yes'){
        $accept_student = 1;
    }else{
        $accept_student = 0;
    }
  $whr .= " and a.accept_student = $accept_student";
}

  $_SESSION['whr']=$whr;
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

.dt-buttons {
    float: none !important;
    margin-top: 15px !important;
}

.buttons-csv {
    float: right !important;
    margin-top: 15px !important;
}

.text-pagination {
    width: 304px;
    position: absolute;
    top: 1.5%;
    left: 15%;
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
                        <h5 class="txt-dark">Manage Student</h5>
                    </div>
                    <?php  if ($_SESSION['level_id']==1 || $_SESSION['level_id']==14){?>
                    <form class="form-horizontal form_csv_download_student"
                        action="download_csv.php?table_name=tbl_student&amp;p=student-list" method="post"
                        name="upload_excel" enctype="multipart/form-data" style="">
                        <div class="row">
                            <!-- <div class="col-md-4 col-6">
                  <input type="submit" name="studentList" class="btn btn-primary download_csv_button" value="Download CSV" style="background: yellow; color: #000">
                </div> -->
                        </div>
                    </form>
                    <?php }?>

                    <div class="breadcrumb-section col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                            <?php
              if($_SESSION['level_id']!=1){
                ?>
                            <li class="active"><span><a href="#">Mangae Student</a></span></li>
                            <?php
              }else{
                ?>
                            <li class="active"><span><a href="student-addf.php">Add Student</a></span></li>
                            <?php
              }
              ?>
                        </ol>
                    </div>
                    <?php
            if(isset($_SESSION['success'])){
              ?>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                        <h5 style="color:#2a911d;">Student deleted successfully.</h5>
                    </div>
                    <?php
              unset($_SESSION['success']);
            }
            ?>
                </div>

                <form action="" method="post" id="form_submit">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="branch_id[]" id="branch_id" class="form-control select2" multiple=""
                                    onchange="submit_form()">
                                    <?php
                                        if(!empty($_REQUEST['branch_id'])){
                                        $branchArr = $_REQUEST['branch_id'];
                                        }elseif(isset($branchids)){
                                        $branchArr = $branchids;
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
                        <?php
                          if($_SESSION['level_id']==23){
                        ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="sraccount_manager_id" id="sraccount_manager_id" class="form-control"
                                    onchange="submit_form()">
                                    <option value="">Tourist Visa Manager</option>
                                    <?php
                                                    if(!empty($_REQUEST['branch_id'])){
                                                    $idArr = $_REQUEST['branch_id'];
                                                    $i=1; $whrr='';
                                                    foreach($idArr as $val){
                                                        if($i==1){
                                                        $whrr .=" and ( FIND_IN_SET($val, a.branch_id)";
                                                        }else{
                                                        $whrr .=" or FIND_IN_SET($val, a.branch_id)";
                                                        }
                                                        if($i==count($idArr)){
                                                        $whrr .=" )";
                                                        }
                                                        $i++;
                                                    }
                                                    }
                                                    $b_con = '';
                                                    if($_SESSION['level_id']!=1){
                                                    $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                                    $b_con = " and a.branch_id in ($branch_id)";
                                                    }
                                                    $amSql = $obj->query("select a.id,a.name from $tbl_admin as a inner join $tbl_student as b on a.id=b.am_id where a.status=1 and a.level_id=23 and b.sam_assign=1 $whrr  $b_con group by a.id",-1);
                                                    while($amResult = $obj->fetchNextObject($amSql)){?>
                                    <option value="<?php echo $amResult->id; ?>"
                                        <?php if($_REQUEST['sraccount_manager_id']==$amResult->id){?> selected
                                        <?php } ?>><?php echo $amResult->name; ?></option>
                                    <?php }
                                                ?>
                                </select>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="account_manager_id" id="account_manager_id" class="form-control"
                                    onchange="submit_form()">
                                    <option value="">Tourist Visa Executive</option>
                                    <?php
                                                if(!empty($_REQUEST['branch_id'])){
                                                $idArr = $_REQUEST['branch_id'];
                                                $i=1; $whrr='';
                                                foreach($idArr as $val){
                                                    if($i==1){
                                                    $whrr .=" and ( FIND_IN_SET($val, b.branch_id)";
                                                    }else{
                                                    $whrr .=" or FIND_IN_SET($val, b.branch_id)";
                                                    }
                                                    if($i==count($idArr)){
                                                    $whrr .=" )";
                                                    }
                                                    $i++;
                                                }
                                                }
                                                $b_con = '';
                                                if($_SESSION['level_id']!=1){
                                                $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                                $b_con = " and a.branch_id in ($branch_id)";
                                                }
                                                $amSql = $obj->query("select a.id,a.name from $tbl_admin as a inner join $tbl_student as b on a.id=b.am_id where a.status=1 and a.level_id=24 and b.am_id!=0 $whrr $b_con group by a.id",-1);
                                                while($amResult = $obj->fetchNextObject($amSql)){?>
                                    <option value="<?php echo $amResult->id; ?>"
                                        <?php if($_REQUEST['account_manager_id']==$amResult->id){?> selected <?php } ?>>
                                        <?php echo $amResult->name; ?></option>
                                    <?php }
                     
                                             ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="counsellor_id" id="counsellor_id" class="form-control"
                                    onchange="submit_form()">
                                    <option value="">Counsellor</option>
                                    <?php
                                                        if(!empty($_REQUEST['branch_id'])){
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
                                                        }        
                                                        $b_con = '';
                                                        if($_SESSION['level_id']!=1){
                                                        $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                                                        $b_con = " and branch_id in ($branch_id)";
                                                        }             
                                                        $clSql = $obj->query("select * from $tbl_admin where status=1 and level_id=4 $whrr $b_con");
                                                        while($clResult = $obj->fetchNextObject($clSql)){?>
                                    <option value="<?php echo $clResult->id; ?>"
                                        <?php if($_REQUEST['counsellor_id']==$clResult->id){?> selected <?php } ?>>
                                        <?php echo $clResult->name; ?></option>
                                    <?php 
                                                    }
                                                 ?>
                                </select>
                            </div>
                        </div>
                        <?php
                                    if($_SESSION['level_id'] == '24'){
                                    ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="accept_student" id="accept_student" class="form-control">
                                    <option value="">Student Acceptance</option>
                                    <option value="Yes" <?=$_REQUEST['accept_student'] == 'Yes' ? 'selected' : ''?>>
                                        Accepted</option>
                                    <option value="No" <?=$_REQUEST['accept_student'] == 'No' ? 'selected' : ''?>>
                                        Pending</option>
                                </select>
                            </div>
                        </div>
                        <?php }else{ ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="travel_type" id="travel_type" class="form-control"
                                    onchange="submit_form()">
                                    <option value="">Travel Type</option>
                                    <option value="Allocated" <?php if($_REQUEST['travel_type']=='Allocated'){?>
                                        selected <?php } ?>>Allocated</option>
                                    <option value="Unallocated" <?php if($_REQUEST['travel_type']=='Unallocated'){?>
                                        selected <?php } ?>>Unallocated</option>
                                </select>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="country_id" id="country_id" class="form-control" onchange="submit_form()">
                                    <option value="">Select Country</option>
                                    <?php
                                    $cSql = $obj->query("select * from $tbl_country where status=1 and id in (1,2,3,6) order by displayorder asc");
                                    while($cResult = $obj->fetchNextObject($cSql)){?>
                                    <option value="<?php echo $cResult->id; ?>"
                                        <?php if($_REQUEST['country_id']==$cResult->id){?> selected <?php }  ?>>
                                        <?php echo $cResult->name; ?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="visa_id" id="visa_id" class="form-control" onchange="submit_form()">
                                    <option value="">Select Visa</option>
                                    <option value="2" <?php if($_REQUEST['visa_id']==2){?> selected <?php } ?>>Tourist
                                        Visa</option>
                                    <option value="3" <?php if($_REQUEST['visa_id']==3){?> selected <?php } ?>>Visitor
                                        Visa</option>
                                    <option value="5" <?php if($_REQUEST['visa_id']==5){?> selected <?php } ?>>Spouse
                                        Visa</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="visa_type" id="visa_type" class="form-control" onchange="submit_form()">
                                    <option value="">Case Type</option>
                                    <?php
                                    if($_REQUEST['country_id'] && $_REQUEST['visa_id']){
                                        if($_REQUEST['visa_id'] == 2 || $_REQUEST['visa_id'] == 3){
                                            $visa_t = " and visa_type in ('Visitior/tourist')";
                                        }elseif($_REQUEST['visa_id'] == 5){
                                            $visa_t = " and visa_type in ('Spouse')";
                                        }
                                        $clSql = $obj->query("select * from $tbl_enrolled_fee where country_id='{$_REQUEST['country_id']}' $visa_t order by displayorder asc");
                                        while($clResult = $obj->fetchNextObject($clSql)){?>
                                    <option value="<?php echo $clResult->visa_sub_type; ?>"
                                        <?php if($_REQUEST['visa_type']==$clResult->visa_sub_type){?> selected
                                        <?php } ?>>
                                        <?php echo getField('visa_sub_type',$tbl_visa_sub_type,$clResult->visa_sub_type);?>
                                    </option>
                                    <?php 
                                                    }
                                                }
                                                 ?>
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
                                        <div class="row">
                                            <div class="col-md-12 mt-3 mb-3"> Color Code: <span
                                                    style="color:red">Tourist Visa Executive Not Selected</span>,
                                                <span style="color:green">I-20 Received</span>,
                                                 <span style="color:white;background:red;padding:4px;">Visa Refused</span>,
                                                 <span style="color:white;background:orange;padding:4px;">Back-Out</span>,
                                                     <span
                                                    style="color:white;background:green;padding:4px;">Visa
                                                    Approved</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="studentList" class="table table-hover display pb-30">
                                            <div class="choose_prog" style="">
                                            </div>
                                            <thead>
                                                <tr>
                                                    <th>Student Id</th>
                                                    <th>Date</th>
                                                    <th>Name</th>
                                                    <th>Father Name</th>
                                                    <th>Passport No.</th>
                                                    <!-- <th>Payment Type</th> -->
                                                    <th>Country</th>
                                                    <th>Intake</th>
                                                    <th>Case Type</th>
                                                    <th>Counsellor Name</th>
                                                    <th>Tourist Visa Executive</th>
                                                    <th>Branch Name</th>
                                                    <th>Profile Status</th>
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


            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-white">
                            <h5 class="modal-title pull-left" id="exampleModalLabel">Managemnet Meet</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="controller.php" method="post" id="get_modal_data">

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
    <?php include("footer.php"); ?>
    <script src="js/select2.full.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script>
    $(".select2").select2({
        placeholder: "Select Branch",
        allowClear: true
    });

    var dataTable = $('#studentList').DataTable({
        "processing": true,
        "serverSide": true,
        "stateSave": false,
        "lengthMenu": [
            [10, 50, 100, 500, 1000, 1500],
            [10, 50, 100, 500, 1000, 1500]
        ],
        "pageLength": 10,
        <?php  
    if ($_SESSION['level_id']==1){?> "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
            },
            {
                "bSearchable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]
            }
        ],
        <?php }else{?> "aoColumnDefs": [{
                "bSortable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
            },
            {
                "bSearchable": false,
                "aTargets": [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]
            }
        ],
        <?php }?> "ajax": {
            url: "student-list-travel-ajax.php",
            type: "post",
            error: function() {
                $(".product-grid-error").html("");
                $("#product-grid").append(
                    '<tbody class="product-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>'
                );
                $("#product-grid_processing").css("display", "none");
            }
        },
        <?php  
    if ($_SESSION['level_id']==1){?> "dom": '<"top"lfB>rt<"bottom"ip><"clear">',
        "buttons": [{
            extend: 'csvHtml5',
            text: 'Download CSV',
            title: 'Student List',
            exportOptions: {
                columns: ':not(:last-child):not(:nth-last-child(2))'
            }
        }],
        <?php } ?> "fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            if (aData[11] == "Visa Approved") {
                $('td', nRow).css('background-color', 'green').css('color', 'white !important');
            }
             else if (aData[11] == "Visa Refused") {
                $('td', nRow).css('background-color', '#C5221F').css('color', 'white !important');
            } 
             else if (aData[11] == 'Back-out') {
                $('td', nRow).css('background-color', 'orange').css('color', 'white !important');
            } 
            else {
                $('td', nRow).css('background-color', '');
            }
        }
    });

    $("div.top").append(
        '<div class="text-pagination"><label for="page-input">Go to page: </label><input id="usermobile" type="text" min="1" style="width: 60px;"></div>'
    );

    $('#usermobile').on('change', function() {
        var page = $(this).val();
        if (page > 0 && page <= dataTable.page.info().pages) {
            dataTable.page(page - 1).draw(false);
        } else {
            alert('Invalid page number.');
        }
    });
    </script>
    <script src="js/change-status.js"></script>
    <script>
    function submit_form() {
        $("#form_submit").submit();
    }
    </script>
</body>

</html>