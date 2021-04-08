<?php
if(isset($_POST['catId'])){
    include "includes/config.php";
    include "includes/helper.php";
    $cats = get_all_rows_with_parent($db,'categories',$_POST['catId']);
    echo '<option value="">اختار</option>';
    foreach ($cats as $key=>$item){
        echo '<option value="'.$item['id'].'">'.$item['name'].'</option>';
    }
    exit();
}
include_once 'header.php';
if (isset($_POST['submit'])){
    $id = get_value($db,'id','products','name',"'".$_POST['name']."'");
    if ($id>0){
        echo '<div class="alert alert-danger">خطأ : رقم المنتج موجود بالفعل في قاعدة البيانات</div>';
    }else{
        $insert = $db->prepare("insert into products(name,category_id,manufacturer_id,cost,amount,size,total_cost,discount,online,created,created_by,updated,updated_by) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
        try {
            $insert->execute([$_POST['name'],$_POST['category'],$_POST['manufacturer'],$_POST['cost'],$_POST['amount'],$_POST['size'],$_POST['cost']*$_POST['amount'],$_POST['discount'],$_POST['online'],date("Y-m-d H:i:s"),$user_id,date("Y-m-d H:i:s"),$user_id]);
            echo '<div class="alert alert-success">تم حفظ البيانات بنجاح</div>';
        }catch (PDOException $e){
            echo '<div class="alert alert-danger">خطأ لم يتم حفظ البيانات</div>';
            echo $e->getMessage();
        }

    }
}
if (isset($_POST['update'])){
    $id = get_value($db,'id','clients','name',"'".$_POST['name']."'");
    if ($id>0 && $id != $_GET['id']){
        echo '<div class="alert alert-danger">خطأ : رقم المنتج موجود بالفعل في قاعدة البيانات</div>';
    }else{
        $update = $db->prepare("update products set name=?,category_id=?,manufacturer_id=?,cost=?,amount=?,size=?,total_cost=?,discount=?,online=?,description=?,updated=?,updated_by=? where id = ?");
        try {
            $update->execute([$_POST['name'],$_POST['category'],$_POST['manufacturer'],$_POST['cost'],$_POST['amount'],$_POST['size'],$_POST['cost']*$_POST['amount'],$_POST['discount'],$_POST['online'],$_POST['description'],date("Y-m-d H:i:s"),$user_id,$_GET['id']]);
            echo '<div class="alert alert-success">تم حفظ البيانات بنجاح</div>';
        }catch (PDOException $e){
            echo '<div class="alert alert-danger">خطأ لم يتم حفظ البيانات</div>';
            echo $e->getMessage();
        }

    }
}
$product_row = false ;
if(isset($_GET['id'])){
    $select = $db->prepare("select p.id id,p.name name,p.description description,p.category_id category_id,p.manufacturer_id manufacturer_id,p.cost cost,p.amount amount,p.size size,p.discount discount,p.online online,p.created created,c.name category,ca.id main_id,ca.name main_category,m.name manufacturer from products p inner join categories c on p.category_id = c.id inner join categories ca on c.parent_id = ca.id left join manufacturer m on p.manufacturer_id = m.id where p.id = ?");
    $select->execute([$_GET['id']]);
    $product_row = $select->fetch(PDO::FETCH_ASSOC);
}
?>
    <section class="content-header">
        <h1>
            العملاء
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
            <li><a href="products.php">المنتجات</a></li>
            <li class="active">انشاء منتج</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">اضافة منتج</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">الاسم</label>
                        <div class="col-sm-10">
                            <input <?php if($product_row){echo 'value="'.$product_row['name'].'"';}?> type="text" name="name" required class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">الفئة الاساسية</label>
                        <div class="col-sm-10">
                            <?php $categories = get_all_rows_with_parent($db,'categories',0);?>
                            <select class="form-control" name="main" id="main">
                                    <option value="">اختار</option>
                                    <?php foreach($categories as $key=>$item){?>
                                        <option <?php if($item['id']==$product_row['main_id']){echo 'selected';}?> value="<?php echo $item['id'];?>"><?php echo $item['name'];?></option>
                                    <?php } ?>
                                </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">الفئة</label>
                        <div class="col-sm-10">
                            <select class="form-control" required name="category" id="category">
                                <option value="">اختار</option>
                                <?php if($product_row){
                                    $sub_categories = get_all_rows_with_parent($db,'categories',$product_row['main_id']);
                                    foreach ($sub_categories as $sub){
                                        ?>
                                        <option <?php if($sub['id']==$product_row['category_id']){echo 'selected';}?> value="<?php echo $sub['id'];?>"><?php echo $sub['name'];?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">الشركة المصنعة</label>
                        <div class="col-sm-10">
                            <?php $manufacturer = get_all_rows($db,'manufacturer');?>
                            <select class="form-control" name="manufacturer" id="manufacturer">
                                <option value="">اختار</option>
                                <?php foreach($manufacturer as $key=>$item){?>
                                    <option <?php if($item['id']==$product_row['manufacturer_id']){echo 'selected';}?> value="<?php echo $item['id'];?>"><?php echo $item['name'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">الحجم (بالمللي)</label>
                        <div class="col-sm-10">
                            <input <?php if($product_row){echo 'value="'.$product_row['size'].'"';}?> type="text" name="size" required class="form-control" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">التكلفة (بالجنيه)</label>
                        <div class="col-sm-10">
                            <input <?php if($product_row){echo 'value="'.$product_row['cost'].'"';}?> type="text" name="cost" required class="form-control" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">الكمية</label>
                        <div class="col-sm-10">
                            <input type="text" <?php if($product_row){echo 'value="'.$product_row['amount'].'"';}?> name="amount" required class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">الخصم (بالجنيه)</label>
                        <div class="col-sm-10">
                            <input type="text" value="<?php if($product_row){echo $product_row['discount'];}else{echo 0;}?>" name="discount" required class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">عرض المنتج</label>
                        <div class="col-sm-10">
                            <select name="online" class="form-control">
                                <option <?php if($product_row['online'] == 1){echo 'selected';}?> value="1">عرض المنتج</option>
                                <option <?php if($product_row['online'] == 0){echo 'selected';}?> value="0">عدم عرض المنتج</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">وصف المنتج</label>
                        <div class="col-sm-10">
                            <textarea name="description" id="editor1" class="form-control"><?php if($product_row){echo $product_row['description'];}?></textarea>
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <?php
                    if ($product_row){ ?>
                        <button type="submit" name="update" class="btn btn-success">تحديث البيانات</button>
                    <?php }else{ ?>
                    <button type="submit" name="submit" class="btn btn-info">حفظ البيانات</button>
                    <?php } ?>
                    <button type="button" onclick="history.back();" class="btn btn-default">الغاء</button>
                </div><!-- /.box-footer -->
            </form>
        </div><!-- /.box -->
    </section>
<?php include "footer.php   "; ?>
<script src="https://cdn.ckeditor.com/4.4.3/standard/ckeditor.js"></script>
<script>
    $("#main").change(function(){
        var cat_id = $(this).val();
        $.ajax({
            type: "POST",
            url: "product.php",
            data: {
                catId: cat_id
            },
            cache: false,
            success: function (result) {
                $("#category").empty();
                $("#category").append(result);
            }
        });
    });
    $(function () {
        CKEDITOR.replace('editor1');
    });
</script>
