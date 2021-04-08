<?php if (isset($_POST['products'])) {
    include 'includes/config.php';
    $select = $db->prepare("select id,name from products");
    $select->execute();
    $products = $select->fetchAll(PDO::FETCH_ASSOC);
    $ids = $_POST['ids'];
//print_r($ids);
    ?>
    <div class="form-group" style="direction: rtl !important;">
        <label for="inputEmail3" class="col-sm-2 control-label"></label>
        <div class="col-sm-4 col-xs-12">
            <select class="form-control pro<?php echo $_POST['products'] + 1; ?>"
                    onchange="getAmount(<?php echo $_POST['products'] + 1; ?>);" name="products[]">
                <option value="">اختار منتج</option>
                <?php foreach ($products as $product) {
                    if (in_array($product['id'], $ids)) {

                    } else {
                        echo '<option value="' . $product['id'] . '">' . $product['name'] . '</option>';
                    }
                } ?>
            </select>
        </div>
        <div class="col-md-1 col-xs-12" style="padding-top: 10px">الكمية</div>
        <div class="col-md-2 col-xs-12"
             style="padding-right:5px !important;padding-left:5px !important">
            <div style="width: 100%">
                <select name="amount[]" class="form-control quant<?php echo $_POST['products'] + 1; ?>">
                </select>
            </div>
        </div>

        <!--                        <div class="col-md-1" style="text-align:center;padding: 0 2px !important">-->
        <button disabled class="col-md-1 col-xs-6 btn btn-info input-height btn<?php echo $_POST['products']; ?>"
                style="padding:8px !important"
                type="button" onclick="addPro();"><span class="fa fa-plus"></span></button>
        <button class="col-md-1 col-xs-6 btn btn-danger input-height"
                style="margin:0 3px !important;padding:8px !important" type="button"
                onclick="$(this).parent().remove();"><span class="fa fa-minus"></span></button>
        <!--                        </div>-->
    </div>
    <?php
    exit();
} elseif (isset($_POST['product_id'])) {
    include 'includes/config.php';
    $select = $db->prepare("select amount from products where id=?");
    $select->execute([$_POST['product_id']]);
    $data = $select->fetch(PDO::FETCH_ASSOC);
    if ($data['amount'] == 0) {
        echo 0;
    } else {
        for ($i = 1; $i <= $data['amount']; $i++) {
            echo '<option value="' . $i . '">' . $i . '</option>';
        }
    }
    exit();
} else {
    header("location:/");
}
