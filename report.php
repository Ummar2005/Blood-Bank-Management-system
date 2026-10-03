<?php
require 'file/connection.php';

$result = mysqli_query($conn, "SELECT * FROM blood_request");

echo "<h2>Blood Request Report</h2>";
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>ID</th><th>Hospital</th><th>Blood</th><th>Status</th></tr>";

while($row = mysqli_fetch_assoc($result)){
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['hid']}</td>
            <td>{$row['blood_group']}</td>
            <td>{$row['status']}</td>
          </tr>";
}

echo "</table>";
?>