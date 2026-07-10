<?php 
 	include "../config/koneksi.php";

    // var_dump($_POST['name']);
    // var_dump($_POST['username']);
    // var_dump($_POST['password']);
    // var_dump($_POST['retype']);
    // var_dump($_POST['email']);   
    // var_dump($_POST['role']);

 	if (strlen($_POST['name'])>255){
		echo "<script type='text/javascript'>
		alert('Full name must not be more than 255 characters');
		window.location = ('../register.php');
        </script>";
	}else if (strlen($_POST['username'])>25){
        echo "<script type='text/javascript'>
		alert('Username must not be more than 25 characters');
		window.location = ('../register.php');
        </script>";
    }else if(strlen($_POST['password'])<8 || strlen($_POST['password'])>18){
        echo "<script type='text/javascript'>
		alert('Sorry, password length cannot be less than 8 and more than 16 character');
		window.location = ('../register.php');
        </script>";
    }else if(trim($_POST['password'])!=trim($_POST['retype'])){
        echo "<script type='text/javascript'>
		alert('Sorry, your Password and Retype do not match');
		window.location = ('../register.php');
        </script>";
    }else{
        $selQuery=mysqli_query($conn,"SELECT * FROM db_maruelectronics.tb_user WHERE username='".mysqli_real_escape_string($conn,trim($_POST['username']))."'") OR die(mysqli_error($conn));
        $jumQuery=mysqli_num_rows($selQuery);
        if($jumQuery>0){
            echo "<script type='text/javascript'>
            alert('Sorry, Username already in use');
            window.location = ('../register.php');
            </script>";
        }else{
            $options = [
                'cost' => 10,
            ];
            $password_hash = password_hash($_POST['password'],PASSWORD_DEFAULT,$options);
            $insertUser=mysqli_query($conn,"INSERT INTO db_maruelectronics.tb_user
                                            (`name`, username, passwd, email, `role`)
                                            VALUES
                                            ('".$_POST['name']."','".$_POST['username']."','".$password_hash."','".$_POST['email']."','Customer')
                                            ")OR die(mysqli_error($conn));
            if($insertUser==true){
                echo "<script type='text/javascript'>
                alert('Registration Successful');
                window.location = ('../login.php');
                </script>";
            }else{
                echo "<script type='text/javascript'>
                alert('Sorry, there was an error in the system');
                window.location = ('../register.php');
                </script>";
            }
        }	
    }
?>