<?php
include_once 'header.php';
if (isset($_POST['submit'])){
//    $id = get_value($db,'id','incoming','name',"'".$_POST['name']."'");
//    if ($id>0){
//        echo '<div class="alert alert-danger">خطأ : هذا الاسم موجود بالفعل في قاعدة البيانات</div>';
//    }else{
        $insert = $db->prepare("insert into incoming(name,supplier_id,amount,cost,note,created,created_by,updated,updated_by) VALUES (?,?,?,?,?,?,?,?,?)");
        try {
            $insert->execute([$_POST['name'],$_POST['supplier'],$_POST['amount'],$_POST['cost'],$_POST['note'],date("Y-m-d H:i:s"),$user_id,date("Y-m-d H:i:s"),$user_id]);
            echo '<div class="alert alert-success">تم حفظ البيانات بنجاح</div>';
        }catch (PDOException $e){
            echo '<div class="alert alert-danger">خطأ لم يتم حفظ البيانات</div>';
            echo $e->getMessage();
        }
//    }
}
if (isset($_POST['update'])){
//    $id = get_value($db,'id','suppliers','name',"'".$_POST['name']."'");
//    if ($id>0 && $id != $_GET['id']){
//        echo '<div class="alert alert-danger">خطأ : هذه الاسم موجود بالفعل في قاعدة البيانات</div>';
//    }else{
        $update = $db->prepare("update incoming set name=?,supplier_id=?,amount=?,cost=?,note=?,updated=?,updated_by=? where id = ?");
        try {
            $update->execute([$_POST['name'],$_POST['supplier'],$_POST['amount'],$_POST['cost'],$_POST['note'],date("Y-m-d H:i:s"),$user_id,$_GET['id']]);
            echo '<div class="alert alert-success">تم حفظ البيانات بنجاح</div>';
        }catch (PDOException $e){
            echo '<div class="alert alert-danger">خطأ لم يتم حفظ البيانات</div>';
            echo $e->getMessage();
        }
//    }
}
$suppliers = get_all_rows($db,'suppliers');
$income = false ;
if(isset($_GET['id'])){
    $income = get_row($db,'incoming','id',$_GET['id']);
}
?>
    <section class="content-header">
        <h1>
            العملاء
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
            <li><a href="incoming.php"> الورادات</a></li>
            <li class="active">انشاء وارد</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">اضافة وارد</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">الاسم</label>
                        <div class="col-sm-10">
                            <input <?php if($income){echo 'value="'.$income['name'].'"';}?> type="text" name="name" required class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">المورد</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="supplier">
                                <option value="">اختار</option>
                                <?php foreach($suppliers as $supplier){ ?>
                                    <option <?php if($income && $income['supplier_id'] == $supplier['id']){echo 'selected';}?> value="<?php echo $supplier['id']; ?>"><?php echo $supplier['name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">الكمية</label>
                        <div class="col-sm-10">
                            <input <?php if($income){echo 'value="'.$income['amount'].'"';}?> type="text" name="amount" required class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">التكلفة</label>
                        <div class="col-sm-10">
                            <input type="text" <?php if($income){echo 'value="'.$income['cost'].'"';}?> name="cost" required class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">ملاحظات</label>
                        <div class="col-sm-10">
                            <input type="text" <?php if($income){echo 'value="'.$income['note'].'"';}?> name="note" required class="form-control">
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <?php
                    if ($income){ ?>
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