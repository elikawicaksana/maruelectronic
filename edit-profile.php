<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | Maru Electronics</title>
    <link href="src/output.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <?php
        include 'config/koneksi.php';

        if (!isset($_SESSION['id_user'])) {
            header("Location: login.php");
            exit;
        }

        $id_user = $_SESSION['id_user'];
        $success_msg = '';
        $error_msg = '';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = mysqli_real_escape_string($conn, trim($_POST['name']));
            $email = mysqli_real_escape_string($conn, trim($_POST['email']));
            $address = mysqli_real_escape_string($conn, trim($_POST['address']));

            if (empty($name) || empty($email) || empty($address)) {
                $error_msg = "All fields are mandatory. Do not leave blank inputs.";
            } else {
                $update_query = "UPDATE db_maruelectronics.tb_user 
                                SET name = '$name', email = '$email', address = '$address' 
                                WHERE id_user = '$id_user'";
                                
                if (mysqli_query($conn, $update_query)) {
                    $success_msg = "Profile updated successfully.";
                } else {
                    $error_msg = "Database constraint failed: " . mysqli_error($conn);
                }
            }
        }
        $query = mysqli_query($conn, "SELECT `name`, email, address FROM db_maruelectronics.tb_user WHERE id_user = '$id_user'");
        $user = mysqli_fetch_assoc($query);
    ?>
</head>
<body class="dark bg-main-blue font-sans">
    <?php include 'include/navbar.php'; ?>
    <main class="pt-26 pb-20 px-4 max-w-screen-sm mx-auto min-h-screen">
        <h1 class="text-3xl font-extrabold text-white mb-8 tracking-tight">Edit Profile</h1>
        <div class="bg-neutral-primary-soft border border-default p-8 rounded-xl shadow-lg">
            <?php if ($success_msg): ?>
                <div class="bg-green-900/50 border border-green-600 text-green-400 p-4 rounded-lg mb-6 text-sm font-bold flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <?php echo $success_msg; ?>
                </div>
            <?php endif; ?>
            
            <?php if ($error_msg): ?>
                <div class="bg-red-900/50 border border-red-600 text-red-400 p-4 rounded-lg mb-6 text-sm font-bold flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    <?php echo $error_msg; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="proses/prosesQuery.php" class="space-y-6">
                <input type="hidden" name="flag" value="prosesEditUser">
                <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
                <div>
                    <label class="block text-sm font-bold text-gray-300 mb-2">Full Name</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required
                        class="w-full bg-main-blue border border-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:border-moss-light focus:ring-1 focus:ring-moss-light transition-all placeholder-gray-500">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-300 mb-2">Email Address</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required
                        class="w-full bg-main-blue border border-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:border-moss-light focus:ring-1 focus:ring-moss-light transition-all placeholder-gray-500">
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-300 mb-2">Delivery Address</label>
                    <textarea name="address" rows="4" required class="w-full bg-main-blue border border-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:border-moss-light focus:ring-1 focus:ring-moss-light transition-all placeholder-gray-500 resize-y"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                </div>

                <div class="pt-6 border-t border-gray-700">
                    <button type="submit" class="w-full inline-flex items-center justify-center text-white bg-gradient-to-r from-moss-light to-moss-dark hover:opacity-90 focus:ring-4 focus:ring-moss-light/50 font-bold rounded-lg px-6 py-4 text-center transition-all shadow-md text-lg">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
<script src="./node_modules/flowbite/dist/flowbite.min.js"></script>
</html>