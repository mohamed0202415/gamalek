<?php include "header.php"; ?>
    <!-- catg header banner section -->
    <section id="aa-catg-head-banner">
        <img src="img/fashion/fashion-header-bg-8.jpg" alt="fashion img">
        <div class="aa-catg-head-banner-area">
            <div class="container">
                <div class="aa-catg-head-banner-content">
                    <h2>اتصل بنا</h2>
                    <ol class="breadcrumb">
                        <li><a href="/">الرئيسية</a></li>
                        <li class="active">اتصل بنا</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- / catg header banner section -->

    <!-- start contact section -->
    <section id="aa-contact">

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="aa-contact-area">
                        <!-- Contact address -->
                        <div class="aa-contact-address">
                            <?php
                            if (isset($_POST['contact'])) {
                                $insert = $db->prepare("insert into contact (name,email,mobile,subject,message,user_ip,user_os,user_browser,created ) VALUES (?,?,?,?,?,?,?,?,?)");
                                try {
                                    $insert->execute([$_POST['name'], $_POST['email'], $_POST['mobile'], $_POST['subject'], $_POST['message'], $user_ip, $user_os, $user_browser, date("Y-m-d H:i:s")]);
                                    echo '<div class="alert alert-success" style="text-align: center">تم حفظ البيانات بنجاح , سيتم التواصل معكم بأقرب وقت</div>';
                                } catch (PDOException $exception) {
                                    echo '<div class="alert alert-danger" style="text-align: center">خطأ لم يتم حفظ البيانات , برجاء اعادة المحاولة</div>';
                                }
                            }
                            ?>
                            <div class="row">
                                <div class="col-md-7 pull-right  col-xs-12" style="direction: rtl !important;">
                                    <div class="aa-contact-address-left">
                                        <form class="comments-form contact-form" method="post">
                                            <div class="row">
                                                <div class="col-md-6 col-xs-12 pull-right">
                                                    <div class="form-group">
                                                        <input type="text" name="name" placeholder="الاسم" required
                                                               class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="form-group">
                                                        <input type="email" name="email" placeholder="الايميل" required
                                                               class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="form-group">
                                                        <input type="text" name="subject" placeholder="الموضوع" required
                                                               class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-xs-12">
                                                    <div class="form-group">
                                                        <input type="text" name="mobile" placeholder="رقم الموبايل"
                                                               required class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <textarea class="form-control" name="message" style="width: 100%"
                                                          rows="1" placeholder="الرسالة"></textarea>
                                            </div>
                                            <div class="form-group" style="text-align: center">
                                                <button name="contact" type="submit" class="btn btn-danger btn-lg">
                                                    ارسال
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <?php
                                $facebook = get_value($db, 'value', 'system_info', 'name', "'facebook'");
                                $instagram = get_value($db, 'value', 'system_info', 'name', "'instagram'");
                                $whatsapp = get_value($db, 'value', 'system_info', 'name', "'whatsapp'");
                                $email = get_value($db, 'value', 'system_info', 'name', "'email'");
                                $youtube = get_value($db, 'value', 'system_info', 'name', "'youtube'");
                                ?>
                                <div class="col-md-5">
                                    <div class="aa-contact-address-right">
                                        <address style="text-align: center">
                                            <h2 style="text-align: center">Gamalek Store</h2>
                                            <hr/>
                                            <!--                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Rerum modi dolor facilis! Nihil error, eius.</p>-->
                                            <a href="<?php echo $facebook; ?>" style="direction: ltr !important;padding-left: 20px"><span
                                                        class="fa fa-facebook"></span></a>
                                            <a href="<?php echo $instagram; ?>" style="direction: ltr !important;padding-left: 20px"><span
                                                        class="fa fa-instagram"></span></a>
                                            <a href="<?php echo $whatsapp; ?>" style="direction: ltr !important;padding-left: 20px"><span
                                                        class="fa fa-whatsapp"></span></a>

                                            <a href="<?php echo $email; ?>" style="direction: ltr !important;padding-left: 20px"><span
                                                        class="fa fa-envelope"></span></a>
                                            <a href="<?php echo $youtube; ?>" style="direction: ltr !important;padding-left: 20px"><span
                                                        class="fa fa-youtube"></span></a>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php include "footer.php"; ?>