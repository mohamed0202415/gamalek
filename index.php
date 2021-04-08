<?php
if(isset($_POST['cart_id'])){
//    include 'includes/config.php';
    session_start();
    if(isset($_SESSION['cart'][$_POST['cart_id']]['id'])){
        $amount = $_SESSION['cart'][$_POST['cart_id']]['amount'];
        $_SESSION['cart'][$_POST['cart_id']]['amount'] =$amount+1;
    }else{
        $_SESSION['cart'][$_POST['cart_id']]['id'] =$_POST['cart_id'];
        $_SESSION['cart'][$_POST['cart_id']]['amount'] = 1;
    }
    echo count($_SESSION['cart']);
    exit();
}
include "header.php"; ?>

<!-- Start slider -->
<section id="aa-slider">
    <div class="aa-slider-area">
        <div id="sequence" class="seq">
            <div class="seq-screen">
                <ul class="seq-canvas">
                    <!-- single slide item -->
                    <?php $slider = get_all_rows($db, 'slider');
                    foreach ($slider as $item) {
                        ?>
                        <!-- single slide item -->
                        <li>
                            <div class="seq-model">
                                <img data-seq src="img/slider/<?php echo $item['image']; ?>"
                                     alt="<?php echo $item['name']; ?>"/>
                            </div>
                            <div class="seq-title">
                                <span data-seq
                                      style="color:#fff;background-color: #ff6666"><?php echo $item['quote']; ?></span>
                                <h2 data-seq><?php echo $item['name']; ?></h2>
                                <p data-seq><?php echo $item['description']; ?></p>
                                <a data-seq href="<?php echo $item['link']; ?>"
                                   class="aa-shop-now-btn aa-secondary-btn">SHOP NOW</a>
                            </div>
                        </li>
                    <?php } ?>

                </ul>
            </div>
            <!-- slider navigation btn -->
            <fieldset class="seq-nav" aria-controls="sequence" aria-label="Slider buttons">
                <a type="button" class="seq-prev" aria-label="Previous"><span class="fa fa-angle-left"></span></a>
                <a type="button" class="seq-next" aria-label="Next"><span class="fa fa-angle-right"></span></a>
            </fieldset>
        </div>
    </div>
