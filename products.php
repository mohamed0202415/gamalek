<?php
if (isset($_POST['cart_id'])) {
//  include 'includes/config.php';
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
if (isset($_GET['category'])) {
    $select = $db->prepare("select count(*) total from products where category_id = ? and online = 1");
    $select->execute([$_GET['category']]);
} elseif (isset($_GET['company'])) {
    $select = $db->prepare("select count(*) total from products where manufacturer_id = ? and online = 1");
    $select->execute([$_GET['company']]);
} elseif (isset($_GET['target']) && $_GET['target'] == 'discount') {
    $select = $db->prepare("select count(*) total from products where discount>0 and online = 1 ");
    $select->execute();
} elseif (isset($_GET['target']) && $_GET['target'] == 'latest') {
    $select = $db->prepare("select count(*) total from products where and online = 1 order by id desc");
    $select->execute();
} elseif (isset($_GET['target']) && $_GET['target'] == 'views') {
    $select = $db->prepare("select count(*) total from products where online = 1 order by views desc");
    $select->execute();
} else {
    $select = $db->prepare("select count(*) total from products where  online = 1");
    $select->execute();
}
$count = $select->fetch(PDO::FETCH_ASSOC);
$total = $count['total'];
if ($total > 0) {
    $limit = 12;
    $pages = ceil($total / $limit);
    $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
        'options' => array(
            'default' => 1,
            'min_range' => 1,
        ),
    )));
    // Calculate the offset for the query
    $offset = ($page - 1) * $limit;
    // Some information to display to the user
    $start = $offset + 1;
    $end = min(($offset + $limit), $total);
    if (isset($_GET['category'])) {
        $select = $db->prepare("select p.id id,p.name name,p.cost cost,p.discount discount,p.size size,i.image image from products p inner join product_images i on p.id = i.product_id where i.main = 1 and p.category_id = ? and p.online = 1 limit $limit offset $offset");
        $select->execute([$_GET['category']]);
    } elseif (isset($_GET['company'])) {
        $select = $db->prepare("select p.id id,p.name name,p.cost cost,p.discount discount,p.size size,i.image image from products p inner join product_images i on p.id = i.product_id  where i.main = 1 and p.manufacturer_id = ? and p.online = 1 limit $limit offset $offset");
        $select->execute([$_GET['company']]);
    } elseif (isset($_GET['target']) && $_GET['target'] == 'discount') {
        $select = $db->prepare("select p.id id,p.name name,p.cost cost,p.discount discount,p.size size,i.image image from products p inner join product_images i on p.id = i.product_id  where i.main = 1 and p.discount>0 and p.online = 1 limit $limit offset $offset");
        $select->execute();
    } elseif (isset($_GET['target']) && $_GET['target'] == 'latest') {
        $select = $db->prepare("select p.id id,p.name name,p.cost cost,p.discount discount,p.size size,i.image image from products p inner join product_images i on p.id = i.product_id  where i.main = 1 and p.online = 1 order by p.id desc limit $limit offset $offset");
        $select->execute();
    } elseif (isset($_GET['target']) && $_GET['target'] == 'views') {
        $select = $db->prepare("select p.id id,p.name name,p.cost cost,p.discount discount,p.size size,i.image image from products p inner join product_images i on p.id = i.product_id  where i.main = 1 and p.online = 1 order by p.views desc limit $limit offset $offset");
        $select->execute();
    } else {
        $select = $db->prepare("select p.id id,p.name name,p.cost cost,p.discount discount,p.size size,i.image image from products p inner join product_images i on p.id = i.product_id where i.main = 1 and p.online = 1 limit $limit offset $offset");
        $select->execute();
    }

    $products = $select->fetchAll(PDO::FETCH_ASSOC);
}
$select = $db->prepare("select p.id id,p.name name,p.cost cost,p.discount discount,p.size size,i.image image from products p inner join product_images i on p.id = i.product_id where i.main = 1 and p.online = 1 order by p.id desc limit 0,3");
$select->execute();
$latest = $select->fetchAll(PDO::FETCH_ASSOC);
$select = $db->prepare("select p.id id,p.name name,p.cost cost,p.discount discount,p.size size,i.image image from products p inner join product_images i on p.id = i.product_id where i.main = 1 and p.online = 1 order by p.views desc limit 0,3");
$select->execute();
$best_views = $select->fetchAll(PDO::FETCH_ASSOC);

