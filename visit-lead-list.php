<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$_SESSION['whr']='';
$_SESSION['whr1']='';
$_SESSION['status']=1;

$whr='';

if($_SESSION['level_id']==19 || $_SESSION['level_id'] == 25){
  $branchid = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
  $whr .= " and a.branch_id in ($branchid)";
}

if($_REQUEST['filter_start_date'] && $_REQUEST['filter_end_date']){
  $filter_start_date = $_REQUEST['filter_start_date'];
  $filter_end_date = $_REQUEST['filter_end_date'];
  $whr .= " and date(a.cdate) >= '$filter_start_date' and date(a.cdate) <= '$filter_end_date'";
}

$_SESSION['whr'] = $whr;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include('head.php'); ?>
</head>
<style type="text/css">
  .material-switch > input[type="checkbox"] {
    display: none;   
  }

  .material-switch > label {
    cursor: pointer;
    height: 0px;
    position: relative; 
    width: 40px;  
  }

  .material-switch > label::before {
    background: rgb(0, 0, 0);
    box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
    border-radius: 8px;
    content: '';
    height: 16px;
    margin-top: -8px;
    position:absolute;
    opacity: 0.3;
    transition: all 0.4s ease-in-out;
    width: 40px;
  }
  .material-switch > label::after {
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
  .material-switch > input[type="checkbox"]:checked + label::before {
    background: inherit;
    opacity: 0.5;
  }
  .material-switch > input[type="checkbox"]:checked + label::after {
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
        <h5 style="color:#2a911d; text-align: center;"><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
        <h5 style="color:red;"><?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
        <div class="row heading-bg">
          <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Manage Visits Lead</h5>
          </div>
          
          <div class="breadcrumb-section col-lg-6 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
              <li><a href="welcome.php">Dashboard</a></li>             
            </ol>
          </div>
        </div> 
        <form method="post" name="searchfrm" id="searchfrm" action="visit-lead-list.php" >
        <div class="row">
          <div class="col-sm-12">
            <div class="panel panel-default card-view">
              <div class="panel-wrapper">
                  <div class="col-md-2">
                    <div class="form-group">
                      <input type="text" name="filter_start_date" id="filter_start_date" class="form-control" style="height: 36px;" value="<?php echo $_REQUEST['filter_start_date']; ?>" placeholder="Start Date" onfocus="(this.type='date')" onblur="(this.type='text')">
                    </div>
                  </div> 

                  <div class="col-md-2">
                    <div class="form-group">
                      <input type="text" name="filter_end_date" id="filter_end_date" class="form-control" style="height: 36px;" value="<?php echo $_REQUEST['filter_end_date']; ?>" placeholder="End Date" onfocus="(this.type='date')" onblur="(this.type='text')">
                    </div>
                  </div> 

                  <div class="col-md-2">
                    <div class="form-group">
                      <button type="submit" name="subit" class="btn btn-primary download_csv_button" style="width: 170px; height: 40px;">Submit</button>
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
                    <div class="table-responsive">
                      <table id="ApplicationList" class="table table-hover display  pb-30" >
                        <div class="choose_prog" style="">
                        </div>
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Applicant Name</th>
                            <th>Contact No.</th>
                            <th>State</th>
                            <th>District</th>
                            <th>Visa Type</th>                            
                            <th>Preferred Country</th>
                            <th>Branch</th>
                            <th>Telecaller</th>
                            <th>Source</th>
                            <th>Status</th>
                            <th>Remarks </th>
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
<script src="js/select2.full.min.js"></script>
<script type="text/javascript">
    $(".select2").select2({
      placeholder: "Select Branch",
      allowClear: true
    });

  var dataTable = $('#ApplicationList').DataTable({
    "processing": true,
    "serverSide": true,
    "stateSave": false,
    "lengthMenu": [[50, 100, 500, 1000, 1500], [50, 100, 500, 1000, 1500]],
    "pageLength": 50,     
    "aoColumnDefs": [
      { "bSortable": false, "aTargets": [ 0, 1, 2, 3,4,5,6,7,8,9,10,11,12 ] }, 
      { "bSearchable": false, "aTargets": [ 0, 1, 2, 3,4,5,6,7,8,9,10,11,12 ] }
      ],
    "ajax":{
      url :"visit-lead-list-ajax.php",
      type: "post",
      error: function(){ 
        $(".product-grid-error").html("");
        $("#product-grid").append('<tbody class="product-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
        $("#product-grid_processing").css("display","none");
      }
    }
  })


  $("#branch_id").change(function(){
    $("#searchfrm").submit();
  })
  $("#country_id").change(function(){
    $("#searchfrm").submit();
  })
  $("#councellor_id").change(function(){
    $("#searchfrm").submit();
  })
  $("#telecaller_id").change(function(){
    $("#searchfrm").submit();
  })
  $("#visa_type").change(function(){
    $("#searchfrm").submit();
  })


 function getAppRecord(status){
    $('#searchfrm').append('<input name="status" value="'+status+'" type="hidden"/>');
    $("#searchfrm").submit();
 }
</script>
<script src="js/change-status.js"></script> 
</body>
</html>