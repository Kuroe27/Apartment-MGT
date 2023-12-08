<?php
session_start();
include_once('../../conn/Crud.php');

$crud = new Crud();
$sql = "SELECT * FROM Invoices";
$invoices = $crud->read($sql);

$sqlTenants = "SELECT id, first_name, last_name FROM Tenants";
$tenants = $crud->read($sqlTenants);
$tenantOptions = [];

foreach($tenants as $tenant) {
    $tenantOptions[$tenant['id']] = $tenant['first_name'].' '.$tenant['last_name'];
}

function getStatusColorClass($status) {
    switch($status) {
        case 'Pending':
            return 'bg-yellow-200 ';
        case 'Paid':
            return 'bg-green-200 ';
        case 'Overdue':
            return 'bg-red-200 ';
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
                <h1 class="text-2xl font-semibold">Invoices</h1>
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
                    <!-- Add New Invoice Button -->
                    <a href="#add" id="openAddModalBtn" class="bg-pallete-400 text-white py-2 px-4 rounded"
                        onclick="openAddModal()">Add New</a><br><br>

                    <!-- Display Invoices in Table -->
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase">
                                <tr>
                                    <th class="px-6 py-3">ID</th>
                                    <th class="px-6 py-3">Tenant Name</th>
                                    <th class="px-6 py-3">Date Created</th>
                                    <th class="px-6 py-3">Due Date</th>
                                    <th class="px-6 py-3">Current Bill</th>
                                    <th class="px-6 py-3">Previous Bill</th>
                                    <th class="px-6 py-3">Total Amount</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($invoices as $invoice): ?>
                                    <tr class="bg-white border-t">
                                        <td class="w-4 p-4 pl-6">
                                            <?php echo $invoice['id']; ?>
                                        </td>
                                        <td class="w-4 p-4 pl-6">
                                            <?php echo $tenantOptions[$invoice['tenant_id']]; ?>
                                        </td>
                                        <td class="w-4 p-4 pl-6">
                                            <?php echo $invoice['date_created']; ?>
                                        </td>
                                        <td class="w-4 p-4 pl-6">
                                            <?php echo $invoice['due_date']; ?>
                                        </td>
                                        <td class="w-4 p-4 pl-6">
                                            <?php echo $invoice['current_bill']; ?>
                                        </td>
                                        <td class="w-4 p-4 pl-6">
                                            <?php echo $invoice['prev_bill']; ?>
                                        </td>
                                        <td class="w-4 p-4 pl-6">
                                            <?php echo $invoice['total_amount']; ?>
                                        </td>
                                        <td class="w-4 p-4 pl-4 ">
                                            <span
                                                class="px-4 py-1 rounded-full <?php echo getStatusColorClass($invoice['status']); ?>">
                                                <?php echo ucfirst($invoice['status']); ?>

                                            </span>
                                        </td>
                                        <td class="w-4 p-4 pl-6 ">
                                            <div class="flex">
                                                <img src="../../images/edit.png" alt="" class="w-4 mr-2 cursor-pointer"
                                                    onclick="openEditModal('<?php echo $invoice['id']; ?>')">
                                                <img src="../../images/delete.png" alt="" class="w-4 mr-2 cursor-pointer"
                                                    onclick="openDeleteModal('<?php echo $invoice['id']; ?>')">
                                            </div>
                                        </td>
                                    </tr>

                                    <?php
                                    // Edit modal
                                    $modalId = 'edit'.$invoice['id'];
                                    $modalTitle = 'Edit Invoice';
                                    $formAction = '../../actions/invoicesAction.php?id='.$invoice['id'];
                                    $submitBtnName = 'edit';
                                    $submitBtnText = 'Save';

                                    $selectedTenantId = $invoice['tenant_id'];

                                    $formFields = [
                                        ['label' => 'ID', 'name' => 'id', 'type' => 'text', 'value' => $invoice['id']],
                                        ['label' => 'Date Created', 'name' => 'date_created', 'type' => 'text', 'value' => $invoice['date_created']],
                                        ['label' => 'Due Date', 'name' => 'due_date', 'type' => 'date', 'value' => $invoice['due_date']],
                                        ['label' => 'Current Bill', 'name' => 'current_bill', 'type' => 'number', 'value' => $invoice['current_bill']],
                                        ['label' => 'Previous Bill', 'name' => 'prev_bill', 'type' => 'number', 'value' => $invoice['prev_bill']],
                                        ['label' => 'Total Amount', 'name' => 'total_amount', 'type' => 'number', 'value' => $invoice['total_amount']],
                                    ];

                                    include('../../components/modal.php');

                                    // Delete modal
                                    $modalId = 'delete'.$invoice['id'];
                                    $modalTitle = 'Delete Invoice';
                                    $formAction = '../../actions/invoicesAction.php?id='.$invoice['id'];
                                    $submitBtnName = 'delete';
                                    $submitBtnText = 'Delete';
                                    $formFields = [
                                        ['label' => 'ID', 'name' => 'id', 'type' => 'text', 'value' => $invoice['id']],
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
    $modalTitle = 'Add Invoice';
    $formAction = '../../actions/invoicesAction.php';
    $submitBtnName = 'add';
    $submitBtnText = 'Save';

    $formFields = [
        ['label' => 'Tenant ID', 'name' => 'tenant_id', 'type' => 'select', 'options' => $tenantOptions],
        ['label' => 'Due Date', 'name' => 'due_date', 'type' => 'date'],
        ['label' => 'Current Bill', 'name' => 'current_bill', 'type' => 'number'],
    ];

    include('../../components/modal.php');
    ?>

    <script src="../../scripts/index.js"></script>
</body>

</html>

<?php
// Function to get the background color class based on the status
?>