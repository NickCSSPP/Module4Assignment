<?php
try {
    // Capture data from main page
    $cost = filter_input(INPUT_POST, 'cost', FILTER_VALIDATE_FLOAT);
    $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_FLOAT);
    $member = isset($_POST['member']);
    $waterproof = isset($_POST['waterproof']);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    // Validation
    if ($cost === FALSE) {
        throw new Exception('Cost must be a valid number');
    } else if ($cost <= 0) {
        throw new Exception('Cost must be greater than zero');
    }

    if ($quantity === FALSE) {
        throw new Exception('Quantity must be a valid number');
    } else if ($quantity <= 0) {
        throw new Exception('Quantity must be greater than zero');
    }

    if (empty($username)) {
        throw new Exception('Username is required');
    } else if (!preg_match('/^[a-zA-Z0-9_]{5,12}$/', $username)) {
        throw new Exception('Username must be between 5 to 12 characters long and can only contain letters, numbers, and underscores');
    }

    if (empty($phone)) {
        throw new Exception('Phone number is required');
    } else if (!preg_match('/^\d{10}$/', $phone)) {
        throw new Exception('Phone number must be a valid 10-digit number');
    }

    if (empty($email)) {
        throw new Exception('Email address is required');
    } else if ($email === FALSE) {
        throw new Exception('Email address must be valid');
    }

    // Calculate total cost
    $total_cost = $cost * $quantity;

    // Member Discount
    if ($member) {
        $discount = $total_cost * 0.1; // Assuming 10% discount
        $total_cost -= $discount;
    }

} catch (Exception $e) {
    // Log the error to MySQL database
    $error_message = $e->getMessage();

    // Connect to MySQL
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'error_logs';

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    // Send error log to MySQL table
    $sql = "INSERT INTO error_logs (error_message) VALUES ('$error_message')";
    $conn->query($sql);
    $conn->close();

    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Error</title>
        <link rel="stylesheet" type="text/css" href="main.css">
    </head>
    <body>
        <main>
            <h1>Error</h1>
            <p>An error occurred: <?php echo $error_message; ?></p>
            <button onclick="goBack()">Go Back</button>
        </main>

        <script>
            function goBack() {
                window.history.back();
            }
        </script>
    </body>
    </html>
    <?php
    exit();
}
?>

<!DOCTYPE html>
<html>
<body>
    <main>
        <title>Order Total</title>
        <link rel="stylesheet" type="text/css" href="main.css">
        <p>Cost of Shoes: $<?php echo $cost; ?></p>
        <p>Quantity: <?php echo $quantity; ?></p>
        <?php 
        if ($waterproof) { 
            echo "<p>Waterproof: Yes</p>";
        } else { 
            echo "<p>Waterproof: No</p>";
        } 
        if ($member) { 
             ?>
            <p>Member Discount: $<?php echo $discount; ?></p>
        <?php
        } 
        ?>
        <p>Total Cost: $<?php echo $total_cost; ?></p>
        <p>Phone Number: <?php echo $phone; ?></p>
        <p>Email: <?php echo $email; ?></p>
    </main>
</body>
</html>

