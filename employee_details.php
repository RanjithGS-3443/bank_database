<?php
session_start();
// Check if logged in
if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Include database connection file
require_once "db_connection.php";

// Handle form submission
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process input
    $name = $_POST['name'];
    $age = $_POST['age'];
    $employee_type = $_POST['employee_type'];
    $salary = $_POST['salary'];

    // Get user ID from session
    $user_id = $_SESSION['user_id'];

    // Insert employee details into 'employees' table
    $sql = "INSERT INTO employees (user_id, name, age, employee_type, salary) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $name, $age, $employee_type, $salary]);

    // Redirect to another page to display the details
    header("Location: display_employee_details.php");
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Details - Employee Database Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .employee-details-container {
            background-color: #fff;
            padding: 20px;
            width: 300px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .employee-details-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px 0;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background-color: #0056b3;
        }

        p {
            text-align: center;
            margin-top: 15px;
        }

        p a {
            color: #007bff;
            text-decoration: none;
        }

        p a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="employee-details-container">
        <h2>Employee Details</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" required>
            </div>
            <div class="form-group">
                <label for="employee_type">Employee Type:</label>
                <input type="text" id="employee_type" name="employee_type">
            </div>
            <div class="form-group">
                <label for="salary">Salary:</label>
                <input type="text" id="salary" name="salary">
            </div>
            <button type="submit">Save</button>
        </form>
        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>
