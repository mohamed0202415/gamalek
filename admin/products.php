<?php include_once 'header.php';
if(isset($_POST['delete_button'])){
    $delete = $db->prepare("delete from products where id = ?");
    try {
        $delete->execute([$_POST['delete_button']]);
        echo '<div class="alert alert-success">تم مسح البيانات بنجاح</div>';
    }catch (PDOException $e){
        echo '<div class="alert alert-danger">خطأ لم يتم مسح البيانات</div>';
    }
}
if(isset($_GET['category'])){
    $select = $db->prepare("select p.id id,p.name name,p.category_id category_id,p.cost cost,p.amount amount,p.cost*p.amount total,p.discount discount,p.online online,p.created created,c.name category,ca.id main_id,ca.name main_category,m.name manufacturer from products p inner join categories c on p.category_id = c.id inner join categories ca on c.parent_id = ca.id left join manufacturer m on p.manufacturer_id = m.id where p.category_id = ?");
    $select->execute([$_GET['category']]);
}elseif(isset($_GET['company'])){
    $select = $db->prepare("select p.id id,p.name name,p.category_id category_id,p.cost cost,p.amount amount,p.cost*p.amount total,p.discount discount,p.online online,p.created created,c.name category,ca.id main_id,ca.name main_category,m.name manufacturer from products p inner join categories c on p.category_id = c.id inner join categories ca on c.parent_id = ca.id left join manufacturer m on p.manufacturer_id = m.id where p.manufacturer_id = ?");
    $select->execute([$_GET['company']]);
}else{
    $select = $db->prepare("select p.id id,p.name name,p.category_id category_id,p.cost cost,p.amount amount,p.cost*p.amount total,p.discount discount,p.online online,p.created created,c.name category,ca.id main_id,ca.name main_category,m.name manufacturer from products p inner join categories c on p.category_id = c.id inner join categories ca on c.parent_id = ca.id left join manufacturer m on p.manufacturer_id = m.id");
    $select->execute();
}
$products = $select->fetchAll(PDO::FETCH_ASSOC);
include_once 'delete_modal.php';

?>
<section class="content-header">
    <h1>
        المنتجات
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
        <li><a> المنتجات</a></li>
        <li class="active">كل المنتجات</li>
    </ol>
</section>
<section class="content">
    <div class="box">
        <div class="box-header" style="direction: rtl !important;">
            <?php if(isset($_GET['category'])){
                $category_name = get_value($db,'name','categories','id',$_GET['category']); ?>
                <h3 class="box-title">منتجات فئة <?php echo $category_name; ?></h3>
                <?php
            }elseif(isset($_GET['company'])){
                $company_name = get_value($db,'name','manufacturer','id',$_GET['company']);
                ?>
                <h3 class="box-title">منتجات شركة <?php echo $company_name; ?></h3>
            <?php }else{ ?>
                <h3 class="box-title">كل المنتجات</h3>
            <?php } ?>
        </div><!-- /.box-header -->
        <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th class="text_align_center">المنتج</th>
                    <th class="text_align_center">الفئة</th>
                    <th class="text_align_center">الشركة المصنعة</th>
                    <th class="text_align_center">التكلفة</th>
                    <th class="text_align_center">الكمية</th>
                    <th class="text_align_center">الاجمالي</th>
                    <th class="text_align_center">الخصم</th>
                    <th class="text_align_center">العرض</th>
                    <th class="text_align_center">التحكم</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($products as $key=>$product) { ?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $product['category']; ?></td>
                        <td><?php echo $product['manufacturer']; ?></td>
                        <td><?php echo $product['cost']; ?></td>
                        <td><?php echo $product['amount']; ?></td>
                        <td><?php echo $product['total']; ?></td>
                        <td><?php echo $product['discount']; ?></td>
                        <td><?php if($product['online'] == 1){echo 'عرض المنتج';}elseif($product['online'] == 0){echo 'عدم عرض المنتج';}?></td>
                        <td style="padding: 0" class="text_align_center">
                            <a class="btn btn-info btn-sm" href="product_images.php?id=<?php echo $product['id']; ?>" data-toggle="tooltip" title="الصور"><i class="fa fa-picture-o"></i></a>
                            <a class="btn btn-primary btn-sm" href="product.php?id=<?php echo $product['id']; ?>" data-toggle="tooltip" title="تعديل"><i class="fa fa-edit"></i></a>
                            <a class="btn btn-warning btn-sm" href="product_reviews.php?id=<?php echo $product['id']; ?>" data-toggle="tooltip" title="تقييمات المنتج"><i class="fa fa-star-o"></i></a>
                            <button value="<?php echo $product['id']; ?>" data-toggle="modal" data-target="#delete_modal" class="btn btn-danger btn-sm delete_btn" title="حذف"><i class="fa fa-remove"></i></button>
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
