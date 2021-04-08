<section id="menu">
    <div class="container">
        <div class="menu-area">
            <!-- Navbar -->
            <div class="navbar navbar-default" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="navbar-collapse collapse" style="direction: rtl !important;">
                    <!-- Left nav -->
                    <ul class="nav navbar-nav">
                        <li style="float: right"><a href="index.php">الرئيسية</a></li>
                        <li style="float: right;"><a href="products.php" style="<?php if($page == 'products' && !isset($_GET['category']) && !isset($_GET['company']) && !isset($_GET['target'])){echo 'color:#ff6666 !important;background:#fff';}?>">المنتجات</a></li>
                        <li style="float: right"><a  style="<?php if(isset($_GET['category'])){echo 'color:#ff6666 !important;background:#fff';}?>">الفئات <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <?php $main_categories = get_all_rows_with_parent($db,'categories',0);
                                foreach ($main_categories as $main_category) {
                                    $categories = get_all_rows_with_parent($db,'categories',$main_category['id']);
                                ?>

                                <li><a style="width: 100%;text-align: right"><?php echo $main_category['name']; ?><span class="fa fa-caret-left pull-left" style="font-size: 12px;padding-top:5px"></span></a>
                                    <ul class="dropdown-menu" style="width: 160px !important;max-width: 160px !important;margin-right:136px !important;right: 0 !important;">
                                        <?php foreach ($categories as $category){?>
                                        <li style="width: 100%;text-align: right"><a style="<?php if(isset($_GET['category']) && $_GET['category'] == $category['id']){echo 'color:#fff !important;background:#ff6666';}?>" href="products.php?category=<?php echo $category['id']; ?>"><?php echo $category['name']; ?></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <?php } ?>
                            </ul>
                        </li>
                        <li style="float: right"><a style="<?php if(isset($_GET['company'])){echo 'color:#ff6666 !important;background:#fff';}?>">الشركات <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <?php $manufacturer = get_all_rows($db,'manufacturer');
                                foreach ($manufacturer as $man) {
                                    ?>
                                    <li><a style="<?php if($_GET['company'] == $man['id']){echo 'color:#fff !important;background:#ff6666';}?>" href="products.php?company=<?php echo $man['id']; ?>" style="width: 100%;text-align: right"><?php echo $man['name']; ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <li style="float: right"><a style="<?php if(isset($_GET['target']) && $_GET['target'] == 'latest'){echo 'color:#ff6666 !important;background:#fff';}?>" href="products.php?target=latest">أحدث المنتجات</a></li>
                        <li style="float: right"><a style="<?php if(isset($_GET['target']) && $_GET['target'] == 'discount'){echo 'color:#ff6666 !important;background:#fff';}?>" href="products.php?target=discount">العروض</a></li>
                        <li style="float: right"><a href="contact.php" style="<?php if($page == 'contact'){echo 'color:#ff6666 !important;background:#fff';}?>">اتصل بنا</a></li>
                        <li style="float: right"><a href="admin/index.php" style="<?php if($page == 'contact'){echo 'color:#ff6666 !important;background:#fff';}?>">دخول</a></li>
                        <li class="cellphone hidden-xs" style="color:#fff">
                            <?php $whatsapp = get_value($db, 'value', 'system_info', 'name', "'whatsapp'"); ?>
                            <p style="margin:10px 0;direction: ltr !important;"><span class="fa fa-phone" style="margin-right: 10px;"></span><i class="fa fa-whatsapp" aria-hidden="true"></i>
                                +2 01117384331</p>
                        </li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </div>
    </div>
</section>