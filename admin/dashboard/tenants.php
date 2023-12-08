<?php
session_start();
include_once('../../conn/Crud.php');

$crud = new Crud();
$sql = "SELECT * FROM Tenants";
$tenants = $crud->read($sql);
$roomOptions = [];

$sqlRooms = "SELECT id, status FROM Rooms WHERE status = 'Available'";
$rooms = $crud->read($sqlRooms);

foreach($rooms as $room) {
    $roomOptions[$room['id']] = $room['id'].' ('.$room['status'].')';
}



$sqlRooms = "SELECT id, status FROM Rooms";
$rooms = $crud->read($sqlRooms);

foreach($rooms as $room) {
    $roomOption[$room['id']] = $room['id'].' ('.$room['status'].')';
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
                <h1 class="text-2xl font-semibold">Tenants</h1>
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
                    <a href="#add" id="openAddModalBtn" class="bg-pallete-400 text-white py-2 px-4 rounded"
                        onclick="openAddModal()">Add New</a><br><br>
                    <div class="relative overflow-x-auto ">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase  ">
                                <tr>
                                    <th class="px-6 py-3">ID</th>
                                    <th class="px-6 py-3">First Name</th>
                                    <th class="px-6 py-3">Last Name</th>
                                    <th class="px-6 py-3">Email</th>
                                    <th class="px-6 py-3">Move In Date</th>
                                    <th class="px-6 py-3">Balance</th>
                                    <th class="px-6 py-3">Room ID</th>
                                    <th class="px-6 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($tenants as $tenant): ?>
                                    <tr class="bg-white border-t">
                                        <td class="w-4 p-4 pl-6">
                                            <?php echo $tenant['id']; ?>
                                        </td>
                                        <td class="w-4 p-4 pl-6">
                                            <?php echo $tenant['first_name']; ?>
                                        </td>
                                        <td class="w-4 p-4 pl-6">
                                            <?php echo $tenant['last_name']; ?>
                                        </td>
                                        <td class="w-4 p-4 pl-6">
                                            <?php echo $tenant['email']; ?>
                                        </td>
                                        <td class="w-4 p-4 pl-6">
                                            <?php echo $tenant['move_in_date']; ?>
                                        </td>
                                        <td class="w-4 p-4 pl-6">
                                            <?php echo $tenant['balance']; ?>
                                        </td>
                                        <td class="w-4 p-4 pl-6">
                                            <?php echo $tenant['room_id']; ?>
                                        </td>
                                        <td class="w-4 p-4 pl-6 ">
                                            <div class="flex">
                                                <img src="../../images/edit.png" alt="" class="w-4 mr-2 cursor-pointer"
                                                    onclick="openEditModal('<?php echo $tenant['id']; ?>')">
                                                <img src="../../images/delete.png" alt="" class="w-4 mr-2 cursor-pointer"
                                                    onclick="openDeleteModal('<?php echo $tenant['id']; ?>')">
                                            </div>
                                        </td>
                                    </tr>

                                    <?php
                                    // Edit modal
                                    $modalId = 'edit'.$tenant['id'];
                                    $modalTitle = 'Edit Tenant';
                                    $formAction = '../../actions/tenantsAction.php?id='.$tenant['id'];
                                    $submitBtnName = 'edit';
                                    $submitBtnText = 'Save';


                                    $selectedRoomId = $tenant['room_id'];

                                    $formFields = [
                                        ['label' => 'ID', 'name' => 'id', 'type' => 'text', 'value' => $tenant['id']],
                                        ['label' => 'First Name', 'name' => 'first_name', 'type' => 'text', 'value' => $tenant['first_name']],
                                        ['label' => 'Last Name', 'name' => 'last_name', 'type' => 'text', 'value' => $tenant['last_name']],
                                        ['label' => 'Email', 'name' => 'email', 'type' => 'email', 'value' => $tenant['email']],
                                        ['label' => 'Move In Date', 'name' => 'move_in_date', 'type' => 'date', 'value' => $tenant['move_in_date']],
                                        ['label' => 'Balance', 'name' => 'balance', 'type' => 'number', 'value' => $tenant['balance']],
                                        ['label' => 'Room ID', 'name' => 'room_id', 'type' => 'select', 'selected' => $selectedRoomId, 'options' => $roomOption],
                                    ];

                                    include('../../components/modal.php');

                                    // Delete modal
                                    $modalId = 'delete'.$tenant['id'];
                                    $modalTitle = 'Delete Tenant';
                                    $formAction = '../../actions/tenantsAction.php?id='.$tenant['id'];
                                    $submitBtnName = 'delete';
                                    $submitBtnText = 'Delete';
                                    $formFields = [
                                        ['label' => 'ID', 'name' => 'id', 'type' => 'text', 'value' => $tenant['id']],
                                    ];

                                    include('../../components/modal.php');
                                    ?>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
        </section>
    </main>

    <?php
    $modalId = 'add';
    $modalTitle = 'Add Tenant';
    $formAction = '../../actions/tenantsAction.php';
    $submitBtnName = 'add';
    $submitBtnText = 'Save';

    $formFields = [
        ['label' => 'First Name', 'name' => 'first_name', 'type' => 'text'],
        ['label' => 'Last Name', 'name' => 'last_name', 'type' => 'text'],
        ['label' => 'Email', 'name' => 'email', 'type' => 'email'],
        ['label' => 'Move In Date', 'name' => 'move_in_date', 'type' => 'date'],
        ['label' => 'Balance', 'name' => 'balance', 'type' => 'number'],
        ['label' => 'Room ID', 'name' => 'room_id', 'type' => 'select', 'options' => $roomOptions],
    ];

    include('../../components/modal.php');
    ?>

    <script src="../../scripts/index.js"></script>
</body>

</html>