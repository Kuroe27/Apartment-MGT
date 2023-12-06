<?php
session_start();
include_once('../../conn/Crud.php');

$crud = new Crud();
$sql = "SELECT * FROM Admin";
$result = $crud->read($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="path-to-your-tailwind.css">
	<title>PHP CRUD using Object Oriented Programming</title>
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-200">
	<div class="container mx-auto p-4">
		<h1 class="text-2xl font-bold mb-4">PHP CRUD using Object Oriented Programming</h1>
		<div>
			<?php
			if(isset($_SESSION['message'])) {
				echo '<div class="bg-blue-200 text-blue-800 p-4 mb-4">'.$_SESSION['message'].'</div>';
				unset($_SESSION['message']);
			}
			?>

			<a href="#add" id="openAddModalBtn" class="bg-green-500 text-white py-2 px-4 rounded"
				onclick="openAddModal()">Add New</a><br><br>

			<table class="w-full border">
				<thead>
					<tr>
						<th class="border p-2">ID</th>
						<th class="border p-2">First Name</th>
						<th class="border p-2">Last Name</th>
						<th class="border p-2">Email</th>
						<th class="border p-2">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($result as $row): ?>
						<tr>
							<td class="border p-2">
								<?php echo $row['id']; ?>
							</td>
							<td class="border p-2">
								<?php echo $row['first_name']; ?>
							</td>
							<td class="border p-2">
								<?php echo $row['last_name']; ?>
							</td>
							<td class="border p-2">
								<?php echo $row['email']; ?>
							</td>
							<td class="border p-2">
								<button class="bg-blue-500 text-white py-1 px-2 rounded"
									onclick="openEditModal('<?php echo $row['id']; ?>')">
									Edit
								</button> |
								<button class="bg-red-500 text-white py-1 px-2 rounded"
									onclick="openDeleteModal('<?php echo $row['id']; ?>')">
									Delete
								</button>
							</td>

							<?php
							// Edit modal
							$modalId = 'edit'.$row['id'];
							$modalTitle = 'Edit Admin';
							$formAction = '../../actions/action.php?id='.$row['id'];
							$submitBtnName = 'edit';
							$submitBtnText = 'Save';
							$formFields = [
								['label' => 'ID', 'name' => 'id', 'type' => 'text', 'value' => $row['id']],
								['label' => 'First Name', 'name' => 'first_name', 'type' => 'text', 'value' => $row['first_name']],
								['label' => 'Last Name', 'name' => 'last_name', 'type' => 'text', 'value' => $row['last_name']],
								['label' => 'Email', 'name' => 'email', 'type' => 'text', 'value' => $row['email']]
							];
							include('../../components/modal.php');
							?>

							<?php
							// Delete modal
							$modalId = 'delete'.$row['id'];
							$modalTitle = 'Delete Admin';
							$formAction = '../../actions/action.php?id='.$row['id'];
							$submitBtnName = 'delete';
							$submitBtnText = 'Delete';
							$formFields = [
								['label' => 'ID', 'name' => 'id', 'type' => 'text', 'value' => $row['id']]
							];
							include('../../components/modal.php');
							?>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>

	<?php
	// Add modal content here
	$modalId = 'add';
	$modalTitle = 'Add Admin';
	$formAction = '../../actions/action.php';
	$submitBtnName = 'add';
	$submitBtnText = 'Save';
	$formFields = [
		['label' => 'First Name', 'name' => 'first_name', 'type' => 'text'],
		['label' => 'Last Name', 'name' => 'last_name', 'type' => 'text'],
		['label' => 'Email', 'name' => 'email', 'type' => 'text'],
		['label' => 'Password', 'name' => 'password', 'type' => 'password']
	];
	include('../../components/modal.php');
	?>

	<script type="text/javascript">
		function openEditModal(id) {
			toggleModal('edit' + id);
		}

		function openDeleteModal(id) {
			toggleModal('delete' + id);
		}

		function openAddModal() {
			toggleModal('add');
		}

		function toggleModal(modalID) {
			document.getElementById(modalID).classList.toggle("hidden");
			document.getElementById(modalID + "-backdrop").classList.toggle("hidden");
			document.getElementById(modalID).classList.toggle("flex");
			document.getElementById(modalID + "-backdrop").classList.toggle("flex");
		}
		function openAddModal() {
			toggleModal('add');
		}
	</script>
</body>

</html>
