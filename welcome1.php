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
<!--  -->
        <?php include("menu.php"); ?>
        <!-- /Top Menu Items -->
        <!-- Main Content -->
        <div class="page-wrapper">

        <div class="container-fluid pt-25">
                <!-- Row -->
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <span class="txt-dark block counter"><span class="counter-anim">914,001</span></span>
                                                    <span class="weight-500 uppercase-font block font-13">visits</span>
                                                </div>
                                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                    <i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
                                                </div>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <span class="txt-dark block counter"><span class="counter-anim">46.41</span>%</span>
                                                    <span class="weight-500 uppercase-font block">bounce rate</span>
                                                </div>
                                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                    <i class="icon-control-rewind data-right-rep-icon txt-light-grey"></i>
                                                </div>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <span class="txt-dark block counter"><span class="counter-anim">4,054,876</span></span>
                                                    <span class="weight-500 uppercase-font block">pageviews</span>
                                                </div>
                                                <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                                    <i class="icon-layers data-right-rep-icon txt-light-grey"></i>
                                                </div>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="panel panel-default card-view pa-0">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body pa-0">
                                    <div class="sm-data-box">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                                    <span class="txt-dark block counter"><span class="counter-anim">46.43</span>%</span>
                                                    <span class="weight-500 uppercase-font block">growth rate</span>
                                                </div>
                                                <div class="col-xs-6 text-center  pl-0 pr-0 pt-25  data-wrap-right">
                                                    <div id="sparkline_4" style="width: 100px; overflow: hidden; margin: 0px auto;"><canvas width="115" height="50" style="display: inline-block; width: 115px; height: 50px; vertical-align: top;"></canvas></div>
                                                </div>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Row -->
                
                <!-- Row -->
                <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                        <div class="panel panel-default card-view">
                            <div class="panel-heading">
                                <div class="pull-left">
                                    <h6 class="panel-title txt-dark">user statistics</h6>
                                </div>
                                <div class="pull-right">
                                    <span class="no-margin-switcher">
                                        <input type="checkbox" checked="" id="morris_switch" class="js-switch" data-color="#2ecd99" data-secondary-color="#dedede" data-size="small" data-switchery="true" style="display: none;"><span class="switchery switchery-small" style="background-color: rgb(46, 205, 153); border-color: rgb(46, 205, 153); box-shadow: rgb(46, 205, 153) 0px 0px 0px 11px inset; transition: border 0.4s ease 0s, box-shadow 0.4s ease 0s, background-color 1.2s ease 0s;"><small style="left: 13px; background-color: rgb(255, 255, 255); transition: background-color 0.4s ease 0s, left 0.2s ease 0s;"></small></span>   
                                    </span> 
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <div id="area_chart" class="morris-chart" style="height: 293px; position: relative; -webkit-tap-highlight-color: rgba(0, 0, 0, 0);"><svg height="293" version="1.1" width="583" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="overflow: hidden; position: relative;"><desc style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Created with Raphaël 2.2.0</desc><defs style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></defs><text x="35.10398864746094" y="251" text-anchor="end" font-family="Poppins" font-size="12px" stroke="none" fill="#878787" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: Poppins; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">0</tspan></text><text x="35.10398864746094" y="194.5" text-anchor="end" font-family="Poppins" font-size="12px" stroke="none" fill="#878787" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: Poppins; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">75</tspan></text><text x="35.10398864746094" y="138" text-anchor="end" font-family="Poppins" font-size="12px" stroke="none" fill="#878787" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: Poppins; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">150</tspan></text><text x="35.10398864746094" y="81.5" text-anchor="end" font-family="Poppins" font-size="12px" stroke="none" fill="#878787" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: Poppins; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">225</tspan></text><text x="35.10398864746094" y="25" text-anchor="end" font-family="Poppins" font-size="12px" stroke="none" fill="#878787" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: end; font-family: Poppins; font-size: 12px; font-weight: normal;" font-weight="normal"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">300</tspan></text><text x="558" y="263.5" text-anchor="middle" font-family="Poppins" font-size="12px" stroke="none" fill="#878787" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Poppins; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,8.5)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Sat</tspan></text><text x="472.93399810791016" y="263.5" text-anchor="middle" font-family="Poppins" font-size="12px" stroke="none" fill="#878787" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Poppins; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,8.5)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Fri</tspan></text><text x="387.8679962158203" y="263.5" text-anchor="middle" font-family="Poppins" font-size="12px" stroke="none" fill="#878787" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Poppins; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,8.5)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Thu</tspan></text><text x="302.80199432373047" y="263.5" text-anchor="middle" font-family="Poppins" font-size="12px" stroke="none" fill="#878787" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Poppins; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,8.5)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Wed</tspan></text><text x="217.73599243164062" y="263.5" text-anchor="middle" font-family="Poppins" font-size="12px" stroke="none" fill="#878787" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Poppins; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,8.5)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Tue</tspan></text><text x="132.66999053955078" y="263.5" text-anchor="middle" font-family="Poppins" font-size="12px" stroke="none" fill="#878787" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Poppins; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,8.5)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Mon</tspan></text><text x="47.60398864746094" y="263.5" text-anchor="middle" font-family="Poppins" font-size="12px" stroke="none" fill="#878787" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); text-anchor: middle; font-family: Poppins; font-size: 12px; font-weight: normal;" font-weight="normal" transform="matrix(1,0,0,1,0,8.5)"><tspan dy="4" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);">Son</tspan></text><path fill="#5bd2ab" stroke="none" d="M47.60398864746094,243.46666666666667C68.8704891204834,220.86666666666667,111.40349006652832,159.65833333333333,132.66999053955078,153.06666666666666C153.93649101257324,146.475,196.46949195861816,185.08333333333334,217.73599243164062,190.73333333333335C239.0024929046631,196.38333333333335,281.535493850708,207.6833333333333,302.80199432373047,198.26666666666665C324.06849479675293,188.85,366.60149574279785,118.69583333333334,387.8679962158203,115.4C409.1344966888428,112.10416666666667,451.6674976348877,178.49166666666667,472.93399810791016,171.9C494.2004985809326,165.30833333333334,536.7334995269775,89.97500000000002,558,62.666666666666686L558,251L47.60398864746094,251Z" fill-opacity="0.6" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 0.6;"></path><path fill="none" stroke="#2ecd99" d="M47.60398864746094,243.46666666666667C68.8704891204834,220.86666666666667,111.40349006652832,159.65833333333333,132.66999053955078,153.06666666666666C153.93649101257324,146.475,196.46949195861816,185.08333333333334,217.73599243164062,190.73333333333335C239.0024929046631,196.38333333333335,281.535493850708,207.6833333333333,302.80199432373047,198.26666666666665C324.06849479675293,188.85,366.60149574279785,118.69583333333334,387.8679962158203,115.4C409.1344966888428,112.10416666666667,451.6674976348877,178.49166666666667,472.93399810791016,171.9C494.2004985809326,165.30833333333334,536.7334995269775,89.97500000000002,558,62.666666666666686" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><circle cx="47.60398864746094" cy="243.46666666666667" r="0" fill="#2ecd99" stroke="#2ecd99" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="132.66999053955078" cy="153.06666666666666" r="0" fill="#2ecd99" stroke="#2ecd99" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="217.73599243164062" cy="190.73333333333335" r="0" fill="#2ecd99" stroke="#2ecd99" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="302.80199432373047" cy="198.26666666666665" r="0" fill="#2ecd99" stroke="#2ecd99" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="387.8679962158203" cy="115.4" r="0" fill="#2ecd99" stroke="#2ecd99" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="472.93399810791016" cy="171.9" r="0" fill="#2ecd99" stroke="#2ecd99" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="558" cy="62.666666666666686" r="0" fill="#2ecd99" stroke="#2ecd99" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><path fill="#89bbe8" stroke="none" d="M47.60398864746094,190.73333333333335C68.8704891204834,186.9666666666667,111.40349006652832,170.95833333333334,132.66999053955078,175.66666666666669C153.93649101257324,180.37500000000003,196.46949195861816,237.81666666666666,217.73599243164062,228.4C239.0024929046631,218.98333333333335,281.535493850708,102.21666666666667,302.80199432373047,100.33333333333334C324.06849479675293,98.45000000000002,366.60149574279785,210.50833333333335,387.8679962158203,213.33333333333334C409.1344966888428,216.15833333333333,451.6674976348877,132.35,472.93399810791016,122.93333333333334C494.2004985809326,113.51666666666667,536.7334995269775,134.23333333333335,558,138L558,251L47.60398864746094,251Z" fill-opacity="0.6" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 0.6;"></path><path fill="none" stroke="#4e9de6" d="M47.60398864746094,190.73333333333335C68.8704891204834,186.9666666666667,111.40349006652832,170.95833333333334,132.66999053955078,175.66666666666669C153.93649101257324,180.37500000000003,196.46949195861816,237.81666666666666,217.73599243164062,228.4C239.0024929046631,218.98333333333335,281.535493850708,102.21666666666667,302.80199432373047,100.33333333333334C324.06849479675293,98.45000000000002,366.60149574279785,210.50833333333335,387.8679962158203,213.33333333333334C409.1344966888428,216.15833333333333,451.6674976348877,132.35,472.93399810791016,122.93333333333334C494.2004985809326,113.51666666666667,536.7334995269775,134.23333333333335,558,138" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><circle cx="47.60398864746094" cy="190.73333333333335" r="0" fill="#4e9de6" stroke="#4e9de6" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="132.66999053955078" cy="175.66666666666669" r="0" fill="#4e9de6" stroke="#4e9de6" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="217.73599243164062" cy="228.4" r="0" fill="#4e9de6" stroke="#4e9de6" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="302.80199432373047" cy="100.33333333333334" r="0" fill="#4e9de6" stroke="#4e9de6" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="387.8679962158203" cy="213.33333333333334" r="0" fill="#4e9de6" stroke="#4e9de6" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="472.93399810791016" cy="122.93333333333334" r="0" fill="#4e9de6" stroke="#4e9de6" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="558" cy="138" r="0" fill="#4e9de6" stroke="#4e9de6" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><path fill="#eed380" stroke="none" d="M47.60398864746094,235.93333333333334C68.8704891204834,224.63333333333333,111.40349006652832,195.4416666666667,132.66999053955078,190.73333333333335C153.93649101257324,186.025,196.46949195861816,203.91666666666666,217.73599243164062,198.26666666666665C239.0024929046631,192.61666666666665,281.535493850708,152.125,302.80199432373047,145.53333333333333C324.06849479675293,138.94166666666666,366.60149574279785,139.88333333333333,387.8679962158203,145.53333333333333C409.1344966888428,151.18333333333334,451.6674976348877,196.38333333333335,472.93399810791016,190.73333333333335C494.2004985809326,185.08333333333334,536.7334995269775,122.93333333333334,558,100.33333333333334L558,251L47.60398864746094,251Z" fill-opacity="0.6" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0); fill-opacity: 0.6;"></path><path fill="none" stroke="#f0c541" d="M47.60398864746094,235.93333333333334C68.8704891204834,224.63333333333333,111.40349006652832,195.4416666666667,132.66999053955078,190.73333333333335C153.93649101257324,186.025,196.46949195861816,203.91666666666666,217.73599243164062,198.26666666666665C239.0024929046631,192.61666666666665,281.535493850708,152.125,302.80199432373047,145.53333333333333C324.06849479675293,138.94166666666666,366.60149574279785,139.88333333333333,387.8679962158203,145.53333333333333C409.1344966888428,151.18333333333334,451.6674976348877,196.38333333333335,472.93399810791016,190.73333333333335C494.2004985809326,185.08333333333334,536.7334995269775,122.93333333333334,558,100.33333333333334" stroke-width="0" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></path><circle cx="47.60398864746094" cy="235.93333333333334" r="0" fill="#f0c541" stroke="#f0c541" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="132.66999053955078" cy="190.73333333333335" r="0" fill="#f0c541" stroke="#f0c541" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="217.73599243164062" cy="198.26666666666665" r="0" fill="#f0c541" stroke="#f0c541" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="302.80199432373047" cy="145.53333333333333" r="0" fill="#f0c541" stroke="#f0c541" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="387.8679962158203" cy="145.53333333333333" r="0" fill="#f0c541" stroke="#f0c541" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="472.93399810791016" cy="190.73333333333335" r="0" fill="#f0c541" stroke="#f0c541" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle><circle cx="558" cy="100.33333333333334" r="0" fill="#f0c541" stroke="#f0c541" stroke-width="1" style="-webkit-tap-highlight-color: rgba(0, 0, 0, 0);"></circle></svg><div class="morris-hover morris-default-style" style="left: 265.802px; top: 94px; display: none;"><div class="morris-hover-row-label">Wed</div><div class="morris-hover-point" style="color: #2ecd99">
  iphone:
  70
