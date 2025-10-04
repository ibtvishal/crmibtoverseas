<?php 
ob_start(); 
session_start();
include('include/config.php');
include("include/functions.php");
validate_admin();
$_SESSION['reload']="1";
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



            <div class="student_filter">
                <div class="form-wrap">
                    <form>
                        <div class="row">
                            <div class="col-md-2 col-4">
                                <div class="form-group">

                                    <div class="input-group">
                                        <div class="input-group-addon">Student ID</div>
                                        <input type="text" class="form-control" id="exampleInputuname_1" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Name</div>
                                        <input type="text" class="form-control" id="exampleInputuname_1" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Father's Name</div>
                                        <input type="text" class="form-control" id="exampleInputuname_1" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">D.O.B</div>
                                        <input type="text" class="form-control" id="exampleInputuname_1" placeholder="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 col-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Passport No.</div>
                                        <input type="text" class="form-control" id="exampleInputuname_1" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Country</div>
                                        <input type="text" class="form-control" id="exampleInputuname_1" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Visa Type</div>
                                        <input type="text" class="form-control" id="exampleInputuname_1" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Counsellor Name</div>
                                        <input type="text" class="form-control" id="exampleInputuname_1" placeholder="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">Account Manager</div>
                                        <select class="form-control" id="exampleFormControlSelect1">
                                            <option>N/A</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-4">
                                <button type="submit" class="btn  " style="position: absolute;background:#363e91;width: 86%;
                                   ">Submit</button>
                            </div>
                        </div>



                    </form>
                </div>
            </div>


            <!-- Tabs Section -->
            <div class="">
                <div class="tab-struct custom-tab-1">
                    <ul role="tablist" class="nav nav-tabs" id="myTabs_9">
                        <li class="active" role="presentation"><a aria-expanded="true" data-toggle="tab" role="tab"
                                id="home_tab_9" href="#document">Documents</a></li>
                        <li role="presentation" class=""><a data-toggle="tab" id="profile_tab_10" role="tab"
                                href="#Application" aria-expanded="false">Application</a></li>
                        <li class="" role="presentation"><a aria-expanded="true" data-toggle="tab" role="tab"
                                id="home_tab_11" href="#Status">Status</a></li>
                        <li role="presentation" class=""><a data-toggle="tab" id="profile_tab_12" role="tab"
                                href="#Notes" aria-expanded="false">Notes</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="tab-content" id="myTabContent_9">
                        <div id="document" class="tab-pane fade active in" role="tabpanel">

                            <div class="pills-struct vertical-pills mt-20">
                                <div class="row">
                                    <div class="col-md-2 col-12">
                                        <ul role="tablist" class="nav nav-pills ver-nav-pills" id="myTabs_10">
                                            <li role="presentation"><a aria-expanded="true" data-toggle="tab" role="tab"
                                                    id="home_tab_10" href="#home_10">Academics</a></li>
                                            <li role="presentation" class=""><a data-toggle="tab" id="profile_tab_10"
                                                    role="tab" href="#profile_10" aria-expanded="false">Language
                                                    Proficiency</a></li>
                                            <li role="presentation" class=""><a data-toggle="tab" id="profile_tab_11"
                                                    role="tab" href="#profile_11" aria-expanded="false">Financial</a>
                                            </li>
                                            <li role="presentation" class=""><a data-toggle="tab" id="profile_tab_12"
                                                    role="tab" href="#profile_12" aria-expanded="false">CA Report</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-10 col-12">
                                        <div class="tab-content" id="myTabContent_10">
                                            <div id="home_10" class="tab-pane fade active in" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-md-2 col-4">
                                                        <img src="/ibtcrm//img/new1.png" alt="" width="100%">
                                                    </div>
                                                    <div class="col-md-2 col-4">
                                                        <img src="/ibtcrm//img/new1.png" alt="" width="100%">
                                                    </div>
                                                    <div class="col-md-2 col-4">
                                                        <img src="/ibtcrm//img/new1.png" alt="" width="100%">
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="profile_10" class="tab-pane fade" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-md-2 col-4">
                                                        <img src="/ibtcrm//img/new1.png" alt="" width="100%">
                                                    </div>
                                                    <div class="col-md-2 col-4">
                                                        <img src="/ibtcrm//img/new1.png" alt="" width="100%">
                                                    </div>
                                                    <div class="col-md-2 col-4">
                                                        <img src="/ibtcrm//img/new1.png" alt="" width="100%">
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="profile_11" class="tab-pane fade " role="tabpanel">
                                                <div class="row">
                                                    <div class="col-md-2 col-4">
                                                        <img src="/ibtcrm//img/new1.png" alt="" width="100%">
                                                    </div>
                                                    <div class="col-md-2 col-4">
                                                        <img src="/ibtcrm//img/new1.png" alt="" width="100%">
                                                    </div>
                                                    <div class="col-md-2 col-4">
                                                        <img src="/ibtcrm//img/new1.png" alt="" width="100%">
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="profile_12" class="tab-pane fade" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-md-2 col-4">
                                                        <img src="/ibtcrm//img/new1.png" alt="" width="100%">
                                                    </div>
                                                    <div class="col-md-2 col-4">
                                                        <img src="/ibtcrm//img/new1.png" alt="" width="100%">
                                                    </div>
                                                    <div class="col-md-2 col-4">
                                                        <img src="/ibtcrm//img/new1.png" alt="" width="100%">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="Application" class="tab-pane fade" role="tabpanel">
                            <div class="table-wrap">
                                <div class="table-responsive">
                                    <div id="datable_1_wrapper" class="dataTables_wrapper">

                                        <table id="datable_1" class="table table-hover display  pb-30 dataTable"
                                            role="grid" aria-describedby="datable_1_info">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting_asc" tabindex="0" aria-controls="datable_1"
                                                        rowspan="1" colspan="1" aria-sort="ascending"
                                                        aria-label="Name: activate to sort column descending"
                                                        style="width: 76px;"><span>S.no</span></th>

                                                    <th class="sorting" tabindex="0" aria-controls="datable_1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Position: activate to sort column ascending"
                                                        style="width: 316px;"><span>Institute Name</span></th>
                                                    <th class="sorting_asc" tabindex="0" aria-controls="datable_1"
                                                        rowspan="1" colspan="1" aria-sort="ascending"
                                                        aria-label="Name: activate to sort column descending"
                                                        style="width: 198px;"><span>Location</span></th>
                                                    <th class="sorting" tabindex="0" aria-controls="datable_1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Office: activate to sort column ascending"
                                                        style="width: 198px;"><span>Course</span></th>
                                                    <th class="sorting" tabindex="0" aria-controls="datable_1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Age: activate to sort column ascending"
                                                        style="width: 52px;"><span>Intake</span></th>
                                                    <th class="sorting" tabindex="0" aria-controls="datable_1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Start date: activate to sort column ascending"
                                                        style="width: 102px;"><span>Year</span></th>
                                                    <th class="sorting" tabindex="0" aria-controls="datable_1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Salary: activate to sort column ascending"
                                                        style="width: 146px;"><span>Status</span></th>
                                                    <th class="sorting" tabindex="0" aria-controls="datable_1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Salary: activate to sort column ascending"
                                                        style="width: 106px;"><span
                                                            style="background:#4b4b4d;color:#fff;text-align:center;">Edit</span></th>
                                                </tr>
                                            </thead>
                                            <tfoot>


                                            </tfoot>
                                            <tbody>

                                                <tr class="odd filter_section" style="border-bottom:none;">
                                                    <td rowspan="1" colspan="1"><span></span></th>
                                                    <td rowspan="1" colspan="1"><span></span></th>
                                                    <td rowspan="1" colspan="1"><span></span></th>
                                                    <td rowspan="1" colspan="1"><span></span></th>
                                                    <td rowspan="1" colspan="1"><span></span></th>
                                                    <td rowspan="1" colspan="1"><span></span></th>
                                                    <td rowspan="1" colspan="1"><span></span></th>

                                                </tr>
                                                <tr role="row" class="even">
                                                    <td class="sorting_1">1</td>
                                                    <td>Arkansas State University</td>
                                                    <td>Arkansas</td>
                                                    <td>Computer Engineering</td>
                                                    <td>January</td>
                                                    <td>2023</td>
                                                    <td>
                                                        <div class="form-group">

                                                            <select class="form-control" id="exampleFormControlSelect1">
                                                                <option>Pending</option>
                                                                <option>Approved</option>
                                                                <option>Review</option>
                                                                <option>Process</option>

                                                            </select>
                                                    </td>
                                                    <td><a href=""><img src="/ibtcrm//img/1827951.png" width="20px"
                                                                height="20px"></a></td>

                                                </tr>
                                                <tr role="row" class="even">
                                                    <td class="sorting_1">2</td>
                                                    <td>Arkansas State University</td>
                                                    <td>Arkansas</td>
                                                    <td>Computer Engineering</td>
                                                    <td>January</td>
                                                    <td>2023</td>
                                                    <td>
                                                        <div class="form-group">

                                                            <select class="form-control" id="exampleFormControlSelect1">
                                                                <option>Pending</option>
                                                                <option>Approved</option>
                                                                <option>Review</option>
                                                                <option>Process</option>

                                                            </select>
                                                    </td>
                                                    <td><a href=""><img src="/ibtcrm//img/1827951.png" width="20px"
                                                                height="20px"></a></td>

                                                </tr>
                                                <tr role="row" class="even">
                                                    <td class="sorting_1">3</td>
                                                    <td>Arkansas State University</td>
                                                    <td>Arkansas</td>
                                                    <td>Computer Engineering</td>
                                                    <td>January</td>
                                                    <td>2023</td>
                                                    <td>
                                                        <div class="form-group">

                                                            <select class="form-control" id="exampleFormControlSelect1">
                                                                <option>Pending</option>
                                                                <option>Approved</option>
                                                                <option>Review</option>
                                                                <option>Process</option>

                                                            </select>
                                                    </td>
                                                    <td><a href=""><img src="/ibtcrm//img/1827951.png" width="20px"
                                                                height="20px"></a>


                                                    </td>
                                                </tr>
                                                <tr role="row" class="even">
                                                    <td class="sorting_1">4</td>
                                                    <td>Arkansas State University</td>
                                                    <td>Arkansas</td>
                                                    <td>Computer Engineering</td>
                                                    <td>January</td>
                                                    <td>2023</td>
                                                    <td>
                                                        <div class="form-group">

                                                            <select class="form-control" id="exampleFormControlSelect1">
                                                                <option>Pending</option>
                                                                <option>Approved</option>
                                                                <option>Review</option>
                                                                <option>Process</option>

                                                            </select>
                                                    </td>
                                                    <td><a href=""><img src="/ibtcrm//img/1827951.png" width="20px"
                                                                height="20px"></a>
                                                    </td>


                                                </tr>
                                                <tr role="row" class="even">
                                                    <td class="sorting_1">5</td>
                                                    <td>Arkansas State University</td>
                                                    <td>Arkansas</td>
                                                    <td>Computer Engineering</td>
                                                    <td>January</td>
                                                    <td>2023</td>
                                                    <td>
                                                        <div class="form-group">

                                                            <select class="form-control" id="exampleFormControlSelect1">
                                                                <option>Pending</option>
                                                                <option>Approved</option>
                                                                <option>Review</option>
                                                                <option>Process</option>

                                                            </select>
                                                    </td>
                                                    <td><a href=""><img src="/ibtcrm//img/1827951.png" width="20px"
                                                                height="20px"></a>
                                                    </td>

                                                </tr>

                                            </tbody>

                                        </table>

                                        <div class="dataTables_info" id="datable_1_info" role="status"
                                            aria-live="polite">
                                            Showing 1 to 10 of
                                            57 entries
                                        </div>
                                        <div class="dataTables_paginate paging_simple_numbers" id="datable_1_paginate">
                                            <a class="paginate_button previous disabled" aria-controls="datable_1"
                                                data-dt-idx="0" tabindex="0"
                                                id="datable_1_previous">Previous</a><span><a
                                                    class="paginate_button current" aria-controls="datable_1"
                                                    data-dt-idx="1" tabindex="0">1</a><a class="paginate_button "
                                                    aria-controls="datable_1" data-dt-idx="2" tabindex="0">2</a><a
                                                    class="paginate_button " aria-controls="datable_1" data-dt-idx="3"
                                                    tabindex="0">3</a><a class="paginate_button "
                                                    aria-controls="datable_1" data-dt-idx="4" tabindex="0">4</a><a
                                                    class="paginate_button " aria-controls="datable_1" data-dt-idx="5"
                                                    tabindex="0">5</a><a class="paginate_button "
                                                    aria-controls="datable_1" data-dt-idx="6"
                                                    tabindex="0">6</a></span><a class="paginate_button next"
                                                aria-controls="datable_1" data-dt-idx="7" tabindex="0"
                                                id="datable_1_next">Next</a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="add-application">
                                <button type="submit" class="btn  " style="background:#363e91;
                                   ">Add Application</button>
                            </div>
                        </div>
                        <div id="Status" class="tab-pane fade " role="tabpanel">
                        <div class="table-wrap">
                                <div class="table-responsive">
                                    <div id="datable_1_wrapper" class="dataTables_wrapper">

                                        <table id="datable_1" class="table table-hover display  pb-30 dataTable"
                                            role="grid" aria-describedby="datable_1_info">
                                            <thead>
                                                <tr role="row">
                                                    
                                                <th class="sorting" tabindex="0" aria-controls="datable_1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Start date: activate to sort column ascending"
                                                        style="width: 130px;"><span>Date</span></th>
                                                        <th class="sorting" tabindex="0" aria-controls="datable_1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Start date: activate to sort column ascending"
                                                        style="width: 130px;"><span>Time</span></th>
                                                    <th class="sorting" tabindex="0" aria-controls="datable_1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Position: activate to sort column ascending"
                                                        style="width: 316px;"><span>Stage</span></th>
                                                        <th class="sorting" tabindex="0" aria-controls="datable_1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Position: activate to sort column ascending"
                                                        style="width: 316px;"><span>Status</span></th>
                                                        <th class="sorting" tabindex="0" aria-controls="datable_1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Position: activate to sort column ascending"
                                                        style="width: 316px;"><span>Remarks</span></th>
                                                        <th class="sorting" tabindex="0" aria-controls="datable_1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Position: activate to sort column ascending"
                                                        style="width: 316px;"><span>Added By</span></th>
                                                        
                                                    
                                                    <th class="sorting" tabindex="0" aria-controls="datable_1"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Salary: activate to sort column ascending"
                                                        style="width: 106px;"><span
                                                            style="background:#4b4b4d;color:#fff;text-align:center;">Edit</span></th>
                                                </tr>
                                            </thead>
                                            <tfoot>


                                            </tfoot>
                                            <tbody>

                                                <tr class="odd filter_section" style="border-bottom:none;">
                                                    <td rowspan="1" colspan="1"><span></span></th>
                                                    <td rowspan="1" colspan="1"><span></span></th>
                                                    <td rowspan="1" colspan="1"><span></span></th>
                                                    <td rowspan="1" colspan="1"><span></span></th>
                                                    <td rowspan="1" colspan="1"><span></span></th>
                                                    <td rowspan="1" colspan="1"><span></span></th>
                                                    
                                                </tr>
                                                <tr role="row" class="even">
                                                    <td class="sorting_1">25 Jan 2023</td>
                                                    <td>12:57 PM</td>
                                                    <td>Documents</td>
                                                    <td>Received</td>
                                                    <td>CA Report Pending</td>
                                                    <td>Aman</td>
                                                    
                                                    <td><a href=""><img src="/ibtcrm//img/1827951.png" width="20px"
                                                                height="20px"></a></td>

                                                </tr>
                                                <tr role="row" class="even">
                                                    <td class="sorting_1">25 Jan 2023</td>
                                                    <td>12:57 PM</td>
                                                    <td>Documents</td>
                                                    <td>Received</td>
                                                    <td>CA Report Pending</td>
                                                    <td>Aman</td>
                                                    
                                                    <td><a href=""><img src="/ibtcrm//img/1827951.png" width="20px"
                                                                height="20px"></a></td>

                                                </tr>
                                                <tr role="row" class="even">
                                                    <td class="sorting_1">25 Jan 2023</td>
                                                    <td>12:57 PM</td>
                                                    <td>Documents</td>
                                                    <td>Received</td>
                                                    <td>CA Report Pending</td>
                                                    <td>Aman</td>
                                                    
                                                    <td><a href=""><img src="/ibtcrm//img/1827951.png" width="20px"
                                                                height="20px"></a></td>

                                                </tr>
                                                <tr role="row" class="even">
                                                    <td class="sorting_1">25 Jan 2023</td>
                                                    <td>12:57 PM</td>
                                                    <td>Documents</td>
                                                    <td>Received</td>
                                                    <td>CA Report Pending</td>
                                                    <td>Aman</td>
                                                    
                                                    <td><a href=""><img src="/ibtcrm//img/1827951.png" width="20px"
                                                                height="20px"></a></td>

                                                </tr>
                                                <tr role="row" class="even">
                                                    <td class="sorting_1">25 Jan 2023</td>
                                                    <td>12:57 PM</td>
                                                    <td>Documents</td>
                                                    <td>Received</td>
                                                    <td>CA Report Pending</td>
                                                    <td>Aman</td>
                                                    
                                                    <td><a href=""><img src="/ibtcrm//img/1827951.png" width="20px"
                                                                height="20px"></a></td>

                                                </tr>

                                            </tbody>

                                        </table>

                                        <div class="dataTables_info" id="datable_1_info" role="status"
                                            aria-live="polite">
                                            Showing 1 to 10 of
                                            57 entries
                                        </div>
                                        <div class="dataTables_paginate paging_simple_numbers" id="datable_1_paginate">
                                            <a class="paginate_button previous disabled" aria-controls="datable_1"
                                                data-dt-idx="0" tabindex="0"
                                                id="datable_1_previous">Previous</a><span><a
                                                    class="paginate_button current" aria-controls="datable_1"
                                                    data-dt-idx="1" tabindex="0">1</a><a class="paginate_button "
                                                    aria-controls="datable_1" data-dt-idx="2" tabindex="0">2</a><a
                                                    class="paginate_button " aria-controls="datable_1" data-dt-idx="3"
                                                    tabindex="0">3</a><a class="paginate_button "
                                                    aria-controls="datable_1" data-dt-idx="4" tabindex="0">4</a><a
                                                    class="paginate_button " aria-controls="datable_1" data-dt-idx="5"
                                                    tabindex="0">5</a><a class="paginate_button "
                                                    aria-controls="datable_1" data-dt-idx="6"
                                                    tabindex="0">6</a></span><a class="paginate_button next"
                                                aria-controls="datable_1" data-dt-idx="7" tabindex="0"
                                                id="datable_1_next">Next</a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="add-application">
                                <button type="submit" class="btn  " style="background:#363e91;
                                   ">Add Status</button>
                            </div>
                        </div>
                        <div id="Notes" class="tab-pane fade" role="tabpanel">
                        <div class="panel panel-default card-view">
								<div class="panel-heading">
									
									<div class="clearfix"></div>
								</div>
								<div class="panel-wrapper collapse in">
									<div class="panel-body">
										<div class="panel-group accordion-struct accordion-style-1" id="accordion_2" role="tablist" aria-multiselectable="true">
											<div class="panel panel-default">
                                                
												<div class="panel-heading activestate" role="tab" id="heading_10">
													<a role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapse_10" aria-expanded="false" class="collapsed"><span style="font-weight:bold;">Harsha Goal</span> - Missing Documents</a> 
												</div>
												<div id="collapse_10" class="panel-collapse collapse in" role="tabpanel" aria-expanded="true" style="height: 93px;">
													<div class="panel-body pa-15"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer la. </div>
												</div>
											</div>
											<div class="panel panel-default">
												<div class="panel-heading" role="tab" id="heading_11">
													<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapse_11" aria-expanded="false"><span style="font-weight:bold;">Harsha Goal </span> -Missing Documents</a>
												</div>
												<div id="collapse_11" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
													<div class="panel-body pa-15"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, </div>
												</div>
											</div>
											<div class="panel panel-default">
												<div class="panel-heading" role="tab" id="heading_12">
													<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_2" href="#collapse_12" aria-expanded="false"><span style="font-weight:bold;">Harsha Goal </span> - Missing Documents</a>
												</div>
												<div id="collapse_12" class="panel-collapse collapse" role="tabpanel" aria-expanded="false">
													<div class="panel-body pa-15"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, inable VHS. </div>
												</div>
											</div>
											
										</div>
									</div>
								</div>
							</div>
                        </div>
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
    /*Accordion js*/
        $(document).on('show.bs.collapse', '.panel-collapse', function (e) {
        $(this).siblings('.panel-heading').addClass('activestate');
    });
    
    $(document).on('hide.bs.collapse', '.panel-collapse', function (e) {
        $(this).siblings('.panel-heading').removeClass('activestate');
    });
    $(".panel-heading").on("click", function() {
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
	
	$(document).on('click','.product-carousel .owl-nav',function(e){
		return false;
	});
	
	$(document).on('click', 'body', function (e) {
		if($(e.target).closest('.fixed-sidebar-right,.setting-panel').length > 0) {
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
	

	$(document).on("mouseenter mouseleave",".wrapper > .fixed-sidebar-left", function(e) {
		if (e.type == "mouseenter") {
			$wrapper.addClass("sidebar-hover"); 
		}
		else { 
			$wrapper.removeClass("sidebar-hover");  
		}
		return false;
	});
	
	$(document).on("mouseenter mouseleave",".wrapper > .setting-panel", function(e) {
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