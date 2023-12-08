<?php
session_start();
include_once('../../conn/Crud.php');

$crud = new Crud();

// Retrieve data for the dashboard
$totalTenantsSQL = "SELECT COUNT(*) as totalTenants FROM Tenants";
$totalRoomsSQL = "SELECT COUNT(*) as totalRooms FROM Rooms";
$totalProfitSQL = "SELECT SUM(total_amount) as totalProfit FROM Invoices WHERE MONTH(date_created) = MONTH(CURRENT_DATE())";
$totalUnpaidInvoicesSQL = "SELECT COUNT(*) as totalUnpaid FROM Invoices WHERE status = 'Pending'";

$resultTotalTenants = $crud->read($totalTenantsSQL);
$resultTotalRooms = $crud->read($totalRoomsSQL);
$resultTotalProfit = $crud->read($totalProfitSQL);
$resultTotalUnpaidInvoices = $crud->read($totalUnpaidInvoicesSQL);

// Extract values from the result
$totalTenants = $resultTotalTenants[0]['totalTenants'];
$totalRooms = $resultTotalRooms[0]['totalRooms'];
$totalProfit = $resultTotalProfit[0]['totalProfit'];
$totalUnpaidInvoices = $resultTotalUnpaidInvoices[0]['totalUnpaid'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" href="path-to-your-tailwind.css">
	<title>PHP CRUD using Object Oriented Programming</title>
	<link href="../../styles/output.css" rel="stylesheet" />
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

</head>

<body class="h-100vh flex">
	<?php include_once('../../components/sidebar.php') ?>

	<main class="ml-0 sm:ml-60 w-full">
		<nav class="container px-4 h-16  w-full  mt-4 z-10 flex items-center text-center justify-center ">

			<div class="flex items-center">
				<button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar" type="button"
					onclick="toggleSidebar()"
					class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2  focus:ring-gray-600">
					<span class="material-symbols-outlined" onclick="toggleSidebar()" data-drawer-target="sidebar"
						data-drawer-toggle="sidebar" aria-controls="sidebar" type="button">
						menu
					</span>

				</button>
				<h1 class="text-2xl font-semibold">Admin</h1>
			</div>
			<div class="flex items-center ml-auto">
			</div>
		</nav>
		<section class="content flex flex-column px-4 ">
			<div class="flex mb-4 w-full">
				<div class="card flex p-4 bg-white rounded-md shadow-md w-1/4 mr-4 h-40">
					<svg xmlns="http://www.w3.org/2000/svg" height="full" viewBox="0 -960 960 960" width="30">
						<path
							d="M40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm720 0v-120q0-44-24.5-84.5T666-434q51 6 96 20.5t84 35.5q36 20 55 44.5t19 53.5v120H760ZM360-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm400-160q0 66-47 113t-113 47q-11 0-28-2.5t-28-5.5q27-32 41.5-71t14.5-81q0-42-14.5-81T544-792q14-5 28-6.5t28-1.5q66 0 113 47t47 113ZM120-240h480v-32q0-11-5.5-20T580-306q-54-27-109-40.5T360-360q-56 0-111 13.5T140-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T440-640q0-33-23.5-56.5T360-720q-33 0-56.5 23.5T280-640q0 33 23.5 56.5T360-560Zm0 320Zm0-400Z" />
					</svg>
					<h2 class="text-lg font-semibold">Total Tenants</h2>
					<p class="text-2xl font-bold">
						<?= $totalTenants ?>
					</p>
				</div>
				<div class="card p-4 bg-white rounded-md shadow-md w-1/4 mr-4">
					<h2 class="text-lg font-semibold">Total Rooms</h2>
					<p class="text-2xl font-bold">
						<?= $totalRooms ?>
					</p>
				</div>
				<div class="card p-4 bg-white rounded-md shadow-md w-1/4 mr-4">
					<h2 class="text-lg font-semibold">Total Profit (Current Month)</h2>
					<p class="text-2xl font-bold">$
						<?= number_format($totalProfit, 2) ?>
					</p>
				</div>
				<div class="card p-4 bg-white rounded-md shadow-md w-1/4">
					<h2 class="text-lg font-semibold">Total Unpaid Invoices</h2>
					<p class="text-2xl font-bold">
						<?= $totalUnpaidInvoices ?>
					</p>
				</div>
			</div>

			<!-- Additional graphs or charts can be added here -->


	</main>

	<script>
		function toggleSidebar() {
			const sidebar = document.getElementById('sidebar');
			sidebar.classList.toggle('translate-x-0');
		}
	</script>
</body>

</html>