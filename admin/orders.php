<?php include_once 'header.php';
if (isset($_POST['delete_button'])) {
    $delete = $db->prepare("delete from order_items where order_id = ?");
    $delete->execute([$_POST['delete_button']]);
    $delete = $db->prepare("delete from orders where id = ?");
    try {
        $delete->execute([$_POST['delete_button']]);
        echo '<div class="alert alert-success">تم مسح البيانات بنجاح</div>';
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">خطأ لم يتم مسح البيانات</div>';
    }
}
if (isset($_POST['confirm_button'])) {
    $update = $db->prepare("update orders set confirmed = 1 ,status='ready' where id = ?");
    try {
        $update->execute([$_POST['confirm_button']]);
        echo '<div class="alert alert-success">تم تحديث البيانات بنجاح</div>';
    } catch (PDOException $exception) {
        echo '<div class="alert alert-danger">خطأ , لم يتم حفظ البيانات برجاء اعادة المحاولة</div>';
    }
}
if (isset($_GET['id'])) {
    $select = $db->prepare("SELECT o.id id,o.created created,o.order_no order_no,cl.name client,o.cost cost,c.name company,o.status `status`,o.is_paid is_paid,o.note note,o.receipt_no receipt_no FROM `orders` o left join shipping_companies c on o.shipping_id = c.id left join clients cl on o.client_id = cl.id where o.client_id = ? and o.confirmed =1");
    $select->execute([$_GET['id']]);
    $select_paid = $db->prepare("select sum(cost) paid from orders where client_id = ? and is_paid = 1");
    $select_paid->execute([$_GET['id']]);
    $select_not_paid = $db->prepare("select sum(cost) not_paid from orders where client_id = ? and is_paid = 0");
    $select_not_paid->execute([$_GET['id']]);
    $select_rejected = $db->prepare("select sum(cost) rejected from orders where client_id = ? and status = 'rejected'");
    $select_rejected->execute([$_GET['id']]);
} elseif (isset($_GET['company'])) {
    $select = $db->prepare("SELECT o.id id,o.created created,o.order_no order_no,cl.name client,o.cost cost,c.name company,o.status `status`,o.is_paid is_paid,o.note note,o.receipt_no receipt_no FROM `orders` o left join shipping_companies c on o.shipping_id = c.id left join clients cl on o.client_id = cl.id where o.shipping_id = ? and o.confirmed =1");
    $select->execute([$_GET['company']]);
    $select_paid = $db->prepare("select sum(cost) paid from orders where shipping_id = ? and is_paid = 1");
    $select_paid->execute([$_GET['company']]);
    $select_not_paid = $db->prepare("select sum(cost) not_paid from orders where shipping_id = ? and is_paid = 0");
    $select_not_paid->execute([$_GET['company']]);
    $select_rejected = $db->prepare("select sum(cost) rejected from orders where shipping_id = ? and status = rejected");
    $select_rejected->execute([$_GET['company']]);
} else {
    $select = $db->prepare("SELECT o.id id,o.created created,o.order_no order_no,cl.name client,o.cost cost,c.name company,o.status `status`,o.is_paid is_paid,o.note note,o.receipt_no receipt_no FROM `orders` o left join shipping_companies c on o.shipping_id = c.id left join clients cl on o.client_id = cl.id where o.confirmed =1");
    $select->execute();
    $select_paid = $db->prepare("select sum(cost) paid from orders where is_paid = 1");
    $select_paid->execute();
    $select_not_paid = $db->prepare("select sum(cost) not_paid from orders where is_paid = 0");
    $select_not_paid->execute();
    $select_rejected = $db->prepare("select sum(cost) rejected from orders where status = 'rejected'");
    $select_rejected->execute();
}
$orders = $select->fetchAll(PDO::FETCH_ASSOC);
$total = array_sum(array_column($orders, 'cost'));
$paid = $select_paid->fetch(PDO::FETCH_ASSOC);
$not_paid = $select_not_paid->fetch(PDO::FETCH_ASSOC);
$rejected = $select_rejected->fetch(PDO::FETCH_ASSOC);
include_once 'delete_modal.php';

?>
<section class="content-header">
    <h1>
        الطلبات
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a> الطلبات</a></li>
        <li class="active">كل الطلبات</li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-header" style="direction: rtl !important;">
            <?php if (isset($_GET['id'])) {
                $client_name = get_value($db, 'name', 'clients', 'id', $_GET['id']); ?>
                <h3 class="box-title col-sm-4 pull-right">طلبات العميل <?php echo $client_name; ?></h3>
                <?php
            } elseif (isset($_GET['company'])) {
                $company_name = get_value($db, 'name', 'shipping_companies', 'id', $_GET['company']);
                ?>
                <h3 class="box-title col-sm-4 pull-right">طلبات شركة <?php echo $company_name; ?></h3>
            <?php } else { ?>
                <h3 class="box-title col-sm-4 pull-right">كل الطلبات</h3>
            <?php } ?>
            <span class="col-sm-4 btn bg-maroon btn-flat">عدد الطلبات : <?php echo count($orders); ?></span>
            <span class="col-sm-4 btn bg-navy btn-flat">اجمالي تكلفة الطلبات : <?php echo $total - $rejected['rejected']; ?></span>
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
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
                    <tr <?php if ($order['status'] == 'rejected') {
                        echo 'style="background:indianred;color:#fff"';
                    }elseif ($order['status'] == 'pending'){echo 'style="background:#f39c12;color:#fff"';} ?> >
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo $order['order_no']; ?></td>
                        <td><?php echo $order['client']; ?></td>
                        <td><?php echo $order['cost']; ?></td>
                        <td><?php echo $order['company']; ?></td>
                        <td><?php echo $order['receipt_no']; ?></td>
                        <td><?php if ($order['status'] == 'pending') {
                                echo 'في انتظار التأكيد';
                            } elseif ($order['status'] == 'ready') {
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
                            <a class="btn btn-primary btn-sm" href="order.php?id=<?php echo $order['id']; ?>"
                               data-toggle="tooltip" title="تعديل"><i class="fa fa-edit"></i></a>
                            <a class="btn btn-info btn-sm" href="order_details.php?id=<?php echo $order['id']; ?>"
                               data-toggle="tooltip" title="بيانات الطلب"><i class="fa fa-list"></i></a>
                            <button id="" value="<?php echo $order['id']; ?>" data-toggle="modal"
                                    data-target="#delete_modal" class="btn btn-danger btn-sm delete_btn" title="حذف"><i
                                        class="fa fa-remove"></i></button>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>

            </table>
        </div><!-- /.box-body -->
    </div>
    <div class="box">
        <div class="box-body">
            <table class="table table-bordered table-striped">
                <tr>
                    <th class="text_align_center">اجمالي المدفوع</th>
                    <th class="text_align_center" style="background:#b7ecd4"><?php echo $paid['paid']; ?></th>
                </tr>
                <tr>
                    <th class="text_align_center">اجمالي الغير مدفوع</th>
                    <th class="text_align_center"
                        style="background: indianred;color:#fff"><?php echo $not_paid['not_paid'] - $rejected['rejected']; ?></th>
                </tr>
                <tr>
                    <th class="text_align_center" style="font-size: 20px">اجمالي الطلبات</th>
                    <th class="text_align_center"
                        style="font-size: 20px"><?php echo $total - $rejected['rejected']; ?></th>
                </tr>
            </table>
        </div>
    </div>
</section>
<?php include "footer.php"; ?>
<!-- DataTables -->
<script>
    $(function () {
        $("#example1").DataTable();
    });
</script>
