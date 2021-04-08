<?php
include_once 'header.php';
if (isset($_POST['submit'])) {
    $id = get_value($db, 'id', 'slider', 'image', "'" . basename($_FILES["fileToUpload"]["name"]) . "'");
    if ($id > 0) {
        echo '<div class="alert alert-danger">خطأ : هذه الشركة موجودة بالفعل في قاعدة البيانات</div>';
    } else {
        $target_dir = "../img/slider/";
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
            $insert = $db->prepare("insert into slider (image,name,description,quote,link,created,created_by,updated,updated_by) Values (?,?,?,?,?,?,?,?,?)");
            try {
                $insert->execute([$file,$_POST['name'], $_POST['description'], $_POST['quote'],$_POST['link'],date("Y-m-d H:i:s"), $user_id, date("Y-m-d H:i:s"), $user_id]);
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    echo '<div class="alert alert-success">تم حفظ البيانات بنجاح</div>';
//                echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
                } else {
                    echo '<div class="alert alert-danger"> حدث خطأ اثناء تحميل الصوره .' . basename($_FILES["fileToUpload"]["name"]) . 'برجاء اعادة المحاولة </div>';
                }
            } catch (PDOException $e) {
                echo '<div class="alert alert-danger">خطأ لم يتم حفظ البيانات</div>';
            }
        }
    }
}
if (isset($_POST['update'])) {
        $update = $db->prepare("update slider set name=?,description=?,quote=?,link=?,updated=?,updated_by=? where id = ?");
        try {
            $update->execute([$_POST['name'],$_POST['description'],$_POST['quote'],$_POST['link'], date("Y-m-d H:i:s"), $user_id, $_GET['id']]);
            echo '<div class="alert alert-success">تم حفظ بيانات العميل بنجاح</div>';
        } catch (PDOException $e) {
            echo '<div class="alert alert-danger">خطأ لم يتم حفظ البيانات</div>';
            echo $e->getMessage();
        }
}
$slider = false;
if (isset($_GET['id'])) {
    $slider = get_row($db, 'slider', 'id', $_GET['id']);
}
?>
    <section class="content-header">
        <h1>
            عارض الصور الأساسي
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
            <li><a href="sliders.php"> عارض الصور الأساسي</a></li>
            <li class="active">انشاء صورة</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">اضافة صورة</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">الاسم</label>
                        <div class="col-sm-10">
                            <input <?php if ($slider) {
                                echo 'value="' . $slider['name'] . '"';
                            } ?> type="text" name="name" required class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">الوصف</label>
                        <div class="col-sm-10">
                            <input <?php if ($slider) {
                                echo 'value="' . $slider['description'] . '"';
                            } ?> type="text" name="description" required class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">كلمة مختصرة</label>
                        <div class="col-sm-10">
                            <input <?php if ($slider) {
                                echo 'value="' . $slider['quote'] . '"';
                            } ?> type="text" name="quote" required class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">الرابط</label>
                        <div class="col-sm-10">
                            <input <?php if ($slider) {
                                echo 'value="' . $slider['link'] . '"';
                            } ?> type="text" name="link" required class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">الصورة (1920*850)</label>
                        <div class="col-sm-10">
                            <input <?php if ($slider) {
                                echo 'value="' . $slider['image'] . '"';
                            } ?> type="file" name="fileToUpload" <?php if($slider){}else{echo 'required';}?> class="form-control">
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <?php
                    if ($slider) { ?>
                        <button type="submit" name="update" class="btn btn-success">تحديث البيانات</button>
                    <?php } else { ?>
                        <button type="submit" name="submit" class="btn btn-info">حفظ البيانات</button>
                    <?php } ?>
                    <button type="button" onclick="history.back();" class="btn btn-default">الغاء</button>
                </div><!-- /.box-footer -->
            </form>
        </div><!-- /.box -->
        <?php
        if ($slider) {
            echo '<img width="1000px" src="../img/slider/' . $slider['image'] . '" />';
        }
        ?>
    </section>

<?php include "footer.php"; ?>