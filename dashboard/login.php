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

// Retrieve username and password from the form
if(isset($_POST['adminusername']) && isset($_POST['adminpass'])) {
    $username = $_POST['adminusername'];
    $password = $_POST['adminpass'];

    // SQL query to check if username and password exist in the database
    $sql = "SELECT * FROM credentials WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Authentication successful
        // Redirect to admin page
        header("Location: adminpage.html");
        exit();
    } else {
        // Authentication failed
        echo "<script>alert('Invalid username or password');</script>";
    }
}

$conn->close();
?>
