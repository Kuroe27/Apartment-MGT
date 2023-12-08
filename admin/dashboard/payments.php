<?php
session_start();
include_once('../../conn/Crud.php');

$crud = new Crud();
$sql = "SELECT * FROM Payments"; // Change the query to select payments
$payments = $crud->read($sql);

$sqlTenants = "SELECT id, first_name, last_name FROM Tenants";
$tenants = $crud->read($sqlTenants);
$tenantOptions = [];

foreach($tenants as $tenant) {
    $tenantOptions[$tenant['id']] = $tenant['first_name'].' '.$tenant['last_name'];
}
$sqlInvoices = "SELECT i.id, i.tenant_id, t.first_name, t.last_name FROM Invoices i
                JOIN Tenants t ON i.tenant_id = t.id";
$invoices = $crud->read($sqlInvoices);
$invoiceOptions = [];

foreach($invoices as $invoice) {
    $invoiceOptions[$invoice['id']] = $invoice['id'].' - '.$invoice['first_name'].' '.$invoice['last_name'];
}




function getStatusColorClass($status) {
    switch($status) {
        case 'Paid':
            return 'bg-green-200 ';
        default:
            return 'bg-gray-200 ';
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="path-to-your-tailwind.css">
    <title>Admin Page</title>
    <link href="../../styles/output.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body class="h-100vh flex">
    <?php include_once('../../components/sidebar.php') ?>

    <main class="ml-0 sm:ml-60 w-full">
        <nav class="container px-4 h-16 w-full mt-4 z-10 flex items-center text-center justify-center mx-auto">
            <div class="flex items-center">
                <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar" type="button"
                    onclick="toggleSidebar()"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2  focus:ring-gray-600">
                    <span class="material-symbols-outlined" onclick="toggleSidebar()" data-drawer-target="sidebar"
                        data-drawer-toggle="sidebar" aria-controls="sidebar" type="button">
                        menu
                    </span>
                </button>
                <h1 class="text-2xl font-semibold">Payments</h1>
            </div>
            <div class="flex items-center ml-auto">
            </div>
        </nav>
        <section class="bg min-h-[calc(100vh-80px)] flex flex-column ">
            <div class="container mx-auto p-4">
                <div class="bg-white  p-4 shadow rounded-md ">
                    <?php
                    if(isset($_SESSION['message'])) {
                        echo '<div class="bg-blue-200 text-blue-800 p-4 mb-4">'.$_SESSION['message'].'</div>';
                        unset($_SESSION['message']);
                    }
                    ?>
                    <!-- Add New Payment Button -->
                    <a href="#add" id="openAddModalBtn" class="bg-pallete-400 text-white py-2 px-4 rounded"
                        onclick="openAddModal()">Add New</a><br><br>

                    <!-- Display Payments in Table -->
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase">
                                <tr>
                                    <th class="px-6 py-3">ID</th>
                                    <th class="px-6 py-3">Tenant Name</th>
                                    <th class="px-6 py-3">Payment Date</th>
                                    <th class="px-6 py-3">Amount Paid</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($payments as $payment): ?>
                                    <tr class="bg-white border-t">
                                        <td class="w-4 p-4 pl-6">
                                            <?php echo $payment['id']; ?>
                                        </td>
                                        <td class="w-4 p-4 pl-6">
                                            <?php echo $tenantOptions[$payment['tenant_id']]; ?>
                                        </td>
                                        <td class="w-4 p-4 pl-6">
                                            <?php echo $payment['payment_date']; ?>
                                        </td>
                                        <td class="w-4 p-4 pl-6">
                                            <?php echo $payment['amount_paid']; ?>
                                        </td>
                                        <td class="w-4 p-4 pl-4 ">
                                            <span class="px-4 py-1 rounded-full <?php echo getStatusColorClass('Paid'); ?>">
                                                Paid
                                            </span>
                                        </td>
                                        <td class="w-4 p-4 pl-6 ">
                                            <div class="flex">
                                                <img src="../../images/edit.png" alt="" class="w-4 mr-2 cursor-pointer"
                                                    onclick="openEditModal('<?php echo $payment['id']; ?>')">
                                                <img src="../../images/delete.png" alt="" class="w-4 mr-2 cursor-pointer"
                                                    onclick="openDeleteModal('<?php echo $payment['id']; ?>')">
                                            </div>
                                        </td>
                                    </tr>

                                    <?php
                                    // Edit modal
                                    $modalId = 'edit'.$payment['id'];
                                    $modalTitle = 'Edit Payment';
                                    $formAction = '../../actions/paymentsAction.php?id='.$payment['id']; // Update to paymentsAction.php
                                    $submitBtnName = 'edit';
                                    $submitBtnText = 'Save';

                                    $selectedTenantId = $payment['tenant_id'];

                                    $formFields = [
                                        ['label' => 'ID', 'name' => 'id', 'type' => 'text', 'value' => $payment['id']],
                                        ['label' => 'Tenant ID', 'name' => 'tenant_id', 'type' => 'select', 'selected' => $selectedTenantId, 'options' => $tenantOptions],
                                        ['label' => 'Payment Date', 'name' => 'payment_date', 'type' => 'date', 'value' => $payment['payment_date']],
                                        ['label' => 'Amount Paid', 'name' => 'amount_paid', 'type' => 'text', 'value' => $payment['amount_paid']],
                                    ];

                                    include('../../components/modal.php');

                                    // Delete modal
                                    $modalId = 'delete'.$payment['id'];
                                    $modalTitle = 'Delete Payment';
                                    $formAction = '../../actions/paymentsAction.php?id='.$payment['id']; // Update to paymentsAction.php
                                    $submitBtnName = 'delete';
                                    $submitBtnText = 'Delete';
                                    $formFields = [
                                        ['label' => 'ID', 'name' => 'id', 'type' => 'text', 'value' => $payment['id']],
                                    ];

                                    include('../../components/modal.php');
                                    ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php
    $modalId = 'add';
    $modalTitle = 'Add Payment';
    $formAction = '../../actions/paymentsAction.php'; // Update to paymentsAction.php
    $submitBtnName = 'add';
    $submitBtnText = 'Save';




    // Add the Invoice ID field as a dropdown
    $formFields = [
        // Remove the 'Tenant ID' field
        ['label' => 'Invoice ID', 'name' => 'invoice_id', 'type' => 'select', 'options' => $invoiceOptions], // Change to dropdown
        ['label' => 'Payment Date', 'name' => 'payment_date', 'type' => 'date'],
        ['label' => 'Amount Paid', 'name' => 'amount_paid', 'type' => 'text'],
    ];


    include('../../components/modal.php');
    ?>


    <script src="../../scripts/index.js"></script>
</body>

</html>