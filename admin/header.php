<?php
$page = basename($_SERVER["SCRIPT_FILENAME"], '.php');
include "includes/config.php";
include "includes/helper.php";
if(!isset($_SESSION['user_id'])){
    $current_url = @end(explode('/',$_SERVER['REQUEST_URI']));
    if($current_url == 'index.php'){
        header('location:logout.php');
    }else{
        header('location:logout.php?url='.$current_url);
    }
}else{
    /*if(isset($_GET['url'])){
        echo '<script>window.location.replace("'.$_GET["url"].'");</script>';
        //location('header:'.$_GET['url']);
    }*/
}
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Gamalek Store - جمالك ستور | Admin Panel - لوحة التحكم</title>
    <link rel="icon" href="dist/img/sales_icon.png" type="image/gif" sizes="16x16">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons 2.0.0 -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="plugins/morris/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker-bs3.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">

    <link rel="stylesheet" href="dist/fonts/fonts-fa.css">
    <link rel="stylesheet" href="dist/css/bootstrap-rtl.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .text_align_center
        {
            text-align: center !important;
        }
        .alert{
            text-align: center !important;
        }
        .dataTables_empty{
            text-align: center !important;
            background: indianred;
            color: #ffffff;
        }
        select{
            height: 40px !important;
        }
    </style>
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper">

    <header class="main-header bg-maroon">
        <!-- Logo -->
        <a href="/admin" class="logo bg-maroon">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>GA</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>GAMALEK</b>Admin</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <?php include "navbar.php";?>
    </header>
    <?php include_once 'aside.php'; ?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

