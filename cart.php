<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart | Maru Electronics</title>
    <link href="src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <?php 
        include 'config/koneksi.php'; 
        include 'config/fungsi.php';
        
        session_start();
        if (!isset($_SESSION['id_user'])) {
            header("Location: login.php");
            exit;
        }
    ?>
    <style>
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        input[type="number"] { -moz-appearance: textfield; }
    </style>
</head>
<body class="dark bg-main-blue font-sans text-gray-200">
    <?php 
        include 'include/navbar.php'; 
    ?>

    <main class="pt-28 pb-20 px-4 max-w-screen-xl mx-auto min-h-screen">
        <h1 class="text-3xl font-extrabold text-white mb-8 tracking-tight">Shopping Cart</h1>

        <?php
        if (empty($_SESSION['cart'])) {
            echo '<div class="bg-neutral-primary-soft border border-default p-10 rounded-xl text-center shadow-lg">
                    <h2 class="text-2xl font-bold text-white mb-4">Your cart is empty.</h2>
                    <p class="text-gray-400 mb-6">Looks like you haven\'t added any electronics to your cart yet.</p>
                    <a href="index.php#catalog" class="inline-flex items-center justify-center text-white bg-gradient-to-r from-moss-light to-moss-dark font-bold rounded-lg px-8 py-3 transition-all hover:opacity-90 shadow-md">Browse Catalog</a>
                  </div>';
        } else {
        ?>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-4">
                    <?php
                    $total_price = 0;
                    foreach ($_SESSION['cart'] as $id_product => $quantity) {
                        $query = mysqli_query($conn, "SELECT * FROM db_maruelectronics.tb_product WHERE id_product = '$id_product'");
                        if (mysqli_num_rows($query) > 0) {
                            $product = mysqli_fetch_assoc($query);
                            $subtotal = $product['price'] * $quantity;
                            $total_price += $subtotal;
                            $thumbnail = !empty($product['img']) ? $product['img'] : 'dist/img/thumbnail.jpg';
                    ?>
                        <div class="bg-neutral-primary-soft border border-default p-4 rounded-xl flex flex-col sm:flex-row items-center gap-4 shadow-sm">
                            <img src="<?php echo $thumbnail; ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" class="w-24 h-24 object-cover rounded-lg border border-gray-700">
                            
                            <div class="flex-1 text-center sm:text-left">
                                <h3 class="text-lg font-bold text-white leading-tight mb-1"><?php echo htmlspecialchars($product['product_name']); ?></h3>
                                <p class="text-moss-light font-bold"><?php echo formatUang($product['price']); ?></p>
                            </div>
                            
                            <div class="flex flex-col sm:flex-row items-center justify-end w-full sm:w-auto gap-4 mt-4 sm:mt-0">
                                
                                <div class="text-lg font-bold text-white min-w-[100px] text-center sm:text-right hidden sm:block">
                                    <?php echo formatUang($subtotal); ?>
                                </div>

                                <div class="flex items-center gap-2">
                                    <form action="proses/prosesQuery.php" method="POST" class="flex items-center gap-2 m-0 p-0">
                                        <input type="hidden" name="flag" value="prosesUpdateKeranjang">
                                        <input type="hidden" name="id_product" value="<?php echo $id_product; ?>">
                                        
                                        <div class="relative flex items-center w-28">
                                            <button type="button" id="decrement-<?php echo $id_product; ?>" data-input-counter-decrement="qty-<?php echo $id_product; ?>" class="bg-gray-800 hover:bg-gray-700 border border-gray-600 rounded-s-lg p-2 h-10 focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                                <svg class="w-2.5 h-2.5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/></svg>
                                            </button>
                                            
                                            <input type="number" id="qty-<?php echo $id_product; ?>" name="quantity" data-input-counter data-input-counter-min="1" data-input-counter-max="<?php echo $product['stock']; ?>" class="bg-gray-900 border-x-0 border-gray-600 h-10 text-center text-white text-sm focus:ring-moss-light focus:border-moss-light block w-full py-1 outline-none" value="<?php echo $quantity; ?>" required />
                                            
                                            <button type="button" id="increment-<?php echo $id_product; ?>" data-input-counter-increment="qty-<?php echo $id_product; ?>" class="bg-gray-800 hover:bg-gray-700 border border-gray-600 rounded-e-lg p-2 h-10 focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                                <svg class="w-2.5 h-2.5 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/></svg>
                                            </button>
                                        </div>
                                        <button type="submit" title="Update Quantity" class="text-moss-light hover:text-white bg-gray-800 hover:bg-gray-700 p-2.5 h-10 rounded border border-gray-600 transition-colors focus:ring-2 focus:ring-moss-light focus:outline-none">
                                            <i class="fas fa-sync-alt"></i>
                                        </button>
                                    </form>

                                    <form action="proses/prosesQuery.php" method="POST" class="m-0 p-0">
                                        <input type="hidden" name="flag" value="prosesHapusKeranjang">
                                        <input type="hidden" name="id_product" value="<?php echo $id_product; ?>">
                                        <button type="submit" title="Remove Item" class="text-gray-400 hover:text-red-500 bg-gray-800 hover:bg-gray-700 p-2.5 h-10 rounded border border-gray-600 transition-colors focus:ring-2 focus:ring-red-500 focus:outline-none">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                                
                            </div>
                        </div>
                    <?php 
                        }
                    } 
                    ?>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-neutral-primary-soft border border-default p-6 rounded-xl sticky top-28 shadow-lg">
                        <h2 class="text-xl font-bold text-white mb-6 pb-4 border-b border-gray-700">Order Summary</h2>
                        <div class="flex justify-between items-center mb-8">
                            <span class="text-gray-400">Total Price</span>
                            <span class="text-2xl font-bold text-white"><?php echo formatUang($total_price); ?></span>
                        </div>
                        <form action="checkout.php" method="POST">
                            <button type="submit" class="w-full inline-flex items-center justify-center text-white bg-gradient-to-r from-moss-light to-moss-dark hover:opacity-90 focus:ring-4 focus:ring-moss-light/50 font-bold rounded-lg px-6 py-4 text-center transition-all shadow-md text-lg">
                                Proceed to Checkout
                            </button>
                        </form>
                    </div>
                </div>
                
            </div>
        <?php } ?>
    </main>

    <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>