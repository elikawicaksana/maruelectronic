<!DOCTYPE html>
<html lang="en" class="scroll-smooth md:scroll-auto">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maru Electronics | Homepage</title>
    <link href="src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/png" href="dist/img/favicon-96x96.png" sizes="96x96" />
    <link rel="shortcut icon" href="dist/img/favicon.ico" />
    <?php
        include 'config/koneksi.php';
    ?>
</head>
<body class="dark bg-main-blue font-sans">
<?php include 'include/navbar.php'; ?>
<main class="pt-15">
    <section class="relative w-full h-[500px] md:h-[650px] overflow-hidden group">
        <!-- Gambar Latar -->
        <img src="dist/img/thumbnail.jpg" alt="Circuit Background" class="absolute inset-0 w-full h-full object-cover object-center" />
        
        <!-- Overlay Gelap -->
        <div class="absolute inset-0 bg-black/60"></div>
        
        <!-- Konten Teks -->
        <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4 max-w-4xl mx-auto">
            <span class="bg-gradient-to-r from-moss-light to-moss-dark text-white text-xs font-semibold px-3 py-1 rounded-full mb-4 uppercase tracking-widest border border-moss-light/50">
                Maru Electronics Online Shop
            </span>
            <h1 class="text-4xl md:text-6xl font-bold text-white mb-6 tracking-tight drop-shadow-lg">
                Smart Hardware & Computing Solutions
            </h1>
            <p class="text-lg md:text-xl text-gray-300 mb-6 max-w-2xl font-light">
                High-performance electronic components platform. Equipped with an instant checkout system and real-time transaction tracking.
            </p>
            <a href="#catalog">
                <button type="button" class="text-white bg-gradient-green box-border border border-transparent hover:animate-gradient shadow-xs font-medium leading-6 rounded-md text-lg px-3 py-2 focus:outline-none">
                    Explore Catalog ↓
                </button>
            </a>
        </div>
    </section>

    <section class="py-20 px-4 bg-main-blue relative" id="catalog">
        <div class="text-center mb-16 relative z-10">
            <h3 class="bg-gradient-to-r from-moss-light to-moss-dark bg-clip-text text-transparent text-2xl font-semibold tracking-wider">
                It's time to build your electronics!
            </h3>
            <div class="relative py-2">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-transparent bg-gradient-to-r from-moss-light to-moss-dark bg-origin-border h-[0.5px]"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="bg-footer-bg px-4">
                        <span class="text-white text-4xl md:text-5xl font-semibold tracking-wider">
                            Maru Electronics's Catalog
                        </span>
                    </span>
                </div>
            </div>
        </div>

        <div class="max-w-screen-xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-4 mb-12">
            <?php
                $query = mysqli_query($conn, "SELECT * FROM db_maruelectronics.tb_product ORDER BY id_product DESC");
                
                if(mysqli_num_rows($query) > 0){
                    while($row = mysqli_fetch_array($query)){
                        $img = !empty($row['img']) ? $row['img'] : 'dist/img/thumbnail.jpg';
                        $price = isset($row['price']) ? number_format($row['price'], 0, ',', '.') : '0';
            ?>
                <div class="bg-neutral-primary-soft p-6 border border-default shadow-xs flex flex-col justify-between">
                    <a href="product-detail.php?id_product=<?php echo $row['id_product']; ?>">
                        <img class="mb-6 w-full h-56 object-cover" src="<?php echo $img; ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>" />
                    </a>
                    <div>
                        <a href="product-detail.php?id_product=<?php echo $row['id_product']; ?>">
                            <h5 class="text-xl text-heading font-semibold tracking-tight line-clamp-2 min-h-[3.5rem]">
                                <?php echo htmlspecialchars($row['product_name']); ?>
                            </h5>
                        </a>
                        <div class="flex items-center justify-between mt-6">
                            <span class="text-2xl font-bold text-heading">Rp <?php echo $price; ?></span>
                            <a href="product-detail.php?id_product=<?php echo $row['id_product']; ?>">
                                <button type="button" class="inline-flex items-center text-white bg-gradient-to-r from-moss-light to-moss-dark box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 text-sm px-3 py-2 focus:outline-none transition-opacity hover:opacity-90">
                                    <svg class="w-4 h-4 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"/>
                                    </svg>
                                    Detail Product
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            <?php 
                    }
                } else {
                    echo '<p class="text-white text-center col-span-1 md:col-span-3 py-10">There is no product available at the moment.</p>';
                }
            ?>
        </div>
    </section>

    <section class="relative w-full py-28 flex items-center justify-center overflow-hidden mt-10">
        <div class="absolute inset-0">
            <img src="dist/img/background-footer.jpg" alt="Abstract Green Waves" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/60"></div>
        </div>
        <div class="relative z-10 text-center max-w-8xl px-12">
            <h1 class="text-6xl md:text-6xl font-bold text-white leading-tight mb-6 drop-shadow-2xl">
                Electronics is not just circuits and code; it is the language that turns imagination into intelligent machines and ideas into reality.
            </h1>
        </div>
    </section>
</main>
<footer class="bg-footer-bg">
    <div class="relative py-8">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-transparent bg-gradient-to-r from-moss-light to-moss-dark bg-origin-border h-[0.5px]"></div>
        </div>
        <div class="relative flex justify-center">
            <span class="bg-footer-bg px-4">
                <span class="bg-gradient-to-r from-moss-light to-moss-dark bg-clip-text text-transparent text-md font-semibold uppercase tracking-wider">
                    Learn More About Us
                </span>
            </span>
        </div>
    </div>
    <div class="mx-auto max-w-screen-xl px-4 pb-16 flex flex-col items-center text-center">
        <div class="mb-5">
            <div class="flex items-center">
                <span class="self-center text-xl font-bold whitespace-nowrap text-heading">MARU ELECTRONICS</span>
            </div>
        </div>
        <div class="space-y-3 text-sm text-white font-light">
            <a href="mailto:maruelectronics@gmail.com" class="hover:text-white transition-colors">
                maruelectronics@gmail.com
            </a>
            <p>
                Copyright © 2026 All rights reserved
            </p>
        </div>
    </div>
</footer>
<script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
</body>
</html>