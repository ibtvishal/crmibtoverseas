<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();

$whr="";
$_SESSION['whr']='';
if($_REQUEST['filter_branch_id']){
  $branchArr = $_REQUEST['filter_branch_id'];
  $branch_id = implode(',',$branchArr);
  $whr .= " and a.branch_id in ($branch_id)";
}

if($_REQUEST['filter_company_id']){
  $company_id = $_REQUEST['filter_company_id'];
  $whr .= " and b.company_id in ($company_id)";
}

if($_REQUEST['filter_stages_id']){
  $filter_stages_id = $_REQUEST['filter_stages_id'];
  if($filter_stages_id==1){
    $whr .= " and b.resume = 1";
  }else if($filter_stages_id==2){
    $whr .= " and b.address_proof = 1";
  }
}

if(!empty($whr)){
  $_SESSION['whr'] = $whr;
}

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
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h5 class="txt-dark">Manage Student Experience</h5>
          </div>

          <form class="form-horizontal form_csv_download_student" action="download_csv.php" method="post" name="upload_excel" enctype="multipart/form-data"  style="">
              <div class="row">                  
                <div class="col-md-4 col-6">
                  <input type="submit" name="experienceList" class="btn btn-primary download_csv_button" value="Download CSV" style="background: yellow; color: #000">
                </div>
              </div>                    
            </form>
       <!--    <div class="breadcrumb-section col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
              <li><a href="welcome.php">Dashboard</a></li>
              <li class="active"><span><a href="student-addf.php">Add Student</a></span></li>
            </ol>
          </div> -->
        </div>


        

        <form method="post" name="searchfrm" id="searchfrm" action="student-experience.php">
        <div class="row">
          <div class="col-sm-12">
            <div class="panel panel-default card-view">
              <div class="panel-wrapper">            
                  <div class="col-md-3">
                    <div class="form-group">
                      <select name="filter_branch_id[]" id="filter_branch_id" class="form-control select2" multiple="">
                        <?php
                        if(!empty($_REQUEST['filter_branch_id'])){
                          $branchArr = $_REQUEST['filter_branch_id'];
                        }else{
                          $branchArr = array();
                        }                       
                        
                        $branchSql = $obj->query("select * from $tbl_branch where status=1");
                        while($branchResult = $obj->fetchNextObject($branchSql)){?>
                          <option value="<?php echo $branchResult->id; ?>" <?php if(sizeof($branchArr)>0){ if(in_array($branchResult->id,$branchArr)){?> selected <?php }} ?>><?php echo $branchResult->name; ?></option>
                        <?php }?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <select name="filter_company_id" id="filter_company_id" class="form-control">
                        <option value="">Select Company Name</option>
                        <?php
                        $isql = $obj->query("select * from $tbl_company where status=1");
                        while($iResult = $obj->fetchNextObject($isql)){?>
                        <option value="<?php echo $iResult->id; ?>" <?php if($_REQUEST['filter_company_id']==$iResult->id){?> selected <?php } ?>><?php echo $iResult->name; ?></option>
                        <?php }?>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-3">
                    <div class="form-group">
                      <select name="filter_stages_id" id="filter_stages_id" class="form-control">
                        <option value="">Select Stage</option>
                        <option value="1" <?php if($_REQUEST['filter_stages_id']==1){?> selected <?php } ?>>Resume</option>
                        <option value="2" <?php if($_REQUEST['filter_stages_id']==2){?> selected <?php } ?>>Aadhar Card</option>
                      </select>
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
                      <table id="datable_3" class="table table-hover display  pb-30" >                        
                        <form name="frm" method="post" action="country-del.php" enctype="multipart/form-data">
                          <thead>
                            <tr>
                              <th>SNo.</th>
                              <th>Timestamp</th>
                              <th>IBT Student Code</th>
                              <th>Request Slip No.</th>
                              <th>Student Name</th>
                              <th>Father Name</th>
                              <th>Company Name</th>
                              <th>Designation</th>
                              <th>Start Date</th>
                              <th>End Date</th>
                              <th>Duration</th>
                              <th>Salary</th>
                              <th>Issued Date</th>
                              <th>Branch Name</th>
                              <th>Counseller Name</th>
                              <th>Student Contact No.</th>
                              <th>Important Remarks</th>
                              <?php if ($_SESSION['level_id']==1 || $_SESSION['level_id']==5 || $_SESSION['level_id']==6){?>
                              <th>Resume</th>
                              <th>Address Proof</th>
                              <?php }
                              if($_SESSION['level_id']==1 || $_SESSION['level_id']==6){?>
                              <th>Counsellor Approval</th>
                              <th>Upload Document</th>
                              <?php }?>
                            </tr>
                          </thead>
                          <tfoot>
                            <tr>
                              <th>SNo.</th>
                              <th>Timestamp</th>
                              <th>IBT Student Code</th>
                              <th>Request Slip No.</th>
                              <th>Student Name</th>
                              <th>Father Name</th>
                              <th>Company Name</th>
                              <th>Designation</th>
                              <th>Start Date</th>
                              <th>End Date</th>
                              <th>Duration</th>
                              <th>Salary</th>
                              <th>Issued Date</th>
                              <th>Branch Name</th>
                              <th>Counseller Name</th>
                              <th>Student Contact No.</th>
                              <th>Important Remarks</th>
                              <?php if ($_SESSION['level_id']==1 || $_SESSION['level_id']==5 || $_SESSION['level_id']==6){?>
                              <th>Resume</th>
                              <th>Address Proof</th>
                              <?php }
                              if($_SESSION['level_id']==1 || $_SESSION['level_id']==6){?>
                              <th>Counsellor Approval</th>
                              <th>Upload Document</th>
                              <?php }?>
                            </tr>
                          </tfoot>
                          <tbody>
                            <?php
                            $man=1;
                            if($_SESSION['level_id']==1){
                              $sql=$obj->query("select a.*,b.id as did,b.slip_number,b.designation_id,b.start_date,b.end_date,b.time_duration,b.salary,b.issue_date,b.stu_contact_number,b.imp_remarks,b.resume,b.address_proof,b.company_id,c.name as designation from $tbl_student as a RIGHT JOIN $tbl_student_experience AS b ON a.id=b.sutdent_id INNER JOIN $tbl_designation as c ON b.designation_id=c.id where 1=1 and b.status='send_request' $whr",$debug=-1);
                            }else if ($_SESSION['level_id']==5){
                              $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                              $sql=$obj->query("select a.*,b.id as did,b.slip_number,b.designation_id,b.start_date,b.end_date,b.time_duration,b.salary,b.issue_date,b.stu_contact_number,b.imp_remarks,b.resume,b.address_proof,b.company_id,c.name as designation from $tbl_student as a RIGHT JOIN $tbl_student_experience AS b ON a.id=b.sutdent_id INNER JOIN $tbl_designation as c ON b.designation_id=c.id where 1=1 and a.branch_id in ($branch_id) and b.status='send_request' $whr",$debug=-1);
                            }else if ($_SESSION['level_id']==6){
                              $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                              $sql=$obj->query("select a.*,b.id as did,b.slip_number,b.designation_id,b.start_date,b.end_date,b.time_duration,b.salary,b.issue_date,b.stu_contact_number,b.imp_remarks,b.resume,b.address_proof,b.counsellor_status,b.pimg,b.company_id,c.name as designation from $tbl_student as a RIGHT JOIN $tbl_student_experience AS b ON a.id=b.sutdent_id INNER JOIN $tbl_designation as c ON b.designation_id=c.id where 1=1 and a.branch_id in ($branch_id) and b.status='send_request' and b.address_proof=1 $whr",$debug=-1);
                            }
                            $i = $obj->numRows($sql);
                            while($line=$obj->fetchNextObject($sql)){
                              if($line->company_id!=0){
                                if ($_SESSION['level_id']==5){
                                  $disabled3 = "disabled";
                                }
                              }else{
                                $disabled3 = "";
                              }


                                $disabled2='';
                                if ($_SESSION['level_id']==5  && $line->resume==1 ){
                                    $disabled2='disabled';  
                                }

                                if ($_SESSION['level_id']==5  && $line->company_id==0 ){
                                    $disabled2='disabled';  
                                }

                                $disabled='';
                                 if ($_SESSION['level_id']==5  && $line->address_proof==1 && $line->resume==1){
                                    $disabled='disabled';  
                                }else if($_SESSION['level_id']==5  && $line->address_proof==0 && $line->resume==0){
                                  $disabled='disabled';  
                                }else if($_SESSION['level_id']==5  && $line->address_proof==1 && $line->resume==0){
                                   $disabled='';
                                }

                              $disabled4="";
                              if ($_SESSION['level_id']==1){
                                  // $disabled='disabled';
                                  // $disabled1='disabled'; 
                                  // $disabled2='disabled'; 
                                  // $disabled3='disabled'; 
                                  // $disabled4='disabled'; 
                                }



                              $color = "style='color:red'";
                              if($_SESSION['level_id']==5){
                                if($line->company_id!=0 && $line->resume==1 && $line->address_proof==1){
                                  $color = "";
                                }
                              }else if($_SESSION['level_id']==6){
                                if($line->counsellor_status==1 && !empty($line->pimg)){
                                  $color = "";
                                }
                              }

                              ?>
                              <tr <?php echo  $color; ?>>
                                <td><?php echo $man++; ?></td>
                                <td><?php echo date("d M y",strtotime($line->cdate)); ?></td>
                                <td><?php echo $line->student_no ?></td>
                                <td><?php echo $line->slip_number ?></td>
                                <td><?php echo $line->stu_name ?></td>
                                <td>
                                  <?php 
                                    $rSql = $obj->query("select name from $tbl_student_relation where sutdent_id='".$line->id."' and relation=1");
                                    $rResult = $obj->fetchNextObject($rSql);
                                    echo $rResult->name;
                                    ?>
                                </td>
                                 <td>
                                  <select name="company_id" id="company_id<?php echo $line->did ?>" onchange="ChangeInstituteData(this.value,<?php echo $line->did ?>,'company')" <?php echo $disabled3; ?>>
                                    <option value="">Select Institute Name</option>
                                  <?php
                                  $isql = $obj->query("select * from $tbl_company where status=1");
                                  while($iResult = $obj->fetchNextObject($isql)){?>
                                    <option value="<?php echo $iResult->id; ?>" <?php if($line->company_id==$iResult->id){?> selected <?php } ?>><?php echo $iResult->name; ?></option>
                                  <?php }?>
                                  </select>
                                </td>      
                                <td><?php echo $line->designation ?></td>
                                <td><?php echo $line->start_date ?></td>
                                <td><?php echo $line->end_date ?></td>
                                <td><?php echo $line->time_duration ?></td>
                                <td><?php echo $line->salary ?></td>
                                <td><?php echo $line->issue_date ?></td>
                                <td>
                                  <?php echo getField('name',$tbl_branch,getField('branch_id',$tbl_admin,$line->c_id)) ?></td>
                                <td><?php echo getField('name',$tbl_admin,$line->c_id) ?></td>
                                <td><?php echo $line->stu_contact_number ?></td>
                                <td><?php echo $line->imp_remarks ?></td>
                                <?php if ($_SESSION['level_id']==1 || $_SESSION['level_id']==5 || $_SESSION['level_id']==6){?>
                                <td>
                                  <select name="resume" id="resume<?php echo $line->did ?>" onchange="ChangeStudentData(this.value,<?php echo $line->did ?>,'resume')" <?php echo $disabled2; ?>>
                                    <option value="0" <?php if($line->resume==0){?> selected <?php } ?>>Pending</option>
                                    <option value="1" <?php if($line->resume==1){?> selected <?php } ?>>Approved</option>
                                  </select>
                                </td>
                                <td><select name="address_proof" id="address_proof<?php echo $line->did ?>" onchange="ChangeStudentData(this.value,<?php echo $line->did ?>,'address_proof')" <?php echo $disabled; ?>>
                                    <option value="0" <?php if($line->address_proof==0){?> selected <?php } ?>>Pending</option>
                                    <option value="1" <?php if($line->address_proof==1){?> selected <?php } ?>>Approved</option>
                                  </select></td>
                                  <?php }
                                  if($_SESSION['level_id']==1 || $_SESSION['level_id']==6){?>
                                    <td>
                                    <select name="counsellor_status" id="counsellor_status<?php echo $line->did ?>" onchange="ChangeStudentData(this.value,<?php echo $line->did ?>,'counsellor_status')" <?php echo $disabled4; ?>>
                                      <option value="0" <?php if($line->counsellor_status==0){?> selected <?php } ?>>Pending</option>
                                      <option value="1" <?php if($line->counsellor_status==1){?> selected <?php } ?>>Approved</option>
                                    </select>
                                    </td>
                                    <td>
                                      <?php
                                    if($disabled4!='disabled'){?>
                                      <a href="" target="_blank" title="image upload" data-toggle="modal" data-target="#imgupload" onclick="userimgupload(<?php echo $line->did ?>,'add')">
                                    <?php }?>
                                      
                                        <img src="img/upload.png" style="width: 30px; height: 30px; cursor: pointer;">
                                        </a>
                                         <?php
                                        if(!empty($line->pimg)){?>
                                         <img src="uploads/<?php echo $line->pimg; ?>" style="width: 30px; height: 30px; cursor: pointer;">
                                          <?php } ?>
                                      
                                    </td>
                                   <?php }?>
                                </tr>
                                <?php } ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
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
          </div>
        </div>
      </div>

