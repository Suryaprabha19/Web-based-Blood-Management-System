<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bloodmanagement";

// Database connection
$conn = new mysqli($servername, $username, $password, $dbname, 4306);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch donor details to pre-fill the form
if (isset($_GET['id'])) {
    $donor_id = $_GET['id'];
    $sql = "SELECT * FROM donors WHERE id = $donor_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $donor = $result->fetch_assoc();
    } else {
        echo "Donor not found.";
        exit();
    }
}

// Handle form submission to update donor details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $blood_group = $_POST['blood_group'];
    $address = $_POST['address'];

    $update_sql = "UPDATE donors SET name='$name', phone='$phone', email='$email', age='$age', gender='$gender', blood_group='$blood_group', address='$address' WHERE id=$donor_id";

    if ($conn->query($update_sql) === TRUE) {
        header("Location: admin_panel.php"); // Redirect back to admin panel after updating
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Donor</title>
    <link rel="stylesheet" href="admin_styles.css">
</head>
<body>

<h2 style="text-align: center;">Update Donor Information</h2>

<form method="POST" action="">
    <label for="name">Name:</label><br>
    <input type="text" name="name" value="<?php echo $donor['name']; ?>" required><br><br>

    <label for="phone">Phone:</label><br>
    <input type="text" name="phone" value="<?php echo $donor['phone']; ?>" required><br><br>

    <label for="email">Email:</label><br>
    <input type="email" name="email" value="<?php echo $donor['email']; ?>" required><br><br>

    <label for="age">Age:</label><br>
    <input type="number" name="age" value="<?php echo $donor['age']; ?>" required><br><br>

    <label for="gender">Gender:</label><br>
    <select name="gender" required>
        <option value="Male" <?php if($donor['gender'] == 'Male') echo 'selected'; ?>>Male</option>
        <option value="Female" <?php if($donor['gender'] == 'Female') echo 'selected'; ?>>Female</option>
    </select><br><br>

    <label for="blood_group">Blood Group:</label><br>
    <select name="blood_group" required>
        <option value="A+" <?php if($donor['blood_group'] == 'A+') echo 'selected'; ?>>A+</option>
        <option value="B+" <?php if($donor['blood_group'] == 'B+') echo 'selected'; ?>>B+</option>
        <option value="O+" <?php if($donor['blood_group'] == 'O+') echo 'selected'; ?>>O+</option>
        <option value="AB+" <?php if($donor['blood_group'] == 'AB+') echo 'selected'; ?>>AB+</option>
        <option value="A-" <?php if($donor['blood_group'] == 'A-') echo 'selected'; ?>>A-</option>
        <option value="B-" <?php if($donor['blood_group'] == 'B-') echo 'selected'; ?>>B-</option>
        <option value="O-" <?php if($donor['blood_group'] == 'O-') echo 'selected'; ?>>O-</option>
        <option value="AB-" <?php if($donor['blood_group'] == 'AB-') echo 'selected'; ?>>AB-</option>
    </select><br><br>

    <label for="address">Address:</label><br>
    <input type="text" name="address" value="<?php echo $donor['address']; ?>" required><br><br>

    <button type="submit">Update</button>
</form>

</body>
</html>
