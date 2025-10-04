<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_user();
?>
<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from hencework.com/theme/philbert/full-width-light/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 04 May 2023 05:24:49 GMT -->

<head>
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
        <?php include("header.php"); ?>
        <?php include("menu.php"); ?>
        <!-- /Top Menu Items -->
        <!-- Main Content -->
        <div class="page-wrapper">
            <div class="container">
                <div class="student_filter">
                    <h4 class="my-3">Student Details</h4>
                    <form>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">

                                    <div class="input-group">
                                        <div class="input-group-addon">Student ID</div>
                                        <input type="text" class="form-control" id="exampleInputuname_1" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">

                                    <div class="input-group">
                                        <div class="input-group-addon">Name</div>
                                        <input type="text" class="form-control" id="exampleInputuname_1" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">

                                    <div class="input-group">
                                        <div class="input-group-addon">Father's Name</div>
                                        <input type="text" class="form-control" id="exampleInputuname_1" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">

                                    <div class="input-group">
                                        <div class="input-group-addon">D.O.B</div>
                                        <input type="text" class="form-control" id="exampleInputuname_1" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">

                                    <div class="input-group">
                                        <div class="input-group-addon">Passport No.</div>
                                        <input type="text" class="form-control" id="exampleInputuname_1" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">

                                    <div class="input-group">
                                        <div class="input-group-addon">Country</div>
                                        <input type="text" class="form-control" id="exampleInputuname_1" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">

                                    <div class="input-group">
                                        <div class="input-group-addon">Visa Type</div>
                                        <input type="text" class="form-control" id="exampleInputuname_1" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">

                                    <div class="input-group">
                                        <div class="input-group-addon">Counsellor Name</div>
                                        <input type="text" class="form-control" id="exampleInputuname_1" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">

                                    <div class="input-group">
                                        <div class="input-group-addon">Account Manager</div>
                                        <select class="form-control">
                                            <option value="Selected">NA</option>
                                            <option value="1">Suresh MAthur</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn mr-10">Submit</button>
                            </div>



                        </div>

                    </form>
                </div>
                <div class="">
                    <div class="panel panel-default card-view" style="background:transparent;">

                        <div class="panel-wrapper collapse in">
                            <div class="panel-body">

                                <div class="tab-struct custom-tab-1 mt-40">
                                    <ul role="tablist" class="nav nav-tabs" id="myTabs_7">
                                        <li class="active" role="presentation"><a aria-expanded="true" data-toggle="tab"
                                                role="tab" id="home_tab_7" href="#home_7">Documents</a></li>
                                        <li role="presentation" class=""><a data-toggle="tab" id="profile_tab_7"
                                                role="tab" href="#profile_7" aria-expanded="false">Application</a></li>
                                        <li class="" role="presentation"><a aria-expanded="true" data-toggle="tab"
                                                role="tab" id="status_tab_7" href="#status_7">Status</a></li>
                                        <li role="presentation" class=""><a data-toggle="tab" id="notes_tab_7"
                                                role="tab" href="#notes_7" aria-expanded="false">Notes</a></li>

                                    </ul>
                                    <div class="tab-content" id="myTabContent_7">
                                        <div id="home_7" class="tab-pane fade active in" role="tabpanel">
                                            <div class="panel panel-default card-view">

                                                <div class="panel-wrapper collapse in">
                                                    <div class="panel-body">

                                                        <div class="pills-struct vertical-pills">
                                                            <ul role="tablist" class="nav nav-pills ver-nav-pills"
                                                                id="myTabs_10">
                                                                <li class="active" role="presentation"><a
                                                                        aria-expanded="true" data-toggle="tab"
                                                                        role="tab" id="home_tab_10"
                                                                        href="#home_10">Academics</a></li>
                                                                <li role="presentation" class=""><a data-toggle="tab"
                                                                        id="profile_tab_10" role="tab"
                                                                        href="#profile_10"
                                                                        aria-expanded="false">Language Proficiency</a>
                                                                </li>
                                                                <li role="presentation" class=""><a data-toggle="tab"
                                                                        id="profile_tab_11" role="tab"
                                                                        href="#profile_11"
                                                                        aria-expanded="false">Financial</a></li>
                                                                <li role="presentation" class=""><a data-toggle="tab"
                                                                        id="profile_tab_12" role="tab"
                                                                        href="#profile_12" aria-expanded="false">CA
                                                                        Report</a></li>

                                                            </ul>
                                                            <div class="tab-content" id="myTabContent_10">
                                                                <div id="home_10" class="tab-pane fade active in"
                                                                    role="tabpanel">
                                                                    <div class="acedmics-certificate">

                                                                        <img src="/ibtcrm/img/acedmics_cer.png" alt="">
                                                                        <img src="/ibtcrm/img/acedmics_cer.png" alt="">
                                                                        <img src="/ibtcrm/img/acedmics_cer.png" alt="">
                                                                    </div>
                                                                </div>
                                                                <div id="profile_10" class="tab-pane fade"
                                                                    role="tabpanel">
                                                                    <div class="acedmics-certificate">

                                                                        <img src="/ibtcrm/img/acedmics_cer.png" alt="">
                                                                        <img src="/ibtcrm/img/acedmics_cer.png" alt="">
                                                                        <img src="/ibtcrm/img/acedmics_cer.png" alt="">
                                                                    </div>
                                                                </div>
                                                                <div id="profile_11" class="tab-pane fade "
                                                                    role="tabpanel">
                                                                    <div class="acedmics-certificate">

                                                                        <img src="/ibtcrm/img/acedmics_cer.png" alt="">
                                                                        <img src="/ibtcrm/img/acedmics_cer.png" alt="">
                                                                        <img src="/ibtcrm/img/acedmics_cer.png" alt="">
                                                                    </div>
                                                                </div>
                                                                <div id="profile_12" class="tab-pane fade"
                                                                    role="tabpanel">
                                                                    <div class="acedmics-certificate">

                                                                        <img src="/ibtcrm/img/acedmics_cer.png" alt="">
                                                                        <img src="/ibtcrm/img/acedmics_cer.png" alt="">
                                                                        <img src="/ibtcrm/img/acedmics_cer.png" alt="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="profile_7" class="tab-pane fade" role="tabpanel">
                                            <div class="table-wrap">
                                                <div class="table-responsive">
                                                    <table id="datable_11" class="table table-hover display  pb-30">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:5%"><span>Sr.No</span></th>
                                                                <th style="width:20%"><span>Institute Name</span></th>
                                                                <th style="width:15%"><span>Location</span></th>
                                                                <th style="width:20%"><span>Course</span></th>
                                                                <th style="width:10%"><span>Intake</span></th>
                                                                <th style="width:10%"><span>Year</span></th>
                                                                <th style="width:15%"><span>Status</span></th>
                                                                <th style="width:5%;"><span
                                                                        style="background:#4b4b4d;color:white;">Edit</span>
                                                                </th>

                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <tr class="filter_section">
                                                                <td style="width:5%"><span></span></td>
                                                                <td style="width:20%"><span></span></td>
                                                                <td style="width:15%"><span></span></td>
                                                                <td style="width:20%"><span></span></td>
                                                                <td style="width:10%"><span></span></td>
                                                                <td style="width:10%"><span></span></td>
                                                                <td style="width:15%"><span></span></td>


                                                            </tr>
                                                            <tr>
                                                                <td>01</td>
                                                                <td>Arkansas State University</td>
                                                                <td>Arkansas</td>
                                                                <td>Computer Engineering</td>
                                                                <td>May</td>
                                                                <td>2023</td>
                                                                <td>
                                                                    <select class="form-control">
                                                                        <option value="selected">Pending</option>
                                                                        <option value="1">Process</option>
                                                                        <option value="2">Review</option>
                                                                        <option value="2">Approved</option>
                                                                        <option value="2">Canceled</option>
                                                                    </select>
                                                                </td>

                                                                <td>


                                                                    <a href="javascript:void(0);" data-toggle="modal"
                                                                        data-target="#edit_application" onclick="get(1)"><i
                                                                            class="fa fa-edit"
                                                                            style="margin-right: 6px;font-size: 16px;"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>01</td>
                                                                <td>Arkansas State University</td>
                                                                <td>Arkansas</td>
                                                                <td>Computer Engineering</td>
                                                                <td>May</td>
                                                                <td>2023</td>
                                                                <td>
                                                                    <select class="form-control">
                                                                        <option value="selected">Pending</option>
                                                                        <option value="1">Process</option>
                                                                        <option value="2">Review</option>
                                                                        <option value="2">Approved</option>
                                                                        <option value="2">Canceled</option>
                                                                    </select>
                                                                </td>

                                                                <td>


                                                                    <a href="javascript:void(0);" data-toggle="modal"
                                                                        data-target="#edit_application" onclick="get(1)"><i
                                                                            class="fa fa-edit"
                                                                            style="margin-right: 6px;font-size: 16px;"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>01</td>
                                                                <td>Arkansas State University</td>
                                                                <td>Arkansas</td>
                                                                <td>Computer Engineering</td>
                                                                <td>May</td>
                                                                <td>2023</td>
                                                                <td>
                                                                    <select class="form-control">
                                                                        <option value="selected">Pending</option>
                                                                        <option value="1">Process</option>
                                                                        <option value="2">Review</option>
                                                                        <option value="2">Approved</option>
                                                                        <option value="2">Canceled</option>
                                                                    </select>
                                                                </td>

                                                                <td>


                                                                    <a href="javascript:void(0);" data-toggle="modal"
                                                                        data-target="#edit_application" onclick="get(1)"><i
                                                                            class="fa fa-edit"
                                                                            style="margin-right: 6px;font-size: 16px;"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>01</td>
                                                                <td>Arkansas State University</td>
                                                                <td>Arkansas</td>
                                                                <td>Computer Engineering</td>
                                                                <td>May</td>
                                                                <td>2023</td>
                                                                <td>
                                                                    <select class="form-control">
                                                                        <option value="selected">Pending</option>
                                                                        <option value="1">Process</option>
                                                                        <option value="2">Review</option>
                                                                        <option value="2">Approved</option>
                                                                        <option value="2">Canceled</option>
                                                                    </select>
                                                                </td>

                                                                <td>


                                                                    <a href="javascript:void(0);" data-toggle="modal"
                                                                        data-target="#edit_application" onclick="get(1)"><i
                                                                            class="fa fa-edit"
                                                                            style="margin-right: 6px;font-size: 16px;"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>01</td>
                                                                <td>Arkansas State University</td>
                                                                <td>Arkansas</td>
                                                                <td>Computer Engineering</td>
                                                                <td>May</td>
                                                                <td>2023</td>
                                                                <td>
                                                                    <select class="form-control">
                                                                        <option value="selected">Pending</option>
                                                                        <option value="1">Process</option>
                                                                        <option value="2">Review</option>
                                                                        <option value="2">Approved</option>
                                                                        <option value="2">Canceled</option>
                                                                    </select>
                                                                </td>

                                                                <td>


                                                                    <a href="javascript:void(0);" data-toggle="modal"
                                                                        data-target="#edit_application" onclick="get(1)"><i
                                                                            class="fa fa-edit"
                                                                            style="margin-right: 6px;font-size: 16px;"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <button class="application-btn btn"><a href="javascript:void(0);" data-toggle="modal"
                                                                        data-target="#add_application" onclick="get(1)" class="add-application">Add
                                                    Application</a></button>
                                        </div>
                                        <div id="status_7" class="tab-pane fade " role="tabpanel">
                                            <div class="table-wrap">
                                                <div class="table-responsive">
                                                    <table id="datable_11" class="table table-hover display  pb-30">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:10%"><span>Date</span></th>
                                                                <th style="width:10%"><span>Time</span></th>
                                                                <th style="width:%"><span>Stage</span></th>
                                                                <th style="width:20%"><span>Status</span></th>
                                                                <th style="width:20%"><span>Remarks</span></th>
                                                                <th style="width:15%"><span>Added by</span></th>

                                                                <th style="width:5%;"><span
                                                                        style="background:#4b4b4d;color:white;">Edit</span>
                                                                </th>

                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <tr class="filter_section">
                                                                <td style="width:10%"><span></span></td>
                                                                <td style="width:10%"><span></span></td>
                                                                <td style="width:20%"><span></span></td>
                                                                <td style="width:20%"><span></span></td>
                                                                <td style="width:20%"><span></span></td>
                                                                <td style="width:15%"><span></span></td>


                                                            </tr>
                                                            <tr>
                                                                <td>12-05-2023</td>
                                                                <td>01:47 PM</td>
                                                                <td>Documents</td>
                                                                <td>Received</td>
                                                                <td>May</td>
                                                                <td>Aman</td>


                                                                <td>


                                                                    <a href="javascript:void(0);" data-toggle="modal"
                                                                        data-target="#updateModal" onclick="get(1)"><i
                                                                            class="fa fa-edit"
                                                                            style="margin-right: 6px;font-size: 16px;"></i>
                                                                    </a>

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>12-05-2023</td>
                                                                <td>01:47 PM</td>
                                                                <td>Documents</td>
                                                                <td>Received</td>
                                                                <td>May</td>
                                                                <td>Aman</td>


                                                                <td>


                                                                    <a href="javascript:void(0);" data-toggle="modal"
                                                                        data-target="#updateModal" onclick="get(1)"><i
                                                                            class="fa fa-edit"
                                                                            style="margin-right: 6px;font-size: 16px;"></i>
                                                                    </a>

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>12-05-2023</td>
                                                                <td>01:47 PM</td>
                                                                <td>Documents</td>
                                                                <td>Received</td>
                                                                <td>May</td>
                                                                <td>Aman</td>


                                                                <td>


                                                                    <a href="javascript:void(0);" data-toggle="modal"
                                                                        data-target="#updateModal" onclick="get(1)"><i
                                                                            class="fa fa-edit"
                                                                            style="margin-right: 6px;font-size: 16px;"></i>
                                                                    </a>

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>12-05-2023</td>
                                                                <td>01:47 PM</td>
                                                                <td>Documents</td>
                                                                <td>Received</td>
                                                                <td>May</td>
                                                                <td>Aman</td>


                                                                <td>


                                                                    <a href="javascript:void(0);" data-toggle="modal"
                                                                        data-target="#updateModal" onclick="get(1)"><i
                                                                            class="fa fa-edit"
                                                                            style="margin-right: 6px;font-size: 16px;"></i>
                                                                    </a>

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>12-05-2023</td>
                                                                <td>01:47 PM</td>
                                                                <td>Documents</td>
                                                                <td>Received</td>
                                                                <td>May</td>
                                                                <td>Aman</td>


                                                                <td>


                                                                    <a href="javascript:void(0);" data-toggle="modal"
                                                                        data-target="#updateModal" onclick="get(1)"><i
                                                                            class="fa fa-edit"
                                                                            style="margin-right: 6px;font-size: 16px;"></i>
                                                                    </a>

                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <button class="application-btn btn"><a href="javascript:void(0);"
                                                    data-toggle="modal" data-target="#add_status" onclick="get(1)"
                                                    class="add-application">Add Status</a></button>
                                        </div>

                                        <div id="notes_7" class="tab-pane fade" role="tabpanel">

                                            <!--   <div class="panel panel-default card-view">
                                <div class="panel-heading">
                                    <div class="pull-left">
                                        <h6 class="panel-title txt-dark">one open</h6>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="panel-wrapper collapse in">
                                    <div class="panel-body">
                                        <div class="panel-group accordion-struct accordion-style-1" id="accordion_2" role="tablist" aria-multiselectable="true">
                                            <div class="panel panel-default">
                                                <div class="panel-heading activestate" role="tab" id="heading_10">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapse_10" aria-expanded="true" ><div class="icon-ac-wrap pr-20"><span class="plus-ac"><i class="ti-plus"></i></span><span class="minus-ac"><i class="ti-minus"></i></span></div>collapse one</a> 
                                                </div>
                                                <div id="collapse_10" class="panel-collapse collapse in" role="tabpanel">
                                                    <div class="panel-body pa-15"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer la. </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="heading_11">
                                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapse_11" aria-expanded="false"  ><div class="icon-ac-wrap pr-20"><span class="plus-ac"><i class="ti-plus"></i></span><span class="minus-ac"><i class="ti-minus"></i></span></div>collapse two </a>
                                                </div>
                                                <div id="collapse_11" class="panel-collapse collapse" role="tabpanel">
                                                    <div class="panel-body pa-15"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="heading_12">
                                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapse_12" aria-expanded="false" ><div class="icon-ac-wrap pr-20"><span class="plus-ac"><i class="ti-plus"></i></span><span class="minus-ac"><i class="ti-minus"></i></span></div>collapse three</a>
                                                </div>
                                                <div id="collapse_12" class="panel-collapse collapse" role="tabpanel">
                                                    <div class="panel-body pa-15"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, inable VHS. </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="heading_13">
                                                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapse_13" aria-expanded="false" ><div class="icon-ac-wrap pr-20"><span class="plus-ac"><i class="ti-plus"></i></span><span class="minus-ac"><i class="ti-minus"></i></span></div>collapse four</a>
                                                </div>
                                                <div id="collapse_13" class="panel-collapse collapse" role="tabpanel">
                                                    <div class="panel-body pa-15"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, inable VHS. </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                                            <div class="panel panel-default card-view">

                                                <div class="panel-wrapper collapse in">
                                                    <div class="panel-body">
                                                        <div class="panel-group accordion-struct" id="accordion_1"
                                                            role="tablist" aria-multiselectable="true">
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading" role="tab" id="heading_1">
                                                                    <a role="button" data-toggle="collapse"
                                                                        data-parent="#accordion_1" href="#collapse_1"
                                                                        aria-expanded="false" class="collapsed">Harsha
                                                                        Goel - Missing Documents</a>
                                                                </div>
                                                                <div id="collapse_1" class="panel-collapse collapse in"
                                                                    role="tabpanel" aria-expanded="false"
                                                                    style="height: auto;">
                                                                    <div class="panel-body pa-15">
                                                                        <p> Anim pariatur cliche reprehenderit, enim
                                                                            eiusmod high life accusamus terry richardson
                                                                            ad squid. 3 wolf moon officia aute, non
                                                                            cupidatat skateboard dolor brunch. Food
                                                                            truck quinoa nesciunt laborum eiusmod.
                                                                            Brunch 3 wolf moon tempor, sunt aliqua put a
                                                                            bird on it squid single-origin coffee nulla
                                                                            assumenda shoreditch et. Nihil anim keffiyeh
                                                                            helvetica, craft beer la.</p>
                                                                        <div class="comments">
                                                                            <div class="replies my-3"
                                                                                style=" background-color: #4b4b4d;">
                                                                                <div class="comment_heading">
                                                                                    <p><strong>Aman Singh -
                                                                                        </strong>Missing Document</p>
                                                                                </div>
                                                                                <div class="comment_icon">
                                                                                    <i class="fa fa-reply"></i>
                                                                                </div>
                                                                            </div>
                                                                            <p class="ml-3">Ok i will</p>
                                                                        </div>

                                                                        <div class="comments">
                                                                            <div class="replies my-3"
                                                                                style=" background-color: #363e91;">
                                                                                <div class="comment_heading">
                                                                                    <p><strong>Manoj Sharma -
                                                                                        </strong>Missing Document</p>
                                                                                </div>
                                                                                <div class="comment_icon">
                                                                                    <i class="fa fa-reply"></i>
                                                                                </div>
                                                                            </div>
                                                                            <p class="ml-3">Ok i will</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading" role="tab" id="heading_2">
                                                                    <a class="collapsed" role="button"
                                                                        data-toggle="collapse"
                                                                        data-parent="#accordion_1" href="#collapse_2"
                                                                        aria-expanded="false">collapse two </a>
                                                                </div>
                                                                <div id="collapse_2" class="panel-collapse collapse"
                                                                    role="tabpanel" aria-expanded="false"
                                                                    style="height: 0px;">
                                                                    <div class="panel-body pa-15"> Anim pariatur cliche
                                                                        reprehenderit, enim eiusmod high life accusamus
                                                                        terry richardson ad squid. 3 wolf moon officia
                                                                        aute, non cupidatat skateboard dolor brunch.
                                                                        Food truck quinoa nesciunt laborum eiusmod.
                                                                        Brunch 3 wolf moon tempor, sunt aliqua put a
                                                                        bird on it squid single-origin coffee nulla
                                                                        assumenda shoreditch et. Nihil anim keffiyeh
                                                                        helvetica, </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading" role="tab" id="heading_3">
                                                                    <a class="collapsed" role="button"
                                                                        data-toggle="collapse"
                                                                        data-parent="#accordion_1" href="#collapse_3"
                                                                        aria-expanded="false">collapse three</a>
                                                                </div>
                                                                <div id="collapse_3" class="panel-collapse collapse"
                                                                    role="tabpanel" aria-expanded="false">
                                                                    <div class="panel-body pa-15"> Anim pariatur cliche
                                                                        reprehenderit, enim eiusmod high life accusamus
                                                                        terry richardson ad squid. 3 wolf moon officia
                                                                        aute, non cupidatat skateboard dolor brunch.
                                                                        Food truck quinoa nesciunt laborum eiusmod.
                                                                        Brunch 3 wolf moon tempor, sunt aliqua put a
                                                                        bird on it squid single-origin coffee nulla
                                                                        assumenda shoreditch et. Nihil anim keffiyeh
                                                                        helvetica, inable VHS. </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel panel-default">
                                                                <div class="panel-heading" role="tab" id="heading_4">
                                                                    <a class="collapsed" role="button"
                                                                        data-toggle="collapse"
                                                                        data-parent="#accordion_1" href="#collapse_4"
                                                                        aria-expanded="false"> collapse four</a>
                                                                </div>
                                                                <div id="collapse_4" class="panel-collapse collapse"
                                                                    role="tabpanel" aria-expanded="false">
                                                                    <div class="panel-body pa-15"> Anim pariatur cliche
                                                                        reprehenderit, enim eiusmod high life accusamus
                                                                        terry richardson ad squid. 3 wolf moon officia
                                                                        aute, non cupidatat skateboard dolor brunch.
                                                                        Food truck quinoa nesciunt laborum eiusmod.
                                                                        Brunch 3 wolf moon tempor, sunt aliqua put a
                                                                        bird on it squid single-origin coffee nulla
                                                                        assumenda shoreditch et. Nihil anim keffiyeh
                                                                        helvetica, inable VHS. </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button class="application-btn btn"><a href="javascript:void(0);"
                                                    data-toggle="modal" data-target="#add_notes" onclick="get(1)"
                                                    class="add-application">Add Notes</a></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


