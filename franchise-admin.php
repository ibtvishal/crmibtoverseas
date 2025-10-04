<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_admin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php'); ?>
</head>
<style type="text/css">
.select2-search__field {
    width: 100% !important;
}

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
                <div class="row heading-bg">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <h5 class="txt-dark">Franchise Admin</h5>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                        <h5 style="color:#2a911d;"><?php echo $_SESSION['sess_msg']; $_SESSION['sess_msg']='';  ?></h5>
                        <h5 style="color:red;">
                            <?php echo $_SESSION['sess_msg_error']; $_SESSION['sess_msg_error']='';  ?></h5>
                    </div>
                    <div class="breadcrumb-section col-lg-4 col-sm-8 col-md-4 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="welcome.php">Dashboard</a></li>
                            <li class="active"><span><a href="#">Franchise Admin</a></span></li>
                        </ol>
                    </div>
                </div>

                <form action="controller.php" method="post">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <select name="branch_id[]" id="branch_id" class="form-control select2" multiple="">
                                    <?php
                                $branchSql = $obj->query("select * from $tbl_branch where status=1");
                                while($branchResult = $obj->fetchNextObject($branchSql)){?>
                                    <option value="<?php echo $branchResult->id; ?>"
                                        <?=$branchResult->show_franchises == 1 ? 'selected' : ''?>>
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
                    <div class="col-sm-12">
                        <div class="panel panel-default card-view">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <div class="table-wrap">
                                        <div class="table-responsive">
                                            <table id="datable_3" class="table table-hover display  pb-30">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Country</th>
                                                        <th>Visa Type</th>
                                                        <th>Payment Type</th>
                                                        <th>BV Share Percentage</th>
                                                        <th>AV Share Percentage</th>
                                                        <th>Befor Visa</th>
                                                        <th>After Visa</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Country</th>
                                                        <th>Visa Type</th>
                                                        <th>Payment Type</th>
                                                        <th>BV Share Percentage</th>
                                                        <th>AV Share Percentage</th>
                                                        <th>Befor Visa</th>
                                                        <th>After Visa</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    <?php
                                                    $i = 1;
                                                    $sql=$obj->query("SELECT * FROM $tbl_enrolled_fee ORDER BY id DESC ",$debug=-1);
                                                    while($line=$obj->fetchNextObject($sql)){ 
                                                        ?>
                                                    <tr>
                                                        <td><?=$line->id?></td>
                                                        <td><?=getField('name',$tbl_country,$line->country_id)?></td>
                                                        <td><?=$line->visa_type?></td>
                                                        <td><?=getField('visa_sub_type',$tbl_visa_sub_type,$line->visa_sub_type)?>
                                                        </td>
                                                        <td> <input type="text" size="5" maxlength="5"
                                                                value="<?php echo $line->share_percentage ?>"
                                                                onchange="chagnedisplayOrder(<?php echo $line->id; ?>,this.value, '<?=$line->amount?>', '<?=$line->after_visa_amount?>')">
                                                        </td>
                                                        <td> <input type="text" size="5" maxlength="5"
                                                                value="<?php echo $line->av_share_percentage ?>"
                                                                onchange="chagnedisplayOrders(<?php echo $line->id; ?>,this.value, '<?=$line->amount?>', '<?=$line->after_visa_amount?>')">
                                                        </td>
                                                        <td id="amount<?=$line->id?>">
                                                            <p>Without GST:
                                                                <?=$line->share_percentage != 0 ? round(($line->amount * $line->share_percentage)/100) : '0' ?>
                                                            </p>
                                                            <p> With GST:
                                                                <?=$line->share_percentage != 0 ? round(($line->amount * $line->share_percentage)/100 + ((($line->amount * $line->share_percentage)/100)*18)/100) : '0' ?>
                                                            </p>
                                                        </td>
                                                        <td id="after_visa_amount<?=$line->id?>">
                                                            <p>Without GST:
                                                                <?=$line->share_percentage != 0 ? round(($line->after_visa_amount * $line->share_percentage)/100) : '0' ?>
                                                            </p>
                                                            <p> With GST:
                                                                <?=$line->av_share_percentage != 0 ? round(($line->after_visa_amount * $line->av_share_percentage)/100 + ((($line->after_visa_amount * $line->av_share_percentage)/100)*18)/100) : '0' ?>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
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


    <?php include("footer.php"); ?>
    <script src="js/select2.full.min.js"></script>
    <script src="js/change-status.js"></script>
    <script>
    $(".select2").select2({
        placeholder: "All Branch",
        allowClear: true
    });

    function chagnedisplayOrder(id, ival, amount, after_visa_amount) {
        $.ajax({
            type: "POST",
            url: 'controller.php',
            data: {
                id: id,
                change_share_percentage: ival
            },
            beforeSend: function() {
                // Optional: Add a loader or disable buttons
            },
            success: function(data) {
                if (data == 1) {
                    if (ival != 0) {
                        // Calculate amounts
                        let without_gst_amount = (amount * ival) / 100;
                        let with_gst_amount = without_gst_amount + (without_gst_amount * 18) / 100;
                        // Calculate amounts
                        let without_gst_afamount = (after_visa_amount * ival) / 100;
                        let with_gst_afamount = without_gst_afamount + (without_gst_afamount * 18) / 100;

                        $("#amount" + id).html(`
                        <p>Without GST: ${Math.round(without_gst_amount)}</p>
                        <p>With GST: ${Math.round(with_gst_amount)}</p>
                        `);

                    } else {
                        $("#amount" + id).html(`<p>Without GST: 0</p><p>With GST: 0</p>`);
                    }

                }
            }
        });
    }

    function chagnedisplayOrders(id, ival, amount, after_visa_amount) {
        $.ajax({
            type: "POST",
            url: 'controller.php',
            data: {
                id: id,
                change_share_percentages: ival
            },
            beforeSend: function() {
                // Optional: Add a loader or disable buttons
            },
            success: function(data) {
                if (data == 1) {
                    if (ival != 0) {
                        // Calculate amounts
                        let without_gst_amount = (amount * ival) / 100;
                        let with_gst_amount = without_gst_amount + (without_gst_amount * 18) / 100;
                        // Calculate amounts
                        let without_gst_afamount = (after_visa_amount * ival) / 100;
                        let with_gst_afamount = without_gst_afamount + (without_gst_afamount * 18) / 100;


                        $("#after_visa_amount" + id).html(`
                        <p>Without GST: ${Math.round(without_gst_afamount)}</p>
                        <p>With GST: ${Math.round(with_gst_afamount)}</p>
                        `);
                    } else {
                        $("#after_visa_amount" + id).html(`<p>Without GST: 0</p><p>With GST: 0</p>`);
                    }

                }
            }
        });
    }
    </script>
</body>


</html>