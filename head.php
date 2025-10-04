<?php
if(basename($_SERVER['SCRIPT_NAME'])!='add-fee.php' && isset($_SESSION['visa_type_session'])){
    unset($_SESSION['visa_type_session']);
}
?>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<title><?php echo SITE_TITLE; ?> | Dashboard</title>
<meta name="description" content="IBT CRM" />
<meta name="keywords" content="admin, admin dashboard, admin template, cms, crm, Philbert Admin, Philbertadmin, premium admin templates, responsive admin, sass, panel, software, ui, visualization, web app, application" />
<meta name="author" content="hencework"/>
<link rel="shortcut icon" href="img/ico.png" type="image/vnd.microsoft.icon" >
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link href="vendors/bower_components/morris.js/morris.css" rel="stylesheet" type="text/css"/>
<link href="vendors/bower_components/datatables/media/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>

<link href="dist/css/style.css" rel="stylesheet" type="text/css">
<link href="vendors/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" type="text/css"/>
<link href="vendors/bower_components/FooTable/compiled/footable.bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css" rel="stylesheet" type="text/css">

<link href="dist/css/style-new.css" rel="stylesheet" type="text/css">
<link href="dist/css/style-new.css" rel="stylesheet" type="text/css">
<link href="dist/css/themify-icons.css" rel="stylesheet" type="text/css">
<link href="dist/css/simple-line-icons.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
 <link rel="stylesheet" href="dist/css/custom.css">
<link rel="stylesheet" href="dist/css/select2.min.css">
<script src="vendors/bower_components/jquery/dist/jquery.min.js"></script>
<script src="vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<link  href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">



