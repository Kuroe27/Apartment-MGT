<?php
session_start();
include_once('../../conn/Crud.php');

if(!isset($_GET['invoice_id'])) {
    header("Location: ./index.php");
    exit();
}

$invoice_id = $_GET['invoice_id'];
$crud = new Crud();

$invoice_sql = "SELECT Invoices.*, Tenants.first_name, Tenants.last_name
                FROM Invoices
                INNER JOIN Tenants ON Invoices.tenant_id = Tenants.id
                WHERE Invoices.id = '$invoice_id'";
$invoice_result = $crud->read($invoice_sql);

if(!$invoice_result || count($invoice_result) != 1) {
    header("Location: ./index.php");
    exit();
}

$invoice = $invoice_result[0];
$due_date = $invoice['due_date'];
$current_bill = $invoice['current_bill'];
$prev_bill = $invoice['prev_bill'];
$total_amount = $invoice['total_amount'];
$tenant_name = $invoice['first_name'].' '.$invoice['last_name'];

// You can add more invoice details as needed

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="path-to-your-tailwind.css">
    <title>Invoice</title>
    <link href="../../styles/output.css" rel="stylesheet" />
    <!-- Add your additional styles or fonts as needed -->
</head>

<body class="bg-gray-200 font-sans">
    <div class="bg-white border rounded-lg shadow-lg px-6 py-8  mx-auto h-screen w-screen ">
        <h1 class="font-bold text-2xl my-4 text-center text-blue-600">Apartment Management System</h1>
        <hr class="mb-2">
        <div class="flex justify-between mb-6">
            <h1 class="text-lg font-bold">Invoice</h1>
            <div class="text-gray-700">
                <div>Date:
                    <?php echo $due_date; ?>
                </div>
                <div>Invoice #:
                    <?php echo $invoice_id; ?>
                </div>
            </div>
        </div>
        <div class="mb-8">
            <h2 class="text-lg font-bold mb-4">Bill To:</h2>
            <div class="text-gray-700 mb-2">
                <?php echo $tenant_name; ?>
            </div>
        </div>
        <table class="w-full mb-8">
            <thead>
                <tr>
                    <th class="text-left font-bold text-gray-700">Description</th>
                    <th class="text-right font-bold text-gray-700">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-left text-gray-700">Previous Bill</td>
                    <td class="text-right text-gray-700">₱
                        <?php echo $prev_bill; ?>
                    </td>
                </tr>
                <tr>
                    <td class="text-left text-gray-700">Current Bill</td>
                    <td class="text-right text-gray-700">₱
                        <?php echo $current_bill; ?>
                    </td>
                </tr>

            </tbody>
            <tfoot>
                <tr>
                    <td class="text-left font-bold text-gray-700">Total</td>
                    <td class="text-right font-bold text-gray-700">₱
                        <?php echo $total_amount; ?>
                    </td>
                </tr>
            </tfoot>
        </table>
        <div class="text-gray-700 mb-2">Thank you for your business!</div>
    </div>
</body>

</html>