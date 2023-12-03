<?php
session_start();
include_once('../../conn/Crud.php');

$crud = new Crud();
$sql = "SELECT * FROM Admin";
$result = $crud->read($sql);
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>PHP OOP </title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
	<div class="container">
		<h1 class="page-header text-center">PHP CRUD using Object Oriented Programming</h1>
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<?php
				if(isset($_SESSION['message'])) {
					echo '<div class="alert alert-info text-center">'.$_SESSION['message'].'</div>';
					unset($_SESSION['message']);
				}
				?>

				<a href="#add" data-toggle="modal" class="btn btn-primary">Add New</a><br><br>
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>ID</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Email</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($result as $row): ?>
							<tr>
								<td>
									<?php echo $row['id']; ?>
								</td>
								<td>
									<?php echo $row['first_name']; ?>
								</td>
								<td>
									<?php echo $row['last_name']; ?>
								</td>
								<td>
									<?php echo $row['email']; ?>
								</td>
								<td>
									<a href="#edit<?php echo $row['id']; ?>" data-toggle="modal"
										class="btn btn-success">Edit</a> |
									<a href="#delete<?php echo $row['id']; ?>" data-toggle="modal"
										class="btn btn-danger">Delete</a>
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
	</div>

	<?php
	// Add modal
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

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>