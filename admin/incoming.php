<?php include_once 'header.php';
if(isset($_POST['delete_button'])){
    $delete = $db->prepare("delete from incoming where id = ?");
    try {
        $delete->execute([$_POST['delete_button']]);
        echo '<div class="alert alert-success">تم مسح البيانات بنجاح</div>';
    }catch (PDOException $e){
        echo '<div class="alert alert-danger">خطأ لم يتم مسح البيانات</div>';
    }
}
    $select = $db->prepare("select i.id id,i.name name,i.amount amount,i.cost cost ,i.note note , s.name supplier,i.created created from incoming i left join suppliers s on i.supplier_id = s.id ");
    $select->execute();
    $incoming = $select->fetchAll(PDO::FETCH_ASSOC);
include_once 'delete_modal.php';?>
<section class="content-header">
    <h1>
        الواردات
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a> الواردات</a></li>
        <li class="active">كل الورادات</li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-header">
            <h3 class="col-sm-4 box-title pull-right">الورادات</h3>
            <span class="col-sm-4 btn bg-maroon btn-flat"> عدد الواردات :<?php echo count($incoming); ?></span>
            <span class="col-sm-4 btn bg-navy btn-flat">اجمالي تكلفة الواردات : <?php $sum = get_value($db,'sum(cost)','incoming',1,1); echo $sum;?></span>
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>المورد</th>
                    <th>الكمية</th>
                    <th>التكلفة</th>
                    <th>ملاحظات</th>
                    <th>التحكم</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($incoming as $key=>$income) {

                ?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $income['name'];?></td>
                        <td><?php echo $income['supplier'];?></td>
                        <td><?php echo $income['amount'];?></td>
                        <td><?php echo $income['cost'];?></td>
                        <td><?php echo $income['note'];?></td>
                        <td style="text-align: center">
                            <a class="btn btn-primary btn-sm" href="income.php?id=<?php echo $income['id']; ?>" data-toggle="tooltip" title="تعديل"><i class="fa fa-edit"></i></a>
                            <button value="<?php echo $income['id']; ?>" data-toggle="modal" data-target="#delete_modal" class="btn btn-danger btn-sm delete_btn" title="حذف"><i class="fa fa-remove"></i></button>
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
