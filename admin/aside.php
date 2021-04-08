<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-right">
<!--                <img src="../img/gamalek.png" alt="User Image" style="background-color:#fff;max-height: 210px;">-->
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="active treeview">
                <a href="/admin">
                    <i class="fa fa-dashboard"></i> <span>الرئيسية</span></i>
                </a>
            </li>
            <li class="treeview <?php if ($page == 'orders' || $page == 'order') {
                echo 'active';
            } ?>">
                <a href="#">
                    <i class="fa fa-external-link"></i> <span>الطلبات</span>
                    <i class="fa fa-angle-left pull-left"></i>
                </a>
                <ul class="treeview-menu">
                    <li <?php if ($page == 'orders') {
                        echo 'class="active"';
                    } ?>><a href="orders.php"><i class="fa fa-circle-o"></i> كل الطلبات</a></li>
                    <li <?php if ($page == 'order') {
                        echo 'class="active"';
                    } ?>><a href="order.php"><i class="fa fa-circle-o"></i> انشاء طلب</a></li>
                </ul>
            </li>
            <li class="treeview <?php if ($page == 'clients' || $page == 'client') {
                echo 'active';
            } ?>">
                <a href="#">
                    <i class="fa fa-users"></i> <span>العملاء</span>
                    <i class="fa fa-angle-left pull-left"></i>
                </a>
                <ul class="treeview-menu">
                    <li <?php if ($page == 'clients') {
                        echo 'class="active"';
                    } ?>><a href="clients.php"><i class="fa fa-circle-o"></i> كل العملاء</a></li>
                    <li <?php if ($page == 'client') {
                        echo 'class="active"';
                    } ?>><a href="client.php"><i class="fa fa-circle-o"></i> انشاء عميل</a></li>
                </ul>
            </li>
            <li class="treeview <?php if ($page == 'incoming' || $page == 'income') {
                echo 'active';
            } ?>">
                <a href="#">
                    <i class="fa fa-angle-double-down"></i> <span>الواردات</span>
                    <i class="fa fa-angle-left pull-left"></i>
                </a>
                <ul class="treeview-menu">
                    <li <?php if ($page == 'incoming') {
                        echo 'class="active"';
                    } ?>><a href="incoming.php"><i class="fa fa-circle-o"></i> الواردات</a></li>
                    <li <?php if ($page == 'income') {
                        echo 'class="active"';
                    } ?>><a href="income.php"><i class="fa fa-circle-o"></i> انشاء وارد</a></li>
                </ul>
            </li>
            <li class="treeview <?php if ($page == 'products' || $page == 'product') {
                echo 'active';
            } ?>">
                <a href="#">
                    <i class="fa fa-table"></i> <span>المنتجات</span>
                    <i class="fa fa-angle-left pull-left"></i>
                </a>
                <ul class="treeview-menu">
                    <li <?php if ($page == 'products') {
                        echo 'class="active"';
                    } ?>><a href="products.php"><i class="fa fa-circle-o"></i> كل المنتجات</a></li>
                    <li <?php if ($page == 'product') {
                        echo 'class="active"';
                    } ?>><a href="product.php"><i class="fa fa-circle-o"></i> انشاء منتج</a></li>
                </ul>
            </li>
            <li class="treeview <?php if ($page == 'suppliers' || $page == 'supplier' || $page == 'shipping_companies' || $page == 'company' || $page == 'users' || $page == 'user' || $page == 'categories' || $page == 'category' || $page == 'manufacturers' || $page == 'manufacturer') {
                echo 'active';
            } ?>">
                <a href="#">
                    <i class="fa fa-cogs"></i> <span>الأقسام</span>
                    <i class="fa fa-angle-left pull-left"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="treeview <?php if ($page == 'suppliers' || $page == 'supplier') {
                        echo 'active';
                    } ?>">
                        <a href="#">
                            <i class="fa fa-user-plus"></i> <span>الموردين</span>
                            <i class="fa fa-angle-left pull-left"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li <?php if ($page == 'suppliers') {
                                echo 'class="active"';
                            } ?>><a href="suppliers.php"><i class="fa fa-circle-o"></i> الموردين</a></li>
                            <li <?php if ($page == 'supplier') {
                                echo 'class="active"';
                            } ?>><a href="supplier.php"><i class="fa fa-circle-o"></i> انشاء مورد</a></li>
                        </ul>
                    </li>
                    <li class="treeview <?php if ($page == 'shipping_companies' || $page == 'company') {
                        echo 'active';
                    } ?>">
                        <a href="#">
                            <i class="fa fa-truck"></i> <span>شركات الشحن</span>
                            <i class="fa fa-angle-left pull-left"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li <?php if ($page == 'shipping_companies') {
                                echo 'class="active"';
                            } ?>><a href="shipping_companies.php"><i class="fa fa-circle-o"></i> شركات الشحن</a></li>
                            <li <?php if ($page == 'company') {
                                echo 'class="active"';
                            } ?>><a href="company.php"><i class="fa fa-circle-o"></i> انشاء شركة</a></li>
                        </ul>
                    </li>
                    <li class="treeview <?php if ($page == 'users' || $page == 'user') {
                        echo 'active';
                    } ?>">
                        <a href="#">
                            <i class="fa fa-user-secret"></i> <span>المستخدمين</span>
                            <i class="fa fa-angle-left pull-left"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li <?php if ($page == 'users') {
                                echo 'class="active"';
                            } ?>><a href="users.php"><i class="fa fa-circle-o"></i> المستخدمين</a></li>
                            <li <?php if ($page == 'user') {
                                echo 'class="active"';
                            } ?>><a href="user.php"><i class="fa fa-circle-o"></i> انشاء مستخدم</a></li>
                        </ul>
                    </li>
                    <li class="treeview <?php if ($page == 'categories' || $page == 'category') {
                        echo 'active';
                    } ?>">
                        <a href="#">
                            <i class="fa fa-table"></i> <span>الفئات</span>
                            <i class="fa fa-angle-left pull-left"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li <?php if ($page == 'categories') {
                                echo 'class="active"';
                            } ?>><a href="categories.php"><i class="fa fa-circle-o"></i>كل الفئات</a></li>
                            <li <?php if ($page == 'category') {
                                echo 'class="active"';
                            } ?>><a href="category.php"><i class="fa fa-circle-o"></i> انشاء فئة</a></li>
                        </ul>
                    </li>
                    <li class="treeview <?php if ($page == 'manufacturers' || $page == 'manufacturer') {
                        echo 'active';
                    } ?>">
                        <a href="#">
                            <i class="fa fa-flask"></i> <span>الشركات المصنعة</span>
                            <i class="fa fa-angle-left pull-left"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li <?php if ($page == 'manufacturers') {
                                echo 'class="active"';
                            } ?>><a href="manufacturers.php"><i class="fa fa-circle-o"></i>كل الشركات المصنعة</a></li>
                            <li <?php if ($page == 'manufacturer') {
                                echo 'class="active"';
                            } ?>><a href="manufacturer.php"><i class="fa fa-circle-o"></i> انشاء شركة</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="treeview <?php if ($page == 'reviews') {
                echo 'active';
            }
            $select = $db->prepare("select count(*) count from reviews where is_read = 0");
            $select->execute();
            $count = $select->fetch(PDO::FETCH_ASSOC);?>">
                <a href="reviews.php">
                    <i class="fa fa-star-o"></i> <span>التقييمات</span>
                    <small class="label pull-left bg-blue"><?php echo $count['count']; ?></small>
                </a>
            </li>
            <li class="treeview <?php if ($page == 'views') {
                echo 'active';
            } ?>">
                <a href="views.php">
                    <i class="fa fa-eye"></i> <span>المشاهدات</span>
                </a>
            </li>
            <li class="treeview <?php if ($page == 'contact') {
                echo 'active';
            }
            $select = $db->prepare("select count(*) count from contact where is_read = 0");
            $select->execute();
            $count = $select->fetch(PDO::FETCH_ASSOC);
            ?>">
                <a href="contact.php">
                    <i class="fa fa-envelope-o"></i> <span>الرسائل</span>
                    <small class="label pull-left bg-yellow"><?php echo $count['count']; ?></small>
                </a>
            </li>
            <li class="treeview <?php if ($page == 'sliders' || $page == 'slider' || $page == 'ads_iamges' || $page == 'ad' || $page == 'social_info' || $page == 'user' || $page == 'categories' || $page == 'category' || $page == 'manufacturers' || $page == 'manufacturer') {
                echo 'active';
            } ?>">
                <a href="#">
                    <i class="fa fa-sliders"></i> <span>الإعدادات</span>
                    <i class="fa fa-angle-left pull-left"></i>
                </a>
                <ul class="treeview-menu">
                    <li class="treeview <?php if ($page == 'sliders' || $page == 'slider') {
                        echo 'active';
                    } ?>">
                        <a href="#">
                            <i class="fa fa-user-plus"></i> <span>عارض الصور الاساسي</span>
                            <i class="fa fa-angle-left pull-left"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li <?php if ($page == 'sliders') {
                                echo 'class="active"';
                            } ?>><a href="sliders.php"><i class="fa fa-circle-o"></i> كل الصور</a></li>
                            <li <?php if ($page == 'slider') {
                                echo 'class="active"';
                            } ?>><a href="slider.php"><i class="fa fa-circle-o"></i> انشاء صورة</a></li>
                        </ul>
                    </li>
                    <li class="treeview <?php if ($page == 'ads_images' || $page == 'ad') {
                        echo 'active';
                    } ?>">
                        <a href="#">
                            <i class="fa fa-sliders"></i> <span>صور الاعلانات</span>
                            <i class="fa fa-angle-left pull-left"></i>
                        </a>
                        <ul class="treeview-menu">
                            <li <?php if ($page == 'ads_images') {
                                echo 'class="active"';
                            } ?>><a href="ads_images.php"><i class="fa fa-circle-o"></i> صور الاعلانات</a></li>
                            <li <?php if ($page == 'ad') {
                                echo 'class="active"';
                            } ?>><a href="ad.php"><i class="fa fa-circle-o"></i> انشاء صورة</a></li>
                        </ul>
                    </li>
                    <li class="treeview <?php if ($page == 'social_info') {
                        echo 'active';
                    } ?>">
                        <a href="social_info.php">
                            <i class="fa fa-cogs"></i> <span>اعدادات التواصل</span>
                        </a>

                    </li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>