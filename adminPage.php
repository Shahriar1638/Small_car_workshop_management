<?php
require('Backend/DBconnect.php');
$query = "SELECT cd.clientid, cd.clientname, cd.clientphone, cd.cregisnumber, cd.appointmentdate, cd.mechanicid, md.mechanicname 
          FROM client_details cd 
          JOIN mechanics_details md ON cd.mechanicid = md.mechanicid 
          ORDER BY cd.appointmentdate DESC";
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
    <form id="editForm" action="Backend/handleResgisEdit.php" method="POST" style="display: none;">
        <input type="text" id="ClientId" name="client_id">
        <input type="date" id="AppointmentDate" name="appointment_date">
        <input type="text" id="MechanicId" name="mechanic_id">
    </form>

    <div id="editModal" class="modal" style="display: none;">
        <div class="modal-content">
            <h3>Edit Appointment</h3>
            <div class="form-group">
                <label for="appointment_date">Appointment Date:</label>
                <input type="date" id="appointment_date" name="appointment_date" min="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="form-group">
                <label for="newMechanic">Select differnet mechanic:</label>
                <select id="newMechanic">
                    <?php
                    $mechanics_query = "SELECT * FROM mechanics_details";
                    $mechanics_result = mysqli_query($conn, $mechanics_query);
                    if (mysqli_num_rows($mechanics_result) > 0) {
                        while($row = mysqli_fetch_assoc($mechanics_result)) {
                            $count = 4- $row['appointmentcount'];
                            if($count!=0) { 
                            ?>
                                <option value='<?php echo $row['mechanicid'] ?>'><?php echo $row['mechanicname'] . " (" .$count. " book left) " ?></option>
                            <?php
                            } else {
                            ?>
                                <option value='<?php echo $row['mechanicid'] ?>' disabled> <?php echo $row['mechanicname'] . " No booking left" ?></option>
                            <?php
                            }}
                    }
                    ?>
                </select>
            </div>
            <div class="modal-buttons">
                <button type="button" onclick="saveEdit()">Save</button>
                <button type="button" onclick="closeModal()">Cancel</button>
            </div>
        </div>
    </div>
    <main>
        <h1>Client Appointments Overview</h1>
        <div class="admin-container">
            <div class="table-container">
                <table class="appointments-table">
                    <thead>
                        <tr>
                            <th>Client Name</th>
                            <th>Phone</th>
                            <th>Car Registration</th>
                            <th>Mechanic Name</th>
                            <th>Appointment Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                        ?>
                                <tr>
                                    <td><?php echo $row['clientname'] ?></td>
                                    <td><?php echo $row['clientphone'] ?></td>
                                    <td><?php echo $row['cregisnumber'] ?></td>
                                    <td><?php echo $row['mechanicname'] ?></td>
                                    <td>
                                        <?php 
                                        $current_date = date('Y-m-d');
                                        $appointment_date = $row['appointmentdate'];
                                        $expired = $appointment_date < $current_date;
                                        if ($expired) { 
                                        ?>
                                            <span style="color: grey;"><?php echo date('M d, Y', strtotime($appointment_date)) ?> (expired)</span>
                                        <?php 
                                        } else { 
                                        ?>
                                            <?php echo date('M d, Y', strtotime($appointment_date)) ?>
                                        <?php 
                                        } 
                                        ?>
                                    </td>
                                    <td>
                                        <?php if ($expired) { ?>
                                            <Button class="delete-btn">Delete</Button>
                                        <?php } else { ?>
                                            <Button class="edit-btn" onclick="openEditModal('<?php echo $row['clientid'] ?>', '<?php echo $row['appointmentdate'] ?>', '<?php echo $row['mechanicid'] ?>')">Edit</Button>
                                        <?php } ?>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                        ?>
                            <tr><td colspan='5' class='no-data'>No appointments found</td></tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="admin-actions">
            <a href="index.php" class="back-btn">&larr; Back to Home</a>
            <a href="mechanicList.php" class="back-btn">Go to Mechanic details &rarr;</a>
        </div>
    </main>

    <script>
        let currentClientId = '';
        
        function openEditModal(clientId, appointmentDate, mechanicId) {
            currentClientId = clientId;
            document.getElementById('appointment_date').value = appointmentDate;
            document.getElementById('newMechanic').value = mechanicId;
            document.getElementById('editModal').style.display = 'block';
        }
        
        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }
        
        function saveEdit() {
            console.log("Saving edit for client ID:", currentClientId);
            const appointmentDate = document.getElementById('appointment_date').value;
            const mechanicId = document.getElementById('newMechanic').value;
            
            document.getElementById('ClientId').value = currentClientId;
            document.getElementById('AppointmentDate').value = appointmentDate;
            document.getElementById('MechanicId').value = mechanicId;
            
            document.getElementById('editForm').submit();
        }
    </script>
</body>
</html>
</html>