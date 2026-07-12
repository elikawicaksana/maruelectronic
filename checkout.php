<?php
    include 'config/koneksi.php';
    require_once dirname(__FILE__) . '/vendor/autoload.php';

    \Midtrans\Config::$serverKey = 'Mid-server-wS9JA0hhqaDKjm83O1q7pxDJ';
    \Midtrans\Config::$isProduction = false;
    \Midtrans\Config::$isSanitized = true;
    \Midtrans\Config::$is3ds = true;

    if (!isset($_SESSION['id_user']) || empty($_SESSION['cart'])) {
        header("Location: index.php");
        exit;
    }

    $id_user = $_SESSION['id_user'];
    $total_amount = 0;
    $item_details = array();

    $user_query = mysqli_query($conn, "SELECT `name`, email, `address` FROM db_maruelectronics.tb_user WHERE id_user = '$id_user'");
    $user_data = mysqli_fetch_assoc($user_query);
    $delivery_address = mysqli_real_escape_string($conn, $user_data['address']);

    foreach ($_SESSION['cart'] as $id_product => $quantity) {
        $query = mysqli_query($conn, "SELECT * FROM db_maruelectronics.tb_product WHERE id_product = '$id_product'");
        $product = mysqli_fetch_assoc($query);
        $price = $product['price'];
        $total_amount += ($price * $quantity);
        
        $item_details[] = array(
            'id' => $id_product,
            'price' => $price,
            'quantity' => $quantity,
            'name' => substr($product['product_name'], 0, 50)
        );
    }

    $created_at = date('Y-m-d H:i:s');
    mysqli_query($conn, "INSERT INTO db_maruelectronics.tb_order (id_user, total, `status`, shipping_status, delivery_address, created_at) 
                         VALUES ('$id_user', '$total_amount', 0, 0, '$delivery_address', '$created_at')");
    $id_order = mysqli_insert_id($conn);

    foreach ($_SESSION['cart'] as $id_product => $quantity) {
        $query = mysqli_query($conn, "SELECT price FROM db_maruelectronics.tb_product WHERE id_product = '$id_product'");
        $product = mysqli_fetch_assoc($query);
        
        $price = $product['price'];
        $subtotal = $price * $quantity; 
        mysqli_query($conn, "INSERT INTO db_maruelectronics.tb_order_detail (id_order, id_product, qty, price) 
                            VALUES ('$id_order', '$id_product', '$quantity', '$subtotal')");
    }

    $transaction_details = array(
        'order_id' => $id_order . '-' . time(),
        'gross_amount' => $total_amount,
    );

    $customer_details = array(
        'first_name' => $user_data['name'],
        'email' => $user_data['email'],
    );

    $transaction = array(
        'transaction_details' => $transaction_details,
        'customer_details' => $customer_details,
        'item_details' => $item_details,
    );

    $snapToken = \Midtrans\Snap::getSnapToken($transaction);
    unset($_SESSION['cart']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Maru Electronics</title>
    <link href="src/output.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="Mid-client-2DameW7wMUi5d0il"></script>
</head>
<body class="dark bg-main-blue font-sans text-gray-200 flex items-center justify-center min-h-screen">
    <div class="bg-neutral-primary-soft border border-default p-10 rounded-xl text-center shadow-lg max-w-md w-full">
        <h2 class="text-2xl font-bold text-white mb-4">Order Created Successfully</h2>
        <p class="text-gray-400 mb-6">Total Payment: Rp <?php echo number_format($total_amount, 0, ',', '.'); ?></p>
        <button id="pay-button" class="w-full inline-flex items-center justify-center text-white bg-gradient-to-r from-moss-light to-moss-dark hover:opacity-90 focus:ring-4 focus:ring-moss-light/50 font-bold rounded-lg px-6 py-4 text-center transition-all shadow-md text-lg">
            Pay Now
        </button>
    </div>

    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function(){
            snap.pay('<?php echo $snapToken; ?>', {
                onSuccess: function(result){
                    window.location.href = 'transaction.php';
                },
                onPending: function(result){
                    window.location.href = 'transaction.php';
                },
                onError: function(result){
                    window.location.href = 'index.php?status=error';
                },
                onClose: function(){
                    alert('Payment window closed before completing the transaction.');
                }
            });
        };
    </script>
</body>
</html>