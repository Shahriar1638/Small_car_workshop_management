<?php
include 'DBconnect.php';

if (isset($_POST['client_id']) && isset($_POST['appointment_date']) && isset($_POST['mechanic_id'])) {
    
    $client_id = $_POST['client_id'];
    $new_appointment_date = $_POST['appointment_date'];
    $new_mechanic_id = $_POST['mechanic_id'];

    $current_query = "SELECT * FROM client_details WHERE clientid = '$client_id'";
    $current_result = mysqli_query($conn, $current_query);
    
    if (mysqli_num_rows($current_result) > 0) {
        $current_data = mysqli_fetch_assoc($current_result);
        $email = $row['email'];

        $check_query = "SELECT * FROM client_details WHERE email = '$email' AND mechanicid = '$new_mechanic_id' AND appointmentdate = '$new_appointment_date'";
        $check_result = mysqli_query($conn, $check_query);
        
        if (mysqli_num_rows($check_result) > 0) {
            echo "<script>alert('Already booked on that date'); window.location.href='../clientPage.php';</script>";
            exit();
        }

        $old_mechanic_id = $current_data['mechanicid'];
        $old_appointment_date = $current_data['appointmentdate'];
        
        $update_query = "UPDATE client_details SET appointmentdate = '$new_appointment_date', mechanicid = '$new_mechanic_id' WHERE clientid = '$client_id'";
        $update_result = mysqli_query($conn, $update_query);
        
        if ($update_result) {
            if ($new_mechanic_id != $old_mechanic_id) {
                $decrease_old = "UPDATE mechanics_details SET appointmentcount = appointmentcount - 1 WHERE mechanicid = '$old_mechanic_id'";
                mysqli_query($conn, $decrease_old);

                $increase_new = "UPDATE mechanics_details SET appointmentcount = appointmentcount + 1 WHERE mechanicid = '$new_mechanic_id'";
                mysqli_query($conn, $increase_new);
            }
            
            echo "<script>alert('Appointment updated successfully!'); window.location.href='../adminPage.php';</script>";
        } else {
            echo "<script>alert('Error updating appointment: " . mysqli_error($conn) . "'); window.location.href='../adminPage.php';</script>";
        }
        
    } else {
        echo "<script>alert('Client not found!'); window.location.href='../adminPage.php';</script>";
    }
    
} else {
    echo "<script>alert('Missing required fields!'); window.location.href='../adminPage.php';</script>";
}
?>
