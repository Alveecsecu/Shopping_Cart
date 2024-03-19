<?php
// Include your database configuration file
@include 'config.php';

// Initialize an array to store monthly transaction amounts
$monthlyTransactions = array_fill(1, 12, 0); // Initialize all months with 0 amount

// Query to retrieve monthly transaction amounts
$query = "SELECT MONTH(date) AS month, SUM(amount) AS total_amount 
          FROM transactions 
          GROUP BY MONTH(date)";

$result = mysqli_query($conn, $query);

if($result) {
    // Fetch associative array
    while($row = mysqli_fetch_assoc($result)) {
        $month = (int)$row['month'];
        $totalAmount = (float)$row['total_amount'];
        // Check if total amount is zero to avoid division by zero error
        $monthlyTransactions[$month] = ($totalAmount != 0) ? $totalAmount : 0;
    }
}

// Close database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Transaction Amount Dashboard</title>
    <style>
        /* CSS styles for the dashboard */
        /* Your CSS styles here */
    </style>
</head>
<body>
    <div class="container">
        <h1>Monthly Transaction Amount Dashboard</h1>
        <div class="chart">
            <?php 
            // Loop through each month and create a bar for each month's transaction amount
            for($month = 1; $month <= 12; $month++) {
                $amount = $monthlyTransactions[$month];
                // Calculate the height of the bar relative to the maximum transaction amount
                $height = ($amount / max($monthlyTransactions)) * 100;
                // Display the bar with the transaction amount
                echo '<div class="bar" style="height: '.$height.'%;"><span>$'.$amount.'</span></div>';
            }
            ?>
        </div>
        <!-- Legend for transaction types -->
        <div class="legend">
            <div><span class="income"></span> Income</div>
            <div><span class="expense"></span> Expense</div>
            <div><span class="savings"></span> Savings</div>
        </div>
    </div>
</body>
</html>

