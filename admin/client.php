<?php
if(isset($_POST['cityId'])){
    include "includes/config.php";
    include "includes/helper.php";
    $cities = get_all_rows_with_parent($db,'cities',$_POST['cityId']);
    echo '<option value="">اختار</option>';
    foreach ($cities as $key=>$city){
        echo '<option value="'.$city['id'].'">'.$city['name'].'</option>';
    }
    exit();
}
include_once 'header.php';
if (isset($_POST['submit'])){
    $id = get_value($db,'id','clients','mobile',$_POST['mobile']);
    if ($id>0){
        echo '<div class="alert alert-danger">خطأ : رقم الهاتف موجود بالفعل في قاعدة البيانات</div>';
    }else{
        $insert = $db->prepare("insert into clients(name,mobile,city_id,address,created,created_by,updated,updated_by) VALUES (?,?,?,?,?,?,?,?)");
        try {
            $insert->execute([$_POST['name'],$_POST['mobile'],$_POST['city'],$_POST['address'],date("Y-m-d H:i:s"),$user_id,date("Y-m-d H:i:s"),$user_id]);
            echo '<div class="alert alert-success">تم حفظ بيانات العميل بنجاح</div>';
        }catch (PDOException $e){
            echo '<div class="alert alert-danger">خطأ لم يتم حفظ البيانات</div>';
            echo $e->getMessage();
        }

    }
}
if (isset($_POST['update'])){
    $id = get_value($db,'id','clients','mobile',$_POST['mobile']);
    if ($id>0 && $id != $_GET['id']){
        echo '<div class="alert alert-danger">خطأ : رقم الهاتف موجود بالفعل في قاعدة البيانات</div>';
    }else{
        $update = $db->prepare("update clients set name=?,mobile=?,city_id=?,address=?,updated=?,updated_by=? where id = ?");
        try {
            $update->execute([$_POST['name'],$_POST['mobile'],$_POST['city'],$_POST['address'],date("Y-m-d H:i:s"),$user_id,$_GET['id']]);
            echo '<div class="alert alert-success">تم حفظ بيانات العميل بنجاح</div>';
        }catch (PDOException $e){
            echo '<div class="alert alert-danger">خطأ لم يتم حفظ البيانات</div>';
            echo $e->getMessage();
        }

    }
}
$client = false ;
$client_gov_id = false;
if(isset($_GET['id'])){
    $select = $db->prepare("select c.id id,c.name name,c.mobile mobile ,c.city_id city_id, c.address address ,c.created created,ci.name city from clients c inner join cities ci on c.city_id = ci.id where c.id = ?");
    $select->execute([$_GET['id']]);
    $client = $select->fetch(PDO::FETCH_ASSOC);
    $client_gov_id = get_value($db,'parent_id','cities','id',$client['city_id']);
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
                            <input <?php if($client){echo 'value="'.$client['name'].'"';}?> type="text" name="name" required class="form-control" id="inputEmail3" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">التليفون</label>
                        <div class="col-sm-10">
                            <input <?php if($client){echo 'value="'.$client['mobile'].'"';}?> type="text" name="mobile" required class="form-control" id="inputPassword3" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">المحافظة</label>
                        <div class="col-sm-10">
                            <?php $govs = get_all_rows_with_parent($db,'cities',0);?>
                            <select class="form-control" name="gov" id="gov">
                                    <option value="">اختار</option>
                                    <?php foreach($govs as $key=>$gov){?>
                                        <option <?php if($gov['id'] == $client_gov_id){echo 'selected';}?> value="<?php echo $gov['id'];?>"><?php echo $gov['name'];?></option>
                                    <?php } ?>
                                </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">المدينة</label>
                        <div class="col-sm-10">
                            <select class="form-control" required name="city" id="city">
                                <option value="">اختار</option>
                                <?php if($client){
                                    $cities = get_all_rows_with_parent($db,'cities',$client_gov_id);
                                    foreach ($cities as $city){
                                        ?>
                                        <option <?php if($city['id']==$client['city_id']){echo 'selected';}?> value="<?php echo $city['id'];?>"><?php echo $city['name'];?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">العنوان</label>
                        <div class="col-sm-10">
                            <input type="text" <?php if($client){echo 'value="'.$client['address'].'"';}?> name="address" required class="form-control" id="inputEmail3" placeholder="">
                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <?php
                    if ($client){ ?>
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
