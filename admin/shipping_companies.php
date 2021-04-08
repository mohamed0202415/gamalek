<?php include_once 'header.php';
if(isset($_POST['delete_button'])){
    $delete = $db->prepare("delete from shipping_companies where id = ?");
    try {
        $delete->execute([$_POST['delete_button']]);
        echo '<div class="alert alert-success">تم مسح البيانات بنجاح</div>';
    }catch (PDOException $e){
        echo '<div class="alert alert-danger">خطأ لم يتم مسح البيانات</div>';
    }
}
$shipping_companies = get_all_rows($db,'shipping_companies');
include_once 'delete_modal.php';
?>
<section class="content-header">
    <h1>
        شركات الشحن
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a> شركات الشحن</a></li>
        <li class="active">كل الشركات</li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">شركات الشحن</h3>
            <a class="btn btn-info btn-sm pull-left" href="company.php">انشاء شركة</a>
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="text_align_center">#</th>
                    <th class="text_align_center">الاسم</th>
                    <th class="text_align_center">رقم التليفون</th>
                    <th class="text_align_center">العنوان</th>
                    <th class="text_align_center">التحكم</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($shipping_companies as $key=>$company){ ?>
                <tr>
                    <td><?php echo $key+1; ?></td>
                    <td><?php echo $company['name'];?></td>
                    <td><?php echo $company['mobile'];?></td>
                    <td><?php echo $company['address'];?></td>
                    <td class="text_align_center" style="padding: 0">
                        <a class="btn btn-info btn-sm" href="orders.php?company=<?php echo $company['id']; ?>" data-toggle="tooltip" title="الطلبات"><i class="fa fa-list"></i></a>
                        <a class="btn btn-primary btn-sm" href="company.php?id=<?php echo $company['id']; ?>" data-toggle="tooltip" title="تعديل"><i class="fa fa-edit"></i></a>
                        <button id="" value="<?php echo $company['id']; ?>" data-toggle="modal" data-target="#delete_modal" class="btn btn-danger btn-sm delete_btn" title="حذف"><i class="fa fa-remove"></i></button>
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
    $(".delete_btn").click(function(){
        var id = $(this).val();
        $("#delete_id").val(id);
    });
</script>
