<?php
$hostname = "localhost";
$username = "admin";
$password = "admin";
$database = "slc_e-log";

// Create connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if data is available in the request
if (isset($_REQUEST['sensor1'])) {
    $sensor1 = $_REQUEST['sensor1'];

    // Insert data into the database using prepared statement
    $stmt_insert = $conn->prepare("INSERT INTO Rfid (RF_ID) VALUES (?)");
    $stmt_insert->bind_param("s", $sensor1);
    if (!$stmt_insert->execute()) {
        echo "Error: " . $stmt_insert->error;
    }
    $stmt_insert->close();
   
    // Retrieve name and REGD from the details table based on ID using prepared statement
    $stmt_details = $conn->prepare("SELECT NAME, REGD FROM Details WHERE RF_ID = ?");
    $stmt_details->bind_param("s", $sensor1);
    $stmt_details->execute();
    $result_details = $stmt_details->get_result();
    
    if ($result_details->num_rows > 0) {
        $row_details = $result_details->fetch_assoc();
        $name = $row_details["NAME"];
        $regd = $row_details["REGD"];
        
        // Count occurrences of the ID in the rfid table
        $stmt_count = $conn->prepare("SELECT COUNT(*) AS id_count FROM Rfid WHERE RF_ID = ?");
        $stmt_count->bind_param("s", $sensor1);
        $stmt_count->execute();
        $result_count = $stmt_count->get_result();
        $status = "";

        if ($result_count->num_rows > 0) {
            $row_count = $result_count->fetch_assoc();
            $id_count = $row_count["id_count"];
            // Determine status based on whether the count is odd or even
            
            $status = ($id_count % 2 == 0)? "VISIT AGAIN !!!" : " WELCOME TO SLC ";

            if ($name != "") {
                // Update ENTRY_Table with name and IN_Time/OUT_Time based on status
                if ($id_count%2 == 0) {
                    $stmt_update = $conn->prepare("UPDATE ENTRY_Table SET OUT_Time = CURRENT_TIMESTAMP() WHERE OUT_Time = '0000-00-00 00:00:00' AND NAME = ? AND REGD = ?");
                    $stmt_update->bind_param("ss", $name, $regd);
                } else {
                    $stmt_update = $conn->prepare("INSERT INTO ENTRY_Table(NAME, REGD, IN_Time) VALUES (?, ?, CURRENT_TIMESTAMP())");
                    $stmt_update->bind_param("ss", $name, $regd);
                }
                
                if ($regd != "") {
                    echo "Regd: " . $regd . "<hr>";
                    echo $status;
                } 
                if (!$stmt_update->execute()) {
                    echo "Error updating ENTRY_Table: " . $stmt_update->error;
                }
                $stmt_update->close();
            }
        }
    }
    $stmt_details->close();
    if ($regd == "") {
                    echo "Invalid ID <hr>";
                    echo "No Entry";
                }
}

$conn->close();
?>
