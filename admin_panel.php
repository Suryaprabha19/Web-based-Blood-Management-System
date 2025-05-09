<?php
session_start();

// Define admin credentials
$admin_username = 'admin';
$admin_password = 'password123';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
    } else {
        $error = "Invalid Username or Password!";
    }
}

// Handle logout
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])) {
    session_destroy();
    header("Location: admin_panel.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bloodmanagement";

$conn = new mysqli($servername, $username, $password, $dbname, 4306);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Blood Group Filter
$filter = "";
if (isset($_POST['blood_group']) && $_POST['blood_group'] !== "") {
    $blood_group = $_POST['blood_group'];
    $filter = "WHERE blood_group = '$blood_group'";
}

$sql = "SELECT * FROM donors $filter";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Manage Donors</title>
    <link rel="stylesheet" href="admin_styles.css">
</head>

<body>

<?php if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true): ?>

<!-- Login Form -->
<div class="login-wrapper">
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (!empty($error)) echo "<p class='error-message'>$error</p>"; ?>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</div>

<?php else: ?>

<!-- Admin Panel Content -->
<div id="header">
    <nav>
        <h1 id="h">Blood Bank and Donation</h1>
        <ul>
            <a href="About Us.html"><li>About Us |</li></a>
            <a href="Why To Donate Blood.html"><li>Why To Donate Blood |</li></a>
            <a href="Need Blood.html"><li>Need Blood |</li></a>
            <a href="Became A Donor.html" target="_blank"><li>Became A Donor |</li></a>
            <a href="admin_panel.php"><li>Admin Panel</li></a>
        </ul>
    </nav>
</div>

<h1 class="admin-title" style="text-align:center;">Admin Panel - Manage Donors</h1>

<!-- Filter/Search Donors -->
<form method="POST" action="admin_panel.php" style="text-align: center; margin: 20px;">
    <label for="blood_group">Choose Blood Group:</label>
    <select name="blood_group">
        <option value="">All</option>
        <option value="A+" <?php if(isset($blood_group) && $blood_group=="A+") echo "selected"; ?>>A+</option>
        <option value="B+" <?php if(isset($blood_group) && $blood_group=="B+") echo "selected"; ?>>B+</option>
        <option value="O+" <?php if(isset($blood_group) && $blood_group=="O+") echo "selected"; ?>>O+</option>
        <option value="AB+" <?php if(isset($blood_group) && $blood_group=="AB+") echo "selected"; ?>>AB+</option>
        <option value="A-" <?php if(isset($blood_group) && $blood_group=="A-") echo "selected"; ?>>A-</option>
        <option value="B-" <?php if(isset($blood_group) && $blood_group=="B-") echo "selected"; ?>>B-</option>
        <option value="O-" <?php if(isset($blood_group) && $blood_group=="O-") echo "selected"; ?>>O-</option>
        <option value="AB-" <?php if(isset($blood_group) && $blood_group=="AB-") echo "selected"; ?>>AB-</option>
    </select>
    <button type="submit">Search</button>
</form>

<!-- Donors Table -->
<div id="donor-table">
    <table border="1" cellpadding="10" style="margin: auto;">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Blood Group</th>
            <th>Address</th>
            <th>Actions</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr id='row_".$row['id']."'>";
                echo "<td>". $row['id'] ."</td>";
                echo "<td>". $row['name'] ."</td>";
                echo "<td>". $row['phone'] ."</td>";
                echo "<td>". $row['email'] ."</td>";
                echo "<td>". $row['age'] ."</td>";
                echo "<td>". $row['gender'] ."</td>";
                echo "<td>". $row['blood_group'] ."</td>";
                echo "<td>". $row['address'] ."</td>";
                echo "<td>";
                echo "<button onclick='deleteDonor(".$row['id'].")' style='color:white; background-color:red; border:none; padding:5px 10px; cursor:pointer;'>Delete</button> ";
                echo "<button onclick='window.location.href=\"update_donor.php?id=".$row['id']."\"' style='color:white; background-color:blue; border:none; padding:5px 10px; cursor:pointer;'>Update</button>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>No donors found.</td></tr>";
        }
        ?>
    </table>
</div>

<center><h2>Blood Requests</h2></center>
    <table>
        <tr>
            <th>Blood Group</th>
            <th>Phone</th>
            <th>Reason</th>
            <th>Requested At</th>
        </tr>
        <?php
        $sql = "SELECT * FROM blood_requests ORDER BY requested_at DESC";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["blood_group"] . "</td>
                        <td>" . $row["phone"] . "</td>
                        <td>" . $row["reason"] . "</td>
                        <td>" . $row["requested_at"] . "</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No blood requests found</td></tr>";
        }
        ?>
    </table>



<!-- Logout Button -->
<form method="POST" action="" style="text-align: center; margin: 20px;">
    <center>
    <button type="submit" name="logout" style="padding: 10px 20px; background-color: #ff4d4d; color: white; border: none; border-radius: 8px; font-size: 16px; cursor: pointer;">Logout</button>
    </center>
</form>

<script>
// Dummy delete function (implement backend logic as needed)
function deleteDonor(id) {
    if (confirm("Are you sure you want to delete this donor?")) {
        window.location.href = 'delete_donor.php?id=' + id;
    }
}
</script>

<?php endif; ?>

</body>
</html>
