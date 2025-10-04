<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$addtional_role = explode(',',$_SESSION['additional_role']);
if($_SESSION['level_id'] == 14){
    ms_redirect('visit-list.php');
}
if($_SESSION['level_id'] == 13){
    ms_redirect('pending-enrollment.php');
}
$yesterday = date('d-M-Y', strtotime("-1 day"));
$today = date('d-M-Y');
$tomorrow = date('d-M-Y', strtotime("+1 day"));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <style>
    .Tomorrow-box {}

    .canvasjs-chart-credit {
        display: none !important;
    }

    .canvasjs-chart-toolbar {
        display: none !important;
    }

    .canvasjs-chart-canvas {
        border-radius: 5px !important;
    }

    .btn_date {
        height: 50px;
        border-radius: 50px 30px !important;
        color: black !important;
        /* border: 1px solid #ccc; */
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px !important;
        background: white;
    }

    .btn_date:hover {
        color: black !important;
        box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px !important;
    }

    .active_btn_date {
        background: #4e9de6 !important;
        color: white !important;
    }


    .btn-container {
        display: flex;
        justify-content: center !important;
        align-items: center !important;
        flex-wrap: wrap !important;
        gap: 20px !important;
        margin-top: 50px !important;
    }

    /* Buttons styling */
    .btn-primary {
        border-radius: 50px !important;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
        /* padding: 12px 25px !important; */
        /* Size bada */
        margin-bottom: 10px !important;
        text-align: center !important;
        transition: all 0.3s ease-in-out;
        position: relative;
        overflow: hidden;
        /* font-size: 18px !important; */
        /* Font bada */
        font-weight: 600;
        /* Bold text */
    }

    /* Hover effect */
    .btn-primary:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 22px rgba(0, 0, 0, 0.15);
    }

    .btn-primary:hover:before {
        width: 160px;
        height: 160px;
        top: -70px;
        right: -70px;
    }

    @media only screen and (max-width: 768px) {
        .show_button {
            display: block !important;

        }
    }

    .card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
        padding: 5px;
        margin-bottom: 10px;
        text-align: center;
        transition: all 0.3s ease-in-out;
        position: relative;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 22px rgba(0, 0, 0, 0.15);
    }

    .card:hover:before {
        width: 160px;
        height: 160px;
        top: -70px;
        right: -70px;
    }

    .card .icon {
        font-size: 40px;
        color: #4e9de6;
        /* Google Sheets green */
        margin-bottom: 15px;
    }

    .card h4 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 5px;
        color: #333;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .card a {
        display: inline-block;
        text-decoration: underline;
        border-radius: 25px;
        transition: background 0.3s;
    }

    .card a:hover {
        color: blue;
    }

    @media only screen and (max-width: 768px) {
        .welcome_sheet {
            width: 100%;
            margin: 0 10px;
        }
    }
    </style>
    <?php include('head.php'); ?>
</head>

