<?php
if (isset($_POST['message_id'])) {
    include "includes/config.php";
    $update = $db->prepare("update contact set is_read = 1 where id =?");
    $update->execute([$_POST['message_id']]);
    echo 1;
    exit();
}
include 'header.php';
$messages = get_all_rows($db, 'contact');
include 'delete_modal.php';
?>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">الرسائل</h3>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                    <div class="table-responsive mailbox-messages">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>الايميل</th>
                                <th>التليفون</th>
                                <th>الموضوع</th>
                                <th>الرسالة</th>
                                <th>التحكم</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($messages as $item) { ?>
                                <tr <?php if($item['is_read'] == 0){echo 'style="background:#cacaca"'; }?>>
                                    <td><?php echo $item['name'] ?></td>
                                    <td><?php echo $item['email'] ?></td>
                                    <td><?php echo $item['mobile'] ?></td>
                                    <td><?php echo $item['subject'] ?></td>
                                    <td><?php echo $item['message'] ?></td>
                                    <td style="text-align: center">
                                        <button value="<?php echo $item['id'] ?>"
                                                onclick="markAsRead(<?php echo $item['id'] ?>);" type="button"
                                                data-toggle="tooltip" title="تمت القراءة"
                                                class="btn btn-success btn-sm"><i
                                                    class="fa fa-check"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#delete_modal"><i class="fa fa-remove"></i></button>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table><!-- /.table -->
                    </div><!-- /.mail-box-messages -->
                </div><!-- /.box-body -->
            </div><!-- /. box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</section>
<?php include 'footer.php'; ?>
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