</section>
<!-- / slider -->
<!-- Start Promo section -->
<section id="aa-promo">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aa-promo-area">
                    <div class="row">
                        <!-- promo left -->
                        <?php
                        $select = $db->prepare("select p.id id,p.name name,p.discount discount,i.image image from products p inner join product_images i on p.id = i.product_id where p.online = 1 and i.main=1 order by p.views desc limit 0,5");
                        $select->execute();
                        $best_views = $select->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <div class="col-md-5 no-padding pull-right">
                            <div class="aa-promo-left">
                                <div class="aa-promo-banner">
                                    <img src="img/products/large/<?php echo $best_views[0]['image']; ?>" alt="img">
                                    <div class="aa-prom-content">
                                        <?php if ($best_views[0]['discount'] > 0) { ?>
                                            <span><?php echo $best_views[0]['discount']; ?>EGP Off</span>
                                        <?php } ?>
                                        <h4>
                                            <a href="product.php?id=<?php echo $best_views[0]['id']; ?>"><?php echo $best_views[0]['name']; ?></a>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- promo right -->
                        <div class="col-md-7 no-padding">
                            <div class="aa-promo-right">
                                <div class="aa-single-promo-right">
                                    <div class="aa-promo-banner">
                                        <img src="img/products/large/<?php echo $best_views[1]['image']; ?>" alt="img">
                                        <div class="aa-prom-content">
                                            <span>Exclusive Item</span>
                                            <h4>
                                                <a href="product.php?id=<?php echo $best_views[1]['id']; ?>"><?php echo $best_views[1]['name']; ?></a>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="aa-single-promo-right">
                                    <div class="aa-promo-banner">
                                        <img src="img/products/large/<?php echo $best_views[2]['image']; ?>" alt="img">
                                        <div class="aa-prom-content">
                                            <span>Sale Off</span>
                                            <h4>
                                                <a href="product.php?id=<?php echo $best_views[2]['id']; ?>"><?php echo $best_views[2]['name']; ?></a>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="aa-single-promo-right">
                                    <div class="aa-promo-banner">
                                        <img src="img/products/large/<?php echo $best_views[3]['image']; ?>" alt="img">
                                        <div class="aa-prom-content">
                                            <span>New Arrivals</span>
                                            <h4>
                                                <a href="product.php?id=<?php echo $best_views[3]['id']; ?>"><?php echo $best_views[3]['name']; ?></a>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="aa-single-promo-right">
                                    <div class="aa-promo-banner">
                                        <img src="img/products/large/<?php echo $best_views[4]['image']; ?>" alt="img">
                                        <div class="aa-prom-content">
                                            <span>25% Off</span>
                                            <h4>
                                                <a href="product.php?id=<?php echo $best_views[4]['id']; ?>"><?php echo $best_views[4]['name']; ?></a>
                                            </h4>
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
</section>
<!-- / Promo section -->
<!-- Products section -->
<section id="aa-product">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="aa-product-area">
                        <div class="aa-product-inner">
                            <?php
                            $select = $db->prepare("select p.id id,p.name name,p.cost cost,p.discount discount,i.image image,c.id category_id ,c.name category from products p inner join categories c on p.category_id = c.id inner join product_images i on p.id = i.product_id where p.online = 1 and i.main=1");
                            $select->execute();
                            $products_categories = $select->fetchAll(PDO::FETCH_ASSOC);
                            $categories = array_column($products_categories, 'category_id');
                            $categories = array_values(array_unique($categories));
                            //                            print_r($categories);
                            ?>
                            <!-- start prduct navigation -->
                            <ul class="nav nav-tabs aa-products-tab" style="direction: rtl !important;">
                                <?php foreach ($categories as $key => $item) {
                                    $category_name = get_value($db, 'name', 'categories', 'id', $item);
                                    ?>
                                    <li <?php if ($key == 0) {
                                        echo 'class="active"';
                                    } ?>><a href="#<?php echo $item; ?>"
                                            data-toggle="tab"><?php echo $category_name; ?></a></li>
                                <?php } ?>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <!-- Start men product category -->
                                <?php foreach ($categories as $key => $cat) {
                                    ?>
                                    <div class="tab-pane fade <?php if ($key == 0) {
                                        echo ' in active';
                                    } ?>" id="<?php echo $cat; ?>">
                                        <ul class="aa-product-catg">
                                            <?php foreach ($products_categories as $k => $product) {
                                                if ($product['category_id'] == $cat) {
                                                    ?>
                                                    <!-- start single product item -->
                                                    <li>
                                                        <figure>
                                                            <a class="aa-product-img"
                                                               href="product.php?id=<?php echo $product['id']; ?>"><img
                                                                        src="img/products/medium/<?php echo $product['image']; ?>"
                                                                        alt="<?php echo $product['name']; ?>"></a>
                                                            <a style="cursor: pointer" class="aa-add-card-btn"
                                                               onclick="addToCart(<?php echo $product['id']; ?>);"><span
                                                                        class="fa fa-shopping-cart"></span>إضافة الى
                                                                السلة</a>
                                                            <figcaption>
                                                                <h4 class="aa-product-title"><a
                                                                            href="product.php?id=<?php echo $product['id']; ?>"><?php echo $product['name']; ?></a>
                                                                </h4>
                                                                <span class="aa-product-price"><?php echo $product['cost'] - $product['discount']; ?>EGP</span>
                                                                <?php if ($product['discount'] > 0) { ?><span
                                                                        class="aa-product-price">
                                                                    <del><?php echo $product['cost']; ?>EGP</del>
                                                                    </span><?php } ?>
                                                            </figcaption>
                                                        </figure>

                                                        <!-- product badge -->
                                                        <?php if ($product['discount'] > 0) { ?><span
                                                                class="aa-badge aa-sale">خصم!</span><?php } ?>
                                                    </li>
                                                <?php }
                                            } ?>
                                        </ul>
                                        <div class="row col-md-12" style="text-align: center;margin-bottom: 15px;">
                                            <a class="aa-browse-btn" href="products.php?category=<?php echo $cat; ?>">تصفح
                                                هذه الفئة <span
                                                        class="fa fa-chevron-left pull-left"></span></a>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- / Products section -->
