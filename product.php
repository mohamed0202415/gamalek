<?php
ob_start();
if (isset($_POST['cart_id'])) {
//    include 'includes/config.php';
    session_start();
    if (isset($_SESSION['cart'][$_POST['cart_id']]['id'])) {
        $amount = $_SESSION['cart'][$_POST['cart_id']]['amount'];
        $_SESSION['cart'][$_POST['cart_id']]['amount'] = $amount + 1;
    } else {
        $_SESSION['cart'][$_POST['cart_id']]['id'] = $_POST['cart_id'];
        $_SESSION['cart'][$_POST['cart_id']]['amount'] = 1;
    }

    echo count($_SESSION['cart']);
    exit();
}
include "header.php";
$view_id = get_value($db, 'id', 'views', 'product_id', $_GET['id']);
$update = $db->prepare("update products set views = views+1 where id = ?");
$update->execute([$_GET['id']]);
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $check = get_value($db, 'id', 'products', 'id', $_GET['id']);
    $online = get_value($db, 'online', 'products', 'id', $_GET['id']);
    if (isset($_GET['id']) && $_GET['id'] > 0 && $check == $_GET['id'] && $online == 1) {
        $select = $db->prepare("select p.id id ,p.category_id category_id,p.manufacturer_id manufacturer_id,p.name name,p.cost cost,p.amount amount,p.size size,p.discount discount,p.description description,m.name manufacturer,c.name category from products p left join categories c on p.category_id = c.id left join manufacturer m on p.manufacturer_id = m.id where p.id = ?");
        $select->execute([$_GET['id']]);
        $product = $select->fetch(PDO::FETCH_ASSOC);
        ?>

        <!-- catg header banner section -->
        <section id="aa-catg-head-banner">
            <img src="img/fashion/fashion-header-bg-8.jpg" alt="fashion img">
            <div class="aa-catg-head-banner-area">
                <div class="container">
                    <div class="aa-catg-head-banner-content">
                        <h2><?php echo $product['name']; ?></h2>
                        <ol class="breadcrumb" style="direction: rtl !important;">
                            <li><a href="/">الرئيسية</a></li>
                            <li>
                                <a href="products.php?category=<?php $product['category_id']; ?>"><?php echo $product['category']; ?></a>
                            </li>
                            <li class="active" style="font-weight: bold;"><?php echo $product['name']; ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- / catg header banner section -->
        <style>
            .add-to-cart:hover {
                color: #ff6666 !important;
                background: #fff !important;
            }

            .aa-header-bottom {
                direction: rtl;
            }

            .checked {
                color: darkorange;
            }
        </style>

        <!-- product category -->
        <section id="aa-product-details">
            <div class="row" style="direction: rtl !important;padding: 15px 120px 15px;background-color: cornsilk">
                <?php $select = $db->prepare("select c.name category,ca.id main_id, ca.name main_category from categories c inner join categories ca on c.parent_id = ca.id where c.id = ?");
                $select->execute([$product['category_id']]);
                $data = $select->fetch(PDO::FETCH_ASSOC);
                ?>
                <a href="/" style="color: #ff6666">الرئيسية</a>
                <i class="fa fa-chevron-left" style="color: #ff6666;font-size: 10px"></i>
                <a style="color: #ff6666"><?php echo $data['main_category']; ?></a>
                <i class="fa fa-chevron-left" style="color: #ff6666;font-size: 10px"></i>
                <a href="/products.php?category=<?php echo $product['category_id']; ?>"
                   style="color: #ff6666"><?php echo $data['category']; ?></a>
                <i class="fa fa-chevron-left" style="color: #ff6666;font-size: 10px"></i>
                <a style="color: #ff6666"><?php echo $product['name']; ?></a>
                <!--                                    <i class="fa fa-chevron-left" style="color: #ff6666;font-size: 10px"></i>-->

            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="aa-product-details-area">
                            <div class="aa-product-details-content">

                                <div class="row">
                                    <!-- Modal view slider -->
                                    <div class="col-md-5 col-sm-5 col-xs-12">
                                        <div class="aa-product-view-slider">
                                            <div id="demo-1" class="simpleLens-gallery-container">
                                                <?php
                                                $select = $db->prepare("select * from product_images where product_id = ? order by main desc");
                                                $select->execute([$_GET['id']]);
                                                $product_images = $select->fetchAll(PDO::FETCH_ASSOC); ?>
                                                <div class="simpleLens-container">
                                                    <div class="simpleLens-big-image-container">
                                                        <a data-lens-image="img/products/large/<?php echo $product_images[0]['image']; ?>"
                                                           class="simpleLens-lens-image">
                                                            <img src="img/products/medium/<?php echo $product_images[0]['image']; ?>"
                                                                 class="simpleLens-big-image"></a>
                                                    </div>
                                                </div>
                                                <div class="simpleLens-thumbnails-container">
                                                    <?php foreach ($product_images as $pro) { ?>
                                                        <a data-big-image="img/products/medium/<?php echo $pro['image']; ?>"
                                                           data-lens-image="img/products/large/<?php echo $pro['image']; ?>"
                                                           class="simpleLens-thumbnail-wrapper" href="#">
                                                            <img src="img/products/thumbnail/<?php echo $pro['image']; ?>">
                                                        </a>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal view content -->
                                    <div class="col-md-7 col-sm-7 col-xs-12" style="text-align: right">
                                        <div class="aa-product-view-content">
                                            <h2><?php echo $product['name']; ?></h2>
                                            <div class="aa-price-block" style="display: block">
                                                <h3 class="aa-product-view-price pull-right"
                                                    style="text-align: right;direction: rtl !important;font-weight: bold;color: #ff6666;margin-top:0"><?php echo $product['cost'] - $product['discount'] . '&nbsp;L.E'; ?></h3> <?php if ($product['discount'] > 0) { ?>
                                                    <sub style="direction:rtl !important;top: 5px">
                                                        <del style="direction:rtl !important;text-align: right;font-weight: bold;color: #ff6666;font-size: 14px;margin-right: 15px"><?php echo $product['cost'] . '&nbsp;L.E'; ?></del>
                                                    </sub><br/><?php } ?>
                                                <br/>
                                                <h3 style="direction: rtl !important; margin-top: 0">الحجم
                                                    : <?php echo $product['size'] . '&nbsp;ml'; ?></h3>
                                                <h3 class="aa-product-avilability">التوفر:
                                                    <span><?php if ($product['amount'] > 0) {
                                                            echo 'متاح';
                                                        } else {
                                                            echo '<span style="color: #ff6666">غير متوفر</span>';
                                                        } ?></span></h3>
                                            </div>

                                            <div class="aa-prod-quantity">
                                                <h4 class="aa-prod-category">
                                                    الفئة : <a style="font-size: 16px;font-weight: bold"
                                                               href="products.php?category=<?php echo $product['category_id']; ?>"><?php echo $product['category']; ?></a>
                                                </h4>
                                                <br/>
                                                <h4 class="aa-prod-category">
                                                    الشركة المصنعة : <a style="font-size: 16px;font-weight: bold"
                                                                        href="products.php?company=<?php echo $product['manufacturer_id']; ?>"><?php echo $product['manufacturer']; ?></a>
                                                </h4>
                                                <br/>
                                                <form action="" style="direction: rtl !important;">
                                                    <span style="font-weight: bold;font-size: 16px">الكمية :</span>
                                                    <select id="amount" name="amount">
                                                        <?php for ($i = 1; $i <= $product['amount']; $i++) { ?>
                                                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </form>
                                            </div>
                                            <div class="aa-prod-view-bottom" style="direction: rtl !important;">
                                                <a class="aa-add-to-cart-btn add-to-cart" href="#"
                                                   onclick="addToCart(<?php echo $product['id']; ?>);"
                                                   style="color: #fff;background: #ff6666">اضف الى السلة</a>
                                                <a class="aa-add-to-cart-btn add-to-cart" href="#add_review"
                                                   style="color: #fff;background: #ff6666">تقييم</a>
                                                <!--                                                <a class="aa-add-to-cart-btn add-to-cart" href="#">Compare</a>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="aa-product-details-bottom">
                                <!--                                <ul class="nav nav-tabs" id="myTab2">-->
                                <!--                                    <li><a href="#description" data-toggle="tab">Description</a></li>-->
                                <!--                                    <li><a href="#review" data-toggle="tab">Reviews</a></li>-->
                                <!--                                </ul>-->

                                <!-- Tab panes -->
                                <!--                                <div class="tab-content">-->
                                <div style="direction: rtl !important;">
                                    <h3>الوصف</h3>
                                    <?php echo $product['description']; ?>
                                </div>
                                <div style="direction: rtl !important;">
                                    <div class="aa-product-review-area pull-right col-md-8">
                                        <?php
                                        $select = $db->prepare("select * from reviews where product_id = ? order by created desc limit 0,5");
                                        $select->execute([$_GET['id']]);
                                        $reviews = $select->fetchAll(PDO::FETCH_ASSOC);
                                        $total_stars = 0;
                                        foreach ($reviews as $review) {
                                            $total_stars += $review['stars'];
                                        }
                                        ?>
                                        <h4> التقييمات : </h4>
                                        <ul class="aa-review-nav">
                                            <?php
                                            foreach ($reviews as $item) {
                                                ?>
                                                <li>
                                                    <div class="media">
                                                        <div class="media-body">
                                                            <h4 class="media-heading pull-right">
                                                                <strong><?php echo $item['name']; ?></strong> -
                                                                <span><?php echo date("M d Y", strtotime($item['created'])); ?> </span>
                                                            </h4>
                                                            <div class="aa-product-rating pull-left">
                                                                <?php $remain_stars = 5 - $item['stars'];
                                                                for ($i = 1; $i <= $item['stars']; $i++) {
                                                                    echo '<i class="fa fa-star-o" style="color:orange"></i>';
                                                                }
                                                                for ($i = 1; $i <= $remain_stars; $i++) {
                                                                    echo '<i class="fa fa-star-o"></i>';
                                                                }
                                                                ?>
                                                            </div>
                                                            <br/>
                                                            <p><?php echo $item['review']; ?></p>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                    <div class="col-md-4">
                                        <h4 id="add_review">اضافة تقييم</h4>
                                        <!-- review form -->
                                        <form method="post" class="aa-review-form">
                                            <div class="aa-your-rating">
                                                <p>عدد النجوم التي يستحقها المنتج</p>
                                                <a style="cursor: pointer"><span class="fa fa-star-o star1"></span></a>
                                                <a style="cursor: pointer"><span class="fa fa-star-o star2"></span></a>
                                                <a style="cursor: pointer"><span class="fa fa-star-o star3"></span></a>
                                                <a style="cursor: pointer"><span class="fa fa-star-o star4"></span></a>
                                                <a style="cursor: pointer"><span class="fa fa-star-o star5"></span></a>
                                            </div>
                                            <input type="hidden" name="stars" id="stars">
                                            <div class="form-group">
                                                <label for="message">اضف تقييمك</label>
                                                <textarea class="form-control" rows="3" name="review"
                                                          id="message"></textarea>
                                            </div>
                                            <div class="form-group" style="padding: 0">
                                                <label for="name">الاسم</label>
                                                <input type="text"
                                                       oninvalid="this.setCustomValidity('برجاء ادخال الاسم')"
                                                       oninput="this.setCustomValidity('')" required
                                                       class="form-control" name="name"
                                                       placeholder="Name">
                                            </div>
                                            <div class="form-group" style="padding: 0">
                                                <label for="email">البريد الالكتروني</label>
                                                <input type="email" class="form-control" name="email"
                                                       placeholder="example@gmail.com">
                                            </div>
                                            <div class="form-group" style="padding: 0">
                                                <label for="email">الهاتف</label>
                                                <input type="text"
                                                       oninvalid="this.setCustomValidity('برجاء ادخال رقم الهاتف')"
                                                       oninput="this.setCustomValidity('')" required
                                                       class="form-control" name="mobile"
                                                       placeholder="01xxxxxxxxx">
                                            </div>
                                            <button type="submit" name="submit"
                                                    class="btn btn-default aa-review-submit">ارسال
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <!--                                </div>-->
                            </div>
                            <!-- Related product -->
                            <div class="aa-product-related-item">
                                <h3>منتجات ذات صلة</h3>
                                <?php $select = $db->prepare("select id,name,cost,discount,size from products where category_id =? and online=1 order by cost desc limit 0,4");
                                $select->execute([$product['category_id']]);
                                $related_products = $select->fetchAll(PDO::FETCH_ASSOC);
                                ?>
                                <ul class="aa-product-catg aa-related-item-slider" style="direction: rtl !important;">
                                    <!-- start single product item -->
                                    <?php foreach ($related_products as $item) {
                                        if($item['id'] != $_GET['id']){
                                        $main_image = main_image($db, $item['id']);
                                        ?>
                                        <li>
                                            <figure>
                                                <a class="aa-product-img"
                                                   href="product.php?id=<?php echo $item['id']; ?>"><img
                                                            src="<?php if (is_file('img/products/medium/' . $main_image)) {
                                                                echo 'img/products/medium/' . $main_image;
                                                            } else {
                                                                echo 'img/noimage.png';
                                                            } ?>"
                                                            alt="polo shirt img"></a>
                                                <!--                                                <a class="aa-add-card-btn" href=""><span-->
                                                <!--                                                            class="fa fa-shopping-cart"></span>ضافة الى السلة</a>-->
                                                <figcaption>
                                                    <h4 class="aa-product-title"><a
                                                                href="product.php?id=<?php echo $item['id']; ?>"><?php echo $item['name']; ?></a>
                                                    </h4>
                                                    <span class="aa-product-price"><?php echo $item['cost'] - $item['discount'] . 'EGP'; ?></span>
                                                    <?php if ($item['discount'] > 0) { ?>
                                                        <span class="aa-product-price"><del><?php echo $item['cost'] . 'EGP'; ?></del></span>
                                                    <?php } ?>
                                                </figcaption>
                                            </figure>
                                            <!-- product badge -->
                                            <?php if ($item['discount'] > 0) { ?>
                                                <span class="aa-badge aa-sale">خصم!</span>
                                            <?php }
                                            if ($item['size'] > 0) { ?>
                                                <span class="aa-badge aa-sale"
                                                      style=" background-color:#f0ad4e;border-color:#f0ad4e;right: 0;left: unset"
                                                      href="#"><?php echo $item['size']; ?>ml</span>
                                            <?php } ?>
                                        </li>
                                    <?php } } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php include "addToCart_modal.php"; ?>

        <!-- / product category -->
        <?php include "footer.php"; ?>
        <script type="text/javascript" src="js/jquery.simpleGallery.js"></script>
        <script type="text/javascript" src="js/jquery.simpleLens.js"></script>
        <script>
            $('.star1').click(function () {
                $('.star2,.star3,.star4,.star5').removeClass('checked').addClass('fa-star-o');
                $('.star1').removeClass('fa-star-o').addClass('fa-star').addClass('checked');
                $('#stars').val(1);
            });
            $('.star2').click(function () {
                $('.star3,.star4,.star5').removeClass('checked').addClass('fa-star-o');
                $('.star1,.star2').removeClass('fa-star-o').addClass('fa-star').addClass('checked');
                $('#stars').val(2);
            });
            $('.star3').click(function () {
                $('.star4,.star5').removeClass('checked').addClass('fa-star-o');
                $('.star1,.star2,.star3').removeClass('fa-star-o').addClass('fa-star').addClass('checked');
                $('#stars').val(3);
            });
            $('.star4').click(function () {
                $('.star5').removeClass('checked').addClass('fa-star-o');
                $('.star1,.star2,.star3,.star4').removeClass('fa-star-o').addClass('fa-star').addClass('checked');
                $('#stars').val(4);
            });
            $('.star5').click(function () {
                $('.star1,.star2,.star3,.star4,.star5').removeClass('fa-star-o').addClass('fa-star').addClass('checked');
                $('#stars').val(5);
            });
            function addToCart(id) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo $_SERVER['REQUEST_URI'];?>",
                    data: {
                        cart_id: id,
                    },
                    cache: false,
                    success: function (result) {
                        $('#addtocart_modal').modal('show');
                        $('.aa-cart-notify').text(result);
                    }
                });
            }
        </script>
        <?php
        if (isset($_POST['submit'])) {

            $insert = $db->prepare("insert into reviews (product_id,stars,name,email,mobile,review,user_ip,user_os,user_browser) values (?,?,?,?,?,?,?,?,?)");
            try {
                $insert->execute([$_GET['id'], $_POST['stars'], $_POST['name'], $_POST['email'], $_POST['mobile'], $_POST['review'], $user_ip, $user_os, $user_browser]);
                ?>
                <div class="modal fade in" tabindex="-1" role="dialog" id="review_success"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content" style="direction: rtl !important;">
                            <div class="modal-header" style="background: #00a157;">
                                <h5 class="modal-title" id="exampleModalLabel" style="color: #fff;font-weight: bold">
                                    رسالة</h5>
                            </div>
                            <div class="modal-body">
                                تم تسجيل التقييم بنجاح شكرا على دعمكم
                            </div>
                            <div class="modal-footer">
                                <form method="post">
                                    <button type="button" class="btn btn-success pull-left" data-dismiss="modal">اغلاق
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    $('#review_success').modal('show');
                </script>
                <?php
            } catch (PDOException $exception) {
                ?>
                <div class="modal fade in" tabindex="-1" role="dialog" id="review_success"
                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content" style="direction: rtl !important;">
                            <div class="modal-header" style="background: #ff6666;">
                                <h5 class="modal-title" id="exampleModalLabel" style="color: #fff;font-weight: bold">
                                    رسالة</h5>
                            </div>
                            <div class="modal-body">
                                عذرا , حدث خطأ اثناء التسجيل ,برجاء اعادة المحاولة
                            </div>
                            <div class="modal-footer">
                                <form method="post">
                                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">اغلاق
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    $('#review_success').modal('show');
                </script>
                <?php
            }
        }
        ?>
        <?php
    } else {
        header("location:index.php");
    }
} else {
    header("location:index.php");
}

ob_end_flush(); ?>