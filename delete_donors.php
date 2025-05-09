<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bloodmanagement"; // your database name

$conn = new mysqli($servername, $username, $password, $dbname, 4306);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Important: prevent SQL injection

    $sql = "DELETE FROM donors WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "success"; // very important - our JS looks for "success"
    } else {
        echo "error";
    }
} else {
    echo "error";
}

$conn->close();
?>
