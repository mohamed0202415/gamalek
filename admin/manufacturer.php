<?php
include_once 'header.php';
if (isset($_POST['submit'])){
    $id = get_value($db,'id','manufacturer','name',"'".$_POST['name']."'");
    if ($id>0){
        echo '<div class="alert alert-danger">خطأ : هذه الشركة موجودة بالفعل في قاعدة البيانات</div>';
    }else{
        $insert = $db->prepare("insert into manufacturer(name,created,created_by,updated,updated_by) VALUES (?,?,?,?,?)");
        try {
            $insert->execute([$_POST['name'],date("Y-m-d H:i:s"),$user_id,date("Y-m-d H:i:s"),$user_id]);
            echo '<div class="alert alert-success">تم حفظ بيانات العميل بنجاح</div>';
        }catch (PDOException $e){
            echo '<div class="alert alert-danger">خطأ لم يتم حفظ البيانات</div>';
            echo $e->getMessage();
        }

    }
}
if (isset($_POST['update'])){
    $id = get_value($db,'id','manufacturer','name',"'".$_POST['name']."'");
    if ($id>0 && $id != $_GET['id']){
        echo '<div class="alert alert-danger">خطأ : هذه الشركة موجودة بالفعل في قاعدة البيانات</div>';
    }else{
        $update = $db->prepare("update manufacturer set name=?,updated=?,updated_by=? where id = ?");
        try {
            $update->execute([$_POST['name'],date("Y-m-d H:i:s"),$user_id,$_GET['id']]);
            echo '<div class="alert alert-success">تم حفظ بيانات العميل بنجاح</div>';
        }catch (PDOException $e){
            echo '<div class="alert alert-danger">خطأ لم يتم حفظ البيانات</div>';
            echo $e->getMessage();
        }

    }
}
$manufacturer = false ;
if(isset($_GET['id'])){
    $manufacturer = get_row($db,'manufacturer','id',$_GET['id']);
}
?>
    <section class="content-header">
        <h1>
            الشركات المصنعة
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
            <li><a href="manufacturers.php"> الشركات المصنعة</a></li>
            <li class="active">انشاء شركة</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">اضافة شركة</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">الاسم</label>
                        <div class="col-sm-10">
                            <input <?php if($manufacturer){echo 'value="'.$manufacturer['name'].'"';}?> type="text" name="name" required class="form-control">
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <?php
                    if ($manufacturer){ ?>
                        <button type="submit" name="update" class="btn btn-success">تحديث البيانات</button>
                    <?php }else{ ?>
                    <button type="submit" name="submit" class="btn btn-info">حفظ البيانات</button>
                    <?php } ?>
                    <button type="button" onclick="history.back();" class="btn btn-default">الغاء</button>
                </div><!-- /.box-footer -->
            </form>
        </div><!-- /.box -->
    </section>
<?php include "footer.php"; ?>