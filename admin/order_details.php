<?php include_once 'header.php';
if (isset($_POST['delete_button'])) {
    $item_quantity = get_value($db, 'quantity', 'order_items', 'id', $_POST['delete_button']);
    $item_product_id = get_value($db, 'product_id', 'order_items', 'id', $_POST['delete_button']);
    $product_amount = get_value($db, 'amount', 'products', 'id', $item_product_id);
    $delete = $db->prepare("delete from order_items where id = ?");
    try {
        $delete->execute([$_POST['delete_button']]);
        $select = $db->prepare("select sum(total_cost) total_cost from order_items where order_id = ?");
        $select->execute([$_GET['id']]);
        $data = $select->fetch(PDO::FETCH_ASSOC);
        $update = $db->prepare('update orders set cost=? where id = ?');
        if($data['total_cost'] == null){
            $data['total_cost'] = 0;
        }
        $update->execute([$data['total_cost'], $_GET['id']]);
        $update = $db->prepare('update products set amount=? where id = ?');
        $update->execute([($item_quantity + $product_amount), $item_product_id]);
        echo '<div class="alert alert-success">تم مسح البيانات بنجاح</div>';
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">خطأ لم يتم مسح البيانات</div>';
        echo $e->getMessage();
    }
}
if (isset($_POST['submit'])) {
    $product = get_row($db, 'products', 'id', $_POST['product']);
    $total_cost = $product['cost'] * $_POST['amount'];
    $insert = $db->prepare("insert into order_items (order_id,product_id,quantity,cost,total_cost,created,created_by,updated,updated_by)values(?,?,?,?,?,?,?,?,?)");
    try {
        $insert->execute([$_GET['id'], $_POST['product'], $_POST['amount'], $product['cost'], $total_cost, date("Y-m-d H:i:s"), $user_id, date("Y-m-d H:i:s"), $user_id]);
        $update = $db->prepare("update products set amount=? where id =?");
        $update->execute([$product['amount'] - $_POST['amount'], $_POST['product']]);
        $order_cost = get_value($db, 'cost', 'orders', 'id', $_GET['id']);
        $update = $db->prepare("update orders set cost=? where id =?");
        $update->execute([$order_cost + $total_cost, $_GET['id']]);
        echo '<div class="alert alert-success">تم حفظ البيانات بنجاح </div>';
    } catch (PDOException $exception) {
        echo '<div class="alert alert-danger"> خطأ: لم تم حفظ البيانات </div>';
    }
}
$select = $db->prepare("SELECT i.id id,i.quantity quantity,i.cost cost,i.total_cost total_cost,i.created created,p.name product FROM `order_items` i inner join products p on i.product_id = p.id where i.order_id=?");
$select->execute([$_GET['id']]);
$order_items = $select->fetchAll(PDO::FETCH_ASSOC);
$select = $db->prepare("select o.id id,o.status status,o.is_paid is_paid,o.cost cost,o.note note,c.name client,sh.name shipping from orders o left join clients c on o.client_id = c.id left join shipping_companies sh on o.shipping_id = sh.id where o.id = ?");
$select->execute([$_GET['id']]);
$order = $select->fetch(PDO::FETCH_ASSOC);
include_once 'delete_modal.php';
include_once 'product_modal.php';

?>
<section class="content-header">
    <h1>
        محتويات الطلب
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a href="orders.php"> الطلبات</a></li>
        <li class="active">محتويات طلب</li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-header" style="direction: rtl !important;">

            <h3 class="box-title col-sm-3 col-xs-6 pull-right">طلب العميل / <?php echo $order['client']; ?></h3>
            <span class="col-sm-4 col-xs-6 btn bg-maroon btn-flat">عدد المنتجات : <?php echo count($order_items); ?></span>
            <span class="col-sm-4 col-xs-6 btn bg-navy btn-flat">اجمالي تكلفة الطلب : <?php echo $order['cost']; ?></span>
            <button class="btn col-xs-6 btn-info col-sm-1 pull-left" data-toggle="modal" data-target="#product_modal"
                    type="button">اضافة منتج
            </button>
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th class="text_align_center">اسم المنتج</th>
                    <th class="text_align_center">الكمية</th>
                    <th class="text_align_center">التكلفة</th>
                    <th class="text_align_center">الاجمالي</th>
                    <th class="text_align_center">التاريخ</th>
                    <th class="text_align_center">التحكم</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($order_items as $key => $item) { ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo $item['product']; ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php echo $item['cost']; ?></td>
                        <td><?php echo $item['total_cost']; ?></td>
                        <td><?php echo $item['created']; ?></td>
                        <td style="padding: 0" class="text_align_center">
                            <button id="" value="<?php echo $item['id']; ?>" data-toggle="modal"
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
                    <th class="text_align_center">حالة الطلب</th>
                    <th class="text_align_center" style="background:#b7ecd4"><?php if ($order['status'] == 'ready') {
                            echo 'تم التجهيز';
                        } elseif ($order['status'] == 'shipped') {
                            echo 'تم الشحن';
                        } elseif ($order['status'] == 'delivered') {
                            echo 'تم التوصيل';
                        } elseif ($order['status'] == 'rejected') {
                            echo 'مرتجع';
                        } ?></th>
                </tr>
                <tr>
                    <th class="text_align_center">شركة الشحن</th>
                    <th class="text_align_center"
                        style="background: indianred;color:#fff"><?php echo $order['shipping']; ?></th>
                </tr>
                <tr>
                    <th class="text_align_center" style="font-size: 20px">حالة الدفع</th>
                    <th class="text_align_center" style="padding:0;font-size: 20px"><?php if ($order['is_paid'] == 1) {
                            echo '<label style="display:block;padding: 5px 2px;text-align:center" class="btn-success">مدفوع</label>';
                        } else {
                            echo '<label style="display:block;padding: 5px 2px;text-align:center" class="btn-warning">غير مدفوع</label>';
                        } ?></th>
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
                if (result == 0) {
                    $('.quant' + id).empty();
                    $('.quant' + id).append('<option value="">0</option>');
                    $('.quant' + id).attr('disabled','disabled');
                } else {
                    $('.quant' + id).removeAttr('disabled');
                    $('.quant' + id).empty();
                    $('.quant' + id).append(result);
                }
            }
        });
    }
</script>