<!-- Add Application Popup -->
<div class="modal fade" id="add_application" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                            <h5 class="modal-title" id="exampleModalLabel1">Add Application</h5>
                        </div>
                        <div class="modal-body">
                            <form method="post" id="add-app" name="updateBranch">
                                <input type="hidden" name="id" id="id">

                                <div class="form-group">

                                    <input type="text" class="form-control" name="name" id="name" placeholder="S.No">
                                </div>
                                <div class="form-group">

                                    <input type="text" class="form-control" name="email" id="email" placeholder="Institue Name">
                                </div>
                                <div class="form-group">

                                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Location">
                                </div>
                                <div class="form-group">

                                    <input type="text" class="form-control" name="address" id="address"
                                        placeholder="Course">
                                </div>
                                <div class="form-group">

                                    <input type="text" class="form-control" name="address" id="address"
                                        placeholder="Intake">
                                </div>
                                <div class="form-group">

                                    <input type="text" class="form-control" name="address" id="address"
                                        placeholder="Year">
                                </div>
                                <div class="form-group">

                                <select class="form-control" name="level_id" id="level_id" required="">
																			<option value="selected">Pending</option>
                                                                            <option value="1">Approved</option>
                                                                            <option value="2">Process</option>
                                                                            <option value="3">Canceled</option>
																			
																		</select>

