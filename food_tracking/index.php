<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome | Food Tracking System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom right, #ffafbd, #ffc3a0);
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
            width: 90%;
            max-width: 500px;
            background-color: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        }

        h1 {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 20px;
        }

        .options {
            margin-top: 30px;
        }

        .options a {
            display: block;
            margin: 15px auto;
            padding: 20px;
            width: 100%;
            max-width: 300px;
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: bold;
            color: white;
            border-radius: 10px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .donor-btn {
            background-color: #3498db;
        }

        .recipient-btn {
            background-color: #e67e22;
        }

        .options a:hover {
            transform: scale(1.05);
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.3);
        }

        .login-btn {
            background-color: #8e44ad;
            margin-top: 30px;
        }

        .login-btn:hover {
            transform: scale(1.05);
            box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Food Tracking System</h1>
        <div class="options">
            <a href="register.php?type=donor" class="donor-btn">Register as Donor</a>
            <a href="register.php?type=recipient" class="recipient-btn">Register as Recipient</a>
        </div>
        <a href="login.php" class="login-btn">Login</a>
    </div>
</body>
</html>

