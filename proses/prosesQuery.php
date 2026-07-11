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
	}
?>