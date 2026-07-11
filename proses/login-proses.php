<?php
    // session_start();
    include "../config/koneksi.php";
    $username=$_POST['username'];

    $queryUser=mysqli_query($conn,"SELECT tb_user.*
                                    FROM db_maruelectronics.tb_user
                                    WHERE username='".$username."' 
                                ") OR die(mysqli_error($conn)); 
    $fetch=mysqli_fetch_array($queryUser);
    $password_hash = $fetch['passwd'];
    $passwd = $_POST['password'];
    if(password_verify($passwd,$password_hash)){    
        $jumlahUser=mysqli_num_rows($queryUser);
        if($jumlahUser>0){
            setcookie('username', $username, time() + (60 * 60 * 24 * 5), '/');
            $status=1;
            $_SESSION['id_user']=$fetch['id_user'];
            $_SESSION['name']=$fetch['name'];
            $_SESSION['username']=$fetch['username'];
            $_SESSION['passwd']=$fetch['passwd'];
            $_SESSION['email']=$fetch['email'];
            $_SESSION['role']=$fetch['role'];
            $_SESSION['address']=$fetch['address'];

            if($_SESSION['role']=='Admin'){
                header('location:../dashboard-admin.php');
            }else{
                header('location:../transaction.php');
            }
        }else{
            echo "<script type='text/javascript'>\n";
            echo "alert('Wrong username!');";
            echo "window.location = ('../login.php');";
            echo "</script>";
        }
    }else{
        echo "<script type='text/javascript'>\n";
        echo "alert('Wrong password!');";
        echo "window.location = ('../login.php');";
        echo "</script>";
    }
?>