</div><div class="morris-hover-point" style="color: #4e9de6">
  ipad:
  200
</div><div class="morris-hover-point" style="color: #f0c541">
  itouch:
  140
</div></div></div>
                                    <ul class="flex-stat mt-40">
                                        <li>
                                            <span class="block">Weekly Users</span>
                                            <span class="block txt-dark weight-500 font-18"><span class="counter-anim">324,222</span></span>
                                        </li>
                                        <li>
                                            <span class="block">Monthly Users</span>
                                            <span class="block txt-dark weight-500 font-18"><span class="counter-anim">123,432</span></span>
                                        </li>
                                        <li>
                                            <span class="block">Trend</span>
                                            <span class="block">
                                                <i class="zmdi zmdi-trending-up txt-success font-24"></i>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="panel panel-default card-view">
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body sm-data-box-1">
                                    <span class="uppercase-font weight-500 font-14 block text-center txt-dark">customer satisfaction</span> 
                                    <div class="cus-sat-stat weight-500 txt-success text-center mt-5">
                                        <span class="counter-anim">93.13</span><span>%</span>
                                    </div>
                                    <div class="progress-anim mt-20">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success wow animated progress-animated" role="progressbar" aria-valuenow="93.12" aria-valuemin="0" aria-valuemax="100" style="width: 93.12%;"></div>
                                        </div>
                                    </div>
                                    <ul class="flex-stat mt-5">
                                        <li>
                                            <span class="block">Previous</span>
                                            <span class="block txt-dark weight-500 font-15">79.82</span>
                                        </li>
                                        <li>
                                            <span class="block">% Change</span>
                                            <span class="block txt-dark weight-500 font-15">+14.29</span>
                                        </li>
                                        <li>
                                            <span class="block">Trend</span>
                                            <span class="block">
                                                <i class="zmdi zmdi-trending-up txt-success font-20"></i>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default card-view">
                            <div class="panel-heading">
                                <div class="pull-left">
                                    <h6 class="panel-title txt-dark">browser stats</h6>
                                </div>
                                <div class="pull-right">
                                    <a href="#" class="pull-left inline-block mr-15">
                                        <i class="zmdi zmdi-download"></i>
                                    </a>
                                    <a href="#" class="pull-left inline-block close-panel" data-effect="fadeOut">
                                        <i class="zmdi zmdi-close"></i>
                                    </a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <div>
                                        <span class="pull-left inline-block capitalize-font txt-dark">
                                            google chrome
                                        </span>
                                        <span class="label label-warning pull-right">50%</span>
                                        <div class="clearfix"></div>
                                        <hr class="light-grey-hr row mt-10 mb-10">
                                        <span class="pull-left inline-block capitalize-font txt-dark">
                                            mozila firefox
                                        </span>
                                        <span class="label label-danger pull-right">10%</span>
                                        <div class="clearfix"></div>
                                        <hr class="light-grey-hr row mt-10 mb-10">
                                        <span class="pull-left inline-block capitalize-font txt-dark">
                                            Internet explorer
                                        </span>
                                        <span class="label label-success pull-right">30%</span>
                                        <div class="clearfix"></div>
                                        <hr class="light-grey-hr row mt-10 mb-10">
                                        <span class="pull-left inline-block capitalize-font txt-dark">
                                            safari
                                        </span>
                                        <span class="label label-primary pull-right">10%</span>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                       <div class="panel panel-default card-view panel-refresh">
                            <div class="refresh-container">
                                <div class="la-anim-1"></div>
                            </div>
                            <div class="panel-heading">
                                <div class="pull-left">
                                    <h6 class="panel-title txt-dark">Visit by Traffic Types</h6>
                                </div>
                                <div class="pull-right">
                                    <a href="#" class="pull-left inline-block refresh mr-15">
                                        <i class="zmdi zmdi-replay"></i>
                                    </a>
                                    <div class="pull-left inline-block dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
                                        <ul class="dropdown-menu bullet dropdown-menu-right" role="menu">
                                            <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>Devices</a></li>
                                            <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>General</a></li>
                                            <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>Referral</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <div><iframe class="chartjs-hidden-iframe" style="width: 100%; display: block; border: 0px; height: 0px; margin: 0px; position: absolute; inset: 0px;"></iframe>
                                        <canvas id="chart_6" height="191" width="266" style="display: block; width: 266px; height: 191px;"></canvas>
                                    </div>  
                                    <hr class="light-grey-hr row mt-10 mb-15">
                                    <div class="label-chatrs">
                                        <div class="">
                                            <span class="clabels clabels-lg inline-block bg-blue mr-10 pull-left"></span>
                                            <span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left"><span class="block font-15 weight-500 mb-5">44.46% organic</span><span class="block txt-grey">356 visits</span></span>
                                            <div id="sparkline_1" class="pull-right" style="width: 100px; overflow: hidden; margin: 0px auto;"><canvas width="100" height="35" style="display: inline-block; width: 100px; height: 35px; vertical-align: top;"></canvas></div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <hr class="light-grey-hr row mt-10 mb-15">
                                    <div class="label-chatrs">
                                        <div class="">
                                            <span class="clabels clabels-lg inline-block bg-green mr-10 pull-left"></span>
                                            <span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left"><span class="block font-15 weight-500 mb-5">5.54% Refrral</span><span class="block txt-grey">36 visits</span></span>
                                            <div id="sparkline_2" class="pull-right" style="width: 100px; overflow: hidden; margin: 0px auto;"><canvas width="100" height="35" style="display: inline-block; width: 100px; height: 35px; vertical-align: top;"></canvas></div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <hr class="light-grey-hr row mt-10 mb-15">
                                    <div class="label-chatrs">
                                        <div class="">
                                            <span class="clabels clabels-lg inline-block bg-yellow mr-10 pull-left"></span>
                                            <span class="clabels-text font-12 inline-block txt-dark capitalize-font pull-left"><span class="block font-15 weight-500 mb-5">50% Other</span><span class="block txt-grey">245 visits</span></span>
                                            <div id="sparkline_3" class="pull-right" style="width: 100px; overflow: hidden; margin: 0px auto;"><canvas width="100" height="35" style="display: inline-block; width: 100px; height: 35px; vertical-align: top;"></canvas></div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Row -->
                
                <!-- Row -->
                <div class="row">
                    <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12">
                        <div class="panel panel-default card-view panel-refresh">
                            <div class="refresh-container">
                                <div class="la-anim-1"></div>
                            </div>
                            <div class="panel-heading">
                                <div class="pull-left">
                                    <h6 class="panel-title txt-dark">social campaigns</h6>
                                </div>
                                <div class="pull-right">
                                    <a href="#" class="pull-left inline-block refresh mr-15">
                                        <i class="zmdi zmdi-replay"></i>
                                    </a>
                                    <a href="#" class="pull-left inline-block full-screen mr-15">
                                        <i class="zmdi zmdi-fullscreen"></i>
                                    </a>
                                    <div class="pull-left inline-block dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
                                        <ul class="dropdown-menu bullet dropdown-menu-right" role="menu">
                                            <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>Edit</a></li>
                                            <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>Delete</a></li>
                                            <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>New</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body row pa-0">
                                    <div class="table-wrap">
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Campaign</th>
                                                        <th>Client</th>
                                                        <th>Changes</th>
                                                        <th>Budget</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><span class="txt-dark weight-500">Facebook</span></td>
                                                        <td>Beavis</td>
                                                        <td><span class="txt-success"><i class="zmdi zmdi-caret-up mr-10 font-20"></i><span>2.43%</span></span></td>
                                                        <td>
                                                            <span class="txt-dark weight-500">$1478</span>
                                                        </td>
                                                        <td>
                                                            <span class="label label-primary">Active</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="txt-dark weight-500">Youtube</span></td>
                                                        <td>Felix</td>
                                                        <td><span class="txt-success"><i class="zmdi zmdi-caret-up mr-10 font-20"></i><span>1.43%</span></span></td>
                                                        <td>
                                                            <span class="txt-dark weight-500">$951</span>
                                                        </td>
                                                        <td>
                                                            <span class="label label-danger">Closed</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="txt-dark weight-500">Twitter</span></td>
                                                        <td>Cannibus</td>
                                                        <td><span class="txt-danger"><i class="zmdi zmdi-caret-down mr-10 font-20"></i><span>-8.43%</span></span></td>
                                                        <td>
                                                            <span class="txt-dark weight-500">$632</span>
                                                        </td>
                                                        <td>
                                                            <span class="label label-default">Hold</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="txt-dark weight-500">Spotify</span></td>
                                                        <td>Neosoft</td>
                                                        <td><span class="txt-success"><i class="zmdi zmdi-caret-up mr-10 font-20"></i><span>7.43%</span></span></td>
                                                        <td>
                                                            <span class="txt-dark weight-500">$325</span>
                                                        </td>
                                                        <td>
                                                            <span class="label label-default">Hold</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><span class="txt-dark weight-500">Instagram</span></td>
                                                        <td>Hencework</td>
                                                        <td><span class="txt-success"><i class="zmdi zmdi-caret-up mr-10 font-20"></i><span>9.43%</span></span></td>
                                                        <td>
                                                            <span class="txt-dark weight-500">$258</span>
                                                        </td>
                                                        <td>
                                                            <span class="label label-primary">Active</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>  
                                </div>  
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
                        <div class="panel panel-default card-view panel-refresh">
                            <div class="refresh-container">
                                <div class="la-anim-1"></div>
                            </div>
                            <div class="panel-heading">
                                <div class="pull-left">
                                    <h6 class="panel-title txt-dark">Advertising &amp; Promotions</h6>
                                </div>
                                <div class="pull-right">
                                    <a href="#" class="pull-left inline-block refresh mr-15">
                                        <i class="zmdi zmdi-replay"></i>
                                    </a>
                                    <div class="pull-left inline-block dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false" role="button"><i class="zmdi zmdi-more-vert"></i></a>
                                        <ul class="dropdown-menu bullet dropdown-menu-right" role="menu">
                                            <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-reply" aria-hidden="true"></i>option 1</a></li>
                                            <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-share" aria-hidden="true"></i>option 2</a></li>
                                            <li role="presentation"><a href="javascript:void(0)" role="menuitem"><i class="icon wb-trash" aria-hidden="true"></i>option 3</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    <div><iframe class="chartjs-hidden-iframe" style="width: 100%; display: block; border: 0px; height: 0px; margin: 0px; position: absolute; inset: 0px;"></iframe>
                                        <canvas id="chart_2" height="253" width="372" style="display: block; width: 372px; height: 253px;"></canvas>
                                    </div>  
                                    <div class="label-chatrs mt-30">
                                        <div class="inline-block mr-15">
                                            <span class="clabels inline-block bg-yellow mr-5"></span>
                                            <span class="clabels-text font-12 inline-block txt-dark capitalize-font">Active</span>
                                        </div>
                                        <div class="inline-block mr-15">
                                            <span class="clabels inline-block bg-blue mr-5"></span>
                                            <span class="clabels-text font-12 inline-block txt-dark capitalize-font">Closed</span>
                                        </div>  
                                        <div class="inline-block">
                                            <span class="clabels inline-block bg-green mr-5"></span>
                                            <span class="clabels-text font-12 inline-block txt-dark capitalize-font">Hold</span>
                                        </div>                                          
                                    </div>
                                </div>
                            </div>  
                        </div>  
                    </div>  
                </div>  
                <!-- Row -->
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


<!-- Mirrored from hencework.com/theme/philbert/full-width-light/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 04 May 2023 05:25:18 GMT -->
<script type="text/javascript">


</script>

</html>