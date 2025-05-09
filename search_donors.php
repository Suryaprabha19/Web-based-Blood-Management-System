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

$blood_group = isset($_POST['blood_group']) ? $_POST['blood_group'] : '';

// Fetch filtered donors
$sql = "SELECT * FROM donors WHERE blood_group LIKE '%$blood_group%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Donors</title>
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

<h1>Search Donors by Blood Group</h1>

<form method="POST" action="">
    <label for="blood_group">Choose Blood Group:</label>
    <select name="blood_group">
        <option value="">All</option>
        <option value="A+">A+</option>
        <option value="B+">B+</option>
        <option value="O+">O+</option>
        <option value="AB+">AB+</option>
        <option value="A-">A-</option>
        <option value="B-">B-</option>
        <option value="O-">O-</option>
        <option value="AB-">AB-</option>
    </select>
    <button type="submit">Search</button>
</form>

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
