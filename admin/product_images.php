<?php
ob_start();
include_once 'header.php';
if (isset($_POST['submit'])) {
    $id = get_value($db, 'id', 'product_images', 'image', "'" . basename($_FILES["fileToUpload"]["name"]) . "'");
    if ($id > 0) {
        echo '<div class="alert alert-danger">خطأ : توجد صورة بهذا الاسم بالفعل في قاعدة البيانات</div>';
    } else {
        $target_dir = "../img/products/large/";
        $file = basename($_FILES["fileToUpload"]["name"]);
        $target_file = $target_dir . $file;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo '<div class="alert alert-danger"> الملف ' . basename($_FILES["fileToUpload"]["name"]) . ' ليس صورة حقيقية.</div>';
            $uploadOk = 0;
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            echo '<div class="alert alert-danger"> الملف ' . basename($_FILES["fileToUpload"]["name"]) . ' موجودة بالفعل.</div>';
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 1500000) {
            echo '<div class="alert alert-danger"> حجم الصورة ' . basename($_FILES["fileToUpload"]["name"]) . ' تخطى الحجم المسموح.</div>';
            $uploadOk = 0;
        }
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            echo '<div class="alert alert-danger"> نوع الصورة المسوح به فقط هو :JPG, JPEG, PNG & GIF.</div>';
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            //echo '<div class="alert alert-danger"> حدث خطأ اثناء تحميل الصوره .' . basename($_FILES["fileToUpload"]["name"]) . 'برجاء اعادة المحاولة </div>';
            // if everything is ok, try to upload file
        } else {
            $insert = $db->prepare("insert into product_images (image,product_id,main,description,created,created_by,updated,updated_by) Values (?,?,?,?,?,?,?,?)");
            try {
                $insert->execute([$file, $_GET['id'], 0, $_POST['description'], date("Y-m-d H:i:s"), $user_id, date("Y-m-d H:i:s"), $user_id]);
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    include 'includes/resizeImage.php';
                    $resize = new ResizeImage($target_file);
                    $resize->resizeTo(50, 50, 'exact');
                    $resize->saveImage('../img/products/thumbnail/' . $file);
                    $resize = new ResizeImage($target_file);
                    $resize->resizeTo(250, 300, 'exact');
                    $resize->saveImage('../img/products/medium/' . $file);
                    echo '<div class="alert alert-success">تم حفظ البيانات بنجاح</div>';
//                echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
                } else {
                    echo '<div class="alert alert-danger"> حدث خطأ اثناء تحميل الصوره .' . basename($_FILES["fileToUpload"]["name"]) . 'برجاء اعادة المحاولة </div>';
                }
            } catch (PDOException $e) {

            }
        }
    }
}
//if (isset($_POST['update'])) {
//    $id = get_value($db, 'id', 'clients', 'name', "'" . $_POST['name'] . "'");
//    if ($id > 0 && $id != $_GET['id']) {
//        echo '<div class="alert alert-danger">خطأ : رقم المنتج موجود بالفعل في قاعدة البيانات</div>';
//    } else {
//        $update = $db->prepare("update products set name=?,category_id=?,manufacturer_id=?,cost=?,amount=?,total_cost=?,discount=?,online=?,updated=?,updated_by=? where id = ?");
//        try {
//            $update->execute([$_POST['name'], $_POST['category'], $_POST['manufacturer'], $_POST['cost'], $_POST['amount'], $_POST['cost'] * $_POST['amount'], $_POST['discount'], $_POST['online'], date("Y-m-d H:i:s"), $user_id, $_GET['id']]);
//            echo '<div class="alert alert-success">تم حفظ البيانات بنجاح</div>';
//        } catch (PDOException $e) {
//            echo '<div class="alert alert-danger">خطأ لم يتم حفظ البيانات</div>';
//            echo $e->getMessage();
//        }
//
//    }
//}
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $select = $db->prepare("select p.id id,p.name name,p.created created,c.name category,ca.id main_id,ca.name main_category,m.name manufacturer from products p inner join categories c on p.category_id = c.id inner join categories ca on c.parent_id = ca.id left join manufacturer m on p.manufacturer_id = m.id where p.id = ?");
    $select->execute([$_GET['id']]);
    $product_row = $select->fetch(PDO::FETCH_ASSOC);
    include "delete_modal.php";
    include "main_image.php";
    if(isset($_POST['delete_button'])){
        $image_row = get_row($db,'product_images','id',$_POST['delete_button']);
        unlink('../img/products/large/'.$image_row['image']);
        unlink('../img/products/medium/'.$image_row['image']);
        unlink('../img/products/thumbnail/'.$image_row['image']);
//        $delete = delete($db,'product_images',$_POST['delete_button']);
        $delete = $db->prepare("delete from product_images where id =?");
        try{
            $delete->execute([$_POST['delete_button']]);
            echo '<div class="alert alert-success">تم حذف البيانات بنجاح </div>';
        }catch(PDOException $e){
            echo '<div class="alert alert-danger">لم يتم الحذف . برجاء اعادة المحاولة</div>';
        }
    }
    if(isset($_POST['main_image'])){
        $update = $db->prepare("update product_images set main=0 where product_id = ?");
        try {
            $update->execute([$_GET['id']]);
            $update2 = $db->prepare("update product_images set main=1 where id = ?");
            try {
                $update2->execute([$_POST['main_image']]);
                echo '<div class="alert alert-success">تم تعيين الصورة بنجاح </div>';
            }catch (PDOException $exp){
                echo '<div class="alert alert-danger">لم يتم التعيين . برجاء اعادة المحاولة</div>';
            }
        }catch(PDOException $e){
            echo '<div class="alert alert-danger">لم يتم التعيين . برجاء اعادة المحاولة</div>';
        }
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
            <li><a href="product.php?id=<?php echo $_GET['id']; ?>">بيانات المنتج</a></li>
            <li class="active">صور منتج</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">اضافة صور للمنتج <?php echo $product_row['name']; ?></h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">صور المنتج</label>
                        <div class="col-sm-10">
                            <input type="file" name="fileToUpload" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">وصف المنتج</label>
                        <div class="col-sm-10">
                            <input type="text" name="description" class="form-control">
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" name="submit" class="btn btn-info">حفظ البيانات</button>
                    <button type="button" onclick="history.back();" class="btn btn-default">الغاء</button>
                </div><!-- /.box-footer -->
            </form>
        </div><!-- /.box -->
    </section>
    <link href="../css/style.css" rel="stylesheet">
    <section id="aa-product-category" style="float:none;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="aa-product-catg-content">
                        <div class="aa-product-catg-head">
                            <div class="aa-product-catg-head-left pull-right" style="font-size: 22px;width:100%">
                                <div class="aa-product-catg-body">
                                    <ul class="aa-product-catg">
                                        <!-- start single product item -->
                                        <?php
                                        $select = $db->prepare("select * from product_images where product_id = ?");
                                        $select->execute([$_GET['id']]);
                                        $product_images = $select->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($product_images as $key => $product) { ?>
                                            <li class="col-sm-3">
                                                <figure>
                                                    <a class="aa-product-img" target="_blank" href="../img/products/large/<?php echo $product['image']; ?>"><img
                                                                src="../img/products/medium/<?php echo $product['image']; ?>"
                                                                alt="polo shirt img"></a>
                                                    <a class="aa-add-card-btn" style="padding: 5px 10px;font-size: 13px"><?php echo $product['image']; ?></a>

                                                </figure>
                                                <div class="aa-product-hvr-content">
                                                    <button value="<?php echo  $product['id']; ?>" class="btn-info main_image" data-toggle="tooltip" data-placement="top" title="" data-original-title="تعيين صورة أساسية"><span class="fa fa-check" style="margin: 7px 4px;"></span></button>
                                                    <a href="../img/products/large/<?php echo $product['image']; ?>" target="_blank" data-toggle2="tooltip" data-placement="top"  data-toggle="tooltip" data-target="#quick-view-modal" data-original-title="معاينة"><span class="fa fa-picture-o"></span></a>
                                                    <button class="btn-danger delete_btn" value="<?php echo  $product['id']; ?>" style="color: #ff6666;" data-toggle="modal" data-target="#delete_modal" data-placement="top" title="حذف" data-original-title="حذف"><span style="margin: 7px 4px;" class="fa fa-remove"></span></button>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include "footer.php   "; ?>
    <script>
        $(".main_image").click(function(){
            $('#main_image').modal('show');
            var id = $(this).val();
            $("#main_id").val(id);
        });
    </script>

<?php } else {
    header("location:products.php");
}
ob_end_flush();
?>