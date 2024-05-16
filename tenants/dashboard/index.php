<?php
session_start();
include_once('../../conn/Crud.php');

if(!isset($_SESSION['tenant_id'])) {
    header("Location: ./login.php");
    exit();
}

$crud = new Crud();
$tenant_id = $_SESSION['tenant_id'];
$sql = "SELECT * FROM Tenants WHERE id = '$tenant_id'";
$result = $crud->read($sql);

if($result && count($result) == 1) {
    $tenant = $result[0];
    $tenant_name = $tenant['first_name'].' '.$tenant['last_name'];
    $room_rent = $tenant['balance'];
    $balance = $tenant['balance'];
    $room_id = $tenant['room_id'];
} else {
    header("Location: ./login.php");
    exit();
}

$display_section = '';
if(isset($_GET['section'])) {
    $display_section = $_GET['section'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="path-to-your-tailwind.css">
    <title>Dashboard</title>
    <link href="../../styles/output.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
    <div class="min-h-full">
        <nav class="bg-white">

            <div class="mx-auto max-w-7xl ">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="flex items-center">

                                <span class="material-symbols-outlined text-pallete-400 flex mr-2  text-3xl   ">
                                    apartment
                                </span>
                                <a href="index.php" class=" py-2 text-lg font-semibold">Apartment Mgt</a>

                            </div>
                        </div>
                    </div>
                    <ul class="mb-2">


                        <li class="px-4 flex   py-2 border-b-1 border-t-1 border-gray-400 rounded-lg mt-2 ">
                            <svg xmlns="http://www.w3.org/2000/svg" height="30" viewBox="0 -960 960 960" width="30"
                                class="mr-2">
                                <path
                                    d="M440-440v-400h80v400h-80Zm40 320q-74 0-139.5-28.5T226-226q-49-49-77.5-114.5T120-480q0-80 33-151t93-123l56 56q-48 40-75 97t-27 121q0 116 82 198t198 82q117 0 198.5-82T760-480q0-64-26.5-121T658-698l56-56q60 52 93 123t33 151q0 74-28.5 139.5t-77 114.5q-48.5 49-114 77.5T480-120Z"
                                    fill="black" />
                            </svg>
                            <a href="../logout.php" class="w-full text-gray-500 text-lg">Logout</a>
                        </li>
                </div>
                </ul>
            </div>
    </div>
    </nav>
    <header class="bg-gradient-to-r from-pallete-100 to-pallete-400 shadow">
        <div class="mx-auto max-w-7xl py-24 ">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-2">Hi tenant,</h1>
            <h2 class="text-2xl font-thin ">
                <?php echo $tenant_name; ?>
            </h2>
        </div>
        <ul id="sectionList" class="flex mx-auto max-w-7xl text-2xl ">
            <li
                class="text-gray- py-2 mr-2 activeLi <?php echo ($display_section == 'dashboard') ? 'activeLi' : ''; ?>">
                <a href="#" onclick="showSection('dashboard')">Dashboard</a>
            </li>
            <li class="text-gray- py-2 mx-2 <?php echo ($display_section == 'payments') ? 'activeLi' : ''; ?>">
                <a href="#" onclick="showSection('payments')">Payments</a>
            </li>
            <li class="text-gray- py-2 mx-2 <?php echo ($display_section == 'invoices') ? 'activeLi' : ''; ?>">
                <a href="#" onclick="showSection('invoices')">Invoices</a>
            </li>
            <li class="text-gray- py-2 mx-2 <?php echo ($display_section == 'invoices') ? 'activeLi' : ''; ?>">
                <a href="#" onclick="showSection('maintenance')">Maintenance</a>
            </li>
        </ul>
    </header>


    <main>
        <section class="mx-auto max-w-7xl py-6 w-full" id="dashboardSection">
            <section class="mx-auto max-w-7xl py-6 w-full">
                <h2 class="text-2xl font-bold mb-4">Dashboard</h2>

                <div class="flex justify-around w-full">
                    <div class="text-start flex w-full">
                        <div class="text-lg shadow-lg rounded-md flex flex-col bg-white p-4 w-full h-18 mr-4 py-10">
                            <span class="mb-4">
                                Room ID
                            </span>
                            <p class="text-3xl">
                                #
                                <?php echo $room_id; ?>
                            </p>
                        </div>
                        <div class="text-lg shadow-lg rounded-md flex flex-col bg-white p-4 w-full h-18 mr-4 py-10">
                            <span class="mb-4">
                                Monthly Rate
                            </span>
                            <p class="text-3xl">
                                ₱
                                <?php echo $room_rent; ?>
                            </p>
                        </div>

                        <div class="text-lg shadow-lg rounded-md flex flex-col bg-white p-4 w-full h-18 mr-4 py-10">
                            <span class="mb-4">
                                Amount To Pay
                            </span>
                            <p class="text-3xl">
                                ₱
                                <?php echo $balance; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </section>

        <section class="mx-auto max-w-7xl py-6 w-full" id="paymentsSection" <?php echo ($display_section == 'payments') ? '' : 'style="display: none;"'; ?>>
            <h2 class="text-2xl font-bold mb-4 mt-4">Payments</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <?php
                $payment_sql = "SELECT * FROM Payments WHERE tenant_id = '$tenant_id'";
                $payment_result = $crud->read($payment_sql);

                if($payment_result) {
                    foreach($payment_result as $payment) {
                        echo '<div class="text-lg shadow-lg rounded-md flex items-center bg-white p-4 h-18 py-10 ">';

                        echo '<div class="mr-4">';
                        echo '<span class="mb-4">Payment Date: '.$payment['payment_date'].'</span>';
                        echo '<p class="text-3xl">Amount Paid: ₱'.$payment['amount_paid'].'</p>';
                        echo '</div>';
                        echo '<div class="text-center flex">';
                        echo '<button onclick="printPayment(\'payment.php?payment_id='.$payment['id'].'\')"><svg fill="gray"xmlns="http://www.w3.org/2000/svg" height="40" viewBox="0 -960 960 960" width="40"><path d="M640-640v-120H320v120h-80v-200h480v200h-80Zm-480 80h640-640Zm560 100q17 0 28.5-11.5T760-500q0-17-11.5-28.5T720-540q-17 0-28.5 11.5T680-500q0 17 11.5 28.5T720-460Zm-80 260v-160H320v160h320Zm80 80H240v-160H80v-240q0-51 35-85.5t85-34.5h560q51 0 85.5 34.5T880-520v240H720v160Zm80-240v-160q0-17-11.5-28.5T760-560H200q-17 0-28.5 11.5T160-520v160h80v-80h480v80h80Z"/></svg> </button>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No payments found for this tenant.</p>';
                }
                ?>
            </div>
        </section>

        <section class="mx-auto max-w-7xl py-6 w-full" id="invoicesSection" <?php echo ($display_section == 'invoices') ? '' : 'style="display: none;"'; ?>>
            <section class="mx-auto max-w-7xl py-6 w-full">
                <h2 class="text-2xl font-bold mb-4">Invoices</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    <?php
                    $invoice_sql = "SELECT * FROM Invoices WHERE tenant_id = '$tenant_id' AND status NOT LIKE 'Paid'";
                    $invoice_result = $crud->read($invoice_sql);

                    if($invoice_result) {
                        foreach($invoice_result as $invoice) {
                            echo '<div class="text-lg shadow-lg rounded-md flex items-center bg-white p-4 h-18 py-10">';

                            echo '<div class="mr-4">';
                            echo '<span class="mb-4">Due Date: '.$invoice['due_date'].'</span>';
                            echo '<p class="text-3xl">Total Amount: ₱'.$invoice['total_amount'].'</p>';
                            echo '</div>';
                            echo '<div class="text-center flex">';
                            echo '<button onclick="printPage(\'invoice.php?invoice_id='.$invoice['id'].'\')"><svg fill="gray" xmlns="http://www.w3.org/2000/svg" height="40" viewBox="0 -960 960 960" width="40"><path d="M640-640v-120H320v120h-80v-200h480v200h-80Zm-480 80h640-640Zm560 100q17 0 28.5-11.5T760-500q0-17-11.5-28.5T720-540q-17 0-28.5 11.5T680-500q0 17 11.5 28.5T720-460Zm-80 260v-160H320v160h320Zm80 80H240v-160H80v-240q0-51 35-85.5t85-34.5h560q51 0 85.5 34.5T880-520v240H720v160Zm80-240v-160q0-17-11.5-28.5T760-560H200q-17 0-28.5 11.5T160-520v160h80v-80h480v80h80Z"/></svg></button>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No pending invoices found for this tenant.</p>';
                    }
                    ?>
                </div>
            </section>
        </section>
    </main>
    </div>

    <script>
        function showSection(sectionName) {
            document.getElementById('dashboardSection').style.display = (sectionName === 'dashboard') ? 'block' : 'none';
            document.getElementById('paymentsSection').style.display = (sectionName === 'payments') ? 'block' : 'none';
            document.getElementById('invoicesSection').style.display = (sectionName === 'invoices') ? 'block' : 'none';

            var listItems = document.getElementById('sectionList').getElementsByTagName('li');
            for (var i = 0; i < listItems.length; i++) {
                listItems[i].classList.remove('activeLi');
            }
            event.target.parentElement.classList.add('activeLi');
        }

        function printPage(url) {
            var printWindow = window.open(url, '_blank');
            printWindow.print();
        }
        function printPayment(url) {
            var printWindow = window.open(url, '_blank');
            printWindow.print();
        }
    </script>

</body>

</html>