<?php
if(isset($_POST['delete_button'])){
    @session_start();
    unset($_SESSION['cart'][$_POST['delete_button']]);
}
include "header.php";
@session_start();

if (isset($_SESSION['cart']) && count($_SESSION['cart'])>0) {

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
}
include 'admin/delete_modal.php';
?>
    <!-- catg header banner section -->
    <section id="aa-catg-head-banner">
        <img src="img/products/ad.jpg" alt="fashion img">

    </section>
    <!-- / catg header banner section -->

    <!-- Cart view section -->
    <section id="cart-view">
        <div class="container">
            <div class="row">
                <form class="col-md-12" method="post">
                    <div class="cart-view-area">
                        <?php if (isset($_SESSION['cart'])  && count($_SESSION['cart'])>0) { ?>
                            <form method="post">
                                <div class="cart-view-table">

                                    <div class="table-responsive">
                                        <table class="table" style="direction: rtl !important;">
                                            <thead>
                                            <tr>
                                                <th></th>
                                                <th>المنتج</th>
                                                <th>السعر</th>
                                                <th>الكمية</th>
                                                <th>الاجمالي</th>
                                                <th>التحكم</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php

                                            $total = 0;
                                            foreach ($products as $product) {
                                                $sub_total = 0;
                                                ?>
                                                <tr>
                                                    <td><a href="#"><img
                                                                    src="img/products/medium/<?php echo $product['image']; ?>"
                                                                    alt="img"></a></td>
                                                    <td><a class="aa-cart-title"
                                                           href="#"><?php echo $product['name']; ?></a>
                                                        <input type="hidden" name="id[]"
                                                               value="<?php echo $product['id']; ?>">
                                                    </td>
                                                    <td id="price<?php echo $product['id']; ?>"><?php echo $product['cost'] - $product['discount'] . 'EGP'; ?></td>
                                                    <input type="hidden" name="cost[]"
                                                           value="<?php echo $product['cost'] - $product['discount']; ?>"/>
                                                    <td><input class="aa-cart-quantity"
                                                               min="1" max="<?php echo $product['amount']; ?>"
                                                               type="number"
                                                               value="<?php echo $session_ids[$product['id']]['amount']; ?>">
                                                        <input type="hidden" name="amount[]"
                                                               value="<?php echo $session_ids[$product['id']]['amount']; ?>">
                                                    </td>
                                                    <td id="price<?php echo $product['id']; ?>"><?php $sub_total = (($product['cost'] - $product['discount']) * $session_ids[$product['id']]['amount']);
                                                        $total += $sub_total;
                                                        echo $sub_total . 'EGP'; ?></td>
                                                    <td><button type="button" data-toggle="modal" data-target="#delete_modal" value="<?php echo $product['id']; ?>" class="btn btn-danger delete_btn" href="#">
                                                            <fa class="fa fa-close"></fa>
                                                        </button></td>
                                                </tr>
                                            <?php } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Cart Total view -->
                                    <div class="cart-view-total">
                                        <h4 style="text-align: center">اجمالي تكلفة المشتريات</h4>
                                        <table class="aa-totals-table">
                                            <tbody>
                                            <tr>
                                                <th>الاجمالي</th>
                                                <td><?php echo $total . 'EGP'; ?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <a href="checkout.php" class="aa-cart-view-btn">تأكيد الطلب</a>
                                    </div>
                                </div>
                            </form>
                        <?php } else { ?>
                            <div class="alert alert-warning"
                                 style="text-align: center;padding:50px;font-weight:bold;font-size:20px">
                                سلة المشتريات فارغة
                            </div>
                        <?php } ?>
                    </div>
            </div>
        </div>
        </div>
    </section>
    <!-- / Cart view section -->


<?php include "footer.php";
?>
    <script>
        $(".delete_btn").click(function(){
            var id = $(this).val();
            $("#delete_id").val(id);
        });
    </script>
