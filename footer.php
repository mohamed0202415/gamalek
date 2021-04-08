<footer id="aa-footer" style="direction: rtl !important;">
    <!-- footer bottom -->
    <div class="aa-footer-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="aa-footer-top-area">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 pull-right">
                                <div class="aa-footer-widget">
                                    <h3>القائمة الرئيسية</h3>
                                    <ul class="aa-footer-nav">
                                        <li><a href="/">الرئيسية</a></li>
                                        <li><a href="products.php#categories">الفئات</a></li>
                                        <li><a href="products.php#companies">الشركات</a></li>
                                        <li><a href="products.php?target=discount">العروض</a></li>
                                        <li><a href="contact.php">تواصل معنا</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 pull-right">
                                <div class="aa-footer-widget">
                                    <div class="aa-footer-widget">
                                        <h3>الفئات</h3>
                                        <?php $main_categories = get_all_rows_with_parent($db, 'categories', 0); ?>
                                        <ul class="aa-footer-nav">
                                            <?php foreach ($main_categories as $main_category) {
                                                echo '<li><a href="products.php">' . $main_category['name'] . '</a></li>';
                                            } ?>
                                            <li><a href="products.php?target=latest">أحدث المنتجات</a></li>
                                            <li><a href="products.php?target=views">الأكثر مشاهدة</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 pull-right">
                                <div class="aa-footer-widget">
                                    <div class="aa-footer-widget">
                                        <h3>الشركات</h3>
                                        <?php $companies = get_all_rows($db, 'manufacturer'); ?>
                                        <ul class="aa-footer-nav">
                                            <?php foreach ($companies as $company) { ?>
                                                <li>
                                                    <a href="products.php?company=<?php echo $company['id']; ?>"><?php echo $company['name']; ?></a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="aa-footer-widget">
                                    <div class="aa-footer-widget">
                                        <h3>اتصل بنا</h3>
                                        <?php
                                        $facebook = "https://www.facebook.com/profile.php?id=100002086130537";
                                        $instagram = "https://www.instagram.com/mohamed_ashraf.8/?fbclid=IwAR02gtlJNz5CLZQlDgOVUCF7EkFWTnRQJSwOFIFlfJgkDDdBNr3TCtIwl_A";
                                        $whatsapp = "01117384331";
                                        $email = "m.ashrafhms880@gmail.com";
                                        $youtube = get_value($db, 'value', 'system_info', 'name', "'youtube'");
                                        ?>
                                        <address>
                                            <!--                                            <p> address</p>-->
                                            <a href="https://api.whatsapp.com/send?phone=<?php echo $whatsapp; ?>" style=" color:green;direction:rtl !important;">&nbsp;<span class="fa fa-whatsapp"></span></a>&nbsp;<p class="pull-right"><?php echo $whatsapp; ?></p>
                                            <!--                                            <p><span class="fa fa-envelope"></span>dailyshop@gmail.com</p>-->
                                        </address>
                                        <div class="aa-footer-social">

                                            <a target="_blank" title="Facebook" href="<?php echo $facebook; ?>"><span
                                                        class="fa fa-facebook"></span></a>
                                            <a target="_blank" title="Instagram" href="<?php echo $instagram; ?>"><span
                                                        class="fa fa-instagram"></span></a>
                                            <a target="_blank" title="Mail" href="mailto:<?php echo $email; ?>"><span
                                                        class="fa fa-envelope"></span></a>
                                            <a target="_blank" href="<?php echo $youtube; ?>"><span class="fa fa-youtube"></span></a>
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
    <!-- footer-bottom -->
    <div class="aa-footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="aa-footer-bottom-area">
                        <p>Designed by <a href="https://www.facebook.com/profile.php?id=100002086130537">M.Ashraf<i class="fa fa-copyright"></i></a>
                            2021</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- / footer -->

<!-- Login Modal -->
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.js"></script>
<!-- SmartMenus jQuery plugin -->
<script type="text/javascript" src="js/jquery.smartmenus.js"></script>
<!-- SmartMenus jQuery Bootstrap Addon -->
<script type="text/javascript" src="js/jquery.smartmenus.bootstrap.js"></script>
<!-- Product view slider -->
<script type="text/javascript" src="js/jquery.simpleGallery.js"></script>
<script type="text/javascript" src="js/jquery.simpleLens.js"></script>
<!-- slick slider -->
<script type="text/javascript" src="js/slick.js"></script>
<!-- Price picker slider -->
<script type="text/javascript" src="js/nouislider.js"></script>
<!-- Custom js -->
<script src="js/custom.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.search-box input[type="text"]').on("keyup input", function(){
            /* Get input value on change */
            var inputVal = $(this).val();
            var resultDropdown = $(this).siblings(".result");
            if(inputVal.length){
                $.get("backend.php", {term: inputVal}).done(function(data){
                    // Display the returned data in browser
                    resultDropdown.html(data);
                });
            } else{
                resultDropdown.empty();
            }
        });

        // Set search input value on click of result item
        $(document).on("click", ".result p", function(){
            $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
            $(this).parent(".result").empty();
        });
    });
</script>
</body>
</html>
<?php ob_end_flush(); ?>