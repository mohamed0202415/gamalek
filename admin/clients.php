<?php include_once 'header.php';
if(isset($_POST['delete_button'])){
    $delete = $db->prepare("delete from clients where id = ?");
    try {
        $delete->execute([$_POST['delete_button']]);
        echo '<div class="alert alert-success">تم مسح بيانات العميل بنجاح</div>';
    }catch (PDOException $e){
        echo '<div class="alert alert-danger">خطأ لم يتم مسح البيانات</div>';
    }
}
$select = $db->prepare("select c.id id,c.name `name`,c.mobile mobile ,c.city_id city_id, c.address address ,c.created created,ci.name city,cit.name gov from clients c inner join cities ci on c.city_id = ci.id left join cities cit on ci.parent_id = cit.id");
$select->execute();
$clients = $select->fetchAll(PDO::FETCH_ASSOC);
include_once 'delete_modal.php';
?>
<section class="content-header">
    <h1>
        العملاء
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a> العملاء</a></li>
        <li class="active">كل العملاء</li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">العملاء</h3>
            <a class="btn btn-info btn-sm pull-left" href="client.php">انشاء عميل</a>
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th class="text_align_center">#</th>
                    <th class="text_align_center">الاسم</th>
                    <th class="text_align_center">رقم التليفون</th>
                    <th class="text_align_center">المحافظة</th>
                    <th class="text_align_center">المدينة</th>
                    <th class="text_align_center">العنوان</th>
                    <th class="text_align_center">التحكم</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($clients as $key=>$client){ ?>
                <tr>
                    <td><?php echo $key+1; ?></td>
                    <td><?php echo $client['name'];?></td>
                    <td><?php echo $client['mobile'];?></td>
                    <td><?php echo $client['gov'];?></td>
                    <td><?php echo $client['city'];?></td>
                    <td><?php echo $client['address'];?></td>
                    <td class="text_align_center" style="padding: 0">
                        <a class="btn btn-info btn-sm" href="orders.php?id=<?php echo $client['id']; ?>" data-toggle="tooltip" title="الطلبات"><i class="fa fa-list"></i></a>
                        <a class="btn btn-primary btn-sm" href="client.php?id=<?php echo $client['id']; ?>" data-toggle="tooltip" title="تعديل"><i class="fa fa-edit"></i></a>
                        <button id="" value="<?php echo $client['id']; ?>" data-toggle="modal" data-target="#delete_modal" class="btn btn-danger btn-sm delete_btn" title="حذف"><i class="fa fa-remove"></i></button>
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
