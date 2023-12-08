<?php
session_start();
$tenant_id = $_SESSION['tenant_id']; // Adjust this based on how you store user sessions

// Include the database connection class
include '../../conn/DbConnection.php';

// Create an instance of DbConnection
$dbConnection = new DbConnection();
$conn = $dbConnection->getConnection();

// Fetch payment details based on the logged-in tenant_id
$sql = "SELECT Payments.id as payment_id, Payments.amount_paid, Payments.payment_date, Invoices.id as invoice_id, Invoices.date_created, Invoices.due_date, Tenants.first_name, Tenants.last_name, Tenants.email, Tenants.id as tenant_id
        FROM Payments
        LEFT JOIN Invoices ON Payments.invoice_id = Invoices.id
        JOIN Tenants ON Payments.tenant_id = Tenants.id
        WHERE Payments.tenant_id = $tenant_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $payments = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $payments = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    
</head>
<body>

    <?php foreach ($payments as $payment): ?>
        <h1>Payment Receipt</h1>

        <table>
            <tr>
                <td colspan="2"><strong>Name:</strong> <?php echo $payment['first_name'] . ' ' . $payment['last_name']; ?></td>
                <td><?php echo $payment['payment_date']; ?></td>
            </tr>
            <tr>
                <td colspan="2"><strong>Email:</strong> <?php echo $payment['email']; ?></td>
                <td><strong>Tenant ID:</strong> <?php echo $payment['tenant_id']; ?></td>
            </tr>
            <tr>
                <td colspan="3">&nbsp;</td> <!-- Empty row for spacing -->
            </tr>
            <tr>
                <td><strong>Invoice ID:</strong></td>
                <td><?php echo $payment['invoice_id']; ?></td>
            </tr>
            <tr>
                <td><strong>Net Amount Paid:</strong></td>
                <td><?php echo $payment['amount_paid']; ?></td>
            </tr>
        </table>
    <?php endforeach; ?>

    <!-- Include any additional information or styling as needed -->

</body>
</html>
