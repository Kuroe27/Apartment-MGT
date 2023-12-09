<?php
session_start();
include_once('../../conn/Crud.php');

$crud = new Crud();

$totalTenantsSQL = "SELECT COUNT(*) as totalTenants FROM Tenants";
$totalRoomsSQL = "SELECT COUNT(*) as totalRooms FROM Rooms";
$totalProfitSQL = "SELECT SUM(total_amount) as totalProfit FROM Invoices WHERE MONTH(date_created) = MONTH(CURRENT_DATE())";
$totalUnpaidInvoicesSQL = "SELECT COUNT(*) as totalUnpaid FROM Invoices WHERE status = 'Pending'";

$resultTotalTenants = $crud->read($totalTenantsSQL);
$resultTotalRooms = $crud->read($totalRoomsSQL);
$resultTotalProfit = $crud->read($totalProfitSQL);
$resultTotalUnpaidInvoices = $crud->read($totalUnpaidInvoicesSQL);

$totalTenants = $resultTotalTenants[0]['totalTenants'];
$totalRooms = $resultTotalRooms[0]['totalRooms'];
$totalProfit = $resultTotalProfit[0]['totalProfit'];
$totalUnpaidInvoices = $resultTotalUnpaidInvoices[0]['totalUnpaid'];
$allPaymentDataSQL = "SELECT * FROM Payments";
$resultAllPaymentData = $crud->read($allPaymentDataSQL);

$paymentDataForChart = [];
foreach($resultAllPaymentData as $payment) {
	$paymentDataForChart[] = [
		'date' => $payment['payment_date'],
		'amount' => $payment['amount_paid'],
	];
}

$allInvoicesSQL = "SELECT * FROM Invoices";
$resultAllInvoices = $crud->read($allInvoicesSQL);

$totalPaidAmount = 0;
$totalPendingAmount = 0;

foreach($resultAllInvoices as $invoice) {
	$amount = $invoice['total_amount'];
	$status = $invoice['status'];

	if($status === 'Paid') {
		$totalPaidAmount += $amount;
	} elseif($status === 'Pending') {
		$totalPendingAmount += $amount;
	}
}

usort($paymentDataForChart, function ($a, $b) {
	return strtotime($a['date']) - strtotime($b['date']);
});

$paymentDates = array_column($paymentDataForChart, 'date');
$paymentAmounts = array_column($paymentDataForChart, 'amount');

$paymentChartData = json_encode([
	'labels' => $paymentDates,
	'data' => $paymentAmounts,
]);
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
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</head>

