<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "bloodmanagement"; // change it

$conn = mysqli_connect($servername, $username, $password, $database, 4306);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM donors";
$result = mysqli_query($conn, $sql);

$output = "";

if (mysqli_num_rows($result) > 0) {
    $output .= "<table border='1' style='width:100%; text-align:center;'>";
    $output .= "<tr>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Age</th>
                <th>Gender</th>
                <th>Blood Group</th>
                <th>Address</th>
            </tr>";

    while($row = mysqli_fetch_assoc($result)) {
        $output .= "<tr>
                        <td>".$row['name']."</td>
                        <td>".$row['number']."</td>
                        <td>".$row['email']."</td>
                        <td>".$row['age']."</td>
                        <td>".$row['gender']."</td>
                        <td>".$row['blood_group']."</td>
                        <td>".$row['address']."</td>
                    </tr>";
    }
    $output .= "</table>";
} else {
    $output = "No donors found.";
}

echo $output;

mysqli_close($conn);
?>
