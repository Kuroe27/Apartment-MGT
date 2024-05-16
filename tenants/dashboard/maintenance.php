<?php
session_start();
include_once('../../conn/Crud.php');

if(!isset($_GET['maintenance_id'])) {
    header("Location: ./index.php");
    exit();
}


$crud = new Crud();
$tenant_id = $_SESSION['tenant_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $description = $_POST['description'];
    
    $sql = "INSERT INTO MaintenanceRequests (tenant_id, description, status) VALUES ('$tenant_id', '$description', 'Pending')";
    if ($crud->execute($sql)) {
        $_SESSION['message'] = "Maintenance request submitted successfully.";
    } else {
        $_SESSION['message'] = "Failed to submit maintenance request.";
    }

    header("Location: maintenance_request.php");
    exit();
}

$sql = "SELECT * FROM MaintenanceRequests WHERE tenant_id = '$tenant_id'";
$requests = $crud->read($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="path-to-your-tailwind.css">
    <title>Maintenance Request</title>
    <link href="../../styles/output.css" rel="stylesheet" />
</head>

<body class="h-100vh flex">
    <?php include_once('../../components/sidebar.php') ?>

    <main class="ml-0 sm:ml-60 w-full">
        <nav class="container px-4 h-16 w-full mt-4 z-10 flex items-center text-center justify-center mx-auto">
            <div class="flex items-center">
                <h1 class="text-2xl font-semibold">Maintenance Request</h1>
            </div>
        </nav>

        <section class="bg min-h-[calc(100vh-80px)] flex flex-column">
            <div class="container mx-auto p-4">
                <div class="bg-white p-4 shadow rounded-md">
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo '<div class="bg-blue-200 text-blue-800 p-4 mb-4">'.$_SESSION['message'].'</div>';
                        unset($_SESSION['message']);
                    }
                    ?>

                    <form action="maintenance_request.php" method="POST" class="mb-4">
                        <label for="description" class="block mb-2">Description:</label>
                        <textarea name="description" id="description" rows="4" class="w-full border rounded p-2" required></textarea>
                        <button type="submit" class="bg-pallete-500 text-white py-2 px-4 rounded mt-2">Submit Request</button>
                    </form>

                    <h2 class="text-xl font-semibold mb-4">Your Maintenance Requests</h2>
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase">
                            <tr>
                                <th class="px-6 py-3">ID</th>
                                <th class="px-6 py-3">Description</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3">Schedule Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($requests as $request): ?>
                                <tr class="bg-white border-t">
                                    <td class="px-6 py-3"><?php echo $request['id']; ?></td>
                                    <td class="px-6 py-3"><?php echo $request['description']; ?></td>
                                    <td class="px-6 py-3"><?php echo $request['status']; ?></td>
                                    <td class="px-6 py-3"><?php echo $request['schedule_date']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
</body>

</html>