<?php
include '../config/koneksi.php';

if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'Admin') exit;

if (isset($_POST['id_order'])) {
    $id_order = mysqli_real_escape_string($conn, $_POST['id_order']);
    
    $query = mysqli_query($conn, "
        SELECT d.qty, d.price, p.product_name 
        FROM db_maruelectronics.tb_order_detail d 
        JOIN db_maruelectronics.tb_product p ON d.id_product = p.id_product 
        WHERE d.id_order = '$id_order'
    ");

    if (mysqli_num_rows($query) > 0) {
        while ($detail = mysqli_fetch_assoc($query)) {
            $total_item = number_format($detail['price'], 0, ',', '.');
            echo '<div class="flex justify-between items-center text-sm border-b border-gray-700 last:border-0 pb-2 last:pb-0">';
            echo '  <span class="text-gray-300 font-medium">'.htmlspecialchars($detail['product_name']).' <span class="text-moss-light ml-2">x '.$detail['qty'].'</span></span>';
            echo '  <span class="text-gray-300 font-bold">Rp '.$total_item.'</span>';
            echo '</div>';
        }
    } else {
        echo '<div class="text-gray-500 text-sm italic">No items found for this transaction.</div>';
    }
}
?>