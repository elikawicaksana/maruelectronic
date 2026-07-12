<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History | Maru Electronics</title>
    <link href="src/output.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <?php 
        include 'config/koneksi.php'; 

        if (!isset($_SESSION['id_user'])) {
            header("Location: login.php");
            exit;
        }
        $id_user = $_SESSION['id_user'];
    ?>
</head>
<body class="dark bg-main-blue font-sans text-gray-200">
    <?php 
        include 'include/navbar.php'; 
    ?>

    <main class="pt-28 pb-20 px-4 max-w-screen-xl mx-auto min-h-screen">
        <h1 class="text-3xl font-extrabold text-white mb-8 tracking-tight">Your Transactions</h1>

        <div class="space-y-6">
            <?php
            $query_order = mysqli_query($conn, "SELECT * FROM db_maruelectronics.tb_order WHERE id_user = '$id_user' ORDER BY created_at DESC");
            
            if (mysqli_num_rows($query_order) == 0) {
                echo '<div class="bg-neutral-primary-soft border border-default p-10 rounded-xl text-center">
                        <p class="text-gray-400">You have no transaction history.</p>
                      </div>';
            } else {
                while ($order = mysqli_fetch_assoc($query_order)) {
                    // Penentuan label status
                    if ($order['status'] == 1) {
                        $status_badge = '<span class="bg-green-900/50 text-green-400 border border-green-800 text-xs font-bold px-3 py-1 rounded-full">Paid</span>';
                    } elseif ($order['status'] == 2) {
                        $status_badge = '<span class="bg-red-900/50 text-red-400 border border-red-800 text-xs font-bold px-3 py-1 rounded-full">Failed / Expired</span>';
                    } else {
                        $status_badge = '<span class="bg-yellow-900/50 text-yellow-400 border border-yellow-800 text-xs font-bold px-3 py-1 rounded-full">Pending Payment</span>';
                    }

                    $shipping_badge = '';
                    $receive_button = '';
                    if ($order['status'] == 1) {
                        if ($order['shipping_status'] == 0) {
                            $shipping_badge = '<span class="bg-gray-800 text-gray-300 border border-gray-600 text-xs font-bold px-3 py-1 rounded-full ml-2">Processing</span>';
                        } elseif ($order['shipping_status'] == 1) {
                            $shipping_badge = '<span class="bg-blue-900/50 text-blue-400 border border-blue-800 text-xs font-bold px-3 py-1 rounded-full ml-2">Shipped</span>';
                            $receive_button = '
                            <form method="POST" action="update_shipping.php" class="mt-4 border-t border-gray-700 pt-4">
                                <input type="hidden" name="id_order" value="'.$order['id_order'].'">
                                <button type="submit" class="w-full bg-moss-light hover:bg-moss-dark text-white font-bold py-2 px-4 rounded-lg transition">
                                    Confirm Order Received
                                </button>
                            </form>';
                        } elseif ($order['shipping_status'] == 2) {
                            $shipping_badge = '<span class="bg-emerald-900/50 text-emerald-400 border border-emerald-800 text-xs font-bold px-3 py-1 rounded-full ml-2">Delivered</span>';
                        }
                    }
            ?>
                <div class="bg-neutral-primary-soft border border-default p-6 rounded-xl shadow-sm">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 pb-4 border-b border-gray-700">
                        <div>
                            <span class="text-sm font-mono text-gray-400">Order ID: #INV-<?php echo date('ym', strtotime($order['created_at'])) . str_pad($order['id_order'], 4, '0', STR_PAD_LEFT); ?></span>
                            <p class="text-sm text-gray-500 mt-1"><?php echo date('d M Y, H:i', strtotime($order['created_at'])); ?></p>
                        </div>
                        <div class="mt-2 sm:mt-0 text-right flex items-center">
                            <div class="mb-2"><?php echo $status_badge . $shipping_badge; ?></div>
                        </div>
                    </div>
                    
                    <div class="space-y-2 mb-2">
                        <h4 class="text-sm font-bold text-gray-300 mb-1">Product</h4>
                        <?php
                        $id_order_current = $order['id_order'];
                        $query_detail = mysqli_query($conn, "SELECT d.qty, d.price, p.product_name FROM db_maruelectronics.tb_order_detail d JOIN db_maruelectronics.tb_product p ON d.id_product = p.id_product WHERE d.id_order = '$id_order_current'");
                        while ($detail = mysqli_fetch_assoc($query_detail)) {
                        ?>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400"><?php echo htmlspecialchars($detail['product_name']); ?> x <?php echo $detail['qty']; ?></span>
                                <span class="text-gray-400">Rp <?php echo number_format($detail['price'], 0, ',', '.'); ?></span>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-700">
                        <h4 class="text-sm font-bold text-gray-300 mb-1">Delivery Address</h4>
                        <p class="text-sm text-gray-400 leading-relaxed">
                            <?php 
                                // Gunakan htmlspecialchars untuk mencegah eksekusi skrip lintas situs (XSS)
                                echo !empty($order['delivery_address']) ? htmlspecialchars($order['delivery_address']) : '<span class="italic text-gray-500">Address not recorded for this transaction.</span>'; 
                            ?>
                        </p>
                    </div>
                    <div class="flex justify-between font-bold text-white mt-4 border-t border-gray-700 pt-2">
                        <span>Total:</span>
                        <span>Rp <?php echo number_format($order['total'], 0, ',', '.'); ?></span>
                    </div>
                    <?php echo $receive_button; ?>
                </div>
            <?php 
                }
            } 
            ?>
        </div>
    </main>
</body>
</html>