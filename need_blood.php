<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bloodmanagement";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, 4306);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$matches = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $blood_group = $_POST['blood_group'] ?? '';
    $reason = $_POST['reason'] ?? '';
    $phone = $_POST['phone'] ?? '';

    if ($blood_group != "") {
        $stmt = $conn->prepare("SELECT * FROM donors WHERE blood_group = ?");
        $stmt->bind_param("s", $blood_group);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $matches[] = $row;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Need Blood</title>
    <link rel="stylesheet" href="need_blood.css">
</head>
<body>

<div class="header">
    <nav class="header1">
        <h1>Blood Bank and Donation</h1>
        <ul>
            <a href="About Us.html"><li>About Us |</li></a>
            <a href="Why To Donate Blood.html"><li>Why To Donate Blood |</li></a>
            <a href="Need Blood.html"><li>Need blood |</li></a>
            <a href="Became A Donor.html" target="_blank"><li>Became A Donor |</li></a>
            <a href="admin_login.php"><li>Admin Panel</li></a>
        </ul>
    </nav>
</div>

<form id="c" method="POST" action="">
    <center>
        <h1 class="style">Need Blood</h1>
        <table>
            <tr>
                <td>Blood Group</td>
                <td>
                    <select name="blood_group" required>
                        <option value="">Select</option>
                        <option>A+</option>
                        <option>B+</option>
                        <option>O+</option>
                        <option>AB+</option>
                        <option>A-</option>
                        <option>B-</option>
                        <option>O-</option>
                        <option>AB-</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Reason</td>
                <td><input type="text" name="reason" required></td>
            </tr>
            <tr>
                <td>Phone Number</td>
                <td><input type="tel" name="phone" required pattern="[0-9]{10}" title="Enter a 10-digit phone number"></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><input type="submit" value="Search Donors"></td>
            </tr>
        </table>
    </center>
</form>

<?php if (!empty($matches)): ?>
    <h2 style="text-align:center;">Available Donors for <?= htmlspecialchars($blood_group) ?></h2>
    <table border="1" cellpadding="10" style="margin:auto;">
        <tr>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Address</th>
        </tr>
        <?php foreach ($matches as $donor): ?>
        <tr>
            <td><?= htmlspecialchars($donor['name']) ?></td>
            <td><?= htmlspecialchars($donor['phone']) ?></td>
            <td><?= htmlspecialchars($donor['email']) ?></td>
            <td><?= htmlspecialchars($donor['age']) ?></td>
            <td><?= htmlspecialchars($donor['gender']) ?></td>
            <td><?= htmlspecialchars($donor['address']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
    <p style="text-align:center; color:red;">No donors found with blood group <?= htmlspecialchars($blood_group) ?>.</p>
<?php endif; ?>

</body>
</html>
