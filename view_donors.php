<?php
// Database connection
$servername = "localhost";
$username = "root";       
$password = "";           
$dbname = "blood_management";

$conn = new mysqli($servername, $username, $password, $dbname, 4306);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all donors
$sql = "SELECT * FROM donors";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Donors</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        table {
            width: 90%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            padding: 12px;
            border: 1px solid #aaa;
            text-align: center;
        }
        th {
            background-color: #ff4d4d;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        h1 {
            text-align: center;
            color: #b30000;
        }
    </style>
</head>
<body>

<h1>List of Blood Donors</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Age</th>
        <th>Gender</th>
        <th>Blood Group</th>
        <th>Address</th>
        <th>Registered On</th>
    </tr>

<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>". $row["id"]. "</td>
                <td>". $row["name"]. "</td>
                <td>". $row["phone"]. "</td>
                <td>". $row["email"]. "</td>
                <td>". $row["age"]. "</td>
                <td>". $row["gender"]. "</td>
                <td>". $row["blood_group"]. "</td>
                <td>". $row["address"]. "</td>
                <td>". $row["created_at"]. "</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='9'>No donors found</td></tr>";
}
$conn->close();
?>

</table>

</body>
</html>
