<?php
    include '../config/koneksi.php';

    $flag=$_POST['flag'];

    if($flag=="prosesTambahUser"){
        // var_dump($_POST['name']);
        // var_dump($_POST['username']);
        // var_dump($_POST['passwd']);
        // var_dump($_POST['email']);
        // var_dump($_POST['role']);

        $options = [
            'cost' => 10,
        ];
        $password_hash = password_hash($_POST['password'],PASSWORD_DEFAULT,$options);
        // echo $password_hash;

        $insertUser=mysqli_query($conn,"INSERT INTO db_maruelectronics.tb_user(username, `name`, email, passwd, `role`, `address`)
                                        VALUES
                                        ('".$_POST['username']."','".$_POST['name']."','".$_POST['email']."', '".$password_hash."','".$_POST['role']."', '".$_POST['address']."')
                                       ")OR die(mysqli_error($conn));

        if($insertUser==true){
            echo "<script type='text/javascript'>\n";
            echo "alert('Successfully Add Data!');";
            echo "window.location = ('../dashboard.php');";
            echo "</script>";
        }else{
            echo "<script type='text/javascript'>\n";
            echo "alert('Sorry, there's an error in the system.');";
            echo "window.location = ('../add-new-user.php');";
            echo "</script>";
        }
    }elseif($flag=="prosesHapusUser"){
		$id_user=$_POST['id_user'];
		$delQuery=mysqli_query($conn,"DELETE FROM db_maruelectronics.tb_user WHERE id_user='".$id_user."'") OR die(mysqli_error($conn));
		if($delQuery==true){
			$data['success']="sukses";
		}else{
			$data['success']="gagal";
		}
		echo json_encode($data);
	}elseif($flag=="prosesEditUser"){
        // var_dump($_POST['id_user']);
        // var_dump($_POST['name']);
        // var_dump($_POST['username']);
        // var_dump($_POST['email']);
        // var_dump($_POST['role']);
        // var_dump($_POST['fotoLama']);
        // var_dump($_POST['foto']);

        $editQuery=mysqli_query($conn,"UPDATE db_maruelectronics.tb_user
                                        SET `name`='".$_POST['name']."',username='".$_POST['username']."',email='".$_POST['email']."',role='".$_POST['role']."' WHERE id_user='".$_POST['id_user']."' 
                                    ") OR die(mysqli_error($conn));
        if($editQuery==true){
            echo "<script type='text/javascript'>\n";
            echo "alert('Successfully edit user information');";
            echo "window.location = ('../edit-user.php?id_user=".$_POST['id_user']."');";
            echo "</script>";
        }else{
            echo "<script type='text/javascript'>\n";
            echo "alert('Failed to edit user information');";
            echo "window.location = ('../edit-user.php?id_user=".$_POST['id_user']."');";
            echo "</script>";
        }
    }elseif($flag=="prosesTambahProduk"){
        // var_dump($_POST);
		$name=$_POST['name'];
		$price=$_POST['price'];
		$stock=$_POST['stock'];
		$desc=$_POST['desc'];

		$folder= "dist/img";
		$tmp_name=$_FILES['img']["tmp_name"];
		$img_name=$_FILES['img']['name'];
        $img_name_clean = str_replace(' ', '_', $img_name);
		$img_fix=$folder."/".date('Ymd-His')."PRODUCT-".$img_name_clean;

        // var_dump($tmp_name);
        // var_dump($img_name);
        // var_dump($img_fix);
		move_uploaded_file($tmp_name,"../".$img_fix);
		
		$insertQuery=mysqli_query($conn,"INSERT INTO db_maruelectronics.tb_product(product_name,price,stock,`desc`,img)
                                            VALUES
                                            ('".$name."','".$price."','".$stock."','".$desc."','".$img_fix."') 
                                        ") OR die(mysqli_error($conn));
		if($insertQuery==true){
			echo "<script>
                    alert('New product successfully saved!'); 
                    window.location = ('../dashboard-admin.php'); 
                  </script>";
		}else{
			$safeError = json_encode($e->getMessage());
            echo "<script>
                    alert('Failed: ' + $safeError); 
                    window.history.back();
                  </script>";
		}
    }elseif($flag=="prosesHapusProduk"){
		$id_product=$_POST['id_product'];
		$delQuery=mysqli_query($conn,"DELETE FROM db_maruelectronics.tb_product WHERE id_product='".$id_product."'") OR die(mysqli_error($conn));
		if($delQuery==true){
			$data['success'] = "sukses";
            $data['message'] = "Product data deleted successfully";
		}else{
			$data['success'] = "gagal";
            $data['message'] = $e->getMessage();
		}
		echo json_encode($data);
	}else if($flag=="prosesEditProduk"){
        // var_dump($_POST);
		$name=$_POST['name'];
		$price=$_POST['price'];
		$stock=$_POST['stock'];
		$desc=$_POST['desc'];
    
        $img=$_POST['old_img'];
        if($_FILES['img_new']['tmp_name']!=""){
            $folder= "dist/img";
            $tmp_name=$_FILES['img_new']["tmp_name"];
            $img_name=$_FILES['img_new']['name'];
            $img=$folder."/".date('Ymd-His')."PRODUCT-".$img_name;
            move_uploaded_file($tmp_name,"../".$img);
        }
        $updateQuery=mysqli_query($conn,"UPDATE db_maruelectronics.tb_product 
                                         SET product_name='".$name."',price='".$price."',stock='".$stock."',img='".$img."',`desc`='".$desc."' 
                                         WHERE id_product='".$_POST['id_product']."'
                                        ") OR die(mysqli_error($conn));
        if($updateQuery==true){
            echo "<script>alert('Product updated!'); window.location='../dashboard-admin.php';</script>";
        }else{
            mysqli_rollback($conn);
            if (!empty($server_upload_path) && file_exists($server_upload_path)) unlink($server_upload_path);
            echo "<script>alert('Update Failed: " . addslashes($e->getMessage()) . "'); window.history.back();</script>";
        }
    } elseif ($flag == "prosesTambahKeranjang") {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['id_user'])) {
            echo "<script>
                    alert('Access Denied: You must log in first to add items to your cart.'); 
                    window.location = '../login.php';
                  </script>";
            exit;
        }

        $id_product = isset($_POST['id_product']) ? (int)$_POST['id_product'] : 0;
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        if ($id_product > 0 && $quantity > 0) {
            $cekProduk = mysqli_query($conn, "SELECT * FROM db_maruelectronics.tb_product WHERE id_product = '$id_product'");
            
            if (mysqli_num_rows($cekProduk) > 0) {
                $produk = mysqli_fetch_assoc($cekProduk);
                $stok_tersedia = $produk['stock'];

                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = array();
                }

                $current_qty_in_cart = isset($_SESSION['cart'][$id_product]) ? $_SESSION['cart'][$id_product] : 0;
                $total_qty_requested = $current_qty_in_cart + $quantity;

                if ($total_qty_requested > $stok_tersedia) {
                    echo "<script>
                            alert('Failed: Requested quantity (" . $total_qty_requested . " units) exceeds available stock (" . $stok_tersedia . " units).'); 
                            window.history.back();
                          </script>";
                } else {
                    $_SESSION['cart'][$id_product] = $total_qty_requested;
                    echo "<script>window.location = '../cart.php';</script>";
                }
            } else {
                echo "<script>alert('Failed: Product not found.'); window.history.back();</script>";
            }
        } else {
            echo "<script>alert('Failed: Invalid request.'); window.history.back();</script>";
        }
    } elseif ($flag == "prosesUpdateKeranjang") {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $id_product = isset($_POST['id_product']) ? (int)$_POST['id_product'] : 0;
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        if ($id_product > 0 && $quantity > 0) {
            $cekProduk = mysqli_query($conn, "SELECT stock FROM db_maruelectronics.tb_product WHERE id_product = '$id_product'");
            if (mysqli_num_rows($cekProduk) > 0) {
                $produk = mysqli_fetch_assoc($cekProduk);
                if ($quantity > $produk['stock']) {
                    echo "<script>alert('Failed: Insufficient stock. Remaining stock: " . $produk['stock'] . "'); window.history.back();</script>";
                } else {
                    $_SESSION['cart'][$id_product] = $quantity;
                    echo "<script>window.location = '../cart.php';</script>";
                }
            }
        } else {
            echo "<script>alert('Failed: Invalid quantity.'); window.history.back();</script>";
        }

    } elseif ($flag == "prosesHapusKeranjang") {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $id_product = isset($_POST['id_product']) ? (int)$_POST['id_product'] : 0;
        
        if (isset($_SESSION['cart'][$id_product])) {
            unset($_SESSION['cart'][$id_product]);
        }
        echo "<script>window.location = '../cart.php';</script>";
    }
?>