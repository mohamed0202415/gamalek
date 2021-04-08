<?php
ob_start();
include "includes/config.php";
include "includes/helper.php";
$page = basename($_SERVER["SCRIPT_FILENAME"], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gamalek Store |  جمالك ستور</title>

    <!-- Font awesome -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- SmartMenus jQuery Bootstrap Addon CSS -->
    <link href="css/jquery.smartmenus.bootstrap.css" rel="stylesheet">
    <!-- Product view slider -->
    <link rel="stylesheet" type="text/css" href="css/jquery.simpleLens.css">
    <!-- slick slider -->
    <link rel="stylesheet" type="text/css" href="css/slick.css">
    <!-- price picker slider -->
    <link rel="stylesheet" type="text/css" href="css/nouislider.css">
    <!-- Theme color -->
    <link id="switcher" href="css/theme-color/default-theme.css" rel="stylesheet">
    <!-- <link id="switcher" href="css/theme-color/bridge-theme.css" rel="stylesheet"> -->
    <!-- Top Slider CSS -->
    <link href="css/sequence-theme.modern-slide-in.css" rel="stylesheet" media="all">

    <!-- Main style sheet -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Google Font -->
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <?php if ($page == 'product' || $page == 'index') {
    } else { ?>
        <style>
            * {
                direction: rtl !important;
            }
        </style>
    <?php } ?>
    <style>
        .search-box {
            width: 300px;
            position: relative;
            display: inline-block;
            font-size: 14px;
        }

        .search-box input[type="text"] {
            height: 32px;
            padding: 5px 10px;
            border: 1px solid #CCCCCC;
            font-size: 14px;
        }

        .result {
            position: absolute;
            z-index: 999;
            top: 100%;
            left: 0;
        }

        .search-box input[type="text"], .result {
            width: 100%;
            box-sizing: border-box;
        }

        /* Formatting result items */
        .result p {
            margin: 0;
            padding: 7px 10px;
            border: 1px solid #CCCCCC;
            border-top: none;
            cursor: pointer;
            background-color: #fff;
        }

        .result p:hover {
            background: #ff6666;
        }
    </style>
</head>
<body class="body">
<!-- wpf loader Two -->
<?php /*
 <div id="wpf-loader-two">
    <div class="wpf-loader-two-inner">
        <span>Loading</span>
    </div>
</div> */ ?>
<!-- / wpf loader Two -->
<!-- SCROLL TOP BUTTON -->
<a class="scrollToTop" href="#"><i class="fa fa-chevron-up"></i></a>
<!-- END SCROLL TOP BUTTON -->


<!-- Start header section -->
<header id="aa-header">
    <!-- start header bottom  -->
    <div class="aa-header-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="aa-header-bottom-area">
                        <!-- logo  -->
                        <div class="aa-logo pull-right">
                            <!-- Text based logo -->
                            <a href="index.php">
                                <!--                                <span class="fa fa-shopping-cart pull-right"></span>-->
                                <img width="85px" src="img/gamalek.png"/>
                                <p style="padding-top:20px "><strong>جمالك&nbsp;</strong>ستور <span>جمالك انتى</span>
                                </p>
                            </a>
                            <!-- img based logo -->
                            <!-- <a href="index.html"><img src="img/logo.jpg" alt="logo img"></a> -->
                        </div>
                        <!-- / logo  -->
                        <!-- cart box -->
                        <div class="aa-cartbox pull-left">
                            <a class="aa-cart-link" href="cart.php">
                                <span class="fa fa-shopping-basket"></span>
                                <span class="aa-cart-title">سلة المشتريات</span>
                                <?php $products_in_cart=0;
                                @session_start();
                                if(isset($_SESSION['cart'])){$products_in_cart = count($_SESSION['cart']); }?>
                                <span class="aa-cart-notify" style="<?php if($products_in_cart && $products_in_cart>0){echo "display:block;";}else{echo 'display:none;';}?>margin-top:30px;margin-right:20px"><?php if($products_in_cart){echo $products_in_cart;} ?></span>
                            </a>

                        </div>
                        <!-- / cart box -->
                        <!-- search box -->
                        <div class="aa-search-box search-box" style="direction: rtl !important;">
                            <input type="text" autocomplete="off" name="search" id="search"
                                   placeholder="ادخل اسم المنتج">
                            <button type="button"><span class="fa fa-search"></span></button>
                            <!--                            <a id="href" style="position:absolute;height: 40px;border-radius: 0;border-color: #ff6666;background-color: #ff6666" class="btn btn-danger"><span class="fa fa-search"></span></a>-->
                            <div class="result"></div>
                        </div>
                        <!-- / search box -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / header bottom  -->
</header>
<!-- / header section -->
<!-- menu -->
<?php include "menu.php"; ?>
<!-- / menu -->
