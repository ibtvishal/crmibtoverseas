<?php
include('include/config.php');
include("include/functions.php");
validate_user();
$first_date = '2024-01-01';
$ten_percentage = 0;
if ($_REQUEST['id'] != '') {
    $telecaller_id = 0;
    $id = base64_decode(base64_decode(base64_decode($_REQUEST['id'])));
    $sql = $obj->query("select * from $tbl_visit where id='$id'");
    $result = $obj->fetchNextObject($sql);
    // $sql1 = $obj->query("select * from $tbl_visit_fee where visit_id='$id' and payment_type='Enrollment'");
    // $result_fee = $obj->fetchNextObject($sql1);
    // $result_fee_count = $obj->numRows($sql1);
 
    // if($result_fee_count2 > 0){
    //     $fee_2 = $result_fee2->registration_amount;
    //     $total_amount2 = $result_fee2->total_amount;
    // }
    // $fee = $result_fee->net_amount+$fee_2;
    // $total_amount = $result_fee->total_amount+$total_amount2;
    $sql2 = $obj->query("select * from $tbl_visit_fee where visit_id='$id' and payment_type='".$_GET['type']."'");
    $result_fee = $obj->fetchNextObject($sql2);
    $visaArr = array();
    $visaArr = explode(',', $result_fee->visa_type);
   

    $get_student = $obj->query("select student_no from $tbl_student where student_contact_no='".$result->applicant_contact_no."' or alternate_contact='".$result->applicant_contact_no."' or student_contact_no='".$result->applicant_alternate_no."' or alternate_contact='".$result->applicant_alternate_no."'");
    $student = $obj->fetchNextObject($get_student);
    $count_s = $obj->numRows($get_student);

    $net_amt = $result_fee->net_amount;
    $gst_amount = $result_fee->gst_amount;
    $total_amount = $result_fee->total_amount;
    if($_GET['type']=='Registration'){
        $total_amount = $result_fee->total_amount + $result_fee->amount_already_paid;
    }else{
        if($_GET['type'] == 'Direct Enrollment' && !isset($_GET['full_payment']) && $result_fee->upi == null && $result_fee->cheque == null && $result_fee->swipe == null && $result_fee->bank == null  && $result_fee->payment_date > $first_date && ($result->visa_sub_type == 3 || $result->visa_sub_type == 43 || $result->visa_sub_type == 44 )){
            $total_amount = $result_fee->total_amount*10/100;
            $ten_percentage = 1;
        }else{
        // $total_amount = $result_fee->total_amount;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>IBT Payment Slip</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
    /* #202121 */
    .bg-theme {
        background-color: #202121;
    }

    .container {
        min-width: 996px !important;
    }
    </style>
</head>

<body onload="window.print()">
    <?php
    for ($j = 0; $j < 1; $j++) {
    ?>
    <!-- invoice section  -->
    <section class="container px-4 mb-1 py-2">
        <div class="card border p-4">
            <header class="d-flex justify-content-between align-items-center mb-3">
                <img src="img/logo-india.svg" alt="logo" height="50px">
                <!-- <h4 class="fw-bold fs-5 bg-theme text-white py-2 px-2 rounded"> <?= $j == 0 ? 'STUDENT' : 'OFFICE'?>
                    COPY</h4> -->
                <span></span>
            </header>
            <main class="fw-semibold">
                <table class="table table-borderless mb-2">
                    <tr>
                        <td><?=$result->billing_name?></td>
                        <td class="text-end">Fee Type: Consultancy Fee</td>
                    </tr>
                    <tr>
                        <td>Branch: <?=$result->billing_address?></td>

                        <td class="text-end">Date: <?=date('d-m-Y',strtotime($result_fee->payment_date))?></td>
                    </tr>
                    <tr class="border-bottom border-secondary">
                        <td>GST No: <?=$result->gst_no?></td>
                        <td class="text-end"></td>
                    </tr>
                    <tr>
                        <td>Country: <?=getField('name',$tbl_country,$result->pre_country_id)?></td>
                        <td class="text-end">Visa Type: <?=implode('/ ',$visaArr)?></td>
                    </tr>
                    <tr>
                        <td>Payment Type: <?=$result_fee->payment_type?></td>
                        <td class="text-end">Reciept No: <?=$result_fee->reciept_no?></td>
                    </tr>
                    <tr>
                        <td>Received From: <?=$result->applicant_name?></td>
                        <?php
                        if($count_s > 0){
                            ?>
                        <td class="text-end">Student Code: <?=$student->student_no?></td>
                        <?php } ?>
                    </tr>
                </table>
                <section class="d-flex justify-content-between align-items-end mb-4 px-2">
                    <div>


                        <?php
                        $number = $total_amount;
                        $no = floor($number);
                        $point = round($number - $no, 2) * 100;
                        $hundred = null;
                        $digits_1 = strlen($no);
                        $i = 0;
                        $str = array();
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
                        while ($i < $digits_1) {
                          $divider = ($i == 2) ? 10 : 100;
                          $number = floor($no % $divider);
                          $no = floor($no / $divider);
                          $i += ($divider == 10) ? 1 : 2;
                          if ($number) {
                             $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                             $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                             $str [] = ($number < 21) ? $words[$number] .
                                 " " . $digits[$counter] . $plural . " " . $hundred
                                 :
                                 $words[floor($number / 10) * 10]
                                 . " " . $words[$number % 10] . " "
                                 . $digits[$counter] . $plural . " " . $hundred;
                          } else $str[] = null;
                       }
                       $str = array_reverse($str);
                       $results = implode('', $str);
                       $points = ($point) ?
                         "." . $words[$point / 10] . " " . 
                               $words[$point = $point % 10] : '';
                       $words = $results . "Rupees";
                        ?>
                        <p class="mb-2">An amount of: <span class="ms-2">₹ <?=number_format($total_amount,2)?>
                                (<?=$words?>)</span></p>
                        <table class="table table-borderless table-sm">
                            <?php
                            if($_GET['type']=='Registration'){
                                ?>
                            <tr>
                                <td>Registration Amount</td>
                                <td>₹ <?=number_format($result_fee->registration_amount,2)?>
                                </td>
                            </tr>

                            <?php
                            }elseif($_GET['type'] == 'Enrollment' || $_GET['type'] == 'Direct Enrollment'){
                               
                                if($_GET['type'] == 'Direct Enrollment' && !isset($_GET['full_payment']) && ($result_fee->upi == null && $result_fee->cheque == null && $result_fee->swipe == null && $result_fee->bank == null)  && $result_fee->payment_date > $first_date && ($result->visa_sub_type == 3 || $result->visa_sub_type == 43 || $result->visa_sub_type == 44 )){
                                    $net_amt = number_format($result_fee->net_amount*10/100,2);
                                    $gst_amount = number_format($result_fee->gst_amount*10/100,2);
                                    $total_amount = number_format($result_fee->total_amount*10/100,2);
                                    $ten_percentage = 1;
                                }else{
                                   
                                }
                                ?>
                            <!-- <tr>
                                    <td><?=$_GET['type']?> Amount</td>
                                    <td>₹ <?=$result_fee->enrollment_amount?></td>
                                </tr> -->
                            <?php
                                    $sql2 = $obj->query("select * from $tbl_visit_fee where visit_id='$id' and payment_type='Registration'");
                                    $result2 = $obj->fetchNextObject($sql2);
                                    $result_fee_count = $obj->numRows($sql2);
                                    if($result_fee_count > 0){
                                        ?>
                            <!-- <tr>
                                    <td>Amount Already Paid</td>
                                    <td>₹ <?=$result_fee->amount_already_paid?></td>
                                </tr>
                                <tr>
                                    <td> Pending Enrollment Amount</td>
                                    <td>₹ <?=$result_fee->pending_enrollement_amount?></td>
                                </tr> -->
                            <?php
                                    }
                                ?>
                            <!-- <tr>
                                    <td>Discount Amount</td>
                                    <td>₹ <?=$result_fee->discount_amount?></td>
                                </tr> -->
                            <tr>
                                <td>Net Amount</td>
                                <td>₹ <?=$net_amt?></td>
                            </tr>

                            <?php }else{
                                $net_amt = $result_fee->net_amount;
                                $gst_amount = $result_fee->gst_amount;
                                $total_amount = $result_fee->total_amount;
                                    ?>
                            <!-- <tr>
                                    <td><?=$_GET['type']?> Amount</td>
                                    <td>₹ <?=$result_fee->enrollment_amount?></td>
                                </tr>
                                      <tr>
                                    <td>Discount Amount</td>
                                    <td>₹ <?=$result_fee->discount_amount?></td>
                                </tr> -->
                            <tr>
                                <td>Net Amount</td>
                                <td>₹ <?=number_format($net_amt,2)?></td>
                            </tr>
                            <?php
                            } ?>
                            <tr>
                                <td>CGST Amount</td>
                                <td>₹ <?=number_format($gst_amount/2,2)?></td>
                            </tr>
                            <tr>
                                <td><?=$result->branch_id == 4 ? 'UTGST' : 'SGST'?> Amount</td>
                                <td>₹ <?=number_format($gst_amount/2,2)?></td>
                            </tr>
                            <tr class="border border-2 border-start-0 border-end-0 border-secondary">
                                <td>TOTAL</td>
                                <td>₹ <?=$total_amount?></td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <span>Authorised Signatory <?=$ten_percentage == 1 ? '*' : '' ?></span>
                    </div>
                </section>
                <p class="text-center">Note: Fee Once paid is not refundable</p>
            </main>
        </div>
    </section>
    <?php } ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>