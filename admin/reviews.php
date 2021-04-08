<?php
if (isset($_POST['message_id'])) {
    include "includes/config.php";
    $update = $db->prepare("update reviews set is_read = 1 where id =?");
    $update->execute([$_POST['message_id']]);
    echo 1;
    exit();
}
include_once 'header.php';
if (isset($_POST['delete_button'])) {
    $delete = $db->prepare("delete from reviews where id = ?");
    try {
        $delete->execute([$_POST['delete_button']]);
        echo '<div class="alert alert-success">تم مسح البيانات بنجاح</div>';
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">خطأ لم يتم مسح البيانات</div>';
    }
}
$select = $db->prepare("SELECT r.id id , r.is_read is_read,r.stars stars,r.product_id product_id,r.name `name`,r.email email,r.mobile mobile,r.review review,r.user_ip user_ip,r.user_os user_os,r.user_browser user_browser,r.created created ,p.name product  FROM `reviews` r LEFT join products p on r.product_id = p.id");
$select->execute();
$reviews = $select->fetchAll(PDO::FETCH_ASSOC);
include_once 'delete_modal.php';
?>
<section class="content-header">
    <h1>
        التقييمات
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li class="active"><a>التقييمات</a></li>
    </ol>
</section>
<section class="content">
    <div class="box">

        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>المنتج</th>
                    <th>النجوم</th>
                    <th>التقييم</th>
                    <th>الزائر</th>
                    <th>الايميل</th>
                    <th>الهاتف</th>
                    <th>التاريخ</th>
                    <th>التحكم</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($reviews as $key => $item) { ?>
                    <tr <?php if($item['is_read'] == 0){echo 'style="background:#cacaca"'; }?>>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo $item['product']; ?></td>
                        <td><?php echo $item['stars']; ?></td>
                        <td><?php echo $item['review']; ?></td>
                        <td><?php echo $item['name']; ?></td>
                        <td><?php echo $item['email']; ?></td>
                        <td><?php echo $item['mobile']; ?></td>
                        <td><?php echo $item['created']; ?></td>
                        <td>
                            <a data-toggle="tooltip"
                               title="<?php echo $item['user_ip'] . ' , ' . $item['user_os'] . ' , ' . $item['user_browser']; ?>"><i
                                        class="fa fa-reply"></i> </a>
                            <button value="<?php echo $item['id'] ?>"
                                    onclick="markAsRead(<?php echo $item['id'] ?>);" type="button"
                                    data-toggle="tooltip" title="تمت القراءة"
                                    class="btn btn-success btn-sm"><i
                                        class="fa fa-check"></i></button>
                            <button value="<?php echo $item['id']; ?>" data-toggle="modal" data-target="#delete_modal"
                                    class="btn btn-danger btn-sm delete_btn" title="حذف"><i class="fa fa-remove"></i>
                            </button>
                        </td>

                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div><!-- /.box-body -->
    </div>
</section>
<?php include "footer.php"; ?>
<!-- DataTables -->
<script>
    $(function () {
        $("#example1").DataTable();
    });

    function markAsRead(id) {
        $.ajax({
            type: "POST",
            url: "<?php echo $_SERVER['REQUEST_URI'];?>",
            data: {
                message_id: id,
            },
            cache: false,
            success: function (result) {
                if (result == 1) {
                    alert('تم حفظ البيانات');
                } else {
                    alert('خطأ : لم يتم حفظ البيانات برجاء اعادة المحاولة');
                }
            }
        })
        ;
    }
</script>
