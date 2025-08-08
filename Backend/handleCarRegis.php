<?php
include 'DBconnect.php';

if (isset($_POST['client_name']) && isset($_POST['phone']) && isset($_POST['address']) && 
    isset($_POST['car_license']) && isset($_POST['car_engine']) && isset($_POST['appointment_date']) && 
    isset($_POST['mechanic_id'])) {
    

    $clientname = $_POST['client_name'];
    $clientphone = $_POST['phone'];
    $address = $_POST['address'];
    $clicensenum = $_POST['car_license'];
    $cenginenum = $_POST['car_engine'];
    $appointmentdate = $_POST['appointment_date'];
    $mechanicid = $_POST['mechanic_id'];
    

    $email = isset($_COOKIE['email']) ? $_COOKIE['email'] : '';
    
    if (empty($email)) {
        echo "<script>alert('Email not found. Please login again.'); window.location.href='../index.php';</script>";
        exit();
    }
    

    $check_query = "SELECT * FROM client_details WHERE email = '$email' AND mechanicid = '$mechanicid' AND appointmentdate = '$appointmentdate'";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Already booked on that date'); window.location.href='../clientPage.php';</script>";
        exit();
    }
    
    // Generate Client ID
    $clientid_query = "SELECT clientid FROM client_details ORDER BY clientid DESC LIMIT 1";
    $clientid_result = mysqli_query($conn, $clientid_query);
    
    if (mysqli_num_rows($clientid_result) > 0) {
        $row = mysqli_fetch_assoc($clientid_result);
        $last_id = $row['clientid'];
        $prefix = substr($last_id, 0, 3);
        $number = (int)substr($last_id, 3);
        $new_number = $number + 1;
        $clientid = $prefix . sprintf("%03d", $new_number);
    } else {
        $clientid = "CLT001";
    }
    
    // Generate Car Registration Number
    $regis_query = "SELECT cregisnumber FROM client_details ORDER BY cregisnumber DESC LIMIT 1";
    $regis_result = mysqli_query($conn, $regis_query);
    
    if (mysqli_num_rows($regis_result) > 0) {
        $row = mysqli_fetch_assoc($regis_result);
        $last_regis = $row['cregisnumber'];
        $prefix = substr($last_regis, 0, 4);
        $number = (int)substr($last_regis, 4);
        $new_number = $number + 1;
        $cregisnumber = $prefix . sprintf("%03d", $new_number);
    } else {
        $cregisnumber = "CRGS001";
    }
    
    $insert_query = "INSERT INTO client_details (clientid, clientname, address, clientphone, clicensenum, cenginenum, cregisnumber, mechanicid, appointmentdate, email) 
                     VALUES ('$clientid', '$clientname', '$address', '$clientphone', '$clicensenum', '$cenginenum', '$cregisnumber', '$mechanicid', '$appointmentdate', '$email')";
    
    $insert_result = mysqli_query($conn, $insert_query);
    
    if ($insert_result) {
        
        $update_mechanic = "UPDATE mechanics_details SET appointmentcount = appointmentcount + 1 WHERE mechanicid = '$mechanicid'";
        $update_result = mysqli_query($conn, $update_mechanic);
        
        if ($update_result) {
            echo "<script>alert('Appointment booked successfully! Your Client ID: $clientid, Registration Number: $cregisnumber'); window.location.href='../clientPage.php';</script>";
        } else {
            echo "<script>alert('Error updating mechanic schedule: " . mysqli_error($conn) . "'); window.location.href='../clientPage.php';</script>";
        }
    } else {
        echo "<script>alert('Error booking appointment: " . mysqli_error($conn) . "'); window.location.href='../clientPage.php';</script>";
    }
    
} else {
    echo "<script>alert('All fields are required!'); window.location.href='../clientPage.php';</script>";
}
?>