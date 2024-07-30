<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "#Glug@23";
$database = "slc_e-log";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve RF_ID from the form
    if(isset($_POST['Regd'])) {
        $Regd = $_POST['Regd'];

        // SQL query to delete row from Details table where RF_ID matches
        $sql = "DELETE FROM Details WHERE REGD='$Regd'";

        if ($conn->query($sql) === TRUE) {
            $response = "record removed successfully!";
        } else {
               $response = "Error: " . $conn->error;
        }

    }
}
echo "<script>
var response = '$response';
if (confirm(response)) {
    window.location.href = 'removeuser.html';
}
</script>";

$conn->close();
?>
