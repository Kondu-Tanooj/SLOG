<?php
$hostname = "localhost";
$username = "root";
$password = "#Glug@23";
$database = "slc_e-log";

// Create connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $rf_id = $_POST['rf_id'];
    $register_number = $_POST['register_number'];
    $full_name = $_POST['full_name'];
    $department = $_POST['department'];
    $batch = $_POST['batch'];

    // Prepare and bind the insert statement
    $stmt_insert = $conn->prepare("UPDATE `Details` SET `REGD`= ?,`NAME`= ?,`DEPARTMENT`= ? ,`BATCH`= ? WHERE `REGD`= ?;");
    $stmt_insert->bind_param("sssss",$register_number, $full_name, $department, $batch,$rf_id);

    // Execute the insert statement
    if ($stmt_insert->execute()) {
        $response = "Record has updated successfully!!";
    } else {
        $response = "Error: " . $stmt_insert->error;
    }
    // Close the statement and connection
    $stmt_insert->close();
    	$stmt_insert = $conn->prepare("UPDATE `ENTRY_Table` SET `NAME`= ? ,`REGD`= ? WHERE `REGD`= ?;");
    $stmt_insert->bind_param("sss",$full_name, $register_number, $rf_id);
    if (!$stmt_insert->execute()) {
        echo "Error: " . $stmt_insert->error;
    }
    $stmt_insert->close();
    $conn->close();

    // Send response back to HTML page
    echo "<script>
            var response = '$response';
            if (confirm(response)) {
                window.location.href = 'addnewuser.html';
            }
          </script>";
}
?>