<!-- image upload modal -->
<div class="modal fade" id="imgupload" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <form name="uploadfrm" id="uploadfrm" method="POST" enctype="multipart/form-data" action="">
         <input type="hidden" name="did" id="did" value="" />
         <input type="hidden" name="action" id="action" value="" />
          <div class="d-flex justify-content-between align-items-center">
          <h4 style="font-size:18px;">Image Upload</h4>
          
        </div>
        <div class="row">
        <div class="col-md-6">
        <input type="file" name="photo" class="fileexperience form-control">
        </div>
        <div class="col-md-6">
          <button type="submit" id="uploadbtn" class="btn btn-success">Save</button>
        </div>
      </div>
      </div>
    </form>
      </div>
    </div>
  </div>
</div>
<!-- end modal -->

      <?php include("footer.php"); ?>
      <script src="js/change-status.js"></script> 
      <script src="js/select2.full.min.js"></script>
      <script type="text/javascript">
        $(".select2").select2({
        placeholder: "Select Branch",
        allowClear: true
        });

        function ChangeInstituteData(fval,id,type){           
            $.ajax({
              type: "POST",
              url: "ajax/update-data.php",
              data:'id='+id+'&fval='+fval+'&type='+type,
              success: function(data){                  
                  $("#resume"+id).removeAttr("disabled");
                  $("#company_id"+id).attr("disabled","disabled");
              }
            });
          }
          
        function ChangeStudentData(fval,id,type){           
            $.ajax({
              type: "POST",
              url: "ajax/update-student-data.php",
              data:'id='+id+'&fval='+fval+'&type='+type+'&stype=2',
              success: function(data){
                  if(type=='resume' && fval==1){
                    $("#resume"+id).attr("disabled","disabled");
                    $("#address_proof"+id).removeAttr("disabled");
                  }else if(type=='resume' && fval==0){
                    location.reload();
                  }
                  if(type=='address_proof' && fval==1){
                    $("#address_proof"+id).attr("disabled","disabled");
                  }
              }
            });
          }
          
        function userimgupload(did,act){
          $("#action").val(act);
          $("#did").val(did);
        }


        $("#uploadfrm").on('submit', function(e){
          e.preventDefault();
          var file_data = $('.fileexperience').prop('files')[0];
          var did = $("#did").val();
          var action = $("#action").val();
              if(file_data != undefined) {
                  var form_data = new FormData();                  
                  form_data.append('file', file_data);
                  form_data.append('did', did);
                  form_data.append('action', action);
                  form_data.append('ttype', 2);
                  //alert(form_data); return;
                  $.ajax({
                      type: 'POST',
                      url: 'ajax/getFileUpload.php',
                      contentType: false,
                      processData: false,
                      data: form_data,
                      success:function(response) {
                        //console.log(response); return;
                          if(response==1){
                            $("#imgupload").modal('toggle');
                          }
                          $('.fileexperience').val('');
                          alert("Document Sucessfully Uploaded");
                          location.reload();
                      }
                  });
              }
            return false;
        });

        $("#filter_branch_id").change(function(){
          $("#searchfrm").submit();
        })
        $("#filter_company_id").change(function(){
          $("#searchfrm").submit();
        })
        $("#filter_stages_id").change(function(){
          $("#searchfrm").submit();
        })


      </script>
    </body>

    </html>