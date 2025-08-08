<?php
require('Backend/DBconnect.php');

$mechanics_query = "SELECT * FROM mechanics_details";
$mechanics_result = mysqli_query($conn, $mechanics_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Work Shop</title>
    <link rel="stylesheet" href="Styles/style.css">
    <link rel="stylesheet" href="Styles/ClientStyle.css">
</head>
<body>
    <main>
        <h1>Book Your Appointment</h1>
        
        <div class="appointment-container">
            <form action="Backend/handleCarRegis.php" method="POST">
                <div class="form-row">
                    <div class="form-group">
                        <label for="client_name">Client Name</label>
                        <input type="text" id="client_name" name="client_name" placeholder="Enter your full name" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address" placeholder="Enter your complete address" required></textarea>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="car_license">Car License Number</label>
                        <input type="text" id="car_license" name="car_license" placeholder="Enter license plate number" required>
                    </div>
                    <div class="form-group">
                        <label for="car_engine">Car Engine Number</label>
                        <input type="number" id="car_engine" name="car_engine" placeholder="Enter engine number" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="appointment_date">Appointment Date</label>
                        <input type="date" id="appointment_date" name="appointment_date" min="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="mechanic_id">Select Mechanic</label>
                        <select id="mechanic_id" name="mechanic_id" required>
                            <option value="">Choose a mechanic</option>
                            <?php
                            if (mysqli_num_rows($mechanics_result) > 0) {
                                while($row = mysqli_fetch_assoc($mechanics_result)) {
                                    $count = 4- $row['appointmentcount'];
                                    if($count!=0) { 
                                    ?>
                                        <option value='<?php echo $row['mechanicid'] ?>'><?php echo $row['mechanicname'] . " (" .$count. " book left) " ?></option>
                                    <?php
                                    } else {
                                    ?>
                                        <option value='<?php echo $row['mechanicid'] ?>' disabled> <?php echo $row['mechanicname'] . "No booking left" ?></option>
                                    <?php
                                    }}}
                            ?>
                        </select>
                    </div>
                </div>

                <button type="submit">Book Appointment</button>
            </form>
        </div>
        <div class="admin-actions">
            <a href="index.php" class="back-btn">← Back to Home</a>
        </div>
    </main>
</body>
</html>
