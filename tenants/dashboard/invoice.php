<?php
session_start();
$tenant_id = $_SESSION['tenant_id'];

include '../../conn/DbConnection.php';

$dbConnection = new DbConnection();
$conn = $dbConnection->getConnection();

$sql = "SELECT Invoices.id as invoice_id, Invoices.date_created,Invoices.due_date, Invoices.prev_bill, Invoices.current_bill, Invoices.total_amount, Tenants.first_name, Tenants.last_name, Tenants.email
        FROM Invoices
        JOIN Tenants ON Invoices.tenant_id = Tenants.id
        WHERE Invoices.tenant_id = $tenant_id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $invoice_id = $row['invoice_id'];
    $date_created = $row['date_created'];
    $due_date = $row['due_date'];
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $email = $row['email'];
    $prev_bill = $row['prev_bill'];
    $current_bill = $row['current_bill'];
    $total_amount = $row['total_amount'];
} else {
    echo "No invoice found for the logged-in tenant.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Page</title>

    
</head>
<body>

    <h1>Invoice</h1>

    <table>
        <tr>
            <th>Invoice ID</th>
            <th>Date Created</th>
            <th>Due Date</th>
        </tr>
        <tr>
            <td><?php echo $invoice_id; ?></td>
            <td><?php echo $date_created; ?></td>
            <td><?php echo $due_date; ?></td>
        </tr>
    </table>

    <div>
        <h2>Invoiced To</h2>
        <p>
            <?php echo $first_name . ' ' . $last_name; ?><br>
            <?php echo $email; ?>
        </p>
    </div>
    

    <table>
    <h2>Bills</h2>
        <tr>
            <th>Previous Bill</th>
            <td><?php echo $prev_bill; ?></td>
        </tr>
        <tr>
            <th>Current Bill</th>
            <td><?php echo $current_bill; ?></td>
        </tr>
        <tr>
            <th>Total Amount</th>
            <td><?php echo $total_amount; ?></td>
        </tr>
     
    </table>

</body>
</html>
