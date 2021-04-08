<?php
include_once 'header.php';
if (isset($_POST['submit'])){
    $id = get_value($db,'id','categories','name',"'".$_POST['name']."'");
    if ($id>0){
        echo '<div class="alert alert-danger">خطأ : هذه الفئة موجودة بالفعل في قاعدة البيانات</div>';
    }else{
        $insert = $db->prepare("insert into categories(name,parent_id,created,created_by,updated,updated_by) VALUES (?,?,?,?,?,?)");
        try {
            $insert->execute([$_POST['name'],$_POST['category'],date("Y-m-d H:i:s"),$user_id,date("Y-m-d H:i:s"),$user_id]);
            echo '<div class="alert alert-success">تم حفظ بيانات العميل بنجاح</div>';
        }catch (PDOException $e){
            echo '<div class="alert alert-danger">خطأ لم يتم حفظ البيانات</div>';
            echo $e->getMessage();
        }

    }
}
if (isset($_POST['update'])){
    $id = get_value($db,'id','categories','name',"'".$_POST['name']."'");
    if ($id>0 && $id != $_GET['id']){
        echo '<div class="alert alert-danger">خطأ : هذه الفئة موجودة بالفعل في قاعدة البيانات</div>';
    }else{
        $update = $db->prepare("update categories set name=?,parent_id=?,updated=?,updated_by=? where id = ?");
        try {
            $update->execute([$_POST['name'],$_POST['category'],date("Y-m-d H:i:s"),$user_id,$_GET['id']]);
            echo '<div class="alert alert-success">تم حفظ بيانات العميل بنجاح</div>';
        }catch (PDOException $e){
            echo '<div class="alert alert-danger">خطأ لم يتم حفظ البيانات</div>';
            echo $e->getMessage();
        }

    }
}
$cat = false ;
if(isset($_GET['id'])){
    $cat = get_row($db,'categories','id',$_GET['id']);
}
$categories = get_all_rows_with_parent($db,'categories',0);
?>
    <section class="content-header">
        <h1>
            الفئات
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
            <li><a href="categories.php"> الفئات</a></li>
            <li class="active">انشاء فئة</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">اضافة فئة</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">الاسم</label>
                        <div class="col-sm-10">
                            <input <?php if($cat){echo 'value="'.$cat['name'].'"';}?> type="text" name="name" required class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">الفئة</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="category" id="category">
                                    <option value="0">فئة أساسية</option>
                                    <?php foreach($categories as $key=>$category){?>
                                        <option <?PHP if($cat['parent_id'] == $category['id']){echo 'selected';}?> value="<?php echo $category['id'];?>"><?php echo $category['name'];?></option>
                                    <?php } ?>
                                </select>
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <?php
                    if ($cat){ ?>
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