<?php
include_once 'header.php';
if (isset($_POST['submit'])){
    $id = get_value($db,'id','suppliers','name',"'".$_POST['name']."'");
    if ($id>0){
        echo '<div class="alert alert-danger">خطأ : هذا الاسم موجود بالفعل في قاعدة البيانات</div>';
    }else{
        $insert = $db->prepare("insert into suppliers(name,mobile,address,note,created,created_by,updated,updated_by) VALUES (?,?,?,?,?,?,?,?)");
        try {
            $insert->execute([$_POST['name'],$_POST['mobile'],$_POST['address'],$_POST['note'],date("Y-m-d H:i:s"),$user_id,date("Y-m-d H:i:s"),$user_id]);
            echo '<div class="alert alert-success">تم حفظ بيانات العميل بنجاح</div>';
        }catch (PDOException $e){
            echo '<div class="alert alert-danger">خطأ لم يتم حفظ البيانات</div>';
            echo $e->getMessage();
        }

    }
}
if (isset($_POST['update'])){
    $id = get_value($db,'id','suppliers','name',"'".$_POST['name']."'");
    if ($id>0 && $id != $_GET['id']){
        echo '<div class="alert alert-danger">خطأ : هذه الاسم موجود بالفعل في قاعدة البيانات</div>';
    }else{
        $update = $db->prepare("update suppliers set name=?,mobile=?,address=?,note=?,updated=?,updated_by=? where id = ?");
        try {
            $update->execute([$_POST['name'],$_POST['mobile'],$_POST['address'],$_POST['note'],date("Y-m-d H:i:s"),$user_id,$_GET['id']]);
            echo '<div class="alert alert-success">تم حفظ بيانات العميل بنجاح</div>';
        }catch (PDOException $e){
            echo '<div class="alert alert-danger">خطأ لم يتم حفظ البيانات</div>';
            echo $e->getMessage();
        }

    }
}
$supplier = false ;
if(isset($_GET['id'])){
    $supplier = get_row($db,'suppliers','id',$_GET['id']);
}
?>
    <section class="content-header">
        <h1>
            العملاء
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
            <li><a href="suppliers.php"> الموردين</a></li>
            <li class="active">انشاء مورد</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">اضافة مورد</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">الاسم</label>
                        <div class="col-sm-10">
                            <input <?php if($supplier){echo 'value="'.$supplier['name'].'"';}?> type="text" name="name" required class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">التليفون</label>
                        <div class="col-sm-10">
                            <input <?php if($supplier){echo 'value="'.$supplier['mobile'].'"';}?> type="text" name="mobile" required class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">العنوان</label>
                        <div class="col-sm-10">
                            <input type="text" <?php if($supplier){echo 'value="'.$supplier['address'].'"';}?> name="address" required class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">ملاحظات</label>
                        <div class="col-sm-10">
                            <input type="text" <?php if($supplier){echo 'value="'.$supplier['note'].'"';}?> name="note" required class="form-control">
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <?php
                    if ($supplier){ ?>
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