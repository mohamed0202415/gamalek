<?php
if (isset($_POST['cityId'])) {
    include "includes/config.php";
    include "includes/helper.php";
    $cities = get_all_rows_with_parent($db, 'cities', $_POST['cityId']);
    echo '<option value="">اختار المدينة</option>';
    foreach ($cities as $key => $city) {
        echo '<option value="' . $city['id'] . '">' . $city['name'] . '</option>';
    }
    exit();
}
ob_start();
include "header.php";
?>
    <!-- catg header banner section -->
    <section id="aa-catg-head-banner">
        <img src="img/fashion/fashion-header-bg-8.jpg" alt="fashion img">
        <div class="aa-catg-head-banner-area">
            <div class="container">
                <div class="aa-catg-head-banner-content">
                    <h2>Checkout Page</h2>
                    <ol class="breadcrumb">
                        <li><a href="/">Home</a></li>
                        <li class="active">Checkout</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <!-- / catg header banner section -->

    <!-- Cart view section -->
    <section id="checkout">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php
                    @session_start();
                    if (!isset($_SESSION['cart']) || count($_SESSION['cart']) <1){
                        header("location:index.php");
                    }
                    if (isset($_POST['order'])) {
                        $inserted = 1;
                        $orders = get_value($db, 'count(*)', 'orders', 1, 1);
                        $client_id = get_value($db, 'id', 'clients', 'mobile', "'" . $_POST['mobile'] . "'");
                        if ($client_id > 0) {

                        } else {
                            $insert = $db->prepare("insert into clients (name,mobile,city_id,address,created,created_by,updated,updated_by,confirmed) VALUES (?,?,?,?,?,?,?,?,?)");
                            try {
                                $insert->execute([$_POST['name'], $_POST['mobile'], $_POST['city'], $_POST['address'], date("Y-m-d H:i:s"), 0, date("Y-m-d H:i:s"), 0, 0]);
                                $client_id = $db->lastInsertId();
                            } catch (PDOException $exception) {
                                $inserted = 0;
//            echo $exception->getMessage();
                            }
                        }
                        $insert = $db->prepare("insert into orders (order_no,client_id,cost,shipping_id,status,is_paid,note,receipt_no,created,created_by,updated,updated_by,confirmed) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
                        try {
                            $insert->execute([date("Ymd").'-'.$orders, $client_id, 0, 0, 'pending', 0, $_POST['note'], 0, date("Y-m-d H:i:s"), 0, date("Y-m-d H:i:s"), 0, 0]);
                            $order_id = $db->lastInsertId();
                            $total = 0;
                            for ($i = 0; $i < count($_POST['id']); $i++) {
                                $sub_total = 0;
                                $sub_total = $_POST['amount'][$i] * $_POST['cost'][$i];
                                $total += $sub_total;
                                $insert = $db->prepare("insert into order_items (order_id,product_id,quantity,cost,total_cost,created,created_by,updated,updated_by) VALUES (?,?,?,?,?,?,?,?,?)");
                                try {
                                    $insert->execute([$order_id, $_POST['id'][$i], $_POST['amount'][$i], $_POST['cost'][$i], $sub_total, date("Y-m-d H:i:s"), 0, date("Y-m-d H:i:s"), 0]);
                                } catch (PDOException $exception) {
                                    $inserted = 0;
                                }
                            }
                            $update = $db->prepare("update orders set cost =? where id = ?");
                            try {
                                $update->execute([$total, $order_id]);
                            } catch (PDOException $exception) {
                                $inserted = 0;
                            }
                        } catch (PDOException $exception) {
                            $inserted = 0;
                        }
                        if ($inserted == 1) {
                            echo '<div class="alert alert-success" style="text-align: center">تم حفظ البيانات بنجاح</div>';
                            unset($_SESSION['cart']);
                            echo '<meta http-equiv="refresh" content="2; url="index.php" />';
                        } else {
                            echo '<div class="alert alert-danger">خطأ لم يتم حفظ البيانات</div>';
                        }
                        //    echo '<pre>';print_r($_POST);echo '</pre>';
                    }

                    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {

                        $session_ids = $_SESSION['cart'];
                        $ids = "";
                        foreach ($session_ids as $key => $item) {
                            if (strlen($ids > 0)) {
                                $ids .= ',' . $item['id'];
                            } else {
                                $ids = $item['id'];
                            }
                        }
                        $ids = '(' . $ids . ')';

                        $query = "select p.id id ,p.category_id category_id,p.manufacturer_id manufacturer_id,p.name `name`,p.cost cost,p.amount amount,p.discount discount,p.description description,m.name manufacturer,c.name category,i.image image,i.main main from products p left join categories c on p.category_id = c.id left join manufacturer m on p.manufacturer_id = m.id left join product_images i on i.product_id = p.id where i.main = 1 and p.id in " . $ids;
                        $select = $db->prepare($query);
                        $select->execute();
                        $products = $select->fetchAll(PDO::FETCH_ASSOC);
                    } ?>
                    <div class="checkout-area">
                        <form method="post">
                            <div class="row">
                                <div class="col-md-8 pull-right">
                                    <div class="checkout-left">
                                        <div class="panel-group" id="accordion">
                                            <!-- Shipping Address -->
                                            <div class="panel panel-default aa-checkout-billaddress">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion"
                                                           href="#collapseFour">
                                                            بيانات العميل
                                                        </a>
                                                    </h4>
                                                </div>
                                                <div id="collapseFour" class="panel-collapse collapse in">
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="aa-checkout-single-bill">
                                                                    <input type="text" name="name" required
                                                                           oninvalid="this.setCustomValidity('برجاء ادخال اسم العميل')"
                                                                           oninput="this.setCustomValidity('')"
                                                                           placeholder="الاسم">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 pull-right">
                                                                <div class="aa-checkout-single-bill">
                                                                    <input type="tel" name="mobile" required
                                                                           oninvalid="this.setCustomValidity('برجاء ادخال رقم الهاتف')"
                                                                           oninput="this.setCustomValidity('')"
                                                                           placeholder="رقم التليفون">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="aa-checkout-single-bill">
                                                                    <input type="email" name="email" required
                                                                           oninvalid="this.setCustomValidity('برجاء ادخال البريد الالكتروني')"
                                                                           oninput="this.setCustomValidity('')"
                                                                           placeholder="البريد الالكتروني">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 pull-right">
                                                                <div class="aa-checkout-single-bill">
                                                                    <?php $cities = get_all_rows_with_parent($db, 'cities', 0); ?>
                                                                    <select name="gov" id="gov" required
                                                                            oninvalid="this.setCustomValidity('برجاء اختيار المحافظة')"
                                                                            oninput="this.setCustomValidity('')"
                                                                            class="form-control">
                                                                        <option value="">
                                                                            المحافظة
                                                                        </option>
                                                                        <?php foreach ($cities as $key => $city) {
                                                                            echo '<option value="' . $city['id'] . '">' . $city['name'] . '</option>';
                                                                        } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="aa-checkout-single-bill">
                                                                    <select name="city" id="city" required
                                                                            oninvalid="this.setCustomValidity('برجاء اختيار المدينة')"
                                                                            oninput="this.setCustomValidity('')"
                                                                            class="form-control">
                                                                        <option value="">
                                                                            المدينة
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="aa-checkout-single-bill">
                                                                    <textarea style="height: 100px" cols="8" rows="3"
                                                                              required placeholder="العنوان"
                                                                              name="address"
                                                                              oninvalid="this.setCustomValidity('برجاء ادخال العنوان')"
                                                                              oninput="this.setCustomValidity('')"
                                                                    ></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="aa-checkout-single-bill">
                                                                    <textarea style="height: 100px" name="note" cols="8"
                                                                              rows="3" placeholder="ملاحظات"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="checkout-right">
                                        <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) { ?>
                                            <h4>ملخص الطلب</h4>
                                            <div class="aa-order-summary-area">
                                                <table class="table table-responsive">
                                                    <thead>
                                                    <tr>
                                                        <th>المنتج</th>
                                                        <th>التكلفة</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php

                                                    $total = 0;
                                                    foreach ($products as $product) {
                                                        $sub_total = 0; ?>
                                                        <tr>
                                                            <td style="direction: rtl !important;"><?php echo $session_ids[$product['id']]['amount']; ?>
                                                                x <?php echo $product['name']; ?><strong>
                                                                    <input type="hidden" name="id[]"
                                                                           value="<?php echo $product['id']; ?>"/>
                                                                </strong>
                                                            </td>
                                                            <td><?php echo $session_ids[$product['id']]['amount'] * ($product['cost'] - $product['discount']); ?>
                                                                EGP
                                                            </td>
                                                            <input type="hidden" name="amount[]"
                                                                   value="<?php echo $session_ids[$product['id']]['amount']; ?>"/>
                                                            <input type="hidden" name="cost[]"
                                                                   value="<?php echo $product['cost'] - $product['discount']; ?>"/>
                                                        </tr>
                                                        <?php
                                                        $sub_total = (($product['cost'] - $product['discount']) * $session_ids[$product['id']]['amount']);
                                                        $total += $sub_total;
                                                    } ?>
                                                    </tbody>
                                                    <tfoot>
                                                    <tr>
                                                        <th>الضريبة</th>
                                                        <td>0.00EGP</td>
                                                    </tr>
                                                    <tr>
                                                        <th>الاجمالي</th>
                                                        <td><?php echo $total; ?>EGP</td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        <?php } ?>
                                        <h4>نظام الدفع</h4>
                                        <div class="aa-payment-method">
                                            <label for="cashdelivery"><input type="radio" checked id="cashdelivery"
                                                                             name="optionsRadios"> كاش عند الاستلام
                                            </label>
                                            <label for="paypal"><input type="radio" disabled id="paypal" name=""
                                                                       checked> البطاقات البنكية </label>
                                            <img src="https://www.paypalobjects.com/webstatic/mktg/logo/AM_mc_vs_dc_ae.jpg"
                                                 border="0" alt="PayPal Acceptance Mark">
                                            <button type="submit" name="order" class="aa-browse-btn">تأكيد الطلب
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- / Cart view section -->
<?php include "footer.php";
?>
    <script>
        $("#gov").change(function () {
            var city_id = $("#gov").val();
            $.ajax({
                type: "POST",
                url: "checkout.php",
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

<?php
ob_end_flush();
?>