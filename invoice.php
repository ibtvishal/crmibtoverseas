<?php
include('include/config.php');
include("include/functions.php");
validate_user();
$get =  $obj->query("select * from $tbl_branch where id='3'");
$res = $obj->fetchNextObject($get);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tax Invoice</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa; 
            padding: 20px;
        }

        .invoice-container {
            background: #fff;
            padding: 20px;
            width: 900px; 
            margin: auto;
            border: 1px solid #ddd;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .invoice-title {
            text-align: center;
            font-size: 24px;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .header-table, 
        .buyer-table, 
        .item-table, 
        .total-table {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }

        .header-table td,
        .buyer-table td,
        .item-table th,
        .item-table td,
        .total-table td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 14px;
        }

        .header-table td {
            width: 33.33%;
            vertical-align: top;
        }

        .buyer-info, 
        .consignee-info {
            width: 50%;
        }

        .item-table th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .item-table td {
            text-align: center;
        }

        .amount-in-words,
        .amount-words {
            font-size: 14px;
            margin-top: 10px;
        }

        .footer {
            text-align: right;
            margin-top: 30px;
            font-size: 14px;
        }

        .signature {
            font-weight: bold;
        }

        body {
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <?php
    if ($_REQUEST['id'] != '') {
        $telecaller_id = 0;
        $id = $_REQUEST['id'];
        $type=$_REQUEST['type'];
        $sql = $obj->query("select * from $tbl_visit where id='$id'");
        $result = $obj->fetchNextObject($sql);
    
        $sql2 = $obj->query("select * from $tbl_visit_fee where visit_id='$id' and payment_type='".$_GET['type']."'",-1);
        $result_fee = $obj->fetchNextObject($sql2);
        $fee_id=$result_fee->id;
        $visaArr = explode(',', $result_fee->visa_type);
        $total_amount = ($_GET['type'] == 'Registration') ? $result_fee->registration_amount : $result_fee->net_amount;
        if($_GET['type'] == 'Direct Enrollment' && !isset($_GET['full_payment']) && $result_fee->upi == null && $result_fee->cheque == null && $result_fee->swipe == null && $result_fee->bank == null  && $result_fee->payment_date > $first_date && ($result->visa_sub_type == 3 || $result->visa_sub_type == 43 || $result->visa_sub_type == 44 )){
            $total_amount = $result_fee->net_amount*10/100;
            // $ten_percentage = 1;
        }else{
        // $total_amount = $result_fee->total_amount;
        }
    ?>
    <div class="invoice-container">
        <h2 class="invoice-title">Tax Invoice</h2>
        
        <table class="header-table">
            <tr>
                <td class="company-details">
                    <strong><?=$res->billing_name?></strong><br>
                    <?=$res->address?><br>
                    GSTIN/UIN: <?=$res->gst?><br>
                    State Name: <?=$res->state?>, Code: <?=$res->state_code?><br>
                    Email: <?=$res->email?><br>
                </td>
                <td class="invoice-details">
                    <strong>Invoice No.</strong>: <?=$result_fee->id?><br>
                    <strong>Dated</strong>: <?=date('d-M-Y', strtotime($result_fee->cdate))?><br>
                    <strong>Delivery Note</strong>:<br>
                    <strong>Mode/Terms of Payment</strong>:<br>
                </td>
            </tr>
        </table>

        <table class="buyer-table">
            <tr>
                <td class="buyer-info">
                    <strong>Ship To: </strong><br>
                    <strong><?=$result->billing_name?></strong><br>
                    <?=$result->billing_address?><br>
                    GSTIN/UIN: <?=$result->gst_no?><br>
                    State Name: <?=getField('state', $tbl_branch, $result->branch_id)?>, Code: <?=getField('state_code', $tbl_branch, $result->branch_id)?><br>
                </td>
                <td class="consignee-info">
                    <strong>Bill To: </strong><br>
                    <strong><?=$result->billing_name?></strong><br>
                    <?=$result->billing_address?><br>
                    GSTIN/UIN: <?=$result->gst_no?><br>
                    State Name: <?=getField('state', $tbl_branch, $result->branch_id)?>, Code: <?=getField('state_code', $tbl_branch, $result->branch_id)?><br>
                </td>
            </tr>
        </table>
        <?php
        $gets = $obj->query("select * from $tbl_enrolled_fee where country_id='".$result->pre_country_id."' and visa_type='".$result->visa_type."' and visa_sub_type='".$result->visa_sub_type."'");
        $ress = $obj->fetchNextObject($gets);
         
        $gst = ($_GET['type'] == 'After Visa') ? $result_fee->av_franchise_percentage : $result_fee->franchise_percentage;
        ?>
        <table class="item-table">
            <tr>
                <th>Sr No</th>
                <th>Particulars</th>
                <th>HSN/SAC</th>
                <th>Quantity</th>
                <th>Rate (Excl. of Tax)</th>
                <th>Rate</th>
                <th>Amount</th>
            </tr>
            <tr>
                <td>1</td>
                <td>Consultancy Share</td>
                <td>9983</td>
                <td>1</td>
                <td>Rs.<?=number_format(($total_amount * $gst) / 100, 2)?></td>
                <td>18%</td>
                <td>Rs.<?=number_format(($total_amount * $gst) / 100, 2)?></td>
            </tr>
            <?php
            if ($res->state == getField('state', $tbl_branch, $result->branch_id)) {
            ?>
            <tr>
                <td colspan="5"></td>
                <td>CGST</td>
                <td>Rs.<?=number_format((((($total_amount * $gst)/100)*18)/100) / 2, 2)?></td>
            </tr>
            <tr>
                <td colspan="5"></td>
                <td>SGST</td>
                <td>Rs.<?=number_format((((($total_amount * $gst)/100)*18)/100) / 2, 2)?></td>
            </tr>
            <?php } else { ?>
            <tr>
                <td colspan="5"></td>
                <td>IGST</td>
                <td>Rs.<?=number_format(((($total_amount * $gst)/100)*18)/100, 2)?></td>
            </tr>
            <?php } ?>
            <tr>
                <td colspan="5"></td>
                <td><strong>Total</strong></td>
                <td><strong>Rs.<?=number_format(($total_amount * $gst)/100 + ((($total_amount * $gst)/100)*18)/100, 2)?></strong></td>
            </tr>
        </table>

        <?php
            $number = ($total_amount * $gst) / 100 + ((($total_amount * $gst) / 100) * 18) / 100;
            $no = floor($number);
            $point = round($number - $no, 2) * 100;

            $words = array(
                '0' => '',
                '1' => 'One',
                '2' => 'Two',
                '3' => 'Three',
                '4' => 'Four',
                '5' => 'Five',
                '6' => 'Six',
                '7' => 'Seven',
                '8' => 'Eight',
                '9' => 'Nine',
                '10' => 'Ten',
                '11' => 'Eleven',
                '12' => 'Twelve',
                '13' => 'Thirteen',
                '14' => 'Fourteen',
                '15' => 'Fifteen',
                '16' => 'Sixteen',
                '17' => 'Seventeen',
                '18' => 'Eighteen',
                '19' => 'Nineteen',
                '20' => 'Twenty',
                '30' => 'Thirty',
                '40' => 'Forty',
                '50' => 'Fifty',
                '60' => 'Sixty',
                '70' => 'Seventy',
                '80' => 'Eighty',
                '90' => 'Ninety'
            );
            $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');

            $digits_1 = strlen($no);
            $i = 0;
            $str = array();
            while ($i < $digits_1) {
                $divider = ($i == 2) ? 10 : 100;
                $number = floor($no % $divider);
                $no = floor($no / $divider);
                $i += ($divider == 10) ? 1 : 2;
                if ($number) {
                    $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                    $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                    $str[] = ($number < 21) ? $words[$number] . " " . $digits[$counter] . $plural . " " . $hundred
                        : $words[floor($number / 10) * 10] . " " . $words[$number % 10] . " " . $digits[$counter] . $plural . " " . $hundred;
                } else $str[] = null;
            }

            $str = array_reverse($str);
            $results = implode('', $str);
            $paise = ($point) ? " and " . $words[floor($point / 10) * 10] . " " . $words[$point % 10] . " Paise" : '';
            $words = $results . " Rupees" . $paise;
        ?>

        <table class="total-table">
            <tr>
                <td class="hsn-details">
                    <strong>HSN/SAC</strong>: 9983<br>
                    <strong>Taxable Value</strong>: Rs.<?=number_format(($total_amount * $gst) / 100, 2)?><br>
                    <?php
                    if ($res->state == getField('state', $tbl_branch, $result->branch_id)) {
                    ?>
                        <strong>CGST @ 9%</strong>: Rs.<?=number_format((((($total_amount * $gst)/100)*18)/100) / 2, 2)?><br>
                        <strong>SGST @ 9%</strong>: Rs.<?=number_format((((($total_amount * $gst)/100)*18)/100) / 2, 2)?><br>
                    <?php } else { ?>
                        <strong>IGST @ 18%</strong>: Rs.<?=number_format(((($total_amount * $gst)/100)*18)/100, 2)?><br>
                    <?php } ?>
                    <strong>Total Amount</strong>: Rs.<?=number_format(($total_amount * $gst)/100 + ((($total_amount * $gst)/100)*18)/100, 2)?><br>
                </td>
            </tr>
        </table>

        <div class="amount-words">
            <strong>Tax Amount (in words)</strong>: INR <?=$words?> Only
        </div>

        <div class="footer">
            <p><strong>Company’s PAN:</strong> <?=substr($res->gst, 3, -3);?></p>
            <img src="uploads/sign.png" alt="Sign" style="height: 70px;">
            <p class="signature">For IBT INSTITUTE PVT. LTD.<br>Authorized Signatory</p>
        </div>
    </div>
    <?php } ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script type="text/javascript">
    window.onload = function() {
        const { jsPDF } = window.jspdf;

        const pdf = new jsPDF({
            orientation: 'portrait',
            unit: 'pt',
            format: 'a4'
        });

        pdf.setFont('NotoSans');

        const element = document.querySelector('.invoice-container');

        pdf.html(element, {
            callback: function (pdf) {
                const pdfBlob = pdf.output('blob');

                const formData = new FormData();
                formData.append('file', pdfBlob, 'invoice.pdf');

                const id = <?php echo $fee_id ?>; 
                formData.append('id', id);

                        pdf.save('invoice.pdf');
            },
            x: 10,
            y: 10,
            width: 575,
            windowWidth: 900
        });
    };
</script>






</body>
</html>

