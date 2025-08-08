<?php
require('Backend/DBconnect.php');

$query = "SELECT mechanicid, mechanicname, mechanicphone, appointmentcount FROM mechanics_details ORDER BY mechanicid ASC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Work Shop</title>
    <link rel="stylesheet" href="Styles/style.css">
    <link rel="stylesheet" href="Styles/AdminStyle.css">
</head>
<body>
    <main>
        <h1>Mechanics Information List</h1>
        
        <div class="admin-container">
            <table class="appointments-table">
                <thead>
                    <tr>
                        <th>Mechanic ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Appointment Count (Max limit: 4)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                    ?>
                            <tr>
                                <td><?php echo $row['mechanicid'] ?></td>
                                <td><?php echo $row['mechanicname'] ?></td>
                                <td><?php echo $row['mechanicphone'] ?></td>
                                <td><?php echo $row['appointmentcount'] ?></td>
                            </tr>
                    <?php
                        }
                    } else {
                    ?>
                        <tr>
                            <td colspan="4" class="no-data">No mechanics found</td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        
        <div class="admin-actions">
            <a href="index.php" class="back-btn">← Back to Home</a>
            <a href="adminPage.php" class="back-btn">Go to Appointment Dashboard →</a>
        </div>
    </main>
</body>
</html>