<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maru Electronics | Transaction List</title>
    <link href="src/output.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <?php
        include 'config/koneksi.php';

        if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'Admin') {
            echo "<script>alert('Unauthorized access!'); window.location = 'index.php';</script>";
            exit;
        }

        $limit = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start = ($page > 1) ? ($page * $limit) - $limit : 0;

        $queryTotal = mysqli_query($conn, "SELECT COUNT(*) as total FROM db_maruelectronics.tb_order");
        $rowTotal = mysqli_fetch_assoc($queryTotal);
        $totalData = $rowTotal['total'];
        $totalPages = ceil($totalData / $limit);
        $queryOrders = mysqli_query($conn, "
            SELECT o.*, u.name, u.email 
            FROM db_maruelectronics.tb_order o 
            JOIN db_maruelectronics.tb_user u ON o.id_user = u.id_user 
            ORDER BY o.created_at DESC 
            LIMIT $start, $limit
        ");
    ?>
</head>
<body class="dark bg-main-blue font-sans text-gray-200">
    <?php include 'include/navbar-dashboard.php'; ?>

    <div class="p-8 mt-14">
        <div class="px-36 sm:px-36">
            <div class="w-full mb-24">   
                <h1 class="text-4xl font-medium text-white mb-8">Transaction Management</h1>
                
                <div class="relative overflow-hidden w-full bg-neutral-primary-soft shadow-xs rounded-base border border-default">
                    <div class="flex flex-col md:flex-row items-center justify-between p-4 border-b border-default-medium">
                        <div>
                            <h2 class="text-2xl font-semibold text-white">Orders List</h2>
                            <p class="text-moss-light font-medium text-sm">Monitor and process customer orders</p>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-300">
                            <thead class="text-xs uppercase bg-neutral-secondary-medium border-b border-default-medium text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-4 font-bold">Order ID / Date</th>
                                    <th scope="col" class="px-6 py-4 font-bold">Customer</th>
                                    <th scope="col" class="px-6 py-4 font-bold text-center">Total</th>
                                    <th scope="col" class="px-6 py-4 font-bold text-center">Payment</th>
                                    <th scope="col" class="px-6 py-4 font-bold text-center">Logistics</th>
                                    <th scope="col" class="px-6 py-4 font-bold text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                if(mysqli_num_rows($queryOrders) > 0){
                                    while($row = mysqli_fetch_assoc($queryOrders)) {
                                        $inv_id = 'INV-' . date('ym', strtotime($row['created_at'])) . str_pad($row['id_order'], 4, '0', STR_PAD_LEFT);
                                        
                                        if ($row['status'] == 1) {
                                            $pay_badge = '<span class="bg-green-900/50 text-green-400 border border-green-800 text-xs px-2 py-1 rounded">Paid</span>';
                                        } elseif ($row['status'] == 2) {
                                            $pay_badge = '<span class="bg-red-900/50 text-red-400 border border-red-800 text-xs px-2 py-1 rounded">Failed</span>';
                                        } else {
                                            $pay_badge = '<span class="bg-yellow-900/50 text-yellow-400 border border-yellow-800 text-xs px-2 py-1 rounded">Pending</span>';
                                        }

                                        if ($row['shipping_status'] == 1) {
                                            $ship_badge = '<span class="bg-blue-900/50 text-blue-400 border border-blue-800 text-xs px-2 py-1 rounded">Shipped</span>';
                                        } elseif ($row['shipping_status'] == 2) {
                                            $ship_badge = '<span class="bg-emerald-900/50 text-emerald-400 border border-emerald-800 text-xs px-2 py-1 rounded">Delivered</span>';
                                        } else {
                                            $ship_badge = '<span class="bg-gray-700 text-gray-300 border border-gray-600 text-xs px-2 py-1 rounded">Processing</span>';
                                        }
                                ?>
                                <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-mono font-bold text-white"><?= $inv_id ?></div>
                                        <div class="text-xs text-gray-500 mt-1"><?= date('d M Y, H:i', strtotime($row['created_at'])) ?></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-200"><?= htmlspecialchars($row['name']) ?></div>
                                        <div class="text-xs text-gray-400"><?= htmlspecialchars($row['email']) ?></div>
                                    </td>
                                    <td class="px-6 py-4 text-center font-bold">
                                        Rp <?= number_format($row['total'], 0, ',', '.') ?>
                                    </td>
                                    <td class="px-6 py-4 text-center"><?= $pay_badge ?></td>
                                    <td class="px-6 py-4 text-center"><?= $ship_badge ?></td>
                                    <td class="px-6 py-4 text-center space-x-2">
                                        <!-- Trigger Modal -->
                                        <button type="button" class="btn-detail text-blue-400 hover:text-blue-300 font-medium text-sm transition"
                                            data-id="<?= $row['id_order'] ?>" 
                                            data-inv="<?= $inv_id ?>"
                                            data-address="<?= htmlspecialchars($row['delivery_address']) ?>"
                                            data-modal-target="detailModal" data-modal-toggle="detailModal">
                                            <i class="fa-solid fa-eye"></i> View
                                        </button>

                                        <?php if($row['status'] == 1 && $row['shipping_status'] == 0): ?>
                                            |
                                            <form action="proses/prosesQuery.php" method="POST" class="inline">
                                                <input type="hidden" name="flag" value="prosesUpdatePengiriman">
                                                <input type="hidden" name="id_order" value="<?= $row['id_order'] ?>">
                                                <input type="hidden" name="shipping_status" value="1">
                                                <input type="hidden" name="return_url" value="<?= $_SERVER['REQUEST_URI'] ?>">
                                                <button type="submit" class="text-moss-light hover:text-white font-medium text-sm transition" onclick="return confirm('Process shipping for this order?');">
                                                    <i class="fa-solid fa-truck-fast"></i> Ship
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php }} else { ?>
                                    <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">No transactions found.</td></tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="detailModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black/60 backdrop-blur-sm">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <div class="relative bg-neutral-primary-soft border border-default rounded-xl shadow-2xl">
                <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-700 rounded-t">
                    <h3 class="text-xl font-bold text-white">Order Details <span id="modalInv" class="text-moss-light ml-2"></span></h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="detailModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
                <div class="p-4 md:p-5 space-y-4">
                    <div>
                        <h4 class="text-sm font-bold text-gray-400 mb-2">Delivery Address:</h4>
                        <p id="modalAddress" class="text-sm text-gray-200 bg-main-blue p-3 rounded-lg border border-gray-700"></p>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-gray-400 mb-2">Purchased Items:</h4>
                        <div id="modalItems" class="space-y-2 bg-main-blue p-3 rounded-lg border border-gray-700">
                            <div class="text-center text-sm text-gray-500 py-4"><i class="fa-solid fa-spinner fa-spin"></i> Loading data...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.btn-detail').on('click', function(){
                let idOrder = $(this).attr('data-id');
                let invId = $(this).attr('data-inv');
                let address = $(this).attr('data-address');

                $('#modalInv').text(invId);
                $('#modalAddress').text(address ? address : 'No address recorded.');
                $('#modalItems').html('<div class="text-center text-sm text-gray-500 py-4"><i class="fa-solid fa-spinner fa-spin"></i> Loading items...</div>');

                $.ajax({
                    url: 'proses/getOrderDetail.php',
                    type: 'POST',
                    data: { id_order: idOrder },
                    success: function(response){
                        $('#modalItems').html(response);
                    },
                    error: function(){
                        $('#modalItems').html('<div class="text-red-400 text-sm">Failed to load item details.</div>');
                    }
                });
            });
        });
    </script>
</body>
</html>