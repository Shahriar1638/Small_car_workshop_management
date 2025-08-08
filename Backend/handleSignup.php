<?php
require_once('DBconnect.php');
if(isset($_POST['email']) && isset($_POST['password'])){
    $e = $_POST['email'];
    $p = $_POST['password'];
    $ut ='client';
    $sql = "INSERT INTO authentication_details (email, password, usertype) VALUES ('$e', '$p', '$ut')";
    $result = mysqli_query($conn, $sql);
    if($result){
        header("Location: ../index.php");
    }
    else{
        header("Location: ../signup.php");
    }
}
?>