<div class="modal fade" id="product_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #ff6666;">
                <h5 class="modal-title" id="exampleModalLabel" style="color: #fff;font-weight: bold">اضافة منتج</h5>
            </div>
            <div class="modal-body" style="height: 70px">
                <?php $select = $db->prepare("select id,name from products");
                $select->execute();
                $products = $select->fetchAll(PDO::FETCH_ASSOC);
                $select = $db->prepare("SELECT id,product_id FROM `order_items` where order_id=?");
                $select->execute([$_GET['id']]);
                $data = $select->fetchAll(PDO::FETCH_ASSOC);
                $ids = array();
                foreach ($data as $item) {
                    $ids[] = $item['product_id'];
                }
                ?>
                <form method="post">
                    <div class="form-group" style="direction: rtl !important;">
                        <div class="col-md-6 col-xs-12"
                             style="padding-right:5px !important;padding-left:5px !important;margin-bottom:10px">
                            <select class="form-control pro1" name="product" onchange="getAmount(1);">
                                <option value="">اختار منتج</option>
                                <?php foreach ($products as $product) {

                                    if (in_array($product['id'], $ids)) {

                                    } else {
                                        echo '<option value="' . $product['id'] . '">' . $product['name'] . '</option>';
                                    }
                                } ?>
                            </select>
                        </div>
                        <div class="col-md-6 col-xs-12"
                             style="padding-right:5px !important;padding-left:5px !important;margin-bottom:10px">
                            <select name="amount" required class="form-control quant1">
                                <option value="">الكمية</option>
                            </select>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="submit" id="delete_id" class="btn btn-danger">أضافة</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
            </div>
            </form>
        </div>
    </div>
</div>