</div>
                                

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="btnUpdateSubmit" class="btn btn-primary">Submit</button>
                        </div>
                        </form>
                    </div>

                </div>
            </div>
<!-- Edit Application Popup -->
<div class="modal fade" id="edit_application" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                            <h5 class="modal-title" id="exampleModalLabel1">Edit Application</h5>
                        </div>
                        <div class="modal-body">
                        <form method="post" id="edit-app" name="updateBranch">
                                <input type="hidden" name="id" id="id">

                                <div class="form-group">

                                    <input type="text" class="form-control" name="name" id="name" placeholder="S.No">
                                </div>
                                <div class="form-group">

                                    <input type="text" class="form-control" name="email" id="email" placeholder="Institue Name">
                                </div>
                                <div class="form-group">

                                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Location">
                                </div>
                                <div class="form-group">

                                    <input type="text" class="form-control" name="address" id="address"
                                        placeholder="Course">
                                </div>
                                <div class="form-group">

                                    <input type="text" class="form-control" name="address" id="address"
                                        placeholder="Intake">
                                </div>
                                <div class="form-group">

                                    <input type="text" class="form-control" name="address" id="address"
                                        placeholder="Year">
                                </div>
                                <div class="form-group">

                                <select class="form-control" name="level_id" id="level_id" required="">
																			<option value="selected">Pending</option>
                                                                            <option value="1">Approved</option>
                                                                            <option value="2">Process</option>
                                                                            <option value="3">Canceled</option>
																			
																		</select>

