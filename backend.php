<?php
if (isset($_REQUEST["term"])) {
    include 'admin/includes/config.php';
    // Prepare a select statement
    $sql = $db->prepare("SELECT id,name FROM products WHERE name LIKE ? and online = 1");
    $sql->execute(['%'.$_REQUEST["term"] . '%']);
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    // Attempt to execute the prepared statement
        if (count($result) > 0){
            // Fetch result rows as an associative array
            foreach ($result as $item) {
                ?><p onclick="location.href='product.php?id=<?php echo $item['id']; ?>';"><?php echo $item["name"]; ?></p>
                <?php
            }
        } else {
            echo "<p>لا يوجد نتائج</p>";
        }
}
?>
