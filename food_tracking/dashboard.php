<?php
// Include the database connection
include 'database.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get session details
$user_id = $_SESSION['user_id'];
$user_type = $_SESSION['user_type'];
$user_name = $_SESSION['user_name'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Food Tracking</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Welcome, <?= htmlspecialchars($user_name) ?>!</h1>
            <div class="logo">
                <img src="logo/call_logs.png" alt="Call Logs Logo" style="width: 150px; height: auto;">
            </div>
        </header>

        <!-- Donor Dashboard -->
        <?php if ($user_type === 'donor') { ?>
            <h2>Donor Dashboard</h2>
            <form method="POST" action="dashboard.php">
                <input type="text" name="food_item" placeholder="Food Item" required><br>
                <input type="number" name="quantity" placeholder="Quantity" required><br>
                <button type="submit" name="add_food">Add Food</button>
            </form>

            <h3>Messages from Recipients</h3>
            <a href="message.php">View Messages</a>

            <h3>Call Logs</h3>
            <a href="call.php">View Call Logs</a>

            <?php
            // Add food functionality
            if (isset($_POST['add_food'])) {
                $food_item = $_POST['food_item'];
                $quantity = $_POST['quantity'];

                $stmt = $conn->prepare("INSERT INTO food (donor_id, food_item, quantity) VALUES (?, ?, ?)");
                $stmt->bind_param("isi", $user_id, $food_item, $quantity);

                if ($stmt->execute()) {
                    echo "<p>Food added successfully!</p>";
                } else {
                    echo "<p>Error: " . $stmt->error . "</p>";
                }
                $stmt->close();
            }
            ?>
        <?php } ?>

        <!-- Recipient Dashboard -->
        <?php if ($user_type === 'recipient') { ?>
            <h2>Recipient Dashboard</h2>
            <h3>Available Food</h3>
            <table>
                <tr>
                    <th>Food Item</th>
                    <th>Quantity</th>
                    <th>Donor</th>
                    <th>Action</th>
                </tr>
                <?php
                $result = $conn->query("SELECT food.*, donors.name AS donor_name FROM food INNER JOIN donors ON food.donor_id = donors.id");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . htmlspecialchars($row['food_item']) . "</td>
                        <td>" . htmlspecialchars($row['quantity']) . "</td>
                        <td>" . htmlspecialchars($row['donor_name']) . "</td>
                        <td>
                            <a href='message.php?receiver_id=" . htmlspecialchars($row['donor_id']) . "&receiver_type=donor'>Message</a> | 
                            <a href='call.php?receiver_id=" . htmlspecialchars($row['donor_id']) . "&receiver_type=donor'>Call</a>
                        </td>
                    </tr>";
                }
                ?>
            </table>

            <h3>Messages from Donors</h3>
            <a href="message.php">View Messages</a>

            <h3>Call Logs</h3>
            <a href="call.php">View Call Logs</a>
        <?php } ?>

        <br>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>

