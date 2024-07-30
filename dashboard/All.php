<!DOCTYPE html>
<html>
<head>
    <title>Database Table Display</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            height: 100vh;
        }
        #searchContainer {
            width: 75%; /* Adjusted width */
            margin-top: 20px;
            margin-bottom: 20px;
            text-align: center;
        }
        #tableContainer {
            width: 75%;
            overflow: auto;
            border: 1px solid #ddd; /* Add border for clarity */
            border-radius: 10px; /* Add border radius for aesthetics */
        }
        table {
            border-collapse: collapse;
            width: 100%; /* Adjusted width */
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .logout {
  background-color: #c00000;
  border-radius: 100px;
  box-shadow: rgba(245, 52, 52, 0.2) 0 -25px 18px -14px inset,rgba(171, 27, 17, 0.15) 0 1px 2px,rgba(240, 35, 35, 0.15) 0 2px 4px,rgba(210, 17, 17, 0.15) 0 4px 8px,rgba(195, 13, 13, 0.15) 0 8px 16px,rgba(145, 3, 3, 0.15) 0 16px 32px;
  color: rgb(95, 2, 2);
  cursor: pointer;
  display: inline-block;
  font-family: CerebriSans-Regular,-apple-system,system-ui,Roboto,sans-serif;
  padding: 10px 30px;
  text-align: center;
  text-decoration: none;
  transition: all 250ms;
  border: 0;
  font-size: 20px;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  position: relative;
  top: 0px;
  width: 150px;
}
.logout:hover{
  background: #ff1c1c;
}
    </style>
    <script>
        function filterTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("searchInput");
            filter = input.value.toUpperCase();
            table = document.getElementById("dataTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td");
                for (var j = 0; j < td.length; j++) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                        break;
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</head>
<body>
    <div>
        <b><h1>ALL ENTRY DATA</h1></b>
    </div>
      <div class="logout-container">
    <a href="alllogs.html"><button class="logout" role="button"><b><--BACK</b></button></a>
</div> 
<div id="searchContainer">
    <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search for data...">
</div>

<div id="tableContainer">
    <table id="dataTable">
        <?php
        // Replace these with your database credentials
        $servername = "localhost";
$username = "root";
$password = "#Glug@23";
        $database = "slc_e-log";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL query to retrieve data from your table
        $sql = "SELECT * FROM Rfid";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // output data of first row with column names
            echo "<tr>";
            $row = $result->fetch_assoc();
            foreach ($row as $key => $value) {
                echo "<th>" . htmlspecialchars($key) . "</th>";
            }
            echo "</tr>";

            // output data of each subsequent row
            do {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>" . htmlspecialchars($value) . "</td>";
                }
                echo "</tr>";
            } while ($row = $result->fetch_assoc());
        } else {
            echo "<tr><td colspan='10'>0 results</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</div>

</body>
</html>
