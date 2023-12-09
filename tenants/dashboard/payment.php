<?php
session_start();
include_once('../../conn/Crud.php');

if(!isset($_GET['payment_id'])) {
    header("Location: ./index.php");
    exit();
}

$payment_id = $_GET['payment_id'];
$crud = new Crud();

$payment_sql = "SELECT Payments.*, Tenants.first_name, Tenants.last_name
                FROM Payments
                INNER JOIN Tenants ON Payments.tenant_id = Tenants.id
                WHERE Payments.id = '$payment_id'";
$payment_result = $crud->read($payment_sql);

if(!$payment_result || count($payment_result) != 1) {
    header("Location: ./index.php");
    exit();
}

$payment = $payment_result[0];
$payment_date = $payment['payment_date'];
$amount_paid = $payment['amount_paid'];
$tenant_name = $payment['first_name'].' '.$payment['last_name'];

// You can add more payment details as needed

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="path-to-your-tailwind.css">
    <title>Payment Receipt</title>
    <link href="../../styles/output.css" rel="stylesheet" />
    <!-- Add your additional styles or fonts as needed -->
</head>

<body class="bg-gray-200 font-sans">
    <div class="bg-white border rounded-lg shadow-lg px-6 py-8  mx-auto h-screen w-screen ">
        <h1 class="font-bold text-2xl my-4 text-center text-blue-600">Apartment Management System</h1>
        <hr class="mb-2">
        <div class="flex justify-between mb-6">
            <h1 class="text-lg font-bold">Payment Receipt</h1>
            <div class="text-gray-700">
                <div>Date:
                    <?php echo $payment_date; ?>
                </div>
                <div>Payment ID:
                    <?php echo $payment_id; ?>
                </div>
            </div>
        </div>
        <div class="mb-8">
            <h2 class="text-lg font-bold mb-4">Paid By:</h2>
            <div class="text-gray-700 mb-2">
                <?php echo $tenant_name; ?>
            </div>
        </div>
        <table class="w-full mb-8">
            <thead>
                <tr>
                    <th class="text-left font-bold text-gray-700">Description</th>
                    <th class="text-right font-bold text-gray-700">Amount Paid</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-left text-gray-700">Payment Amount</td>
                    <td class="text-right text-gray-700">₱
                        <?php echo $amount_paid; ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="text-gray-700 mb-2">Thank you for your payment!</div>
    </div>
</body>

</html>