<?php
require_once('./DBconnect.php');
if(isset($_POST['email']) && isset($_POST['password'])){
    $e = $_POST['email'];
    $p = $_POST['password'];
    $sql = "SELECT * FROM authentication_details WHERE email = '$e' AND password = '$p'";
    $result = mysqli_query($conn, $sql);
    if($result && mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $email = $row['email'];
        $role = $row['usertype'];
        echo "Login successful. Welcome, $email!";
        setcookie('email', $email, time() + 3600, "/");

        if ($role == 'client'){
            header("Location: ../clientPage.php");
        }
        else if ($role == 'admin'){
            header("Location: ../adminPage.php");
        }
    }
    else{
        header("Location: ../index.php?error=Invalid credentials");
    }
}
?>