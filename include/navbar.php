<nav class="bg-main-blue fixed w-full z-20 top-0 start-0 border-b border-default">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4 relative">
    <div class="relative z-10">
        <a href="product-catalog.php">
            <button type="button" class="text-white bg-gradient-green box-border border border-transparent hover:animate-gradient shadow-xs font-medium leading-4 text-sm px-3 py-2 focus:outline-none">
                Catalog
            </button>
        </a>
    </div>
    <div class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 mt-1 z-0 flex">
        <a href="index.php" class="flex items-center">  
            <img src="dist/img/logo.png" class="h-8 md:h-8" alt="Notasi Logo">
        </a>
    </div>
    <?php 
        if(isset($_SESSION['username']) && isset($_SESSION['passwd'])){
            echo "
                <div class='relative z-10 flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse'>
                    <button type='button' class='flex text-sm bg-neutral-primary rounded-full md:me-0 focus:ring-4 focus:ring-neutral-tertiary' id='user-menu-button' aria-expanded='false' data-dropdown-toggle='user-dropdown' data-dropdown-placement='bottom'>
                        <span class='sr-only'>Open user menu</span>
                        <img class='w-8 h-8 rounded-full' src='https://flowbite.com/docs/images/people/profile-picture-5.jpg' alt='user photo'>
                    </button>
                    
                    <div class='z-50 hidden bg-neutral-primary-medium border border-default-medium rounded-base shadow-lg w-44' id='user-dropdown'>
                        <div class='px-4 py-3 text-sm border-b border-default'>
                            <span class='block text-heading font-medium'>".$_SESSION['name']."</span>
                            <span class='block text-body truncate'>".$_SESSION['email']."</span>
                        </div>
                        <ul class='p-2 text-sm text-body font-medium' aria-labelledby='user-menu-button'>
                        <li>";
                        if($_SESSION['role']=="Admin"){
                            echo "<a href='dashboard-admin.php' class='inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded'>Dashboard</a>";
                        }else{
                            echo "<a href='dashboard.php' class='inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded'>Dashboard</a>";
                        }
                        echo "
                        </li>
                        <li>
                            <a href='proses/logout.php' class='inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded'>Sign out</a>
                        </li>
                        </ul>
                    </div>
                </div>
            ";
        }else{
            echo "
                <div class='flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse'>
                    <a href='login.php'><button type='button' class='text-white bg-gradient-green box-border border border-transparent hover:animate-gradient shadow-xs font-medium leading-4 text-sm px-3 py-2 focus:outline-none'>Sign In</button></a>
                </div>
            ";
        }
    ?>
  </div>
</nav>