</div>
                                

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="btnUpdateSubmit" class="btn btn-primary">Submit</button>
                        </div>
                        </form>
                    </div>

                </div>
            </div>
<!-- Add Notes Popup -->
<div class="modal fade" id="add_notes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                            <h5 class="modal-title" id="exampleModalLabel1">Add Notes</h5>
                        </div>
                        <div class="modal-body">
                            <form method="post" id="updateBranch" name="updateBranch">
                                <input type="hidden" name="id" id="id">

                                <div class="form-group">
                                <select class="form-control" name="level_id" id="level_id" required="">
																			<option value="selected">Stage</option>
																			
																		</select>
                                </div>
                                <div class="form-group">

                                    <input type="text" class="form-control" name="email" id="email" placeholder="Subject">
                                </div>
                                <div class="form-group">

                                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Stage">
                                </div>
                                <div class="form-group">
    
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Remarks"></textarea>
  </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="btnUpdateSubmit" class="btn btn-primary">Submit</button>
                        </div>
                        </form>
                    </div>

                </div>
            </div>
<!-- Edit Status Popup -->
            <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                            <h5 class="modal-title" id="exampleModalLabel1">Edit Status</h5>
                        </div>
                        <div class="modal-body">
                            <form method="post" id="updateBranch" name="updateBranch">
                                <input type="hidden" name="id" id="id">

                                <div class="form-group">

                                    <input type="text" class="form-control" name="name" id="name" placeholder="Date">
                                </div>
                                <div class="form-group">

                                    <input type="text" class="form-control" name="email" id="email" placeholder="Time">
                                </div>
                                <div class="form-group">

                                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Stage">
                                </div>
                                <div class="form-group">

                                    <input type="text" class="form-control" name="address" id="address"
                                        placeholder="Status">
                                </div>
                                <div class="form-group">

                                    <input type="text" class="form-control" name="address" id="address"
                                        placeholder="Remarks">
                                </div>
                                <div class="form-group">

                                    <input type="text" class="form-control" name="address" id="address"
                                        placeholder="Added by">
                                </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="btnUpdateSubmit" class="btn btn-primary">Submit</button>
                        </div>
                        </form>
                    </div>

                </div>
            </div>
            <!-- Add Status Popup -->
            <div class="modal fade" id="add_status" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                            <h5 class="modal-title" id="exampleModalLabel1">Add Status</h5>
                        </div>
                        <div class="modal-body">
                            <form method="post" id="updateBranch" name="updateBranch">
                                <input type="hidden" name="id" id="id">

                                <div class="form-group">

                                    <input type="text" class="form-control" name="name" id="name" placeholder="Date">
                                </div>
                                <div class="form-group">

                                    <input type="text" class="form-control" name="email" id="email" placeholder="Time">
                                </div>
                                <div class="form-group">

                                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Stage">
                                </div>
                                <div class="form-group">

                                    <input type="text" class="form-control" name="address" id="address"
                                        placeholder="Status">
                                </div>
                                <div class="form-group">

                                    <input type="text" class="form-control" name="address" id="address"
                                        placeholder="Remarks">
                                </div>
                                <div class="form-group">

                                    <input type="text" class="form-control" name="address" id="address"
                                        placeholder="Added by">
                                </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="btnUpdateSubmit" class="btn btn-primary">Submit</button>
                        </div>
                        </form>
                    </div>

                </div>
            </div>



            <!-- Footer -->
            <footer class="footer container-fluid pl-30 pr-30">
                <div class="row">
                    <div class="col-sm-12">
                        <p>2017 &copy; Philbert. Pampered by Hencework</p>
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
    <!-- jQuery -->

