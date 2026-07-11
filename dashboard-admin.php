<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notasi | Admin List</title>
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
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
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

        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start = ($page > 1) ? ($page * $limit) - $limit : 0;

        $queryTotal = mysqli_query($conn, "SELECT COUNT(*) as total FROM db_maruelectronics.tb_product");
        $rowTotal = mysqli_fetch_assoc($queryTotal);
        $totalData = $rowTotal['total'];
        $totalPages = ceil($totalData / $limit);

        $queryProducts = mysqli_query($conn, "SELECT * FROM db_maruelectronics.tb_product ORDER BY id_product DESC LIMIT $start, $limit");
    ?>
</head>
<body class="dark bg-main-blue font-sans">
    <?php 
        include 'include/navbar-dashboard.php';
    ?>
    <div class="p-8 mt-14">
        <div class="px-48 sm:px-48">
            <div class="w-full mb-24">   
                <h1 class="text-5xl font-medium text-heading">Welcome back, <?php echo $_SESSION['name']; ?>! 👋</h1><br/><br/>
                <div class="relative overflow-hidden w-full bg-neutral-primary-soft shadow-xs rounded-base border border-default">
                    <div class="flex flex-col md:flex-row items-center justify-between space-y-4 md:space-y-0 p-4 border-b border-default-medium">
                        <div class="w-full md:w-auto">
                            <h2 class="text-2xl font-semibold text-heading">Products List</h2>
                            <p class="text-[#708238] font-medium">Manage Your Products</p>
                        </div>
                        <a href="add-new-product.php">
                            <button type="button" class="inline-flex items-center text-white bg-[#708238] hover:bg-[#006D4C] box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                                <p><i class="fa-solid fa-plus"></i> Add New Product</p>
                            </button>
                        </a>
                    </div>
                    <div class="">
                        <table class="w-full text-sm text-left rtl:text-right text-body" id="tableData">
                            <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-default-medium">
                                <tr>
                                    <th scope="col" class="px-6 py-3 font-medium">Name</th>
                                    <th scope="col" class="px-6 py-3 font-medium text-center">Price</th>
                                    <th scope="col" class="px-6 py-3 font-medium text-center">Stock</th>
                                    <th scope="col" class="px-6 py-3 font-medium text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    if(mysqli_num_rows($queryProducts) > 0){
                                        while($row = mysqli_fetch_assoc($queryProducts)) {
                                            $idProduct = $row['id_product'];
                                            $img = !empty($row['img']) ? $row['img'] : "https://flowbite.com/docs/images/people/profile-picture-5.jpg";
                                ?>
                                <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium transition-colors duration-200">
                                    
                                    <th scope="row" class="flex items-center px-6 py-4 text-heading whitespace-nowrap">
                                        <img class="w-12 h-8 object-cover rounded-sm ring-1 ring-gray-700" src="<?= $img ?>" alt="<?= $row['product_name'] ?>">
                                        <div class="ps-3">
                                            <div class="text-base font-semibold text-white max-w-xs truncate" title="<?= $row['product_name'] ?>"><?= $row['product_name'] ?></div>
                                        </div>  
                                    </th>
                                    
                                    <td class="px-6 py-4 text-gray-300 text-center">
                                        <?= formatUang($row['price']) ?>
                                    </td>
                                    <td class="px-6 py-4 text-gray-300 text-center">
                                        <?= $row['stock'] ?>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="edit-product.php?id_product=<?= $idProduct ?>" class="font-medium text-[#708238] hover:text-[#8FA348] hover:underline transition-colors">Edit</a> |
                                        <button type='button' id='btnDel' class='font-medium text-fg-danger hover:text-danger hover:underline transition-colors' data-id=<?= $idProduct ?>>Delete</button>
                                    </td>
                                </tr>
                                <?php 
                                        } // End While
                                    } else { 
                                ?>
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                            No product data found.
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                    <nav class="flex flex-col md:flex-row justify-between items-center space-y-3 md:space-y-0 p-4 border-t border-default-medium" aria-label="Table navigation">
                        
                        <span class="text-sm font-normal text-gray-400">
                            Showing <span class="font-semibold text-white"><?= ($totalData > 0) ? $start + 1 : 0 ?></span> 
                            to <span class="font-semibold text-white"><?= min($start + $limit, $totalData) ?></span> 
                            of <span class="font-semibold text-white"><?= $totalData ?></span> entries
                        </span>
                        
                        <ul class="inline-flex items-center -space-x-px md:space-x-0 gap-2 text-sm h-8">
                            
                            <li>
                                <?php if($page > 1): ?>
                                    <a href="?page=<?= $page - 1 ?>" class="flex items-center justify-center px-3 h-9 leading-tight text-gray-400 bg-transparent border border-gray-600 rounded-lg hover:bg-gray-700 hover:text-white transition-all">
                                        <span class="sr-only">Previous</span>
                                        <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                                        </svg>
                                    </a>
                                <?php else: ?>
                                    <span class="flex items-center justify-center px-3 h-9 leading-tight text-gray-600 bg-transparent border border-gray-800 rounded-lg cursor-not-allowed opacity-50">
                                        <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                                        </svg>
                                    </span>
                                <?php endif; ?>
                            </li>

                            <?php for($i = 1; $i <= $totalPages; $i++): ?>
                                <li>
                                    <?php if($i == $page): ?>
                                        <span class="flex items-center justify-center px-3 h-9 text-white bg-gradient-to-br from-[#708238] to-[#506028] border border-[#708238] rounded-lg shadow-[0_4px_10px_rgba(112,130,56,0.4)] font-bold transform scale-105">
                                            <?= $i ?>
                                        </span>
                                    <?php else: ?>
                                        <a href="?page=<?= $i ?>" class="flex items-center justify-center px-3 h-9 leading-tight text-gray-400 bg-transparent border border-gray-600 rounded-lg hover:bg-gray-700 hover:text-white hover:border-gray-500 transition-all">
                                            <?= $i ?>
                                        </a>
                                    <?php endif; ?>
                                </li>
                            <?php endfor; ?>

                            <li>
                                <?php if($page < $totalPages): ?>
                                    <a href="?page=<?= $page + 1 ?>" class="flex items-center justify-center px-3 h-9 leading-tight text-gray-400 bg-transparent border border-gray-600 rounded-lg hover:bg-gray-700 hover:text-white transition-all">
                                        <span class="sr-only">Next</span>
                                        <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                        </svg>
                                    </a>
                                <?php else: ?>
                                    <span class="flex items-center justify-center px-3 h-9 leading-tight text-gray-600 bg-transparent border border-gray-800 rounded-lg cursor-not-allowed opacity-50">
                                        <svg class="w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                        </svg>
                                    </span>
                                <?php endif; ?>
                            </li>

                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </div>
    <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        var tableData=$('#tableData');

        tableData.on("click","#btnDel",function(){
    	var validasi=confirm("Are you sure you want to delete this product?");
    	if(validasi){
	    	var btn=$(this);
	    	var id_product=$(this).attr("data-id");
	    	// alert(id_product);
	    	var promise=$.ajax({
	    		url  : 'proses/prosesQuery.php',
	    		type : 'POST',
	    		dataType: 'json',
	    		cache   : false,
	    		data    : {
	    			flag  : "prosesHapusProduk",
	    			id_product : id_product
	    		},
	    		success: function(data){
                    if(data.success == "sukses"){
                        alert("Successfully deleted data!");
                        location.reload(); 
                    } else {
                        alert("Failed to delete data.");
                    }
                }
	    	});
	    }else{
	    	alert("Be careful!");
	    }
    });
    </script>
</body>
</html>