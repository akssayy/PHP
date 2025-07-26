<?php
// index.php - The main entry point of our application

$name = "World"; // Default name

// Check if a 'name' parameter is present in the URL
if (isset($_GET['name']) && !empty($_GET['name'])) {
    $name = htmlspecialchars($_GET['name']); // Sanitize input
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #007bff;
        }
        p {
            margin-top: 20px;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo "Hello, " . $name . "!"; ?></h1>
        <p>This is a simple PHP application.</p>
        <p>Try adding <code>?name=YourName</code> to the URL!</p>
        <p><a href="about.php">Learn more about us</a></p>
    </div>
</body>
</html>