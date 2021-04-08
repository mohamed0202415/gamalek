<?php include_once 'header.php';
if(isset($_POST['delete_button'])){
    $delete = $db->prepare("delete from categories where id = ?");
    try {
        $delete->execute([$_POST['delete_button']]);
        echo '<div class="alert alert-success">تم مسح بيانات العميل بنجاح</div>';
    }catch (PDOException $e){
        echo '<div class="alert alert-danger">خطأ لم يتم مسح البيانات</div>';
    }
}
$select = $db->prepare("SELECT c.id id ,c.name `name` ,c.parent_id parent_id,ca.name parent FROM `categories` c left JOIN categories ca on c.parent_id = ca .id");
$select->execute();
$categories = $select->fetchAll(PDO::FETCH_ASSOC);
include_once 'delete_modal.php';
?>
<section class="content-header">
    <h1>
        الفئات
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a> الفئات</a></li>
        <li class="active">كل الفئات</li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">الفئات</h3>
            <a class="btn btn-info btn-sm pull-left" href="category.php">انشاء فئة</a>
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="text_align_center">#</th>
                    <th class="text_align_center">الاسم</th>
                    <th class="text_align_center">نوع الفئة</th>
                    <th class="text_align_center">التحكم</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($categories as $key=>$category){ ?>
                <tr>
                    <td><?php echo $key+1; ?></td>
                    <td><?php echo $category['name'];?></td>
                    <td><?php if($category['parent_id'] == 0){ echo 'فئة أساسية';}else{echo $category['parent'];}?></td>
                    <td class="text_align_center" style="padding: 0">
                        <a class="btn btn-info btn-sm" href="products.php?category=<?php echo $category['id']; ?>" data-toggle="tooltip" title="المنتجات"><i class="fa fa-list"></i></a>
                        <a class="btn btn-primary btn-sm" href="category.php?id=<?php echo $category['id']; ?>" data-toggle="tooltip" title="تعديل"><i class="fa fa-edit"></i></a>
                        <button id="" value="<?php echo $category['id']; ?>" data-toggle="modal" data-target="#delete_modal" class="btn btn-danger btn-sm delete_btn" title="حذف"><i class="fa fa-remove"></i></button>
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
