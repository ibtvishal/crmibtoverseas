<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
$fields = [
    'ihs_inr' => 'IHS (Insurance)',
    'embassy_inr' => 'Embassy Fees',
    'medical_inr' => 'Medical Fees',
    'biomatric_inr' => 'Biomatric',
    'cas_interest_inr' => 'CAS Interest',
    'ihs_interest_inr' => 'IHS Interest',
    'funds_interest_inr' => 'Funds Interest',
    'cas_risk_inr' => 'CAS Deposit Risk',
    'profit_inr' => 'Profit',
];
$program = ["UG", "PG"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php'); ?>
    <!-- Bootstrap CSS -->
    <style>
        /* .table > tbody > tr > td{
            padding: 5px;
        } */
    .calculator-table th {
        /* background: #ffe600; */
        color: #333;
        text-align: center;
    }

    .calculator-table td {
        vertical-align: middle;
    }

    .table-section {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border-radius: 8px;
        background: #fff;
        padding: 24px;
        margin-bottom: 32px;
    }

    .table-title {
        font-weight: bold;
        font-size: 1.2rem;
        color: #2a911d;
        /* margin-bottom: 16px; */
    }

    .total-row {
        background: #e6ffe6;
        font-weight: bold;
    }
    td{
        padding: 5px !important;
    }
    </style>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
</head>

<body>
    <!--Preloader-->
    <div class="preloader-it">
        <div class="la-anim-1"></div>
    </div>
    <!--/Preloader-->
    <div class="wrapper theme-1-active pimary-color-green">
        <?php include("menu.php"); ?>

        <!-- Main Content -->
        <div class="page-wrapper">
            <div class="container-fluid">
                <!-- Title -->
                <div class="row heading-bg">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <h5 class="txt-dark">UK Package Calculator</h5>
                    </div>
                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-1+2 text-center">
                        <h5 style="color:#2a911d;" id="sess_msg">
                            <?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
                        <h5 style="color:red;">
                            <?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
                    </div>
                    <div class="breadcrumb-section col-lg-4 col-sm-8 col-md-8 col-xs-12">
                        <ol class=" breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                        </ol>
                    </div>
                </div>
                <!-- /Title -->

                <div class="row">
                    <?php
                    foreach ($program as $prog) {
                    ?>
                    <div class="col-md-6">
                        <div class="table-section">
                            <div class="table-title">Package Calculator (<?=$prog?>)</div>
                            <table class="table calculator-table">
                                <thead>
                                    <tr>
                                        <th style="width: 250px;">Item</th>
                                        <th>GBP</th>
                                        <th>Rate</th>
                                        <th>Amount (INR)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>CAS Deposit</td>
                                        <td><input type="number" class="form-control" value="1" id="cas_gbp<?=$prog?>"
                                                onkeyup="getCalculate('<?=$prog?>')"></td>
                                        <?php
                                        $get2 = $obj->query("SELECT * FROM tbl_package where country_id='6' and program_type='$prog' and `key`='rate'");
                                         if ($obj->numRows($get2) > 0) {
                                            $res2 = $obj->fetchNextObject($get2);
                                            $value12 = $res2->value;
                                        } else {
                                            $value12 = 0;
                                        }
                                        ?>
                                        <td>
                                            <input type="number" class="form-control" value="<?= $value12 ?>"
                                                id="cas_rate<?= $prog ?>"
                                                onchange="update_value(this.value, 'rate', '<?= $prog ?>')"
                                                <?= $_SESSION['level_id'] == 1 ? "onkeyup=\"getCalculate('$prog')\"" : 'disabled' ?>>
                                        </td>
                                        <td><input type="number" class="form-control" readonly id="cas_inr<?= $prog ?>"></td>
                                    </tr>
                                    <?php foreach ($fields as $key => $field) {
                                        $get = $obj->query("SELECT * FROM tbl_package where country_id='6' and program_type='$prog' and `key`='$key'");
                                        if ($obj->numRows($get) > 0) {
                                            $res = $obj->fetchNextObject($get);
                                            $value = $res->value;
                                        } else {
                                            $value = 0;
                                        }
                                    ?>
                                    <tr>
                                        <td><?php echo $field; ?></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <input type="number" class="form-control get_all_amount<?=$prog?>"
                                                value="<?php echo $value; ?>" id="<?php echo $key; ?>"
                                                onchange="update_value(this.value, '<?=$key?>', '<?=$prog?>')"
                                                <?=$_SESSION['level_id'] == 1 ? "onkeyup=\"getCalculate('$prog')\"" : 'disabled'?>>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    <tr class="total-row">
                                        <td colspan="3">Total</td>
                                        <td><input type="number" class="form-control" value="" id="total_inr<?=$prog?>"
                                                readonly></td>
                                    </tr>
                                    <?php
                                        $get1 = $obj->query("SELECT * FROM tbl_package where country_id='6' and program_type='$prog' and `key`='moi_inr'");
                                         if ($obj->numRows($get1) > 0) {
                                            $res1 = $obj->fetchNextObject($get1);
                                            $value1 = $res1->value;
                                        } else {
                                            $value1 = 0;
                                        }
                                        ?>
                                    <tr>
                                        <td>In case of MOI - Extra Charges</td>
                                        <td></td>
                                        <td></td>
                                        <td><input type="number" class="form-control" value="<?=$value1?>"
                                                id="moi_inr<?=$prog?>"
                                                onchange="update_value(this.value, 'moi_inr', '<?=$prog?>')"
                                                <?=$_SESSION['level_id'] == 1 ? "onkeyup=\"getCalculate('$prog')\"" : 'disabled'?>></td>
                                    </tr>
                                    <tr class="total-row">
                                        <td colspan="3">Grand Total</td>
                                        <td><input type="number" class="form-control" value=""
                                                id="grand_total_inr<?=$prog?>" readonly></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php } ?>
                </div>

                <footer class="footer container-fluid pl-30 pr-30">
                    <div class="row">
                        <div class="col-sm-12">
                            <p>2023 &copy; Powered by IBT India Pvt Ltd</p>
                        </div>
                    </div>
                </footer>
                <!-- /Footer -->

            </div>
        </div>
        <!-- /Main Content -->

    </div>
    <!-- /#wrapper -->

    <?php include("footer.php"); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
    function update_value(value, field, prog) {
        $.ajax({
            type: "POST",
            url: 'controller.php',
            data: {
                update_prog_value: value,
                field: field,
                prog: prog,
                country_id: 6
            },
            beforeSend: function() {},
            success: function(response) {
                toastr.success('Updated Successfully!');
            }
        });
    }
    </script>
    <script>
    function getCalculate(prog) {
        let gbp = $("#cas_gbp" + prog).val();
        let rate = $("#cas_rate" + prog).val();
        let cas_inr = parseFloat(gbp) * parseFloat(rate);
        $("#cas_inr" + prog).val(isNaN(cas_inr) ? 0 : cas_inr);

        $("#cas_inr" + prog).addClass("get_all_amount"+prog);
        let total = 0;
        $(".get_all_amount"+prog).each(function() {
            let val = parseFloat($(this).val());
            if (!isNaN(val)) {
                total += val;
            }
        });
        $("#total_inr"+prog).val(total);
        moi_inr = $("#moi_inr"+prog).val();
        grand_total = total + parseFloat(moi_inr);
        $("#grand_total_inr"+prog).val(isNaN(grand_total) ? 0 : grand_total);
    }
    </script>
    <script>
        $(document).ready(function() {
            <?php foreach ($program as $prog) { ?>
                getCalculate('<?=$prog?>');
            <?php } ?>
        });
    </script>
</body>

</html>