</body>

<script type="text/javascript">

    $(document).on('.collapse.in', '.panel-collapse', function (e) {
        $(this).siblings('.panel-heading').addClass('activestate');
    });

    $(document).on('hide.bs.collapse', '.panel-collapse', function (e) {
        $(this).siblings('.panel-heading').removeClass('activestate');
    });
    $(".panel-heading").on("click", function () {
        $(".panel-heading").removeClass("activestate");
    });


</script>



<script>
    /*Sidebar Navigation*/
    $(document).on('click', '#toggle_nav_btn,#open_right_sidebar,#setting_panel_btn', function (e) {
        $(".dropdown.open > .dropdown-toggle").dropdown("toggle");
        return false;
    });
    $(document).on('click', '#toggle_nav_btn', function (e) {
        $wrapper.removeClass('open-right-sidebar open-setting-panel').toggleClass('slide-nav-toggle');
        return false;
    });

    $(document).on('click', '#open_right_sidebar', function (e) {
        $wrapper.toggleClass('open-right-sidebar').removeClass('open-setting-panel');
        return false;

    });

    $(document).on('click', '.product-carousel .owl-nav', function (e) {
        return false;
    });

    $(document).on('click', 'body', function (e) {
        if ($(e.target).closest('.fixed-sidebar-right,.setting-panel').length > 0) {
            return;
        }
        $('body > .wrapper').removeClass('open-right-sidebar open-setting-panel');
        return;
    });

    $(document).on('show.bs.dropdown', '.nav.navbar-right.top-nav .dropdown', function (e) {
        $wrapper.removeClass('open-right-sidebar open-setting-panel');
        return;
    });

    $(document).on('click', '#setting_panel_btn', function (e) {
        $wrapper.toggleClass('open-setting-panel').removeClass('open-right-sidebar');
        return false;
    });
    $(document).on('click', '#toggle_mobile_nav', function (e) {
        $wrapper.toggleClass('mobile-nav-open').removeClass('open-right-sidebar');
        return;
    });


    $(document).on("mouseenter mouseleave", ".wrapper > .fixed-sidebar-left", function (e) {
        if (e.type == "mouseenter") {
            $wrapper.addClass("sidebar-hover");
        }
        else {
            $wrapper.removeClass("sidebar-hover");
        }
        return false;
    });

    $(document).on("mouseenter mouseleave", ".wrapper > .setting-panel", function (e) {
        if (e.type == "mouseenter") {
            $wrapper.addClass("no-transition");
        }
        else {
            $wrapper.removeClass("no-transition");
        }
        return false;
    });

</script>



<!-- Mirrored from hencework.com/theme/philbert/full-width-light/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 04 May 2023 05:25:18 GMT -->

</html>