?>
<style>
    .aa-catg-nav li a:hover {
        color: #fff;
        background: #ff6666;
    }

    .active1 {
        display: block;
        background: #ff6666;
        color: #fff !important;
        font-weight: bold;
        padding: 8px;
        border-bottom: 1px solid #fff;;
    }

    .sub_category {
        border-bottom: 1px solid #ff6666;
    }

    .sub_category:hover {
        background: #ff6666 !important;
        color: #fff !important;
    }

    .list-group-item {
        border: none !important;
        padding: 8px !important;
    }
</style>
<!-- catg header banner section -->
<section id="aa-catg-head-banner">
    <img src="img/products/ad.jpg" alt="fashion img">
</section>
<!-- / catg header banner section -->
<!-- product category -->
<section id="aa-product-category">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-8">
                <div class="aa-product-catg-content">
                    <div class="aa-product-catg-head">
                        <div class="aa-product-catg-head-left pull-right" style="font-size: 22px">
                            <?php if (isset($_GET['category'])) {
                                $cat_name = get_value($db, 'name', 'categories', 'id', $_GET['category']);
                                ?>
                                منتجات فئة <strong><?php echo $cat_name; ?></strong>
                            <?php } elseif (isset($_GET['company'])) {
                                $com_name = get_value($db, 'name', 'manufacturer', 'id', $_GET['company']);
                                ?>
                                منتجات شركة <strong><?php echo $com_name; ?></strong>
                                <?php
                            } elseif (isset($_GET['target']) && $_GET['target'] == 'discount') {
                                ?>
                                منتجات  <strong>العروض</strong>
                                <?php
                            } elseif (isset($_GET['target']) && $_GET['target'] == 'latest') {
                                ?>
                                <strong>أحدث المنتجات</strong>
                                <?php
                            } elseif (isset($_GET['target']) && $_GET['target'] == 'views') {
                                ?>
                                <strong>المنتجات الأكثر مشاهدة</strong>
                                <?php
                            } else { ?>
                                <strong>كل المنتجات</strong>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="aa-product-catg-body">
                        <?php if ($total > 0) { ?>
                            <ul class="aa-product-catg">
                                <!-- start single product item -->
                                <?php foreach ($products as $key => $product) { ?>
                                    <li>
                                        <figure>
                                            <a class="aa-product-img"
                                               href="product.php?id=<?php echo $product['id']; ?>"><img
                                                        src="img/products/medium/<?php echo $product['image']; ?>"
                                                        alt=""
                                                        onerror="this.src='../img/noimage.png'"></a>
                                            <a class="aa-add-card-btn"
                                               onclick="addToCart(<?php echo $product['id']; ?>);" href="#"><span
                                                        class="fa fa-shopping-cart"></span>اضافة الى السلة</a>
                                            <figcaption>
                                                <h4 class="aa-product-title"><a
                                                            href="product.php?id=<?php echo $product['id']; ?>"><?php echo $product['name']; ?></a>
                                                </h4>
                                                <span class="aa-product-price"> <?php echo ($product['cost'] - $product['discount']) . 'EGP'; ?></span><?php if ($product['discount'] > 0) { ?>
                                                    <span class="aa-product-price"> / <del><?php echo $product['cost']; ?></del>EGP
                                                    </span><?php } ?>
                                                <p class="aa-product-descrip"></p>
                                            </figcaption>
                                        </figure>
                                        <!-- product badge -->
                                        <?php if ($product['discount'] > 0) { ?>
                                            <span class="aa-badge aa-sale" href="#">خصم!</span>
                                        <?php }
                                        if ($product['size'] > 0) { ?>
                                            <span class="aa-badge aa-sale"
                                                  style=" background-color:#f0ad4e;border-color:#f0ad4e;right: 0;left: unset"
                                                  href="#"><?php echo $product['size']; ?>ml</span>
                                        <?php } ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php }else{
                            echo '<div class="alert alert-warning" style="text-align: center">لا يوجد منتجات في الوقت الحالي</div>';
                        } ?>
                    </div>
                    <div class="aa-product-catg-pagination">
                        <nav>
                            <?php if ($total > 0) {
                                // The "back" link
                                $prevlink = ($page > 1) ? '<a href="?page=1" style="padding: 3px 7px;border: 1px solid silver;border-radius: 3px;" title="First page" >&laquo;</a> <a style="padding: 3px 7px;border: 1px solid silver;border-radius: 3px;" href="?page=' . ($page - 1) . '" title="Previous page">&lsaquo;</a>' : '<span style="padding: 3px 7px;border: 1px solid silver;border-radius: 3px;" class="disabled">&laquo;</span> <span style="padding: 3px 7px;border: 1px solid silver;border-radius: 3px;" class="disabled">&lsaquo;</span>';
                                // The "forward" link
                                $nextlink = ($page < $pages) ? '<a style="padding: 3px 7px;border: 1px solid silver;border-radius: 3px;" href="?page=' . ($page + 1) . '" title="Next page">&rsaquo;</a> <a style="padding: 3px 7px;border: 1px solid silver;border-radius: 3px;" href="?page=' . $pages . '" title="Last page">&raquo;</a>' : '<span style="padding: 3px 7px;border: 1px solid silver;border-radius: 3px;" class="disabled">&rsaquo;</span> <span style="padding: 3px 7px;border: 1px solid silver;border-radius: 3px;" class="disabled">&raquo;</span>';
                                // Display the paging information
                                echo '<div id="paging" style="direction: rtl !important;"><p>', $prevlink, ' صفحة ', $page, ' من ', $pages, ' - عرض ', $start, '-', $end, ' من ', $total, ' منتجات ', $nextlink, ' </p></div>';
                            }
                            ?>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-4">
                <aside class="aa-sidebar">
                    <!-- single sidebar -->
                    <div class="aa-sidebar-widget" id="categories">
                        <h3>الفئات</h3>
                        <?php $categories = get_all_rows_with_parent($db, 'categories', 0); ?>
                        <div class="list-group">
                            <!--                        <ul class="aa-catg-nav">-->
                            <?php foreach ($categories

                            as $key => $category){
                            $sub_categories = get_all_rows_with_parent($db, 'categories', $category['id']);
                            ?>
                            <a class="active1"
                               onclick="$('.category<?php echo $category['id']; ?>').toggle();$('.chev1<?php echo $category['id']; ?>,.chev2<?php echo $category['id']; ?> ').toggle(); "
                               id="category<?php echo $category['id']; ?>">
                                <?php echo $category['name']; ?>
                                <i class="fa fa-chevron-down pull-left chev1<?php echo $category['id']; ?>"
                                   style="display:<?php if ($key > 0) {
                                       echo 'none';
                                   } else {
                                       echo 'block';
                                   } ?>;font-size: 10px;margin:7px" aria-hidden="true"></i>
                                <i class="fa fa-chevron-up pull-left chev2<?php echo $category['id']; ?>"
                                   style="display:<?php if ($key > 0) {
                                       echo 'block';
                                   } else {
                                       echo 'none';
                                   } ?>;font-size: 10px;margin:7px" aria-hidden="true"></i>
                            </a>
                            <div class="category<?php echo $category['id']; ?>"
                                 style="display:<?php if ($key == 0) {
                                     echo 'block';
                                 } else {
                                     echo 'none';
                                 } ?>;">
                                <?php foreach ($sub_categories as $item) { ?>
                                    <a style="font-weight: bold;<?php if (isset($_GET['category']) && ($_GET['category'] == $item['id'])) {
                                        echo 'color:#fff !important;background:#fb8e8e !important';
                                    } ?>" href="products.php?category=<?php echo $item['id']; ?>"
                                       class="list-group-item list-group-item-action sub_category"><?php echo $item['name']; ?></a>
                                    <!--                                <li><a style="font-weight: bold" href="products.php?category=--><?php //echo $category['id']; ?><!--">--><?php //echo $category['name']; ?><!--</a></li>-->
                                <?php }
                                echo '</div>';
                                } ?>
                                <!--                        </ul>-->
                            </div>
                        </div>
                        <!-- single sidebar -->
                        <div class="aa-sidebar-widget" id="companies">
                            <h3>الشركات</h3>
                            <?php $manufacturer = get_all_rows($db, 'manufacturer'); ?>
                            <div class="tag-cloud">
                                <?php foreach ($manufacturer as $item) {
                                    ?>
                                    <a <?php if (isset($_GET['company']) && ($_GET['company'] == $item['id'])) {
                                        echo 'style="color:#fff !important;background:#fb8e8e !important"';
                                    } else {
                                        echo 'href="products.php?company=' . $item['id'] . '"';
                                    } ?> ><?php echo $item['name']; ?></a>
                                    <?php
                                } ?>
                            </div>
                        </div>
                        <!-- single sidebar -->
                        <div class="aa-sidebar-widget">
                            <h3>أحدث المنتجات</h3>
                            <div class="aa-recently-views">
                                <ul>
                                    <?php foreach ($latest as $item) {
//                                            $select = $db->prepare("select image from product_images where product_id = ? and main=1");
//                                            $select->execute([$item['id']]);
//                                            $image = $select->fetch(PDO::FETCH_ASSOC);
                                        ?>
                                        <li>
                                            <a href="product.php?id=<?php echo $item['id']; ?>"
                                               class="aa-cartbox-img"><img alt="img"
                                                                           src="img/products/medium/<?php echo $item['image']; ?>"></a>
                                            <div class="aa-cartbox-info">
                                                <h4><a style="font-weight: bold"
                                                       href="product.php?id=<?php echo $item['id']; ?>"><?php echo $item['name']; ?></a>
                                                </h4>
                                                <p style="font-weight: bold;color: #ff6666"><span
                                                            class="pull-right"><?php echo $item['cost'] - $item['discount'] . 'EGP</span>';
                                                    if ($item['discount'] > 0) {
                                                        echo '<del style="font-size: 13px;margin-right:10px">' . $item['cost'] . 'EGP</del>';
                                                    } ?></p>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <!-- single sidebar -->
                        <div class="aa-sidebar-widget">
                            <h3>الأكثر مشاهده</h3>
                            <div class="aa-recently-views">
                                <ul>
                                    <?php foreach ($best_views as $item) {
//                                            $select = $db->prepare("select image from product_images where product_id = ? and main=1");
//                                            $select->execute([$item['id']]);
//                                            $image = $select->fetch(PDO::FETCH_ASSOC);
                                        ?>
                                        <li>
                                            <a href="product.php?id=<?php echo $item['id']; ?>"
                                               class="aa-cartbox-img"><img alt="img"
                                                                           src="img/products/medium/<?php echo $item['image']; ?>"></a>
                                            <div class="aa-cartbox-info">
                                                <h4><a style="font-weight: bold"
                                                       href="product.php?id=<?php echo $item['id']; ?>"><?php echo $item['name']; ?></a>
                                                </h4>
                                                <p style="font-weight: bold;color: #ff6666"><span
                                                            class="pull-right"><?php echo $item['cost'] - $item['discount'] . 'EGP</span>';
                                                    if ($item['discount'] > 0) {
                                                        echo '<del style="font-size: 13px;margin-right:10px">' . $item['cost'] . 'EGP</del>';
                                                    } ?></p>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                </aside>
            </div>
        </div>
    </div>
</section>
<?php include "addToCart_modal.php"; ?>
<!-- / product category -->
<!-- footer -->
<?php include "footer.php"; ?>
<script>
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
