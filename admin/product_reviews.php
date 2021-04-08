<?php include 'header.php';
$product = get_row($db, 'products', 'id', $_GET['id']);
$select = $db->prepare("select * from reviews where product_id = ?");
$select->execute([$_GET['id']]);
$reviews = $select->fetchAll(PDO::FETCH_ASSOC);
?>
<section class="content-header">
    <h1>
        تقييمات المنتجات
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a href="products.php.php"> المنتجات</a></li>
        <li class="active"><a href="reviews.php"> تقييمات المنتجات</a></li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-header" style="direction: rtl !important;padding: 0">
            <h3 class="box-title col-sm-4 col-xs-6 pull-right" style="padding: 8px 5px">تقييمات المنتج
                / <?php echo $product['name']; ?></h3>
            <span class="col-sm-4 col-xs-6 btn bg-maroon btn-flat">عدد التقييمات : <?php echo count($reviews); ?></span>
            <span class="col-sm-4 col-xs-6 btn bg-navy btn-flat">متوسط التقييمات : <?php echo 1; ?></span>
        </div>
        <style>
            a.list-group-item {
                height: auto;
                min-height: 100px;
            }
            a.list-group-item.active small {
                color: #fff;
            }

            .stars {
                margin: 20px auto 1px;
            }
        </style>
        <div class="box-body">
            <?php foreach ($reviews as $item) { ?>
                <div class="well" style="padding: 0;margin-bottom: 0;">
                    <div class="list-group">
                        <a class="list-group-item">
                            <div class="col-md-9">
                                <p class="list-group-item-heading"
                                   style="font-size:20px;font-weight:bold;float: right;"> <?php echo $item['name']; ?> </p>
                                <span
                                        style="color:#ff6666;font-size: 11px;float: right;padding-right: 15px;padding-top: 10px"><?php echo '&nbsp;' . $item['user_ip'] . ' : ' . $item['user_os'] . ' : ' . $item['user_browser']; ?></span>
                                <br/>
                                <hr style="margin: 15px 0 5px 0"/>
                                <p class="list-group-item-text"> <?php echo $item['review']; ?>
                                </p>
                            </div>
                            <div class="col-md-3 text-center">
                                <div class="stars" style="margin: 20px 0">
                                    <?php $remain_stars = 5 - $item['stars'];
                                    for ($i = 1; $i <= $item['stars']; $i++) {
                                        echo '<i class="fa fa-star-o" style="font-size:20px;color:orange"></i>';
                                    }
                                    for ($i = 1; $i <= $remain_stars; $i++) {
                                        echo '<i class="fa fa-star-o" style="font-size:20px;"></i>';
                                    }
                                    ?>
                                </div>
                                <!--                                <p> Average 4.5 <small> / </small> 5 </p>-->
                            </div>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</section>
<?php include "footer.php"; ?>
