<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
$_SESSION['reload']="1";
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

#datable_1_filter label {
    display: none;
}

div#datable_1_length label {
    display: none;
}

th.sorting_asc {
    display: none;
}

div#datable_1_info {
    display: none;
}

table.dataTable.display tbody td {
    border-top: none;
}

.static-fix {
    height: 500px;
    overflow-y: auto;
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
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h5 class="txt-dark">Manage Search Courses</h5>
                    </div>

                </div>

                <div class="row">
                    <div class="search-programm-side col-sm-3">
                        <!-- <h5>Search Courses</h5> -->
                        <div class="programmes search">
                            <form class="prgrm_search-form">
                                <div
                                    style="display: flex; align-items: center; border: 1.5px solid #aaaaaa; border-radius: 5px; background: #fff; height: 45px; padding: 0 10px; width:360px">
                                    <i class="fas fa-search" style="color: #888;"></i>
                                    <input type="text" name="global_search" id="global_search" class="form-control"
                                        placeholder="Type Course Name Here"
                                        style="border: none; outline: none; margin-left: 10px; height: 100%; flex: 1; background: transparent;">
                                </div>
                                <div class="static-fix">
                                    <select class="form-select select2" name="country" id="country">
                                        <option selected value="">Select Country</option>
                                        <?php
										$sql=$obj->query("select * from $tbl_country where status=1 order by displayorder",$debug=-1);
										while($line=$obj->fetchNextObject($sql)){?>
                                        <option value="<?php echo $line->id ?>"
                                            <?php if($result->country_id==$line->id){?>selected<?php } ?>>
                                            <?php echo $line->name ?></option>
                                        <?php } ?>
                                    </select>
                                    <select class="form-select select2" name="state" id="state_id">
                                        <option selected value="">Select State</option>
                                        <?php
										$ssql=$obj->query("select * from $tbl_state where status=1",$debug=-1);
										while($sline=$obj->fetchNextObject($ssql)){?>
                                        <option value="<?php echo $sline->id ?>"
                                            <?php if($result->state==$sline->id){?>selected<?php } ?>>
                                            <?php echo $sline->state ?></option>
                                        <?php } ?>
                                    </select>
                                    <select class="form-select select2" name="univercity" id="univercity">
                                        <option selected value="">--Select University--</option>
                                        <?php
									$usql=$obj->query("select * from $tbl_univercity where status=1",$debug=-1);
									while($uline=$obj->fetchNextObject($usql)){?>
                                        <option value="<?php echo $uline->id ?>"
                                            <?php if($result->univercity==$uline->id){?>selected<?php } ?>>
                                            <?php echo $uline->name ?></option>
                                        <?php } ?>
                                    </select>
                                    <select class="form-control select2" name="programme_lavel" id="programme_level">
                                        <option selected value="">Select Programme Level</option>
                                        <?php
									$i=1;
									$sql=$obj->query("select * from $tbl_programmes where status=1 GROUP BY program_level",$debug=-1);
									while($line=$obj->fetchNextObject($sql)){?>
                                        <option value="<?php echo $line->program_level ?>">
                                            <?php echo $line->program_level ?></option>
                                        <?php } ?>
                                    </select>
                                    <select class="form-control select2" name="stream" id="stream">
                                        <option selected value="">Select Stream</option>
                                        <?php
									$sql=$obj->query("select stream from $tbl_programmes where status=1 GROUP BY stream",$debug=-1);
									while($line=$obj->fetchNextObject($sql)){
										$streamArr = explode(",",$line->stream);
										foreach($streamArr as $aval){
											$streamarr[] = trim($obj->escapestring($aval));
										}
									} 									

									$streamarr = array_unique($streamarr);
									if(count($streamarr)>1){
										foreach($streamarr as $sint){?>
                                        <option value="<?php echo $sint ?>"><?php echo $sint ?></option>
                                        <?php } ?>
                                        <?php }	?>
                                    </select>
                                    <select class="form-select new_select select2" aria-label="Default select example"
                                        name="percentage" id="percentage">
                                        <option selected value="">Percentage</option>
                                        <option value="41-50">41-50</option>
                                        <option value="51-60">51-60</option>
                                        <option value="61-70">61-70</option>
                                        <option value="71-100">Above 70</option>
                                        <!-- <?php
										$i=1;
										$sql=$obj->query("select * from $tbl_programmes where status=1 GROUP BY percentage",$debug=-1);
										while($line=$obj->fetchNextObject($sql)){?>
											<option value="<?php echo $line->percentage ?>"><?php echo $line->percentage ?></option>
										<?php } ?> -->
                                    </select>
                                    <select class="form-select new_select select2" aria-label="Default select example"
                                        name="multipalData" id="multipalData">
                                        <option selected>Language Proficiency</option>
                                        <option value="1">IELTS</option>
                                        <option value="2">PTE</option>
                                        <option value="3">Duolingo</option>
                                        <option value="4">TOEFL </option>
                                        <option value="5">MOI</option>
                                    </select>
                                    <select class="form-select new_select select2" aria-label="Default select example"
                                        name="intake" id="intake">
                                        <option selected value="">Intake</option>
                                        <?php
										$i=1;
										$sql=$obj->query("select * from $tbl_programmes where status=1 GROUP BY intake",$debug=-1);
										while($line=$obj->fetchNextObject($sql)){
											$intakeArr = explode(",",$line->intake);
											foreach($intakeArr as $aval){
												$intarr[] = trim($obj->escapestring($aval));
											}
										} ?>
                                        <?php
									$intarr = array_unique($intarr);
									if(count($intarr)>1){
										foreach($intarr as $vint){?>
                                        <option value="<?php echo $vint; ?>"><?php echo $vint; ?></option>
                                        <?php }?>
                                        <?php }?>

                                    </select>
                                    <select class="form-select new_select select2" aria-label="Default select example"
                                        name="student_bachelor" id="student_bachelor">
                                        <option selected value="">Bachelor’s Duration</option>
                                        <?php
										$i=1;
										$sql=$obj->query("select * from $tbl_programmes where status=1 GROUP BY student_bachelors",$debug=-1);
										while($line=$obj->fetchNextObject($sql)){?>
                                        <option value="<?php echo $line->student_bachelors ?>">
                                            <?php echo $line->student_bachelors ?></option>
                                        <?php } ?>
                                    </select>
                                    <select class="form-select select2" aria-label="Default select example"
                                        name="course_type" id="course_type">
                                        <option selected value="">Course Type</option>
                                        <option value="STEM">STEM</option>
                                        <option value="NON STEM">NON STEM</option>
                                    </select>
                                </div>
                                <button type="button" class="btn btn-success mt-20" onclick="search_button()"
                                    style="width:100%">Search</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <div class="panel panel-default card-view">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body custom-class-perce">

                                    <div class="table-wrap">
                                        <div class="table-responsive">
                                            <table id="datable_3" class="table table-hover display  pb-30"
                                                style="width: 100% !important;">
                                                <form name="frm " method="post" action="programmes-del.php"
                                                    enctype="multipart/form-data">
                                                    <thead>
                                                        <tr>
                                                            <th></th>

                                                        </tr>
                                                    </thead>

                                                    <tbody id="programmeData">

                                                    </tbody>
                                                </form>
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
    <script src="vendors/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="dist/js/jquery.slimscroll.js"></script>
    <script src="dist/js/dropdown-bootstrap-extended.js"></script>
    <script src="vendors/bower_components/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="vendors/bower_components/switchery/dist/switchery.min.js"></script>
    <script src="dist/js/init.js"></script>
    <script src="vendors/bower_components/simpleWeather/jquery.simpleWeather.min.js"></script>
    <script src="vendors/bower_components/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="vendors/bower_components/jquery.counterup/jquery.counterup.min.js"></script>
    <script src="vendors/jquery.sparkline/dist/jquery.sparkline.min.js"></script>
    <script src="vendors/chart.js/Chart.min.js"></script>
    <script src="vendors/bower_components/raphael/raphael.min.js"></script>
    <script src="vendors/bower_components/morris.js/morris.min.js"></script>
    <script src="vendors/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="js/select2.full.min.js"></script>
    <script>
    $(".select2").select2();
    $(document).ready(function() {

        $("#global_search").keypress(function() {
            var global_search = $(this).val();
            var country_id = $("#country").val();
            var state = $('#state_id').val();
            var univercity = $('#univercity').val();
            var programme_level = $('#programme_level').val();
            var stream = $('#stream').val();
            var percentage = $('#percentage').val();
            var intake = $('#intake').val();
            var multipalData = $('#multipalData').val();
            var student_bachelor = $('#student_bachelor').val();
            var course_type = $('#course_type').val();
            // fileter(country_id, state, univercity, programme_level, stream, percentage, intake,student_bachelor, multipalData, global_search, course_type);
        })


        $('#country').change(function() {
            var country_id = $(this).val();
            var state = $('#state_id').val();
            var univercity = $('#univercity').val();
            var programme_level = $('#programme_level').val();
            var stream = $('#stream').val();
            var percentage = $('#percentage').val();
            var intake = $('#intake').val();
            var multipalData = $('#multipalData').val();
            var student_bachelor = $('#student_bachelor').val();
            var global_search = $('#global_search').val();
            var course_type = $('#course_type').val();
            if (country_id == 6) {
                $("#course_type").hide();
            } else {
                $("#course_type").show();
            }
            // fileter(country_id, state, univercity, programme_level, stream, percentage, intake,student_bachelor, multipalData, global_search, course_type);
            $.ajax({
                type: "GET",
                url: 'ajax/getModalData.php',
                data: {
                    country_id: country_id,
                    type: 'getSearchstatedrop'
                },
                success: function(response) {
                    response = response.split('##');
                    $("#state_id").html(response[0]);
                    $("#percentage").html(response[1]);
                    $("#intake").html(response[2]);
                    $("#student_bachelor").html(response[3]);
                    $("#univercity").html(response[4]);
                }
            });
        })

        $('#state_id').change(function() {
            var state_id = $(this).val();
            var country_id = $('#country').val();
            var univercity = $('#univercity').val();
            var programme_level = $('#programme_level').val();
            var stream = $('#stream').val();
            var percentage = $('#percentage').val();
            var intake = $('#intake').val();
            var student_bachelor = $('#student_bachelor').val();
            var multipalData = $('#multipalData').val();
            var global_search = $('#global_search').val();
            var course_type = $('#course_type').val();
            // fileter(country_id, state_id, univercity, programme_level, stream, percentage, intake,student_bachelor, multipalData, global_search, course_type);
            $.ajax({
                type: "GET",
                url: 'ajax/getModalData.php',
                data: {
                    state_id: state_id,
                    type: 'getunivercitydrop'
                },
                success: function(response) {
                    response = response.split('##');
                    $("#univercity").html(response);
                }
            });
        })
        //     $('#univercity').change(function() {
        //         var univercity = $(this).val();
        //         var country_id = $('#country').val();
        //         var state_id = $('#state_id').val();
        //         var programme_level = $('#programme_level').val();
        //         var stream = $('#stream').val();
        //         var percentage = $('#percentage').val();
        //         var intake = $('#intake').val();
        //         var student_bachelor = $('#student_bachelor').val();
        //         var multipalData = $('#multipalData').val();
        //         var global_search = $('#global_search').val();
        //         var course_type = $('#course_type').val();
        //         fileter(country_id, state_id, univercity, programme_level, stream, percentage, intake,
        //             student_bachelor, multipalData, global_search, course_type);
        //     })
        //     $('#programme_level').change(function() {
        //         var programme_level = $(this).val();
        //         var country_id = $('#country').val();
        //         var state_id = $('#state_id').val();
        //         var univercity = $('#univercity').val();
        //         var stream = $('#stream').val();
        //         var percentage = $('#percentage').val();
        //         var intake = $('#intake').val();
        //         var student_bachelor = $('#student_bachelor').val();
        //         var multipalData = $('#multipalData').val();
        //         var global_search = $('#global_search').val();
        //         var course_type = $('#course_type').val();
        //         fileter(country_id, state_id, univercity, programme_level, stream, percentage, intake,
        //             student_bachelor, multipalData, global_search, course_type);
        //     })
        //     $('#stream').change(function() {
        //         var stream = $(this).val();
        //         var country_id = $('#country').val();
        //         var state_id = $('#state_id').val();
        //         var univercity = $('#univercity').val();
        //         var programme_level = $('#programme_level').val();
        //         var percentage = $('#percentage').val();
        //         var intake = $('#intake').val();
        //         var student_bachelor = $('#student_bachelor').val();
        //         var multipalData = $('#multipalData').val();
        //         var global_search = $('#global_search').val();
        //         var course_type = $('#course_type').val();
        //         fileter(country_id, state_id, univercity, programme_level, stream, percentage, intake,
        //             student_bachelor, multipalData, global_search, course_type);
        //     })
        //     $('#percentage').change(function() {
        //         var percentage = $(this).val();
        //         var country_id = $('#country').val();
        //         var state_id = $('#state_id').val();
        //         var univercity = $('#univercity').val();
        //         var programme_level = $('#programme_level').val();
        //         var stream = $('#stream').val();
        //         var intake = $('#intake').val();
        //         var student_bachelor = $('#student_bachelor').val();
        //         var multipalData = $('#multipalData').val();
        //         var global_search = $('#global_search').val();
        //         var course_type = $('#course_type').val();
        //         fileter(country_id, state_id, univercity, programme_level, stream, percentage, intake,
        //             student_bachelor, multipalData, global_search, course_type);
        //     })
        //     $('#intake').change(function() {
        //         var intake = $(this).val();
        //         var country_id = $('#country').val();
        //         var state_id = $('#state_id').val();
        //         var univercity = $('#univercity').val();
        //         var programme_level = $('#programme_level').val();
        //         var stream = $('#stream').val();
        //         var percentage = $('#percentage').val();
        //         var student_bachelor = $('#student_bachelor').val();
        //         var multipalData = $('#multipalData').val();
        //         var global_search = $('#global_search').val();
        //         var course_type = $('#course_type').val();
        //         fileter(country_id, state_id, univercity, programme_level, stream, percentage, intake,
        //             student_bachelor, multipalData, global_search, course_type);
        //     })
        //     $('#student_bachelor').change(function() {
        //         var student_bachelor = $(this).val();
        //         var country_id = $('#country').val();
        //         var state_id = $('#state_id').val();
        //         var univercity = $('#univercity').val();
        //         var programme_level = $('#programme_level').val();
        //         var stream = $('#stream').val();
        //         var intake = $('#intake').val();
        //         var percentage = $('#percentage').val();
        //         var multipalData = $('#multipalData').val();
        //         var global_search = $('#global_search').val();
        //         var course_type = $('#course_type').val();
        //         fileter(country_id, state_id, univercity, programme_level, stream, percentage, intake,
        //             student_bachelor, multipalData, global_search, course_type);
        //     })

        //     $('#multipalData').change(function() {
        //         var multipalData = $(this).val();
        //         var country_id = $('#country').val();
        //         var state_id = $('#state_id').val();
        //         var univercity = $('#univercity').val();
        //         var programme_level = $('#programme_level').val();
        //         var stream = $('#stream').val();
        //         var intake = $('#intake').val();
        //         var percentage = $('#percentage').val();
        //         var student_bachelor = $('#student_bachelor').val();
        //         var global_search = $('#global_search').val();
        //         var course_type = $('#course_type').val();
        //         fileter(country_id, state_id, univercity, programme_level, stream, percentage, intake,
        //             student_bachelor, multipalData, global_search, course_type);
        //     })

        //     $('#course_type').change(function() {
        //         var course_type = $(this).val();
        //         var multipalData = $('#multipalData').val();
        //         var country_id = $('#country').val();
        //         var state_id = $('#state_id').val();
        //         var univercity = $('#univercity').val();
        //         var programme_level = $('#programme_level').val();
        //         var stream = $('#stream').val();
        //         var intake = $('#intake').val();
        //         var percentage = $('#percentage').val();
        //         var student_bachelor = $('#student_bachelor').val();
        //         var global_search = $('#global_search').val();
        //         fileter(country_id, state_id, univercity, programme_level, stream, percentage, intake,
        //             student_bachelor, multipalData, global_search, course_type);
        //     })
    })

    function search_button() {
        var course_type = $('#course_type').val();
        var multipalData = $('#multipalData').val();
        var country_id = $('#country').val();
        var state_id = $('#state_id').val();
        var univercity = $('#univercity').val();
        var programme_level = $('#programme_level').val();
        var stream = $('#stream').val();
        var intake = $('#intake').val();
        var percentage = $('#percentage').val();
        var student_bachelor = $('#student_bachelor').val();
        var global_search = $('#global_search').val();
        fileter(country_id, state_id, univercity, programme_level, stream, percentage, intake, student_bachelor,
            multipalData, global_search, course_type);
    }

    function fileter(country_id, state_id, univercity, programme_level, stream, percentage, intake, student_bachelor,
        multipalData, global_search, course_type) {
        $("#programmeData").html(`
            <div style="text-align:center">
                <h4>Loading Courses...</h4>
                <i class="fas fa-spinner fa-spin" style="font-size:24px;"></i>
            </div>
        `);
        $.ajax({
            type: "post",
            url: 'ajax/getProgrammelData.php',
            data: {
                country_id: country_id,
                state_id: state_id,
                univercity: univercity,
                programme_level: programme_level,
                stream: stream,
                percentage: percentage,
                intake: intake,
                student_bachelor: student_bachelor,
                multipalData: multipalData,
                global_search: global_search,
                type: 'filter',
                course_type: course_type
            },
            success: function(response) {
                //console.log(response);
                $('#datable_3').DataTable().clear().destroy();
                $("#programmeData").html(response);
            }
        });
    };
    </script>

    <script src="js/change-status.js"></script>


</body>

</html>