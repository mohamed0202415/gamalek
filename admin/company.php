<?php include_once 'header.php';
    if (isset($_POST['submit'])){
        $id = get_value($db,'id','shipping_companies','name',"'".$_POST['name']."'");
        if ($id>0){
            echo '<div class="alert alert-danger">خطأ : هذه الشركة موجوده بالفعل في قاعدة البيانات</div>';
        }else{
            $insert = $db->prepare("insert into shipping_companies(name,mobile,address,created,created_by,updated,updated_by) VALUES (?,?,?,?,?,?,?)");
            try {
                $insert->execute([$_POST['name'],$_POST['mobile'],$_POST['address'],date("Y-m-d H:i:s"),$user_id,date("Y-m-d H:i:s"),$user_id]);
                echo '<div class="alert alert-success">تم حفظ البيانات بنجاح</div>';
            }catch (PDOException $e){
                echo '<div class="alert alert-danger">خطأ لم يتم حفظ البيانات</div>';
                echo $e->getMessage();
            }
        }
    }
    if (isset($_POST['update'])){
        $id = get_value($db,'id','shipping_companies','name',"'".$_POST['name']."'");
        if ($id>0 && $id != $_GET['id']){
            echo '<div class="alert alert-danger">خطأ : هذه الشركة موجوده بالفعل في قاعدة البيانات</div>';
        }else{
            $update = $db->prepare("update shipping_companies set name=?,mobile=?,address=?,updated=?,updated_by=? where id = ?");
            try {
                $update->execute([$_POST['name'],$_POST['mobile'],$_POST['address'],date("Y-m-d H:i:s"),$user_id,$_GET['id']]);
                echo '<div class="alert alert-success">تم حفظ بيانات العميل بنجاح</div>';
            }catch (PDOException $e){
                echo '<div class="alert alert-danger">خطأ لم يتم حفظ البيانات</div>';
                echo $e->getMessage();
            }

        }
    }
$company = false ;
if(isset($_GET['id'])){
    $company = get_row($db,'shipping_companies','id',$_GET['id']);
}
?>
    <section class="content-header">
        <h1>
            شركات الشحن
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
            <li><a href="shipping_companies.php"> شركات الشحن</a></li>
            <li class="active">انشاء شركة</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">انشاء شركة</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">اسم الشركة</label>
                        <div class="col-sm-10">
                            <input required <?php if($company){echo 'value="'.$company['name'].'"';}?> type="text" class="form-control" name="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">العنوان</label>
                        <div class="col-sm-10">
                            <input required <?php if($company){echo 'value="'.$company['address'].'"';}?> type="text" class="form-control" name="address">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">رقم التليفون</label>
                        <div class="col-sm-10">
                            <input required <?php if($company){echo 'value="'.$company['mobile'].'"';}?> type="text" class="form-control" name="mobile">
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <?php
                    if ($company){ ?>
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