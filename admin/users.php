<?php include_once 'header.php';
if(isset($_POST['delete_button'])){
    $delete = $db->prepare("delete from users where id = ?");
    try {
        $delete->execute([$_POST['delete_button']]);
        echo '<div class="alert alert-success">تم مسح بيانات العميل بنجاح</div>';
    }catch (PDOException $e){
        echo '<div class="alert alert-danger">خطأ لم يتم مسح البيانات</div>';
    }
}
$users = get_all_rows($db,'users');
include_once 'delete_modal.php';
?>
<section class="content-header">
    <h1>
        المستخدمين
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a> المستخدمين</a></li>
        <li class="active">كل المستخدمين</li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">المستخدمين</h3>
            <a class="btn btn-info btn-sm pull-left" href="user.php">انشاء مستخدم</a>
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="text_align_center">#</th>
                    <th class="text_align_center">الاسم</th>
                    <th class="text_align_center">اسم الدخول</th>
                    <th class="text_align_center">الموبايل</th>
                    <th class="text_align_center">التحكم</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $key=>$user){ ?>
                <tr>
                    <td><?php echo $key+1; ?></td>
                    <td><?php echo $user['name'];?></td>
                    <td><?php echo $user['username'];?></td>
                    <td><?php echo $user['mobile'];?></td>
                    <td class="text_align_center" style="padding: 0">
                        <a class="btn btn-primary btn-sm" href="user.php?id=<?php echo $user['id']; ?>" data-toggle="tooltip" title="تعديل"><i class="fa fa-edit"></i></a>
                        <button value="<?php echo $user['id']; ?>" data-toggle="modal" data-target="#delete_modal" class="btn btn-danger btn-sm delete_btn" title="حذف"><i class="fa fa-remove"></i></button>
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