<!-- banner section -->
<section id="aa-banner">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="aa-banner-area">
                        <a href="#"><img src="img/fashion-banner.jpg" alt="fashion banner img"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$select = $db->prepare("select p.id id,p.name name,p.cost cost,p.discount discount,p.size size,i.image image from products p inner join product_images i on p.id = i.product_id where i.main = 1 and p.online = 1 order by p.id desc ");
$select->execute();
$latest = $select->fetchAll(PDO::FETCH_ASSOC);
$select = $db->prepare("select p.id id,p.name name,p.cost cost,p.discount discount,p.size size,i.image image from products p inner join product_images i on p.id = i.product_id where i.main = 1 and p.online = 1 order by p.views desc limit 0,3");
$select->execute();
$best_views = $select->fetchAll(PDO::FETCH_ASSOC);
$select = $db->prepare("select p.id id,p.name name,p.cost cost,p.discount discount,p.size size,i.image image from products p inner join product_images i on p.id = i.product_id  where i.main = 1 and p.discount>0 and p.online = 1");
$select->execute();
$discount = $select->fetchAll(PDO::FETCH_ASSOC);
?>
<!-- popular section -->
<section id="aa-popular-category">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="aa-popular-category-area">
                        <!-- start prduct navigation -->
                        <ul class="nav nav-tabs aa-products-tab" style="direction: rtl !important;">
                            <li class="active"><a href="#best_views" data-toggle="tab">الأكثر مشاهدة</a></li>
                            <li><a href="#latest" data-toggle="tab">أحدث المنتجات</a></li>
                            <li><a href="#discount" data-toggle="tab">العروض</a></li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <!-- Start men popular category -->
                            <div class="tab-pane fade in active" id="best_views">
                                <ul class="aa-product-catg aa-popular-slider">
                                    <!-- start single product item -->
                                    <?php foreach($best_views as $key=>$item){?>
                                    <li>
                                        <figure>
                                            <a class="aa-product-img" href="product.php?id=<?php echo $item['id']; ?>"><img src="img/products/medium/<?php echo $item['image']; ?>"
                                                                                    alt="<?php echo $item['name']; ?>"></a>
                                            <a class="aa-add-card-btn" style="cursor: pointer" onclick="addToCart(<?php echo $item['id']; ?>);" ><span
                                                        class="fa fa-shopping-cart"></span>Add To Cart</a>
                                            <figcaption>
                                                <h4 class="aa-product-title"><a href="product.php?id=<?php echo $item['id']; ?>"><?php echo $item['name']; ?></a></h4>
                                                <span class="aa-product-price"><?php echo $item['cost']-$item['discount']; ?>EGP</span>
                                                <?php if($item['discount'] >0){?><span class="aa-product-price"><del><?php echo $item['cost']; ?>EGP</del></span> <?php } ?>
                                            </figcaption>
                                        </figure>
                                        <!-- product badge -->
                                        <?php if($item['discount'] >0){?><span class="aa-badge aa-sale">خصم!</span><?php } ?>
                                    </li>
                                   <?php } ?>
                                </ul>
                                <a class="aa-browse-btn" href="products.php?target=views">المنتجات الأكثر مشاهدة <span
                                            class="fa fa-long-arrow-right"></span></a>
                            </div>
                            <div class="tab-pane fade" id="latest">
                                <ul class="aa-product-catg aa-popular-slider">
                                    <!-- start single product item -->
                                    <?php foreach($latest as $key=>$item){?>
                                        <li>
                                            <figure>
                                                <a class="aa-product-img" href="product.php?id=<?php echo $item['id']; ?>"><img src="img/products/medium/<?php echo $item['image']; ?>"
                                                                                                                                alt="<?php echo $item['name']; ?>"></a>
                                                <a class="aa-add-card-btn" style="cursor: pointer" onclick="addToCart(<?php echo $item['id']; ?>);" ><span
                                                            class="fa fa-shopping-cart"></span>Add To Cart</a>
                                                <figcaption>
                                                    <h4 class="aa-product-title"><a href="product.php?id=<?php echo $item['id']; ?>"><?php echo $item['name']; ?></a></h4>
                                                    <span class="aa-product-price"><?php echo $item['cost']-$item['discount']; ?>EGP</span>
                                                    <?php if($item['discount'] >0){?><span class="aa-product-price"><del><?php echo $item['cost']; ?>EGP</del></span> <?php } ?>
                                                </figcaption>
                                            </figure>
                                            <!-- product badge -->
                                            <?php if($item['discount'] >0){?><span class="aa-badge aa-sale">خصم!</span><?php } ?>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <a class="aa-browse-btn" href="products.php?target=latest">أحدث المنتجات <span
                                            class="fa fa-long-arrow-right"></span></a>
                            </div>
                            <div class="tab-pane fade" id="discount">
                                <ul class="aa-product-catg aa-popular-slider">
                                    <!-- start single product item -->
                                    <?php foreach($discount as $key=>$item){?>
                                        <li>
                                            <figure>
                                                <a class="aa-product-img" href="product.php?id=<?php echo $item['id']; ?>"><img src="img/products/medium/<?php echo $item['image']; ?>"
                                                                                                                                alt="<?php echo $item['name']; ?>"></a>
                                                <a class="aa-add-card-btn" style="cursor: pointer" onclick="addToCart(<?php echo $item['id']; ?>);" ><span
                                                            class="fa fa-shopping-cart"></span>Add To Cart</a>
                                                <figcaption>
                                                    <h4 class="aa-product-title"><a href="product.php?id=<?php echo $item['id']; ?>"><?php echo $item['name']; ?></a></h4>
                                                    <span class="aa-product-price"><?php echo $item['cost']-$item['discount']; ?>EGP</span>
                                                    <?php if($item['discount'] >0){?><span class="aa-product-price"><del><?php echo $item['cost']; ?>EGP</del></span> <?php } ?>
                                                </figcaption>
                                            </figure>
                                            <!-- product badge -->
                                            <?php if($item['discount'] >0){?><span class="aa-badge aa-sale">خصم!</span><?php } ?>
                                        </li>
                                    <?php } ?>
                                </ul>
                                <a class="aa-browse-btn" href="products.php?target=discount">كل العروض <span
                                            class="fa fa-long-arrow-right"></span></a>
                            </div>
                            <!-- / popular product category -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- / popular section -->
<!-- Client Brand -->
<style>
    .manu:hover {
        color: #ff6666 !important;
        background-color: #fff !important;
    }
</style>
<section id="aa-client-brand">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="aa-client-brand-area">
                    <ul class="aa-client-brand-slider">
                        <?php $companies = get_all_rows($db, 'manufacturer');
                        foreach ($companies as $company) {
                            ?>
                            <li>
                                <a class="manu" style="font-weight:bold;background-color: #ff6666;color:#fff"
                                   href="products.php?company=<?php echo $company['id']; ?>">
                                    <?php
                                    if(is_file('img/companies/'.$company['image'])){
                                        echo '<img src="img/companies/'.$company['image'].'" alt="'.$company['name'].'" />';
                                    }else{
                                        echo $company['name'];
                                    }
                                     ?>
                                </a></li>
                        <?php }foreach ($companies as $company) {
                            ?>
                            <li>
                                <a class="manu" style="font-weight:bold;background-color: #ff6666;color:#fff"
                                   href="products.php?company=<?php echo $company['id']; ?>">
                                    <?php
                                    if(is_file('img/companies/'.$company['image'])){
                                        echo '<img src="img/companies/'.$company['image'].'" alt="'.$company['name'].'" />';
                                    }else{
                                        echo $company['name'];
                                    }
                                     ?>
                                </a></li>
                        <?php } ?>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include "addToCart_modal.php"; ?>

<!-- / Client Brand -->

<!-- footer -->
<?php include "footer.php"; ?>
<!-- To Slider JS -->
<script src="js/sequence.js"></script>
<script src="js/sequence-theme.modern-slide-in.js"></script>

<script>
    function addToCart(id){
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