<?php
include_once 'header.php';
if (isset($_POST['submit'])){
    $id = get_value($db,'id','users','mobile',"'".$_POST['name']."'");
    if ($id>0){
        echo '<div class="alert alert-danger">خطأ : الاسم موجود بالفعل في قاعدة البيانات</div>';
    }else{
        $insert = $db->prepare("insert into users(name,username,password,mobile,created,created_by,updated,updated_by) VALUES (?,?,?,?,?,?,?,?)");
        try {
            $insert->execute([$_POST['name'],$_POST['username'],sha1(md5(strip_tags(htmlspecialchars($_POST['password'])))),$_POST['mobile'],date("Y-m-d H:i:s"),$user_id,date("Y-m-d H:i:s"),$user_id]);
            echo '<div class="alert alert-success">تم حفظ بيانات العميل بنجاح</div>';
        }catch (PDOException $e){
            echo '<div class="alert alert-danger">خطأ لم يتم حفظ البيانات</div>';
            echo $e->getMessage();
        }

    }
}
if (isset($_POST['update'])){
    $id = get_value($db,'id','users','name',"'".$_POST['name']."'");
    if ($id>0 && $id != $_GET['id']){
        echo '<div class="alert alert-danger">خطأ : رقم الاسم موجود بالفعل في قاعدة البيانات</div>';
    }else{
        $update = $db->prepare("update users set name=?,username=?,password=?,mobile=?,updated=?,updated_by=? where id = ?");
        try {
            $update->execute([$_POST['name'],$_POST['username'],sha1(md5(strip_tags(htmlspecialchars($_POST['password'])))),$_POST['mobile'],date("Y-m-d H:i:s"),$user_id,$_GET['id']]);
            echo '<div class="alert alert-success">تم حفظ بيانات العميل بنجاح</div>';
        }catch (PDOException $e){
            echo '<div class="alert alert-danger">خطأ لم يتم حفظ البيانات</div>';
            echo $e->getMessage();
        }

    }
}
$user = false ;
$client_gov_id = false;
if(isset($_GET['id'])){
    $user = get_row($db,'users','id',$_GET['id']);
}
?>
    <section class="content-header">
        <h1>
            العملاء
            <small></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> الرئيسية</a></li>
            <li><a href="clients.php"> العملاء</a></li>
            <li class="active">انشاء عميل</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">اضافة عميل</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">الاسم</label>
                        <div class="col-sm-10">
                            <input <?php if($user){echo 'value="'.$user['name'].'"';}?> type="text" name="name" required class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">اسم الدخول</label>
                        <div class="col-sm-10">
                            <input <?php if($user){echo 'value="'.$user['username'].'"';}?> type="text" name="username" required class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">كلمة المرور</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" required class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">التليفون</label>
                        <div class="col-sm-10">
                            <input <?php if($user){echo 'value="'.$user['mobile'].'"';}?> type="text" name="mobile" required class="form-control" id="inputPassword3" placeholder="">
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <?php
                    if ($user){ ?>
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
<script>
    $("#gov").change(function(){
        var city_id = $("#gov").val();
        $.ajax({
            type: "POST",
            url: "client.php",
            data: {
                cityId: city_id
            },
            cache: false,
            success: function (result) {
                $("#city").empty();
                $("#city").append(result);
            }
        });
    });
</script>
