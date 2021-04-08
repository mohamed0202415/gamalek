<?php include_once 'header.php';
if (isset($_POST['delete_button'])) {
    $get_image = get_value($db, 'image', 'slider', 'id', $_POST['delete_button']);
    $delete = $db->prepare("delete from slider where id = ?");
    try {
        $delete->execute([$_POST['delete_button']]);
        unlink('img/slider/' . $get_image);
        echo '<div class="alert alert-success">تم مسح البيانات بنجاح</div>';
    } catch (PDOException $e) {
        echo '<div class="alert alert-danger">خطأ لم يتم مسح البيانات</div>';
    }
}
$sliders = get_all_rows($db, 'slider');
include_once 'delete_modal.php';
?>
<section class="content-header">
    <h1>
        عارض الصور الأساسي
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a> عارض الصور الأساسي</a></li>
        <li class="active">كل الصور</li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">عارض الصور الأساسي</h3>
            <a class="btn btn-info btn-sm pull-left" href="slider.php">انشاء صورة</a>
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="text_align_center">#</th>
                    <th class="text_align_center">الصورة</th>
                    <th class="text_align_center">الاسم</th>
                    <th class="text_align_center">الوصف</th>
                    <th class="text_align_center">التحكم</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($sliders as $key => $item) { ?>
                    <tr>
                        <td><?php echo $key + 1; ?></td>
                        <td><?php echo $item['image']; ?></td>
                        <td><?php echo $item['name']; ?></td>
                        <td><?php echo $item['description']; ?></td>
                        <td class="text_align_center" style="padding: 0">
                            <a class="btn btn-primary btn-sm" href="slider.php?id=<?php echo $item['id']; ?>"
                               data-toggle="tooltip" title="تعديل"><i class="fa fa-edit"></i></a>
                            <a class="btn btn-info btn-sm" target="_blank" href="/img/slider/<?php echo $item['image']; ?>"
                            data-toggle="tooltip" title="معاينة"><i class="fa fa-picture-o"></i></a>
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

</script>
