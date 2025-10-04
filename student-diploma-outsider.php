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
            <h5 class="txt-dark">Manage Student</h5>
          </div>
          <div class="breadcrumb-section col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
              <li><a href="welcome.php">Dashboard</a></li>
              <!-- <li class="active"><span><a href="student-addf.php">Add Student</a></span></li> -->
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
                        <form name="frm" method="post" action="country-del.php" enctype="multipart/form-data">
                          <thead>
                            <tr>
                              <th>SNo.</th>
                              <th>Timestamp</th>
                              <th>IBT Student Code</th>
                              <th>Request Slip No.</th>
                              <th>Registration No.</th>
                              <th>Student Name</th>
                              <th>Father Name</th>
                              <th>Monther Name</th>
                              <th width="100">Date of Birth</th>
                              <th>Course Name</th>
                              <th>Duration</th>
                              <th>Roll No. 1st Year</th>
                              <th>Start Date</th>
                              <th>Roll No. 2nd Year</th>
                              <th>End Date</th>
                              <th>Passport Size Photo</th>
                              <th>Branch Name</th>
                              <th>Counseller Name</th>
                              <th>Student Contact No.</th>
                              <th>10th Passing Year</th>
                              <th>12th Passing Year</th>
                              <th>Important Remarks</th>
                            <?php 
                            if ($_SESSION['level_id']==5 || $_SESSION['level_id']==6){?>
                              <th>Institute Forms</th>
                              <th>Exams</th>
                              <th>Download PDF</th>
                              <th>Student Approval</th>
                            <?php }
                            if($_SESSION['level_id']==6){?>
                              <th>Media & Gap Manager Status</th>
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
                              <th>Registration No.</th>
                              <th>Student Name</th>
                              <th>Father Name</th>
                              <th>Monther Name</th>
                              <th>Date of Birth</th>
                              <th>Course Name</th>
                              <th>Duration</th>
                              <th>Roll No. 1st Year</th>
                              <th>Start Date</th>
                              <th>Roll No. 2nd Year</th>
                              <th>End Date</th>
                              <th>Passport Size Photo</th>
                              <th>Branch Name</th>
                              <th>Counseller Name</th>
                              <th>Student Contact No.</th>
                              <th>10th Passing Year</th>
                              <th>12th Passing Year</th>
                              <th>Important Remarks</th>
                            <?php if ($_SESSION['level_id']==5 || $_SESSION['level_id']==6){?>
                              <th>Institute Forms</th>
                              <th>Exams</th>
                              <th>Download PDF</th>
                              <th>Student Approval11 <?php echo $_SESSION['level_id']; ?></th>
                            <?php }
                            if($_SESSION['level_id']==6){?>
                              <th>Media & Gap Manager Status</th>
                              <th>Upload Document</th>
                            <?php }?>
                            </tr>
                          </tfoot>
                          <tbody >
                           <?php
                           $man=0; 
                           if ($_SESSION['level_id']==5){
                              $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                              $sql=$obj->query("select a.*,b.id as did,b.diploma_id,b.slip_number,b.institute_id,b.time_duration,b.mother_name,b.start_date,b.end_date,b.stu_contact_number,b.photo,b.institute_forms_status,b.exam_status,b.student_approval_status,b.registration_no,b.roll_no_1,b.roll_no_2,b.imp_remarks,c.name as diploma_name from $tbl_student as a RIGHT JOIN $tbl_student_diploma AS b ON a.id=b.sutdent_id INNER JOIN $tbl_diploma as c ON b.diploma_id=c.id where 1=1 and a.branch_id in ($branch_id) and b.status='send_request' and c.diploma_type='Outsider'",$debug=-1);
                            }else if ($_SESSION['level_id']==6){
                              $branch_id = getField('branch_id',$tbl_admin,$_SESSION['sess_admin_id']);
                              $sql=$obj->query("select a.*,b.id as did,b.diploma_id,b.slip_number,b.diploma_id,b.time_duration,b.mother_name,b.start_date,b.end_date,b.stu_contact_number,b.photo,b.institute_forms_status,b.exam_status,b.student_approval_status,b.registration_no,b.roll_no_1,b.roll_no_2,b.media_gap_status,b.pimg,b.imp_remarks,c.name as diploma_name from $tbl_student as a RIGHT JOIN $tbl_student_diploma AS b ON a.id=b.sutdent_id INNER JOIN $tbl_diploma as c ON b.diploma_id=c.id where 1=1 and a.branch_id in ($branch_id) and b.status='send_request' and c.diploma_type='Outsider' and b.student_approval_status=1",$debug=-1);
                            }
                            $i = $obj->numRows($sql);
                            while($line=$obj->fetchNextObject($sql)){?>
                              <tr>
                                <td><?php echo  $man++; ?></td>
                                <td><?php echo date("d M y",strtotime($line->cdate)); ?></td>
                                <td><?php echo $line->student_no ?></td>
                                <td><?php echo $line->slip_number ?></td>
                                <td><?php echo $line->registration_no ?></td>
                                <td><?php echo $line->stu_name ?></td>
                                <td><?php echo $line->father_name ?></td>
                                <td><?php echo $line->mother_name ?></td>
                                <td><?php echo $line->dob ?></td>
                                <td><?php echo $line->diploma_name ?></td>
                                <td><?php echo $line->time_duration ?></td>
                                <td><?php echo $line->roll_no_1 ?></td>
                                <td><?php echo $line->start_date ?></td>
                                <td><?php echo $line->roll_no_2 ?></td>
                                <td><?php echo $line->end_date ?></td>
                                <td>
                                  <a href="uploads/<?php echo $line->photo ?>" download>
                                  <img src="uploads/<?php echo $line->photo ?>" style="width: 50px; height: 50px;">
                                  </a>
                                </td>
                                 <td><?php echo getField('name',$tbl_branch,getField('branch_id',$tbl_admin,$line->c_id)) ?></td>
                               <td><?php echo getField('name',$tbl_admin,$line->c_id) ?></td>
                                <td><?php echo $line->stu_contact_number ?></td>
                                <td><?php echo $line->ten_qualification ?></td>
                                <td><?php echo $line->twl_qualification ?></td>
                                <td><?php echo $line->imp_remarks ?></td>

                                <?php 
                                $disabled='';
                                if ($_SESSION['level_id']==5){
                                  $disabled='disabled';                                  
                                }

                                if($line->institute_forms_status==0){
                                  $disabled1=''; 
                                }else{
                                  $disabled1='disabled'; 
                                }

                                if($_SESSION['level_id']==6){
                                  $disabled='';
                                  $disabled1=''; 
                                }

                                $disabled2='';
                                if($line->institute_forms_status==1 && $line->exam_status==1){
                                  if($line->student_approval_status==0){
                                    $disabled2=''; 
                                  }else{
                                    $disabled2='disabled'; 
                                  }
                                  
                                }else{
                                  $disabled2='disabled'; 
                                }

                                if ($_SESSION['level_id']==5 || $_SESSION['level_id']==6){?>
                                <td>
                                  <select name="institute_forms_status" id="institute_forms_status<?php echo $line->did ?>" onchange="ChangeStudentData(this.value,<?php echo $line->did ?>,'institute_forms_status')" <?php echo $disabled1; ?>>
                                    <option value="0" <?php if($line->institute_forms_status==0){?> selected <?php } ?>>Pending</option>
                                    <option value="1" <?php if($line->institute_forms_status==1){?> selected <?php } ?>>Approved</option>
                                  </select>
                                </td>
                                <td><select name="exam_status" id="exam_status<?php echo $line->did ?>" onchange="ChangeStudentData(this.value,<?php echo $line->did ?>,'exam_status')" <?php echo $disabled; ?>>
                                    <option value="0" <?php if($line->exam_status==0){?> selected <?php } ?>>Pending</option>
                                    <option value="1" <?php if($line->exam_status==1){?> selected <?php } ?>>Approved</option>
                                  </select></td>
                                  <td>
                                    <a href="downloadpdf.php?did=<?php echo $line->did ?>"><img src="img/pdf.png" style="width: 30px; height: 30px; cursor: pointer;"></a>
                                  </td>
                                <td><select name="student_approval_status" id="student_approval_status<?php echo $line->did ?>" onchange="ChangeStudentData(this.value,<?php echo $line->did ?>,'student_approval_status')" <?php echo $disabled2; ?>>
                                    <option value="0" <?php if($line->student_approval_status==0){?> selected <?php } ?>>Pending</option>
                                    <option value="1" <?php if($line->student_approval_status==1){?> selected <?php } ?>>Approved</option>
                                  </select></td>
                                  <?php }
                                  if($_SESSION['level_id']==6){?>
                                     <td><select name="media_gap_status" id="media_gap_status<?php echo $line->did ?>" onchange="ChangeStudentData(this.value,<?php echo $line->did ?>,'media_gap_status')">
                                    <option value="0" <?php if($line->media_gap_status==0){?> selected <?php } ?>>Pending</option>
                                    <option value="1" <?php if($line->media_gap_status==1){?> selected <?php } ?>>Approved</option>
                                  </select></td>
                                  <td>
                                     <a href="" target="_blank" title="image upload" data-toggle="modal" data-target="#imgupload" onclick="userimgupload(<?php echo $line->did ?>,'add')">
                                    <img src="img/upload.png" style="width: 30px; height: 30px; cursor: pointer;">
                                     <img src="uploads/<?php echo $line->pimg; ?>" style="width: 30px; height: 30px; cursor: pointer;">
                                  </a>
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

<div class="modal fade" id="imgupload" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <form name="uploadfrm" id="uploadfrm" method="POST" enctype="multipart/form-data" action="">
         <input type="hidden" name="did" id="did" value="" />
         <input type="hidden" name="action" id="action" value="" />
          <div class="d-flex justify-content-between align-items-center">
          <h4 style="font-size:18px;">Image Upload</h4>
          <button type="submit" id="uploadbtn" class="btn btn-success">Save</button>
        </div>
        <div class="mt-3 pb-2">
        <input type="file" name="photo" class="file form-control">
      </div>
    </form>
      </div>
    </div>
  </div>
</div>
      <?php include("footer.php"); ?>
      <script src="js/change-status.js"></script> 
      <script type="text/javascript">
        function ChangeStudentData(fval,id,type){           
            $.ajax({
              type: "POST",
              url: "ajax/update-student-data.php",
              data:'id='+id+'&fval='+fval+'&type='+type+'&stype=1',
              success: function(data){
                  if(type=='institute_forms_status' && fval==1){
                    $("#institute_forms_status"+id).attr("disabled","disabled");
                    $("#exam_status"+id).removeAttr("disabled");
                  }
                  if(type=='exam_status' && fval==1){
                    $("#exam_status"+id).attr("disabled","disabled");
                    $("#student_approval_status"+id).removeAttr("disabled");
                  }
                  if(type=='student_approval_status' && fval==1){
                    $("#student_approval_status"+id).attr("disabled","disabled");
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
          var file_data = $('.file').prop('files')[0];
          var did = $("#did").val();
          var action = $("#action").val();
              if(file_data != undefined) {
                  var form_data = new FormData();                  
                  form_data.append('file', file_data);
                  form_data.append('did', did);
                  form_data.append('action', action);
                  form_data.append('ttype', 1);
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
                          $('.file').val('');
                          location.reload();
                      }
                  });
              }
            return false;
        });

      </script>
    </body>

    </html>