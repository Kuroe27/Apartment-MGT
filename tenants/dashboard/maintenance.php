<?php
session_start();
include_once('../../conn/Crud.php');

$crud = new Crud();
$tenant_id = $_SESSION['tenant_id'];
$maintenance_sql = "SELECT * FROM Maintenance WHERE tenant_id = '$tenant_id'";
$maintenance_result = $crud->read($maintenance_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="path-to-your-tailwind.css">
    <title>Maintenance</title>
    <link href="../../styles/output.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body class="h-100vh flex">
    <?php include_once('../../components/sidebar.php') ?>

    <main class="ml-0 sm:ml-60 w-full">
        <nav class="container px-4 h-16 w-full mt-4 z-10 flex items-center text-center justify-center mx-auto">
            <div class="flex items-center">
                <button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar" type="button" onclick="toggleSidebar()" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-600">
                    <span class="material-symbols-outlined" onclick="toggleSidebar()" data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar" type="button">
                        menu
                    </span>
                </button>
                <h1 class="text-2xl font-semibold">Maintenance</h1>
            </div>
            <div class="flex items-center ml-auto">
            </div>
        </nav>

        <section class="bg min-h-[calc(100vh-80px)] flex flex-column">
            <div class="container mx-auto p-4">
                <div class="bg-white p-4 shadow rounded-md">
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo '<div class="bg-blue-200 text-blue-800 p-4 mb-4">' . $_SESSION['message'] . '</div>';
                        unset($_SESSION['message']);
                    }
                    ?>

                    <a href="#add" id="openAddModalBtn" class="bg-blue-500 text-white py-2 px-4 rounded" onclick="openAddModal()">Request Maintenance</a><br><br>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                        <?php if ($maintenance_result): ?>
                            <?php foreach ($maintenance_result as $maintenance): ?>
                                <div class="text-lg shadow-lg rounded-md flex items-center bg-white p-4 h-18 py-10 ">
                                    <div class="mr-4">
                                        <span class="mb-4">Description: <?php echo $maintenance['description']; ?></span>
                                        <p>Status: <?php echo $maintenance['status']; ?></p>
                                        <p>Scheduled Date: <?php echo $maintenance['schedule_date']; ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No ongoing maintenance.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php
    $modalId = 'add';
    $modalTitle = 'Request Maintenance';
    $formAction = '../../actions/maintenance_action.php';
    $submitBtnName = 'add_maintenance';
    $submitBtnText = 'Submit';
    include('../../components/modal.php');
    ?>

    <script src="../../scripts/index.js"></script>
</body>

</html>
