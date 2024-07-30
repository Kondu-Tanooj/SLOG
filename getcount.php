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
// Check if data is available in the request
if (isset($_REQUEST['sensor1'])) {
    $sensor1 = $_REQUEST['sensor1'];

        $stmt_count = $conn->prepare("SELECT COUNT(*) AS id_count FROM ENTRY_Table ");
        $stmt_count->execute();
        $result_count = $stmt_count->get_result();
        if ($result_count->num_rows > 0) {
            $row_count = $result_count->fetch_assoc();
            $id_count = $row_count["id_count"];
        }
        echo " VISITS:".$id_count."<hr>";
        echo " ENTER HERE !!";
    	$stmt_count->close();
}
$conn->close();
?>
