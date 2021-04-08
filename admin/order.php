<?php
ob_start();
include_once 'header.php';
if (isset($_POST['submit'])) {
    echo $_POST['order_no'] . '<br>';
    $id = get_value($db, 'id', 'orders', 'order_no', "'" . $_POST['order_no'] . "'");
    if ($id > 0) {
        echo '<div class="alert alert-danger">خطأ : يوجد طلب بهذا الرقم بالفعل في قاعدة البيانات</div>';
    } else {
        $insert = $db->prepare("insert into orders(order_no,client_id,shipping_id,status,is_paid,note,receipt_no,created,created_by,updated,updated_by,confirmed) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
        try {
            $insert->execute([$_POST['order_no'], $_POST['client'], $_POST['company'], $_POST['status'], $_POST['is_paid'], $_POST['note'], $_POST['receipt'], date("Y-m-d H:i:s"), $user_id, date("Y-m-d H:i:s"), $user_id, $_POST['confirmed']]);
            $p_id = $db->lastInsertId();
//            echo '<div class="alert alert-success">تم اضافة البيانات بنجاح اضغط <a href="order_details.php?id='.$p_id.'">هنا</a> لاضافة منتجات للطلب </div>';
//            echo '<meta http-equiv="refresh" content="2; url="order_details.php?id='.$p_id.'" />';
            header('location:order_details.php?id='.$p_id);
            /*if (count($_POST['products']) > 0) {
                $total_cost = 0;
                $insert_ok = 0;
                for ($i = 0; $i < count($_POST['products']); $i++) {
                    $cost = 0;
                    $total = 0;
                    $cost = get_value($db, 'cost', 'products', 'id', $_POST['products'][$i]);
                    $total = $cost * $_POST['amount'][$i];
                    $total_cost += $total;
                    $insert = $db->prepare("insert into order_items (order_id,product_id,quantity,cost,total_cost,created,created_by,updated,updated_by)VALUES (?,?,?,?,?,?,?,?,?)");
                    try {
                        $insert->execute([$p_id, $_POST['products'][$i], $_POST['amount'][$i], $cost, $total, date("Y-m-d H:i:s"), $user_id, date("Y-m-d H:i:s"), $user_id]);
                        $insert_ok = 1;
                    } catch (PDOException $exp) {
                        $insert_ok = 0;
                    }
                }
                if ($insert_ok == 1) {
                    echo '<div class="alert alert-success">تم حفظ بيانات العميل بنجاح</div>';
                    $update = $db->prepare('update orders set cost = ? where id = ?');
                    $update->execute([$total_cost, $p_id]);
                } else {
                    echo '<div class="alert alert-danger">خطأ لم يتم حفظ البيانات</div>';
                }
            } else {
                echo '<div class="alert alert-success">تم حفظ بيانات العميل بنجاح</div>';
            }*/
        } catch (PDOException $e) {
            echo '<div class="alert alert-danger">خطأ لم يتم حفظ البيانات</div>';
//            echo $e->getMessage();
        }
    }
}
if (isset($_POST['update'])) {
    /*$id = get_value($db, 'id', 'orders', 'order_no', "'" . $_POST['order_no'] . "'");
    if ($id > 0 && $id != $_GET['id']) {
        echo '<div class="alert alert-danger">خطأ : يوجد طلب بهذا الرقم بالفعل في قاعدة البيانات</div>';
    } else {*/
        $update = $db->prepare("update orders set client_id=?,shipping_id=?,status=?,is_paid=?,note=?,receipt_no=?,updated=?,updated_by=?,confirmed=? where id = ?");
        try {
            $update->execute([ $_POST['client'], $_POST['company'], $_POST['status'], $_POST['is_paid'], $_POST['note'], $_POST['receipt'], date("Y-m-d H:i:s"), $user_id, $_POST['confirmed'], $_GET['id']]);
            echo '<div class="alert alert-success">تم حفظ البيانات بنجاح</div>';
        } catch (PDOException $e) {
            echo '<div class="alert alert-danger">خطأ لم يتم حفظ البيانات</div>';
            echo $e->getMessage();
        }

    //}
}
$sql = $db->prepare("select id,name from clients");
$sql->execute();
$clients = $sql->fetchAll(PDO::FETCH_ASSOC);
$sql = $db->prepare("select id,name from shipping_companies");
$sql->execute();
$shipping_companies = $sql->fetchAll(PDO::FETCH_ASSOC);
$order = false;
if (isset($_GET['id'])) {
    $select = $db->prepare("SELECT o.id id,o.confirmed confirmed,o.client_id client_id,o.shipping_id shipping_id,o.order_no order_no,cl.name `client`,o.cost cost,c.name company,o.status `status`,o.is_paid is_paid,o.note note,o.receipt_no receipt_no FROM `orders` o left join shipping_companies c on o.shipping_id = c.id left join clients cl on o.client_id = cl.id where o.id = ?");
    $select->execute([$_GET['id']]);
    $order = $select->fetch(PDO::FETCH_ASSOC);
//    $select = $db->prepare("SELECT id,product_id FROM `order_items` where order_id=?");
//    $select->execute([$_GET['id']]);
//    $order_items = $select->fetchAll(PDO::FETCH_ASSOC);
//    $ids = array();
//    foreach ($order_items as $order_item) {
//        $ids[] = $order_item['product_id'];
//    }
}
?>
<section class="content-header">
    <h1>
        الطلبات
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a href="orders.php"> الطلبات</a></li>
        <li class="active">انشاء طلب</li>
    </ol>
</section>
<section class="content">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">انشاء طلب</h3>
        </div><!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" method="post">
            <div class="box-body">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">رقم الطلب</label>
                    <div class="col-sm-10">
                        <?php if ($order) {
                            echo '<label class="form-control">' . $order['order_no'] . '</label>';
                        } else { ?>
                            <input type="text" class="form-control" name="order_no">
                        <?php } ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">العميل</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="client">
                            <option value="">اختار</option>
                            <?php foreach ($clients as $client) { ?>
                                <option <?php if ($order && $order['client_id'] == $client['id']) {
                                    echo 'selected';
                                } ?> value="<?php echo $client['id']; ?>"><?php echo $client['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <?php if ($order) { ?>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">التكلفة</label>
                        <div class="col-sm-10">
                            <label class="form-control"><?php echo $order['cost']; ?></label>
                        </div>
                    </div>
                <?php } ?>
                <input type="hidden" id="countOfProducts" value="1">
                <?php /*$select = $db->prepare("select id,name from products");
                $select->execute();
                $products = $select->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <div id="items_parent">
                    <div class="form-group" style="direction: rtl !important;">
                        <label for="inputEmail3" class="col-sm-2 control-label">محتويات الطلب</label>
                        <div class="col-sm-4 col-xs-12">
                            <select class="form-control pro1" name="products[]" onchange="getAmount(1);">
                                <option value="">اختار منتج</option>
                                <?php foreach ($products as $product) {

                                    if (in_array($product['id'], $ids)) {

                                    } else {
                                        echo '<option value="' . $product['id'] . '">' . $product['name'] . '</option>';
                                    }
                                } ?>
                            </select>
                        </div>
                        <div class="col-md-1 col-xs-12" style="padding-top: 10px">الكمية</div>
                        <div class="col-md-2 col-xs-12"
                             style="padding-right:5px !important;padding-left:5px !important">
                            <select name="amount[]" class="form-control quant1">

                            </select>
                        </div>
                        <button disabled class="col-md-1 col-xs-6 btn btn-info input-height btn1"
                                style="padding:8px !important"
                                type="button" onclick="addPro();"><span class="fa fa-plus"></span></button>
                    </div>

                </div> */ ?>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">شركة الشحن</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="company">
                            <option value="">اختار</option>
                            <?php foreach ($shipping_companies as $company) { ?>
                                <option <?php if ($order && $order['shipping_id'] == $company['id']) {
                                    echo 'selected';
                                } ?> value="<?php echo $company['id']; ?>"><?php echo $company['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">رقم بوليصة الشحن</label>
                    <div class="col-sm-10">
                        <input <?php if ($order) {
                            echo 'value="' . $order['receipt_no'] . '"';
                        } ?> type="text" class="form-control" name="receipt">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">حالة الطلب</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="status">
                            <option value="">اختار</option>
                            <option <?php if ($order && $order['status'] == 'pending') {
                                echo 'selected';
                            } ?> value="pending">في انتظار التأكيد
                            </option>
                            <option <?php if ($order && $order['status'] == 'ready') {
                                echo 'selected';
                            } ?> value="ready">تم التجهيز
                            </option>
                            <option <?php if ($order && $order['status'] == 'shipped') {
                                echo 'selected';
                            } ?> value="shipped">تم الشحن
                            </option>
                            <option <?php if ($order && $order['status'] == 'delivered') {
                                echo 'selected';
                            } ?> value="delivered">تم التوصيل
                            </option>
                            <option <?php if ($order && $order['status'] == 'rejected') {
                                echo 'selected';
                            } ?> value="rejected">مرتجع
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">الدفع</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="is_paid">
                            <option <?php if ($order && $order['is_paid'] == 0) {
                                echo 'selected';
                            } ?> value="0">لم يتم الدفع
                            </option>
                            <option <?php if ($order && $order['is_paid'] == 1) {
                                echo 'selected';
                            } ?> value="1">تم الدفع
                            </option>

                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">تأكيد الطلب</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="confirmed">
                            <option <?php if ($order && $order['confirmed'] == 0) {
                                echo 'selected';
                            } ?> value="0">لم يتم التأكيد
                            </option>
                            <option <?php if ($order && $order['confirmed'] == 1) {
                                echo 'selected';
                            } ?> value="1">تم التأكيد
                            </option>

                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">ملاحظات</label>
                    <div class="col-sm-10">
                        <textarea rows="2" class="form-control" name="note"><?php if ($order) {
                                echo $order['note'];
                            } ?></textarea>
                    </div>
                </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
                <?php
                if ($order) { ?>
                    <button type="submit" name="update" class="btn btn-success">تحديث البيانات</button>
                <?php } else { ?>
                    <button type="submit" name="submit" class="btn btn-info">حفظ البيانات</button>
                <?php } ?>
                <button type="button" onclick="history.back();" class="btn btn-default">الغاء</button>
            </div><!-- /.box-footer -->
        </form>
    </div><!-- /.box -->
</section>
<?php include "footer.php"; ?>
<script>
    function addPro() {
        var noOfProducts = $('#countOfProducts').val();
        var ids = [];
        $("select[name='products[]']").each(function () {
            ids.push($(this).val());
        });
        $.ajax({
            type: "POST",
            url: "backend.php",
            data: {
                products: noOfProducts,
                ids: ids
            },
            cache: false,
            success: function (result) {
                $("#items_parent").append(result);
                noOfProducts++;
                $('#countOfProducts').val(noOfProducts);
            }
        });
    }

    function getAmount(id) {
        var product_id = $('.pro' + id).val();
        $('.btn' + id).removeAttr('disabled');
        $.ajax({
            type: "POST",
            url: "backend.php",
            data: {
                product_id: product_id
            },
            cache: false,
            success: function (result) {
                $('.quant' + id).empty();
                $('.quant' + id).append(result);
            }
        });
    }
</script>
<?php ob_end_flush();