<body>
    <!-- Preloader -->
    <div class="preloader-it">
        <div class="la-anim-1"></div>
    </div>
    <!-- /Preloader -->
    <div class="wrapper theme-1-active pimary-color-green">
        <!-- Top Menu Items -->
        <!--  -->
        <?php include("menu.php"); ?>
        <!-- /Top Menu Items -->
        <!-- Main Content -->
        <div class="page-wrapper" style="margin-top: 0;">
            <div class="mt-30">
                <div style="text-align:center;">
                    <h5
                        style="text-align: center;text-decoration: underline; text-transform: none;margin-bottom: 10px;">
                        Important Sheets</h5>
                </div>
                <div class="row btn-container">
                    <?php
                        $get_google_sheet=$obj->query("select * from tbl_google_sheet where 1=1",$debug=-1);
						while($res=$obj->fetchNextObject($get_google_sheet)){
                    ?>
                    <div class="col-sm-2 welcome_sheet">
                        <div class="card">
                            <h4><i class="fa fa-file-excel-o"></i> <?=$res->name?></h4>
                            <a href="<?=$res->url?>" target="_blank">Open Sheet</a>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>

            <div class="container-fluid pt-25">
                <?php
                if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25 || $_SESSION['level_id'] == 2 || $_SESSION['level_id'] == 3 || $_SESSION['level_id'] == 2 || $_SESSION['level_id'] == 9 || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 4 || in_array(4,$addtional_role) || in_array(1,$addtional_role)){
                    ?>
                <!-- <button type="button" class="btn btn-primary" onclick="show_performance()">Today's Performance</button> -->
                <?php } ?>
                <form action="" id="form_submit" method="get" class="">
                    <input type="hidden" name="perfor" id="perform"
                        value="<?=isset($_GET['perfor']) ? $_GET['perfor'] : "Today's"?>">
                    <center>
                        <div class="row show_button" style="display: flex;justify-content: center;">
                            <div class="col-md-2" style="display:none">
                                <div class="form-group">
                                    <input type="text" name="from_date" id="from_date" class="form-control"
                                        style="height: 36px;" value="<?php echo $_GET['from_date']; ?>"
                                        placeholder="From Date" onfocus="(this.type='date')"
                                        onblur="(this.type='text')">
                                </div>
                            </div>
                            <div class="col-md-2" style="display:none">
                                <div class="form-group">
                                    <input type="text" name="to_date" id="to_date" class="form-control"
                                        style="height: 36px;" value="<?php echo $_GET['to_date']; ?>"
                                        placeholder="To Date" onfocus="(this.type='date')" onblur="(this.type='text')">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <button type="button"
                                        class="btn btn_date <?=isset($_GET['from_date']) && $_GET['from_date'] == date('Y-m-d',strtotime($yesterday)) ? 'active_btn_date' : ''?>"
                                        style="height: 50px;"
                                        onclick="change_date('<?=date('Y-m-d',strtotime($yesterday))?>','Yesterday\'s')">Yesterday
                                        (<?=$yesterday?>)</button>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button type="button"
                                        class="btn btn_date <?=isset($_GET['from_date']) ? '' : 'active_btn_date'?> <?=isset($_GET['from_date']) && $_GET['from_date'] == date('Y-m-d',strtotime($today)) ? 'active_btn_date' : ''?>"
                                        style="height: 50px; position: relative;" id="dateButton">
                                        <?=isset($_GET['perfor']) && $_GET['perfor'] != "Yesterday's" && $_GET['perfor'] != "Tomorrow's" ? 'Selected ('.date('d-M-Y',strtotime($_GET['to_date'])) .')' : 'Today ('.$today.')'?>
                                    </button>
                                    <div id="calendar" style="display: none; z-index: 1000;"></div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button type="button"
                                        class="btn btn_date <?=isset($_GET['from_date']) && $_GET['from_date'] == date('Y-m-d',strtotime($tomorrow)) ? 'active_btn_date' : ''?>"
                                        style="height: 50px;"
                                        onclick="change_date('<?=date('Y-m-d',strtotime($tomorrow))?>','Tomorrow\'s')">Tomorrow
                                        (<?=$tomorrow?>)</button>
                                </div>
                            </div>
                        </div>
                    </center>
                </form>
                <div id="get_todays_performance_data"></div>
                <div id="get_todays_expected_data"></div>
                <div class="btn-container">


                    <?php
                if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25 || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 4){
                ?>
                    <button type="button" class="btn btn-primary" onclick="show_graphs_counsellor()">Visit &
                        Enrollment
                        Graphs</button>
                    <?php } ?>
                    <?php
                if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25 || $_SESSION['level_id'] == 11 || $_SESSION['level_id'] == 9 || in_array(4,$addtional_role) || in_array(1,$addtional_role)){
                ?>
                    <button type="button" class="btn btn-primary" onclick="show_graphs_crm()">CRM Graphs</button>
                    <?php } ?>
                    <?php
                if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25 || $_SESSION['level_id'] == 2  || $_SESSION['level_id'] == 3 || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 2 ){
                ?>
                    <button type="button" class="btn btn-primary" onclick="show_graphs_data()">Application
                        Graphs</button>
                    <?php } ?>
                    <?php
                if($_SESSION['level_id'] != 31){
                ?>
                    <button type="button" class="btn btn-primary" onclick="show_counters()">Counters</button>
                    <?php } ?>
                </div>
                <div id="get_graph_data_counsellor"></div>
                <div id="get_graph_data_crm"></div>
                <div id="get_graph_data_data"></div>
                <div id="get_counter_data"></div>
                <!-- Footer -->
                <footer class="footer container-fluid pl-30 pr-30">
                    <div class="row">
                        <div class="col-sm-12">
                            <p>2023 &copy; Powered by IBT India Pvt Ltd</p>
                        </div>

                    </div>
                </footer>
                <!-- /Footer -->

            </div>
            <!-- /Main Content -->

        </div>
        <!-- /#wrapper -->

        <!-- JavaScript -->
        <?php include("footer.php"); ?>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

        <!-- jQuery -->

