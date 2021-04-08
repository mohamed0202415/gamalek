<?php include_once 'header.php';
$select = $db->prepare("SELECT id,name,views FROM products");
$select->execute();
$products = $select->fetchAll(PDO::FETCH_ASSOC);
include_once 'delete_modal.php';
?>
<section class="content-header">
    <h1>
        المشاهدات
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li class="active"><a> المشاهدات</a></li>
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
                    <th>عدد المشاهدات</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($products as $key=>$item) { ?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $item['name']; ?></td>
                        <td class="text_align_center"><?php echo $item['views']; ?></td>
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
