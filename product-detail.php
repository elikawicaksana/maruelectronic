<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail | Maru Electronics</title>
    <link href="src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <?php include 'config/koneksi.php'; ?>

    <style>
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }
    </style>
</head>
<body class="dark bg-main-blue font-sans text-gray-200">
    <?php include 'include/navbar.php'; ?>

    <?php
    $id_product = isset($_GET['id_product']) ? (int)$_GET['id_product'] : 0;
    
    $query = mysqli_query($conn, "SELECT * FROM db_maruelectronics.tb_product WHERE id_product = '$id_product'");
    
    if (mysqli_num_rows($query) == 0) {
        echo '<div class="pt-40 text-center text-white"><h1 class="text-3xl font-bold mb-4">Product not found.</h1><a href="index.php" class="text-moss-light underline inline-block">Back to Catalog</a></div>';
        exit;
    }
    
    $product = mysqli_fetch_assoc($query);
    $thumbnail = !empty($product['thumbnail']) ? $product['thumbnail'] : 'dist/img/thumbnail.jpg';
    $price_formatted = isset($product['price']) ? number_format($product['price'], 0, ',', '.') : '0';
    $stock = isset($product['stock']) ? $product['stock'] : 0; 
    
    $description = !empty($product['desc']) ? $product['desc'] : 'Technical specifications are not available for this product yet.';
    ?>

    <main class="pt-28 pb-20 px-4 max-w-screen-xl mx-auto min-h-screen">
        <div class="bg-neutral-primary-soft border border-default p-6 md:p-10 rounded-xl shadow-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
                
                <div class="rounded-xl overflow-hidden bg-black/40 border border-gray-800 flex items-center justify-center p-4">
                    <img src="<?php echo $thumbnail; ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" class="w-full h-auto object-cover max-h-[450px] rounded-lg shadow-xl">
                </div>

                <div class="flex flex-col justify-center">
                    <span class="text-moss-light text-sm font-bold tracking-widest uppercase mb-2">Hardware Component</span>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-4 tracking-tight leading-tight">
                        <?php echo htmlspecialchars($product['product_name']); ?>
                    </h1>
                    
                    <div class="text-3xl font-bold text-white mb-6 pb-6 border-b border-gray-700/50">
                        Rp <?php echo $price_formatted; ?>
                    </div>

                    <p class="text-gray-400 mb-8 leading-relaxed font-light text-base md:text-lg">
                        <?php echo nl2br(htmlspecialchars($description)); ?>
                    </p>

                    <div class="flex items-center gap-4 mb-8">
                        <span class="bg-gray-800 text-gray-300 text-sm font-bold px-4 py-2 rounded border border-gray-600">
                            Stock Available: <span class="text-white"><?php echo $stock; ?></span> Units
                        </span>
                    </div>

                    <form action="proses/add_to_cart.php" method="POST" class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                        <input type="hidden" name="id_product" value="<?php echo $product['id_product']; ?>">
                        
                        <div class="relative flex items-center w-full sm:w-36">
                            <button type="button" id="decrement-button" data-input-counter-decrement="quantity-input" class="bg-gray-800 hover:bg-gray-700 border border-gray-600 rounded-s-lg p-3 h-12 focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                <svg class="w-3 h-3 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h16"/></svg>
                            </button>
                            <input type="number" id="quantity-input" name="quantity" data-input-counter data-input-counter-min="1" data-input-counter-max="<?php echo $stock; ?>" class="bg-gray-900 border-x-0 border-gray-600 h-12 text-center text-white text-base focus:ring-moss-light focus:border-moss-light block w-full py-2.5 outline-none" value="1" min="1" max="<?php echo $stock; ?>" required />
                            <button type="button" id="increment-button" data-input-counter-increment="quantity-input" class="bg-gray-800 hover:bg-gray-700 border border-gray-600 rounded-e-lg p-3 h-12 focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                <svg class="w-3 h-3 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 1v16M1 9h16"/></svg>
                            </button>
                        </div>
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center text-white bg-gradient-to-r from-moss-light to-moss-dark hover:opacity-90 focus:ring-4 focus:ring-moss-light/50 font-bold rounded-md text-base px-4 py-3 h-12 text-center transition-all shadow-lg border border-transparent">
                            <svg class="w-5 h-5 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"/>
                            </svg>
                            Add to Cart
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </main>
    
    <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>