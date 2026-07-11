<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maru Electronics | Add New Product</title>
    <link href="src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/png" href="dist/img/favicon-96x96.png" sizes="96x96" />
    <link rel="shortcut icon" href="dist/img/favicon.ico" />
    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;  
            scrollbar-width: none; 
        }
    </style>
    <?php
        include 'config/koneksi.php';
        include 'config/fungsi.php';

        if (!isset($_SESSION['id_user'])) {
            echo "<script type='text/javascript'>\n";
            echo "alert('Please login first!');";
            echo "window.location = ('index.php');";
            echo "</script>";
        }

        if($_SESSION['role']!='Admin'){
            echo "<script type='text/javascript'>\n";
            echo "alert('You are not an admin!');";
            echo "window.location = ('index.php');";
            echo "</script>";
        }

        $id_product = $_GET['id_product'];

        $queryProduct = mysqli_query($conn, "SELECT * FROM db_maruelectronics.tb_product WHERE id_product = '$id_product'");
        $product = mysqli_fetch_assoc($queryProduct);
    ?>
</head>
<body class="dark bg-main-blue font-sans">
    <?php 
        include 'include/navbar-dashboard.php'; 
    ?>
    <div class="p-8 mt-14">
        <div class="p-4 px-48 sm:px-48">
            <div class="w-full mb-24"> 
                <div class="relative overflow-hidden w-full bg-neutral-primary-soft shadow-xs rounded-base border border-default p-6">
                    <h2 class="mb-6 text-xl font-bold text-heading">Edit product information</h2>
                    <form action="proses/prosesQuery.php" method="post" autocomplete="off" enctype="multipart/form-data">
                        <input type="hidden" name="flag" value="prosesEditProduk">
                        <input type="hidden" name="id_product" value="<?php echo $product['id_product']; ?>">
                        <input type="hidden" name="old_img" value="<?php echo $product['img']; ?>">
                        <div class="grid gap-4 mb-4 grid-cols-2 gap-6 mb-5">
                            <div class="col-span-2">
                                <label for="student-name" class="block mb-2 text-sm font-medium text-heading">Product Name</label>
                                <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($product['product_name']); ?>" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-md focus:border-[#708238] focus:ring-1 focus:ring-[#708238] block w-full p-2.5 placeholder:text-body" placeholder="Type product name" required="">
                            </div>
                            <div class="w-full">
                                <label for="price" class="block mb-2 text-sm font-medium text-heading">Price</label>
                                <input type="number" name="price" id="price" value="<?php echo htmlspecialchars($product['price']); ?>" min="1" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-md focus:border-[#708238] focus:ring-1 focus:ring-[#708238] block w-full p-2.5 placeholder:text-body" placeholder="Type price" required="">
                            </div>
                            <div class="w-full">
                                <label for="stock" class="block mb-2 text-sm font-medium text-heading">Stock</label>
                                <input type="number" name="stock" id="stock" value="<?php echo htmlspecialchars($product['stock']); ?>" data-input-counter data-input-counter-min="1" min="1" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-md focus:border-[#708238] focus:ring-1 focus:ring-[#708238] block w-full p-2.5 placeholder:text-body" placeholder="Type stock" required="">
                            </div>
                            <div class="col-span-2">
                                <label class="block mb-2 text-sm font-medium text-heading" for="img">Product Photo</label>
                                <?php if(!empty($product['img'])): ?>
                                    <div class="mb-2">
                                        <img src="<?php echo $product['img']; ?>" alt="Current Photo" class="h-32 rounded-md object-cover border border-gray-700">
                                        <p class="text-xs text-gray-500 mt-1">Current Image. Upload new one to replace.</p>
                                    </div>
                                <?php endif; ?>
                                <input class="cursor-pointer bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-md focus:border-[#708238] focus:ring-1 focus:ring-[#708238] block w-full shadow-xs placeholder:text-body" id="img_new" name="img_new" type="file" accept="image/*">
                            </div>
                            <div class="col-span-2">
                                <label for="desc" class="block mb-2 text-sm font-medium text-heading">Description</label>
                                <textarea id="desc" name="desc" rows="4" class="block p-2.5 w-full text-sm text-heading bg-neutral-secondary-medium rounded-md border border-default-medium focus:border-[#708238] focus:ring-1 focus:ring-[#708238] placeholder:text-body" placeholder="Product description..." required><?php echo htmlspecialchars($product['desc']); ?></textarea>
                            </div>
                        </div>
                        <button type="submit" class="inline-flex items-center text-white bg-[#708238] hover:bg-[#006D4C] box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                            Edit Product
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>