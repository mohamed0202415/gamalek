<?php
include 'includes/config.php';
if (isset($_SESSION['username'])) {
    if ((time() - $_SESSION['time']) > (86400)) {
        if ($_SESSION['type'] == 'user') {
            $update = $db->prepare("update users set status = 'offline' where id = ?");
            $update->execute([$_SESSION['user_id']]);
        } elseif ($_SESSION['type'] == 'doctor') {
            $update = $db->prepare("update doctors set status = 'offline' where id = ?");
            $update->execute([$_SESSION['user_id']]);
        }
        // $url = $_SESSION]['last_page'] = @end(explode('/',$_SERVER['REQUEST_URI']));
        if (isset($_GET['url'])) {
            header('location:logout.php?url=' . $_GET['url']);
        } else {
            header('location:logout.php');
        }
    }
    include_once 'header.php';
    if(isset($_POST['delete_client_button'])){
        $delete = $db->prepare("delete from clients where id = ?");
        try {
            $delete->execute([$_POST['delete_client_button']]);
            echo '<div class="alert alert-success">تم مسح بيانات العميل بنجاح</div>';
        }catch (PDOException $e){
            echo '<div class="alert alert-danger">خطأ لم يتم مسح البيانات</div>';
        }
    }
    if (isset($_POST['delete_order_button'])) {
        $delete = $db->prepare("delete from order_items where order_id = ?");
        $delete->execute([$_POST['delete_order_button']]);
        $delete = $db->prepare("delete from orders where id = ?");
        try {
            $delete->execute([$_POST['delete_order_button']]);
            echo '<div class="alert alert-success">تم مسح البيانات بنجاح</div>';
        } catch (PDOException $e) {
            echo '<div class="alert alert-danger">خطأ لم يتم مسح البيانات</div>';
        }
    }
    ?>
    <section class="content-header">
        <h1>
            الرئيسية
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><a><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?php $orders = get_count($db, 'orders');
                            echo $orders; ?></h3>
                        <p>الطلبات</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-shopping-cart"></i>
                    </div>
                    <a href="orders.php" class="small-box-footer">الطلبات <i class="fa fa-arrow-circle-left"></i></a>
                </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?php $products = get_count($db, 'products');
                            echo $products; ?></h3>
                        <p>المنتجات</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-caret-square-o-down"></i>
                    </div>
                    <a href="products.php" class="small-box-footer">المنتجات <i class="fa fa-arrow-circle-left"></i></a>
                </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?php $clients = get_count($db, 'clients');
                            echo $clients; ?></h3>
                        <p>العملاء</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="clients.php" class="small-box-footer">العملاء <i class="fa fa-arrow-circle-left"></i></a>
                </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?php $select = $db->prepare("select sum(views) views from products");
                            $select->execute();
                            $count = $select->fetch(PDO::FETCH_ASSOC);
                            echo $count['views'];
                            ?></h3>
                        <p>المشاهدات</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="views.php" class="small-box-footer">المشاهدات <i class="fa fa-arrow-circle-left"></i></a>
                </div>
            </div><!-- ./col -->
        </div><!-- /.row -->
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-md-2 com-xs-12">
                <a href="product.php" style="padding:12px !important;height:50px;display: block;margin:0 0 10px 0"
                   class="btn bg-maroon btn-flat margin">انشاء
                    طلب</a>
            </div>
            <div class="col-md-2 com-xs-12">
                <a href="client.php" style="padding:12px !important;height:50px;display: block;margin:0 0 10px 0"
                   class="btn bg-navy btn-flat margin">انشاء
                    عميل</a>
            </div>
            <div class="col-md-2 com-xs-12">
                <a href="category.php" style="padding:12px !important;height:50px;display: block;margin:0 0 10px 0"
                   class="btn bg-olive btn-flat margin">انشاء
                    فئة</a>
            </div>
            <div class="col-md-2 com-xs-12">
                <a href="product.php" style="padding:12px !important;height:50px;display: block;margin:0 0 10px 0"
                   class="btn bg-orange btn-flat margin">انشاء
                    منتج</a>
            </div>
            <div class="col-md-2 com-xs-12">
                <a href="supplier.php" style="padding:12px !important;height:50px;display: block;margin:0 0 10px 0"
                   class="btn bg-aqua btn-flat margin">انشاء
                    مورد</a>
            </div>
            <div class="col-md-2 com-xs-12">
                <a href="income.php" style="padding:12px !important;height:50px;display: block;margin:0 0 10px 0"
                   class="btn bg-blue btn-flat margin">انشاء
                    وارد</a>
            </div>
        </div>

        <?php
        if (isset($_POST['confirm_button'])) {
            $update = $db->prepare("update orders set confirmed = 1 ,status='ready' where id = ?");
            try {
                $update->execute([$_POST['confirm_button']]);
                echo '<div class="alert alert-success">تم تحديث البيانات بنجاح</div>';
            } catch (PDOException $exception) {
                echo '<div class="alert alert-danger">خطأ , لم يتم حفظ البيانات برجاء اعادة المحاولة</div>';
            }
        }
        if (isset($_POST['client_button'])) {
            $update = $db->prepare("update clients set confirmed = 1 where id = ?");
            try {
                $update->execute([$_POST['client_button']]);
                echo '<div class="alert alert-success">تم تحديث البيانات بنجاح</div>';
            } catch (PDOException $exception) {
                echo '<div class="alert alert-danger">خطأ , لم يتم حفظ البيانات برجاء اعادة المحاولة</div>';
            }
        }
        $select = $db->prepare("select c.id id,c.name `name`,c.mobile mobile ,c.city_id city_id, c.address address ,c.created created,ci.name city,cit.name gov from clients c inner join cities ci on c.city_id = ci.id left join cities cit on ci.parent_id = cit.id where c.confirmed =0");
        $select->execute();
        $clients = $select->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">العملاء التي لم تراجع</h3>
            </div>
            <div class="box-body">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th class="text_align_center">#</th>
                        <th class="text_align_center">الاسم</th>
                        <th class="text_align_center">رقم التليفون</th>
                        <th class="text_align_center">المحافظة</th>
                        <th class="text_align_center">المدينة</th>
                        <th class="text_align_center">العنوان</th>
                        <th class="text_align_center">التحكم</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($clients as $key => $client) { ?>
                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo $client['name']; ?></td>
                            <td><?php echo $client['mobile']; ?></td>
                            <td><?php echo $client['gov']; ?></td>
                            <td><?php echo $client['city']; ?></td>
                            <td><?php echo $client['address']; ?></td>
                            <td class="text_align_center" style="padding: 0">
                                <button value="<?php echo $client['id']; ?>" type="button" id="client-btn"
                                        class="btn btn-success btn-sm client-btn" data-toggle="modal" data-target="#confirm_client"
                                        title="تأكيد"><i
                                            class="fa fa-check"></i></button>
                                <a class="btn btn-info btn-sm" href="orders.php?id=<?php echo $client['id']; ?>"
                                   data-toggle="tooltip" title="الطلبات"><i class="fa fa-list"></i></a>
                                <a class="btn btn-primary btn-sm" href="client.php?id=<?php echo $client['id']; ?>"
                                   data-toggle="tooltip" title="تعديل"><i class="fa fa-edit"></i></a>
                                <button id="" value="<?php echo $client['id']; ?>" data-toggle="modal"
                                        data-target="#delete_client_modal" class="btn btn-danger btn-sm delete_client_btn"
                                        title="حذف"><i class="fa fa-remove"></i></button>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php

        $select = $db->prepare("SELECT o.id id,o.created created,o.order_no order_no,cl.name client,o.cost cost,c.name company,o.status `status`,o.is_paid is_paid,o.note note,o.receipt_no receipt_no FROM `orders` o left join shipping_companies c on o.shipping_id = c.id left join clients cl on o.client_id = cl.id where o.confirmed = 0");
        $select->execute();
        $orders = $select->fetchAll(PDO::FETCH_ASSOC);
        include "confirm_modal.php";
        include "confirm_client.php";
        include "delete_client.php";
        include "delete_order.php";
        ?>
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">الطلبات التي لم تراجع</h3>
            </div>
            <div class="box-body">
                <table id="example2" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th class="text_align_center">رقم الطلب</th>
                        <th class="text_align_center">العميل</th>
                        <th class="text_align_center">التكلفة</th>
                        <th class="text_align_center">شركة الشحن</th>
                        <th class="text_align_center">بوليصة الشحن</th>
                        <th class="text_align_center">حالة الطلب</th>
                        <th class="text_align_center">الدفع</th>
                        <th class="text_align_center">التاريخ</th>
                        <th class="text_align_center">التحكم</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($orders as $key => $order) { ?>
                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo $order['order_no']; ?></td>
                            <td><?php echo $order['client']; ?></td>
                            <td><?php echo $order['cost']; ?></td>
                            <td><?php echo $order['company']; ?></td>
                            <td><?php echo $order['receipt_no']; ?></td>
                            <td><?php if ($order['status'] == 'pending') {
                                    echo 'في انتظار التأكيد';
                                } else if ($order['status'] == 'ready') {
                                    echo 'تم التجهيز';
                                } elseif ($order['status'] == 'shipped') {
                                    echo 'تم الشحن';
                                } elseif ($order['status'] == 'delivered') {
                                    echo 'تم التوصيل';
                                } elseif ($order['status'] == 'rejected') {
                                    echo 'مرتجع';
                                } ?></td>
                            <td style="padding: 0"><?php if ($order['is_paid'] == 1) {
                                    echo '<label style="display:block;padding: 5px 2px;text-align:center" class="btn-success">مدفوع</label>';
                                } else {
                                    echo '<label style="display:block;padding: 5px 2px;text-align:center" class="btn-warning">غير مدفوع</label>';
                                } ?></td>
                            <td><?php echo date("Y-m-d", strtotime($order['created'])); ?></td>
                            <td style="padding: 0" class="text_align_center">
                                <button value="<?php echo $order['id']; ?>" type="button" id="confirm-btn"
                                        class="btn btn-success btn-sm confirm-btn" data-toggle="modal" data-target="#confirm_modal"
                                        title="تأكيد"><i
                                            class="fa fa-check"></i></button>
                                <a class="btn btn-primary btn-sm" href="order.php?id=<?php echo $order['id']; ?>"
                                   data-toggle="tooltip" title="تعديل"><i class="fa fa-edit"></i></a>
                                <button id="" value="<?php echo $order['id']; ?>" data-toggle="modal"
                                        data-target="#delete_order_modal" class="btn btn-danger btn-sm delete_order_btn"
                                        title="حذف"><i class="fa fa-remove"></i></button>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>

                </table>
            </div><!-- /.box-body -->
        </div>
        <!-- Main row -->


    </section><!-- /.content -->
    <?php include "footer.php"; ?>


    <script>
        $('.confirm-btn').click(function () {
            var id = $(this).val();
            $('#confirm_id').val(id);
        });
        $('.client-btn').click(function () {
            var id = $(this).val();
            $('#client_id').val(id);
        });
        $(".delete_client_btn").click(function(){
            var id = $(this).val();
            $("#delete_client_id").val(id);
        });
        $(".delete_order_btn").click(function(){
            var id = $(this).val();
            $("#delete_order_id").val(id);
        });
        $(function () {
            $("#example1,#example2").DataTable();
        });
    </script>
<?php } else {
    ob_start();
    include_once 'includes/config.php'; ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>AdminLTE 2 | Log in</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.4 -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <?php
    if (isset($_POST['login'])) {
        include 'includes/helper.php';
        $id = get_value($db, 'id', 'users', 'username', "'" . $_POST['username'] . "'");
        $name = get_value($db, 'name', 'users', 'id', $id);
        $mobile = get_value($db, 'mobile', 'users', 'id', $id);
        if ($id > 0) {
            $password = get_value($db, 'password', 'users', 'id', $id);
            $pass = sha1(md5(strip_tags(htmlspecialchars($_POST['password']))));
            if ($pass === $password) {
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['name'] = $name;
                $_SESSION['mobile'] = $mobile;
                $_SESSION['user_id'] = $id;
                $_SESSION['time'] = time();
                $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
                $up = $db->prepare("update users set last_activity = ? where id = ?");
                $up->execute([date("Y-m-d H:i:s"), $id]);
                $update = $db->prepare("update users set status = 'online' where id = ?");
                $update->execute([$id]);
                echo '<div style="text-align:center" class="alert alert-success" onclick="$(this).fadeOut(30);">Welcome ' . $_POST['username'] . ' <br>Login Successfull <br> Redirecting ... </div>';
                if (isset($_GET['url'])) {
                    echo '<meta http-equiv="refresh" content="2; url="' . $_GET['url'] . '" />';
                } else {
                    echo '<meta http-equiv="refresh" content="2; url="index.php" />';
                }
            } else {
                echo '<div style="text-align:center" class="alert alert-danger" onclick="$(this).fadeOut(30);">خطأ . كلمة المرور غير صحيحة.</div>';
                echo '<meta http-equiv="refresh" content="2; url="index.php" />';
            }
        }
    }
    if (!isset($_POST['login'])) {
        ?>
        <body class="login-page"
              style="background-image: url(/admin/dist/img/bg.jpeg);background-repeat: no-repeat;background-size: cover;">
        <div class="login-box">
            <div class="login-logo">
                <a href="index.php" style="color: #fff"><b>Sales</b>APP</a>
            </div><!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Enter Username and password to Sign in</p>
                <form method="post">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="username" placeholder="Username">
                        <span class="fa fa-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" name="password" placeholder="Password">
                        <span class="fa fa-unlock-alt form-control-feedback"></span>
                    </div>
                    <div class="row"><!-- /.col -->
                        <div class="col-xs-12">
                            <button type="submit" name="login" class="btn btn-primary btn-block btn-flat">Sign In
                            </button>
                        </div><!-- /.col -->
                    </div>
                </form>
            </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->
        <!-- jQuery 2.1.4 -->
        <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- Bootstrap 3.3.4 -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="plugins/iCheck/icheck.min.js"></script>
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        </script>
        </body>
        </html>
    <?php } //include_once 'footer.php';

    ob_end_flush();
} ?>
