<?php
session_start();
include_once('../../conn/Crud.php');

if (!isset($_SESSION['tenant_id'])) {
    header("Location: ./login.php");
    exit();
}

$tenant_id = $_SESSION['tenant_id'];
$crud = new Crud();

$maintenance_sql = "SELECT * FROM Maintenance WHERE tenant_id = '$tenant_id' AND status = 'Pending'";
$maintenance_result = $crud->read($maintenance_sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="path-to-your-tailwind.css">
    <title>Maintenance Requests</title>
    <link href="../../styles/output.css" rel="stylesheet" />
</head>

<body class="bg-gray-200 font-sans">
    <div class="bg-white border rounded-lg shadow-lg px-6 py-8  mx-auto h-screen w-screen ">
        <h1 class="font-bold text-2xl my-4 text-center text-blue-600">Apartment Management System</h1>
        <hr class="mb-2">
        <div class="flex justify-between mb-6">
            <h1 class="text-lg font-bold">Maintenance Requests</h1>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Request Maintenance
            </button>
        </div>
        <div class="mb-8">
            <?php if (!$maintenance_result || empty($maintenance_result)) : ?>
                <p class="text-gray-700">No ongoing maintenance</p>
            <?php else : ?>
                <table class="w-full mb-8">
                    <thead>
                        <tr>
                            <th class="text-left font-bold text-gray-700">ID</th>
                            <th class="text-left font-bold text-gray-700">Description</th>
                            <th class="text-left font-bold text-gray-700">Status</th>
                            <th class="text-left font-bold text-gray-700">Schedule Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($maintenance_result as $maintenance) : ?>
                            <tr>
                                <td class="text-left text-gray-700"><?php echo $maintenance['id']; ?></td>
                                <td class="text-left text-gray-700"><?php echo $maintenance['description']; ?></td>
                                <td class="text-left text-gray-700"><?php echo $maintenance['status']; ?></td>
                                <td class="text-left text-gray-700"><?php echo $maintenance['schedule_date']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
