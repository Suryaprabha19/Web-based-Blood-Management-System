<?php
// DB Connection
$conn = new mysqli("localhost", "root", "", "bloodmanagement", 4306);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$matching_donors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $blood_group = $_POST['blood_group'];
    $reason = $_POST['reason'];
    $phone = $_POST['phone'];
    $name = $_POST['name'];

    // Insert request
    $stmt = $conn->prepare("INSERT INTO blood_requests (name, phone, blood_group, reason) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $phone, $blood_group, $reason);
    $stmt->execute();

    // Fetch matching donors
    $result = $conn->query("SELECT * FROM donors WHERE blood_group = '$blood_group'");
    while ($row = $result->fetch_assoc()) {
        $matching_donors[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Find Donor</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container" style="max-width:500px; margin:auto;">
        <h2 style="text-align:center;">Request Blood</h2>
        <form method="POST" action="">
            <label>Your Name:</label><br>
            <input type="text" name="name" required><br><br>

            <label>Phone Number:</label><br>
            <input type="tel" name="phone" required><br><br>

            <label>Blood Group Needed:</label><br>
            <select name="blood_group" required>
                <option value="">--Select--</option>
                <option>A+</option><option>B+</option><option>O+</option><option>AB+</option>
                <option>A-</option><option>B-</option><option>O-</option><option>AB-</option>
            </select><br><br>

            <label>Reason for Request:</label><br>
            <input type="text" name="reason" required><br><br>

            <input type="submit" value="Submit Request">
        </form>
    </div>

    <?php if (!empty($matching_donors)): ?>
        <h2 style="text-align:center; margin-top:40px;">Available Donors for <?= htmlspecialchars($blood_group) ?></h2>
        <table border="1" cellpadding="10" style="margin:auto;">
            <tr>
                <th>Name</th><th>Phone</th><th>Email</th><th>Address</th>
            </tr>
            <?php foreach ($matching_donors as $donor): ?>
                <tr>
                    <td><?= $donor['name'] ?></td>
                    <td><?= $donor['phone'] ?></td>
                    <td><?= $donor['email'] ?></td>
                    <td><?= $donor['address'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