</body>

<script type="text/javascript">
/*Accordion js*/
$(document).on('show.bs.collapse', '.panel-collapse', function(e) {
    $(this).siblings('.panel-heading').addClass('activestate');
});

$(document).on('hide.bs.collapse', '.panel-collapse', function(e) {
    $(this).siblings('.panel-heading').removeClass('activestate');
});
$(".panel-heading").on("click", function() {
    $(".panel-heading").removeClass("activestate");
});



function getAppRecord(status) {
    $('#searchfrm').append('<input name="status" value="' + status + '" type="hidden"/>');
    $("#searchfrm").submit();
}

function getAppRecord2(status) {
    $('#searchfrm2').append('<input name="statuss1" value="' + status + '" type="hidden"/>');
    $("#searchfrm2").submit();
}

function getAppRecords(status) {
    $('#sent_not_submit').append('<input name="statuss" value="' + status + '" type="hidden"/>');
    $("#sent_not_submit").submit();
}
</script>



<?php
    if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25 || $_SESSION['level_id'] == 2 || $_SESSION['level_id'] == 3  || $_SESSION['level_id'] == 2 || $_SESSION['level_id'] == 9 || $_SESSION['level_id'] == 19 || $_SESSION['level_id'] == 4 || in_array(4,$addtional_role) || in_array(1,$addtional_role)){
?>
<script>
<?php
    if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25 || $_SESSION['level_id'] == 4){
    ?>

function get_todays_expected_data() {
    $("#get_todays_expected_data").html(`
            <div style="text-align:center">
                <h4>Today's Performance Loading...</h4>
                <i class="fas fa-spinner fa-spin" style="font-size:24px;"></i>
            </div>
        `);
    var from_date = "<?=isset($_GET['from_date']) ? $_GET['from_date'] : ''?>";
    var to_date = "<?=isset($_GET['to_date']) ? $_GET['to_date'] : ''?>";
    var perform = $("#perform").val();
    $.ajax({
        method: "post",
        url: "ajax/welcome-data.php",
        data: {
            expected_data: 1,
            from_date: from_date,
            to_date: to_date,
            perform: perform
        },
        success: function(data) {
            $("#get_todays_expected_data").html(data);
        }
    })
}
<?php } ?>

function show_performance() {
    $("#get_todays_performance_data").html(`
            <div style="text-align:center">
                <h5>Today's Performance Loading...</h5>
                <i class="fas fa-spinner fa-spin" style="font-size:24px;"></i>
            </div>
        `);
    var from_date = "<?=isset($_GET['from_date']) ? $_GET['from_date'] : ''?>";
    var to_date = "<?=isset($_GET['to_date']) ? $_GET['to_date'] : ''?>";
    var perform = $("#perform").val();
    $.ajax({
        method: "post",
        url: "ajax/welcome-data.php",
        data: {
            today_performance: 1,
            from_date: from_date,
            to_date: to_date,
            perform: perform
        },
        success: function(data) {
            $("#get_todays_performance_data").html(data);
        }
    })
}

