<?php include 'header.php';
if (isset($_POST['update'])) {
    $system_info = get_all_rows($db, 'system_info');
    $updated = 0;
    foreach ($system_info as $item) {
        $update = $db->prepare("update system_info set value = ? where id=?");
        try {
            $update->execute([$_POST['info'][$item['id']], $item['id']]);
            $updated = 1;
        } catch (PDOException $exception) {
            $updated = 0;
        }
    }
    if ($updated == 1) {
        echo '<div class="alert alert-success">تم حفظ البيانات بنجاح</div>';
    } else {
        echo '<div class="alert alert-danger">خطأ لم يتم حفظ البيانات</div>';
    }
}
$system_info = get_all_rows($db, 'system_info');
?>
<section class="content-header">
    <h1>
        اعدادات التواصل
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li class="active">اعدادات التواصل</li>
    </ol>
</section>
<section class="content">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">اعدادات التواصل</h3>
        </div><!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="box-body">
                <?php foreach ($system_info

                               as $item) { ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label"><?php echo $item['name']; ?></label>
                        <div class="col-sm-10">
                            <input value="<?php echo $item['value']; ?> "
                                   type="text" name="info[<?php echo $item['id']; ?>]" required class="form-control">
                        </div>
                    </div>
                <?php } ?>
            </div><!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" name="update" class="btn btn-success">تحديث البيانات</button>
                <button type="button" onclick="history.back();" class="btn btn-default">الغاء</button>
            </div><!-- /.box-footer -->
        </form>
    </div><!-- /.box -->
</section>

<?php include "footer.php"; ?>
