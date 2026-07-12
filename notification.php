<?php
require_once dirname(__FILE__) . '/vendor/autoload.php';
include 'config/koneksi.php';

\Midtrans\Config::$serverKey = 'Mid-server-wS9JA0hhqaDKjm83O1q7pxDJ';
\Midtrans\Config::$isProduction = false;

try {
    $notif = new \Midtrans\Notification();
} catch (\Exception $e) {
    exit('Invalid signature');
}

$transaction = $notif->transaction_status;
$order_id_midtrans = $notif->order_id;
$id_order = explode('-', $order_id_midtrans)[0];

/* 
 * Standar Status Database:
 * 0 = Pending (Menunggu Pembayaran)
 * 1 = Settled (Lunas / Berhasil)
 * 2 = Expired / Canceled / Denied (Gagal)
 */
$status_db = 0;

if ($transaction == 'settlement' || $transaction == 'capture') {
    $status_db = 1;
} else if ($transaction == 'pending') {
    $status_db = 0;
} else if ($transaction == 'deny' || $transaction == 'expire' || $transaction == 'cancel') {
    $status_db = 2;
}

mysqli_query($conn, "UPDATE db_maruelectronics.tb_order SET status = '$status_db' WHERE id_order = '$id_order'");

if ($status_db == 1) {
    $items = mysqli_query($conn, "SELECT id_product, qty FROM db_maruelectronics.tb_order_detail WHERE id_order = '$id_order'");
    
    while ($item = mysqli_fetch_assoc($items)) {
        $id_prod = $item['id_product'];
        $qty_sold = $item['qty'];
        $transaction = $notif->transaction_status;
        $order_id_midtrans = $notif->order_id;
        $payment_type = $notif->payment_type;
        $id_order = explode('-', $order_id_midtrans)[0];

        mysqli_query($conn, "UPDATE db_maruelectronics.tb_order 
                             SET status = '$status_db', payment_type = '$payment_type' 
                             WHERE id_order = '$id_order'");
    }
}
?>