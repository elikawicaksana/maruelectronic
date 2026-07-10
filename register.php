<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maru's Electronics | Register</title>
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

        input:focus {
            border-color: #708238 !important;
            --tw-ring-color: #708238 !important;
            box-shadow: 0 0 0 1px #708238 !important; 
            outline: none !important;
        }
    </style>
    <?php
        session_start();
        if(isset($_SESSION['username']) && isset($_SESSION['passwd'])){
            echo "<script type='text/javascript'>\n";
            echo "alert('You already logged in!');";
            echo "window.location = ('index.php');";
            echo "</script>";
        }

        include 'config/koneksi.php';
    ?>
</head>
<body class="dark bg-main-blue font-sans">
<section class="min-h-screen grid grid-cols-1 lg:grid-cols-12">
        <div class="lg:col-span-5 flex flex-col items-center justify-center px-6 py-8 mx-auto w-full h-full bg-[#040911] relative z-10">    
            <div class="w-full sm:max-w-md">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-white md:text-2xl mb-8">
                    Start Your Journey From Here!
                </h1>
                <form class="space-y-4 md:space-y-6" action="proses/register-proses.php" method="post" autocomplete="off">
                    <div>
                        <label for="username" class="block mb-2 text-sm font-medium text-white">Username</label>
                        <input type="text" name="username" id="username" maxlength="18" class="bg-gray-800 border border-gray-600 text-white sm:text-sm rounded-md block w-full p-2.5 placeholder-gray-400" placeholder="e.g. doejohnuser" required="">
                    </div>
                    <div>
                        <label for="full-name" class="block mb-2 text-sm font-medium text-white">Full Name</label>
                        <input type="text" name="name" id="full-name" class="bg-gray-800 border border-gray-600 text-white sm:text-sm rounded-md block w-full p-2.5 placeholder-gray-400" placeholder="e.g. John Doe" required="">
                    </div>
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-white">Email</label>
                        <input type="text" name="email" id="email" class="bg-gray-800 border border-gray-600 text-white sm:text-sm rounded-md block w-full p-2.5 placeholder-gray-400" placeholder="example@gmail.com" required="">
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-white">Password</label>
                        <input type="password" name="password" id="password" placeholder="••••••••••••" maxlength="18" class="bg-gray-800 border border-gray-600 text-white sm:text-sm rounded-md block w-full p-2.5 placeholder-gray-400" required="">
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-white">Confirm Password</label>
                        <input type="password" name="retype" id="retype" placeholder="••••••••••••" maxlength="18" class="bg-gray-800 border border-gray-600 text-white sm:text-sm rounded-md block w-full p-2.5 placeholder-gray-400" required="">
                    </div>
                    <button type="submit" class="w-full text-white bg-gradient-to-r from-[#708238] to-[#006D4C] hover:brightness-110 focus:ring-4 focus:outline-none focus:ring-[#006D4C]/50 font-medium rounded-md text-sm px-5 py-2.5 text-center transition-all">
                        Sign Up
                    </button>
                    <p class="text-md font-light text-gray-400">
                        Already have an account? <a href="login.php" class="font-medium text-[#708238] hover:underline hover:text-[#006D4C]">Login here</a>
                    </p>
                </form>
            </div>
        </div>
        <div class="hidden lg:block lg:col-span-7 w-full h-full p-4 bg-[#040911]">
            <div class="relative w-full h-full rounded-[2rem] overflow-hidden shadow-2xl border border-gray-800">
                <img class="absolute inset-0 w-full h-full object-cover" src="dist/img/thumbnail.jpg" alt="Login Background">
                <div class="absolute inset-0 bg-gradient-to-t from-[#040911] via-[#006D4C]/40 to-transparent opacity-90"></div>
                <div class="absolute inset-0 z-10 flex flex-col justify-end p-12 text-white">
                    <a href="index.php"><img src="dist/img/logo.png" class="h-14 mb-6 invert brightness-0 contrast-200 self-start" alt="Logo White"></a>
                    <h2 class="text-5xl font-bold leading-tight mb-4">
                        Build Your Project With Us.
                    </h2>
                    <p class="text-lg text-gray-200 font-light max-w-md mb-8">
                        Start your electronics project with the right component from our shop.
                    </p>
                    <div class="flex items-center gap-4 p-4 backdrop-blur-sm rounded-xl w-fit">
                        <div class="flex -space-x-4">
                            <!-- <img class="w-10 h-10 border-2 border-[#fffff] rounded-full" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=64&h=64" alt="">
                            <img class="w-10 h-10 border-2 border-[#fffff] rounded-full" src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=64&h=64" alt="">
                            <img class="w-10 h-10 border-2 border-[#fffff] rounded-full" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=64&h=64" alt=""> -->
                        </div>
                        <!-- <span class="text-sm font-medium text-white">Bergabung dengan 11.4k Siswa</span> -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
</body>
</html>