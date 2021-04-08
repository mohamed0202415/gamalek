<?php include_once 'header.php';
    if(isset($_POST['delete_button'])){
        $delete = $db->prepare("delete from suppliers where id = ?");
        try {
            $delete->execute([$_POST['delete_button']]);
            echo '<div class="alert alert-success">تم مسح البيانات بنجاح</div>';
        }catch (PDOException $e){
            echo '<div class="alert alert-danger">خطأ لم يتم مسح البيانات</div>';
        }
    }
    $suppliers = get_all_rows($db,'suppliers');
include_once 'delete_modal.php';
?>
<section class="content-header">
    <h1>
        الموردين
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a> الموردين</a></li>
        <li class="active">كل الموردين</li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">الموردين</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>اسم المورد</th>
                    <th>العنوان</th>
                    <th>رقم التليفون</th>
                    <th>المنتج</th>
                    <th>التحكم</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($suppliers as $key=>$supplier) { ?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $supplier['name']; ?></td>
                        <td><?php echo $supplier['address']; ?></td>
                        <td><?php echo $supplier['mobile']; ?></td>
                        <td><?php echo $supplier['note']; ?></td>
                        <td>
                            <a class="btn btn-info btn-sm" href="incoming.php?id=<?php echo $supplier['id']; ?>" data-toggle="tooltip" title="الواردات"><i class="fa fa-list"></i></a>
                            <a class="btn btn-primary btn-sm" href="supplier.php?id=<?php echo $supplier['id']; ?>" data-toggle="tooltip" title="تعديل"><i class="fa fa-edit"></i></a>
                            <button value="<?php echo $supplier['id']; ?>" data-toggle="modal" data-target="#delete_modal" class="btn btn-danger btn-sm delete_btn" title="حذف"><i class="fa fa-remove"></i></button>
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
