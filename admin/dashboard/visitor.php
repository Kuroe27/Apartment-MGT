<?php
session_start();
include_once ('../../conn/Crud.php');

$crud = new Crud();

// Fetch only the records associated with the current tenant
$tenant_id = $_SESSION['tenant_id'];
$sql = "SELECT * FROM Visitor_Log";
$visitors = $crud->read($sql);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="path-to-your-tailwind.css">
    <title>Visitor Page</title>
    <link href="../../styles/output.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body class="h-100vh flex">
    <?php include_once ('../../components/sidebar.php') ?>

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
                <h1 class="text-2xl font-semibold">Visitor</h1>
            </div>
            <div class="flex items-center ml-auto">
            </div>
        </nav>


        <section class="bg min-h-[calc(100vh-80px)] flex flex-column ">
            <div class="container mx-auto p-4">
                <div class="bg-white  p-4 shadow rounded-md ">
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo '<div class="bg-blue-200 text-blue-800 p-4 mb-4">' . $_SESSION['message'] . '</div>';
                        unset($_SESSION['message']);
                    }
                    ?>
                    <!-- Add New Button -->
                    <a href="#add" id="openAddModalBtn" class="bg-pallete-400 text-white py-2 px-4 rounded"
                        onclick="openAddModal()">Add New</a><br><br>
                    <div class="relative overflow-x-auto ">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase  ">
                                <tr>
                                    <th class="px-6 py-3">ID</th>
                                    <th class="px-6 py-3">Visitor Name</th>
                                    <th class="px-6 py-3">Visitor Email</th>
                                    <th class="px-6 py-3">Visitor Phone</th>
                                    <th class="px-6 py-3">Visit Date</th>
                                    <th class="px-6 py-3">Purpose</th>
                                    <th class="px-6 py-3">Tenant ID</th>
                                    <th class="px-6 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Loop through visitors -->
                                <?php foreach ($visitors as $visitor): ?>
                                    <tr class="bg-white border-t">
                                        <td class="w-4 p-4 pl-6">
                                            <?php echo $visitor['id']; ?>
                                        </td>
                                        <td class="w-4 p-4 pl-6">
                                            <?php echo $visitor['visitor_name']; ?>
                                        </td>
                                        <td class="w-4 p-4 pl-6">
                                            <?php echo $visitor['visitor_email']; ?>
                                        </td>
                                        <td class="w-4 p-4 pl-6">
                                            <?php echo $visitor['visitor_phone']; ?>
                                        </td>
                                        <td class="w-4 p-4 pl-6">
                                            <?php echo $visitor['visit_date']; ?>
                                        </td>
                                        <td class="w-4 p-4 pl-6">
                                            <?php echo $visitor['purpose']; ?>
                                        </td>
                                        <td class="w-4 p-4 pl-6">
                                            <?php echo $visitor['tenant_id']; ?>
                                        </td>
                                        <td class="w-4 p-4 pl-6 ">
                                            <div class="flex">
                                                <img src="../../images/edit.png" alt="" class="w-4 mr-2 cursor-pointer"
                                                    onclick="openEditModal('<?php echo $visitor['id']; ?>')">
                                                <img src="../../images/delete.png" alt="" class="w-4 mr-2 cursor-pointer"
                                                    onclick="openDeleteModal('<?php echo $visitor['id']; ?>')">
                                            </div>
                                        </td>
                                    </tr>
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
    $modalTitle = 'Add Visitor';
    $formAction = '../../actions/visitorAction.php';
    $submitBtnName = 'add';
    $submitBtnText = 'Save';

    $formFields = [
        ['label' => 'Visitor Name', 'name' => 'visitor_name', 'type' => 'text'],
        ['label' => 'Visitor Email', 'name' => 'visitor_email', 'type' => 'email'],
        ['label' => 'Visitor Phone', 'name' => 'visitor_phone', 'type' => 'text'],
        ['label' => 'Visit Date', 'name' => 'visit_date', 'type' => 'date'],
        ['label' => 'Purpose', 'name' => 'purpose', 'type' => 'text'],
    ];

    include ('../../components/modal.php');
    ?>

    <?php foreach ($visitors as $visitor): ?>
        <?php
        $modalId = 'edit' . $visitor['id'];
        $modalTitle = 'Edit Visitor';
        $formAction = '../../actions/visitorAction.php?id=' . $visitor['id'];
        $submitBtnName = 'edit';
        $submitBtnText = 'Save';

        $formFields = [
            ['label' => 'ID', 'name' => 'id', 'type' => 'text', 'value' => $visitor['id']],
            ['label' => 'Visitor Name', 'name' => 'visitor_name', 'type' => 'text', 'value' => $visitor['visitor_name']],
            ['label' => 'Visitor Email', 'name' => 'visitor_email', 'type' => 'email', 'value' => $visitor['visitor_email']],
            ['label' => 'Visitor Phone', 'name' => 'visitor_phone', 'type' => 'text', 'value' => $visitor['visitor_phone']],
            ['label' => 'Visit Date', 'name' => 'visit_date', 'type' => 'date', 'value' => $visitor['visit_date']],
            ['label' => 'Purpose', 'name' => 'purpose', 'type' => 'text', 'value' => $visitor['purpose']],
        ];

        include ('../../components/modal.php');

        $modalId = 'delete' . $visitor['id'];
        $modalTitle = 'Delete Visitor';
        $formAction = '../../actions/visitorAction.php?tenant_id=' . $_SESSION['tenant_id'];
        $submitBtnName = 'delete';
        $submitBtnText = 'Delete';

        $formFields = [
            ['label' => 'ID', 'name' => 'id', 'type' => 'text', 'value' => $visitor['id']],
        ];

        include ('../../components/modal.php');
        ?>
    <?php endforeach; ?>

    <script src="../../scripts/index.js"></script>
</body>

</html>