window.onload = function() {
    show_performance();
    <?php
            if($_SESSION['level_id'] == 1 || $_SESSION['level_id'] == 25 || $_SESSION['level_id'] == 4){
            ?>
    get_todays_expected_data();
    <?php } ?>
};
</script>
<?php } ?>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<script>
function show_graphs_counsellor() {
    $("#get_graph_data_counsellor").html(`
            <div style="text-align:center">
                <h5>Graphs Loading...</h5>
                <i class="fas fa-spinner fa-spin" style="font-size:24px;"></i>
            </div>
        `);
    $.ajax({
        method: "post",
        url: "ajax/welcome-data.php",
        data: {
            graph_data: 1,
            show_graphs_counsellor: 1
        },
        success: function(data) {
            $("#get_graph_data_counsellor").html(data);
        }
    })
}

function show_graphs_crm() {
    $("#get_graph_data_crm").html(`
            <div style="text-align:center">
                <h5>Graphs Loading...</h5>
                <i class="fas fa-spinner fa-spin" style="font-size:24px;"></i>
            </div>
        `);
    $.ajax({
        method: "post",
        url: "ajax/welcome-data.php",
        data: {
            graph_data: 1,
            show_graphs_crm: 1
        },
        success: function(data) {
            $("#get_graph_data_crm").html(data);
        }
    })
}

function show_graphs_data() {
    $("#get_graph_data_data").html(`
            <div style="text-align:center">
                <h5>Graphs Loading...</h5>
                <i class="fas fa-spinner fa-spin" style="font-size:24px;"></i>
            </div>
        `);
    $.ajax({
        method: "post",
        url: "ajax/welcome-data.php",
        data: {
            graph_data: 1,
            show_graphs_data: 1
        },
        success: function(data) {
            $("#get_graph_data_data").html(data);
        }
    })
}
</script>
<script>
function show_counters() {
    $("#get_counter_data").html(`
            <div style="text-align:center">
                <h5>Counters Loading...</h5>
                <i class="fas fa-spinner fa-spin" style="font-size:24px;"></i>
            </div>
        `);
    $.ajax({
        method: "post",
        url: "ajax/welcome-data.php",
        data: {
            counter_data: 1
        },
        success: function(data) {
            $("#get_counter_data").html(data);
        }
    })
}
</script>
<script>
function change_date(date, perform) {
    $("#from_date").val(date);
    $("#to_date").val(date);
    $("#perform").val(perform);
    $("#form_submit").submit();
}
</script>
<script>
$(document).ready(function() {
    const today = new Date();

    // Disable yesterday and tomorrow
    function disableSpecificDates(date) {
        const yesterday = new Date(today);
        yesterday.setDate(today.getDate() - 1);

        const tomorrow = new Date(today);
        tomorrow.setDate(today.getDate() + 1);

        if (
            date.toDateString() === yesterday.toDateString() ||
            date.toDateString() === tomorrow.toDateString()
        ) {
            return [false, "", "Date disabled"];
        }
        return [true, "", ""];
    }

    $("#calendar").datepicker({
        dateFormat: "yy-mm-dd",
        beforeShowDay: disableSpecificDates,
        onSelect: function(dateText) {
            $("#calendar").hide();
            const [year, month, day] = dateText.split("-");
            const dateObject = new Date(year, month - 1, day);
            const monthName = dateObject.toLocaleString("default", {
                month: "short"
            });

            const formattedDate = `${day}-${monthName}-${year}`;
            change_date(dateText, formattedDate);
        }
    });

    // Show calendar on button click
    $("#dateButton").click(function(event) {
        const offset = $(this).offset();
        const height = $(this).outerHeight();
        $("#calendar").css({
            top: offset.top + height + 5 + "px",
            left: offset.left + "px"
        }).toggle(); // Toggle visibility
        event.stopPropagation(); // Prevent document click from closing
    });

    // Prevent calendar from closing when clicking inside
    $("#calendar").click(function(event) {
        event.stopPropagation(); // Stop event from reaching document
    });

    // Hide calendar when clicking outside
    $(document).click(function(event) {
        if (!$(event.target).closest("#calendar, #dateButton").length) {
            $("#calendar").hide();
        }
    });
});
</script>

</html>