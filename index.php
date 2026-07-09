<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notasi | Homepage</title>
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
        <img src="dist/img/thumbnail.jpg" alt="Circuit" class="absolute inset-0 w-full h-full object-cover object-center" />
    </section>

    <section class="py-20 px-4 bg-main-blue relative">
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
                            Maru Electornics's Catalog
                        </span>
                    </span>
                </div>
            </div>
        </div>
        <div class="max-w-lg mx-auto grid grid-cols-1 md:grid-cols-3 gap-18 mb-12">
            <?php
                $query = mysqli_query($conn, "SELECT * FROM db_maruelectronics.tb_product ORDER BY id_product DESC LIMIT 3");
                
                if(mysqli_num_rows($query) > 0){
                    while($row = mysqli_fetch_array($query)){
                        $thumbnail = !empty($row['thumbnail']) ? $row['thumbnail'] : 'dist/img/thumbnail.png';
            ?>
                <a href="product-detail.php?id_product=<?php echo $row['id_product']; ?>" class="group relative h-[450px] rounded-2xl overflow-hidden cursor-pointer shadow-lg hover:shadow-moss-dark/20 transition-all duration-300 block">
                    <img src="<?php echo $thumbnail; ?>" alt="<?php echo htmlspecialchars($row['product_name']); ?>" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-black/30 group-hover:from-black/80 transition-all"></div>
                    <div class="absolute inset-0 flex flex-col items-center p-6 text-center z-10">
                        <img src="dist/img/logo.png" class="h-6 mb-4" alt="Logo Small">
                        <h3 class="text-3xl font-semibold text-white leading-tight transition-colors">
                            <?php echo htmlspecialchars($row['product_name']); ?>
                        </h3>
                    </div>
                </a>
            <?php 
                    }
                } else {
                    echo '<p class="text-white text-center col-span-3">There is no product available at the moment.</p>';
                }
            ?>
        </div>
        <div class="flex items-center justify-center">
            <a href="product-catalog.php" class="flex items-center gap-2 text-white/70 hover:text-[#01553c] transition-colors group">
                <span class="text-sm font-medium tracking-widest uppercase"> See all products</span>
                <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </a>
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
            <img src="dist/img/logo.png" alt="Notasi Logo" class="h-14 mx-auto" />
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