<body class="h-100vh flex">
	<?php include_once('../../components/sidebar.php') ?>

	<main class="ml-0 sm:ml-60 w-full h-screen">
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
		<section class="content flex flex-column px-4">
			<div class="flex mb-4 w-full text-white">

				<div
					class="card flex p-4 bg-gradient-to-r from-pallete-500 to-pallete-700 rounded-md shadow-md w-1/4 mr-4 h-40 items-center">
					<svg xmlns="http://www.w3.org/2000/svg" height="full" viewBox="0 -960 960 960" width="60"
						class="mx-6">
						<path fill="white"
							d="M40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm720 0v-120q0-44-24.5-84.5T666-434q51 6 96 20.5t84 35.5q36 20 55 44.5t19 53.5v120H760ZM360-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm400-160q0 66-47 113t-113 47q-11 0-28-2.5t-28-5.5q27-32 41.5-71t14.5-81q0-42-14.5-81T544-792q14-5 28-6.5t28-1.5q66 0 113 47t47 113ZM120-240h480v-32q0-11-5.5-20T580-306q-54-27-109-40.5T360-360q-56 0-111 13.5T140-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T440-640q0-33-23.5-56.5T360-720q-33 0-56.5 23.5T280-640q0 33 23.5 56.5T360-560Zm0 320Zm0-400Z">
						</path>
					</svg>
					<div>
						<p class="text-3xl">
							<?= $totalTenants ?>
						</p>
						<h2 class="text-lg font-thin">Total Tenants</h2>
					</div>
				</div>

				<div
					class="card flex p-4 bg-gradient-to-r from-pallete-500 to-pallete-700 rounded-md shadow-md w-1/4 mr-4 h-40 items-center">
					<svg xmlns="http://www.w3.org/2000/svg" height="full" viewBox="0 -960 960 960" width="60"
						class="mx-6">
						<path fill="white"
							d="M120-120v-80h80v-640h400v40h160v240h-80v-160h-80v240h-80v-280H280v560h200v80H120Zm560 40-12-60q-12-5-22.5-11T625-165l-58 20-40-69 45-40q-2-15-2-25.5t2-25.5l-45-40 40-69 58 20q10-8 20.5-14.5T668-420l12-60h80l12 60q12 5 22.5 11t20.5 14l58-20 40 69-45 40q2 15 2 25.5t-2 25.5l45 40-40 69-58-19q-10 8-20.5 14T772-140l-12 60h-80Zm40-120q33 0 56.5-23.5T800-280q0-33-23.5-56.5T720-360q-33 0-56.5 23.5T640-280q0 33 23.5 56.5T720-200ZM440-440q-17 0-28.5-11.5T400-480q0-17 11.5-28.5T440-520q17 0 28.5 11.5T480-480q0 17-11.5 28.5T440-440ZM280-200v-560 560Z">
						</path>
					</svg>

					<div>
						<p class="text-3xl">
							<?= $totalRooms ?>
						</p>
						<h2 class="text-lg font-thin">Total Rooms</h2>
					</div>
				</div>

				<div
					class="card flex p-4 bg-gradient-to-r from-pallete-500 to-pallete-700 rounded-md shadow-md w-1/4 mr-4 h-40 items-center">
					<svg xmlns="http://www.w3.org/2000/svg" height="full" viewBox="0 -960 960 960" width="60"
						class="mx-6">
						<path fill="white"
							d="M441-120v-86q-53-12-91.5-46T293-348l74-30q15 48 44.5 73t77.5 25q41 0 69.5-18.5T587-356q0-35-22-55.5T463-458q-86-27-118-64.5T313-614q0-65 42-101t86-41v-84h80v84q50 8 82.5 36.5T651-650l-74 32q-12-32-34-48t-60-16q-44 0-67 19.5T393-614q0 33 30 52t104 40q69 20 104.5 63.5T667-358q0 71-42 108t-104 46v84h-80Z">
						</path>
					</svg>


					<div>
						<p class="text-3xl">
							<?= number_format($totalProfit, 2) ?>
						</p>
						<h2 class="text-lg font-thin">Profit of the month</h2>
					</div>
				</div>

				<div
					class="card flex p-4 bg-gradient-to-r from-pallete-500 to-pallete-700 rounded-md shadow-md w-1/4 mr-4 h-40 items-center">
					<svg xmlns="http://www.w3.org/2000/svg" height="full" viewBox="0 -960 960 960" width="60"
						class="mx-6">
						<path fill="white"
							d="M240-80q-50 0-85-35t-35-85v-120h120v-560l60 60 60-60 60 60 60-60 60 60 60-60 60 60 60-60 60 60 60-60v680q0 50-35 85t-85 35H240Zm480-80q17 0 28.5-11.5T760-200v-560H320v440h360v120q0 17 11.5 28.5T720-160ZM360-600v-80h240v80H360Zm0 120v-80h240v80H360Zm320-120q-17 0-28.5-11.5T640-640q0-17 11.5-28.5T680-680q17 0 28.5 11.5T720-640q0 17-11.5 28.5T680-600Zm0 120q-17 0-28.5-11.5T640-520q0-17 11.5-28.5T680-560q17 0 28.5 11.5T720-520q0 17-11.5 28.5T680-480ZM240-160h360v-80H200v40q0 17 11.5 28.5T240-160Zm-40 0v-80 80Z" />
					</svg>


					<div>
						<p class="text-3xl">
							<?= $totalUnpaidInvoices ?>
						</p>
						<h2 class="text-lg font-thin">Unpaid Invoices</h2>
					</div>
				</div>
			</div>

		</section>
		<section class="flex pr-8 ">
			<div class="   w-4/5 p-4">
				<div class="bg-white p-4 shadow rounded-md">
					<h1 class="text-xl">Payment Chart</h1>
					<canvas id="paymentChart"></canvas>
				</div>
			</div>

			<div class=" h-full  w-1/5 ">
				<div class="bg-white p-4 shadow rounded-md h-1/2 mt-4">
					<h1 class="text-xl">Invoice Status</h1>

					<canvas id="invoicePieChart"></canvas>
				</div>

				<div class="bg-white p-4 shadow rounded-md h-1/2 mt-2  ">
					<div class="flex items-center text-center">
						<div class="w-4 h-4 bg-pallete-500 mr-2"></div>
						<h1 class="text-xl">Balances</h1>
					</div>
					<div class="flex text-center align-center  mt-10 min-h-full pb-20 ">

						<div class="w-full">
							<p class="text-xl py-10  ">
								<?= number_format($totalPaidAmount, 2) ?>
							</p>
							<h2 class="text-lg font-thin  bg-pallete-400 text-white rounded-full ">Paid </h2>
						</div>
						<div class=" max-h-screen w-2 bg-gray-500 mx-2"></div>
						<div class="w-full">
							<p class="text-xl py-10 ">
								<?= number_format($totalPendingAmount, 2) ?>
							</p>
							<h2 class="text-lg font-thin  bg-gray-500 text-white rounded-full">Pending </h2>
						</div>
					</div>
				</div>

			</div>
		</section>
		</div>


		</div>
	</main>

	<script>
		const paymentChartData = <?php echo $paymentChartData; ?>;

		const ctx = document.getElementById('paymentChart').getContext('2d');
		const paymentChart = new Chart(ctx, {
			type: 'line',
			data: {
				labels: paymentChartData.labels,
				datasets: [{
					label: 'Payment Amount',
					data: paymentChartData.data,
					borderColor: 'rgba(199, 56, 255)',
					borderWidth: 2,
					pointBackgroundColor: 'rgba(191, 219, 255)',
				}]
			},
			options: {
				scales: {
					x: [{
						grid: {
							display: false
						},
						type: 'time',
						time: {
							unit: 'day',
							tooltipFormat: 'MMM DD, YYYY',
						},
						title: {
							display: true,
							text: 'Date',
						},
					}],
					y: {

						title: {
							display: true,
							text: 'Payment Amount',
						},
					},
				},
			},
		});

		const totalPaidInvoices = <?php echo $totalTenants - $totalUnpaidInvoices; ?>;
		const totalUnpaidInvoices = <?php echo $totalUnpaidInvoices; ?>;

		const pieData = {
			labels: ['Paid Invoices', 'Unpaid Invoices'],
			datasets: [{
				data: [totalPaidInvoices, totalUnpaidInvoices],
				backgroundColor: ['#5b5be7', 'rgba(199, 56, 255)'],
				borderWidth: 1,
			}],
		};

		const pieCtx = document.getElementById('invoicePieChart').getContext('2d');
		const pieChart = new Chart(pieCtx, {
			type: 'doughnut',
			data: pieData,
			options: {
				cutoutPercentage: 50,
				legend: {
					display: true,
					position: 'bottom',
				},
			},
		});

		function toggleSidebar() {
			const sidebar = document.getElementById('sidebar');
			sidebar.classList.toggle('translate-x-0');
		}
	</script>

</body>

</html>