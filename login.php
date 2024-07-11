<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <form action="login.php" method="POST">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="user_type">User Type</label>
            <select class="form-control" id="user_type" name="user_type" required>
                <option value="hospital">Hospital</option>
                <option value="receiver">Receiver</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>
</body>
</html>

<?php
include 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];
$user_type = $_POST['user_type'];

$sql = "SELECT * FROM users WHERE username='$username' AND user_type='$user_type'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        session_start();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_type'] = $row['user_type'];
        if ($row['user_type'] == 'hospital') {
            header("Location: add_blood_info.php");
        } else {
            header("Location: available_samples.php");
        }
    } else {
        echo "Invalid password";
    }
} else {
    echo "No user found";
}

$conn->close();
?>
