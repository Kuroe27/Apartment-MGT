<?php
session_start();
include_once('../../conn/Crud.php');

$crud = new Crud();
$sql = "SELECT * FROM rooms";
$result = $crud->read($sql);
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
                <h1 class="text-2xl font-semibold">Rooms</h1>
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
                                    <th class="px-6 py-3">Rent</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($result as $row): ?>
                                    <tr class="bg-white border-t">
                                        <td class="w-4 p-4 pl-6">
                                            <?php echo $row['id']; ?>
                                        </td>
                                        <td class="w-4 p-4 pl-6">
                                            <?php echo $row['rent']; ?>
                                        </td>
                                        <td class="w-4 p-4 pl-6">
                                            <?php echo $row['status']; ?>
                                        </td>
                                        <td class="w-4 p-4  pl-6 ">
                                            <div class="flex">
                                                <img src="../../images/edit.png" alt="" class="w-4 mr-2 cursor-pointer"
                                                    onclick="openEditModal('<?php echo $row['id']; ?>')">
                                                <img src="../../images/delete.png" alt="" class="w-4 mr-2 cursor-pointer"
                                                    onclick="openDeleteModal('<?php echo $row['id']; ?>')">
                                            </div>
                                        </td>

                                        <?php
                                        $modalId = 'edit'.$row['id'];
                                        $modalTitle = 'Edit Rooms';
                                        $formAction = '../../actions/roomsAction.php?id='.$row['id'];
                                        $submitBtnName = 'edit';
                                        $submitBtnText = 'Save';

                                        $statusOptions = [
                                            'Occupied' => 'Occupied',
                                            'Available' => 'Available',
                                        ];

                                        $selectedStatus = $row['status'];

                                        $formFields = [
                                            ['label' => 'ID', 'name' => 'id', 'type' => 'text', 'value' => $row['id']],
                                            ['label' => 'Rent', 'name' => 'rent', 'type' => 'number', 'value' => $row['rent']],

                                            ['label' => 'Status', 'name' => 'status', 'type' => 'select', 'selected' => $selectedStatus, 'options' => $statusOptions],
                                        ];
                                        include('../../components/modal.php');

                                        $modalId = 'delete'.$row['id'];
                                        $modalTitle = 'Delete Rooms';
                                        $formAction = '../../actions/roomsAction.php?id='.$row['id'];
                                        $submitBtnName = 'delete';
                                        $submitBtnText = 'Delete';
                                        $formFields = [
                                            ['label' => 'ID', 'name' => 'id', 'type' => 'text', 'value' => $row['id']],
                                        ];
                                        include('../../components/modal.php');
                                        ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
        </section>
    </main>

    <?php
    $modalId = 'add';
    $modalTitle = 'Add Rooms';
    $formAction = '../../actions/roomsAction.php';
    $submitBtnName = 'add';
    $submitBtnText = 'Save';
    $selectedStatus = null;
    $formFields = [
        ['label' => 'Rent', 'name' => 'rent', 'type' => 'number'],
        ['label' => 'Status', 'name' => 'status', 'type' => 'select', 'options' => [
            '' => 'Select Status', 
            'Available' => 'Available',
            'Occupied' => 'Occupied',

        ], 'selected' => $selectedStatus, 'required' => true], 
    ];
    include('../../components/modal.php');
    ?>

    <script src="../../scripts/index.js"></script>
</body>

</html>