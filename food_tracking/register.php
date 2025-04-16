<?php
include 'database.php';

$type = $_GET['type'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $state = $_POST['state'];
    $city = $_POST['city'];

    if ($type === 'donor') {
        $address = $_POST['address'];
        $stmt = $conn->prepare("INSERT INTO donors (name, email, phone_number, password, state, city, address) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $name, $email, $phone_number, $password, $state, $city, $address);
    } else {
        $stmt = $conn->prepare("INSERT INTO recipients (name, email, phone_number, password, state, city) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $name, $email, $phone_number, $password, $state, $city);
    }

    if ($stmt->execute()) {
        echo "Registration successful. Redirecting to login...";
        header("refresh:2;url=login.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register as <?= ucfirst($type) ?></title>
</head>
<body>
    <h1>Register as <?= ucfirst($type) ?></h1>
    <form method="POST">
        <input type="text" name="name" placeholder="Name" required><br>
        <input type="email" name="email" placeholder="Email" required><br>
        <input type="text" name="phone_number" placeholder="Phone Number" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <input type="text" name="state" placeholder="State" required><br>
        <input type="text" name="city" placeholder="City" required><br>
        <?php if ($type === 'donor') { ?>
            <textarea name="address" placeholder="Address" required></textarea><br>
        <?php } ?>
        <button type="submit">Register</button>
    </form>
</body>
</html>
