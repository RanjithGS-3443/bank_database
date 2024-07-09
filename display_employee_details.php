<?php
session_start();
// Check if logged in
if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Include database connection file
require_once "db_connection.php";

// Fetch employee details for the current user
if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT * FROM employees WHERE user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Handle case where user_id is not set (this should ideally not happen if login flow is correct)
    // Redirect to login page or handle error
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .employee-details-container {
            background-color: #fff;
            padding: 20px;
            width: 600px;
            margin: 20px auto;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .employee {
            margin-bottom: 20px;
        }

        .employee p {
            margin-bottom: 10px;
        }

        hr {
            border: 0;
            border-top: 1px solid #ccc;
            margin: 10px 0;
        }

        .employee-details-container p {
            text-align: center;
            margin-top: 15px;
        }

        .employee-details-container a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }

        .employee-details-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Employee Details</h2>
    <div class="employee-details-container">
        <?php foreach ($employees as $employee): ?>
            <div class="employee">
                <p><strong>Name:</strong> <?php echo htmlspecialchars($employee['name']); ?></p>
                <p><strong>Age:</strong> <?php echo htmlspecialchars($employee['age']); ?></p>
                <p><strong>Employee Type:</strong> <?php echo htmlspecialchars($employee['employee_type']); ?></p>
                <p><strong>Salary:</strong> <?php echo htmlspecialchars($employee['salary']); ?></p>
            </div>
            <hr>
        <?php endforeach; ?>
        <p><a href="employee_details.php">Back to Employee Details</a></p>
        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>

