<?php
session_start();
include_once('../../conn/Crud.php');

$crud = new Crud();
$sql = "SELECT t.*, r.rent, r.status AS room_status FROM Tenants t LEFT JOIN rooms r ON t.room_id = r.id";
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
                            <th>Phone Number</th>
                            <th>Move In Date</th>
                            <th>Balance</th>
                            <th>Room ID</th>
                            <th>Monthly Rate</th>
                            <th>Password</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($result as $row): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['first_name']; ?></td>
                            <td><?php echo $row['last_name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['phone_number']; ?></td>
                            <td><?php echo $row['move_in_date']; ?></td>
                            <td><?php echo $row['balance']; ?></td>
                            <td><?php echo $row['room_id']; ?></td>
                            <td><?php echo $row['monthly_rate']; ?></td>
                            <td><?php echo $row['password']; ?></td>

                            <td>
                                <a href="#edit<?php echo $row['id']; ?>" data-toggle="modal"
                                    class="btn btn-success">Edit</a> |
                                <a href="#delete<?php echo $row['id']; ?>" data-toggle="modal"
                                    class="btn btn-danger">Delete</a>
                            </td>

                            <?php
								// Edit modal
								$modalId = 'edit'.$row['id'];
								$modalTitle = 'Edit Tenant';
								$formAction = '../../actions/tenantsAction.php?id='.$row['id'];
								$submitBtnName = 'edit';
								$submitBtnText = 'Save';
								$formFields = [
									['label' => 'ID', 'name' => 'id', 'type' => 'text', 'value' => $row['id']],
									['label' => 'First Name', 'name' => 'first_name', 'type' => 'text', 'value' => $row['first_name']],
									['label' => 'Last Name', 'name' => 'last_name', 'type' => 'text', 'value' => $row['last_name']],
									['label' => 'Email', 'name' => 'email', 'type' => 'text', 'value' => $row['email']],
									['label' => 'Phone Number', 'name' => 'phone_number', 'type' => 'text', 'value' => $row['phone_number']],
									['label' => 'Move In Date', 'name' => 'move_in_date', 'type' => 'date', 'value' => $row['move_in_date']],
									['label' => 'Balance', 'name' => 'balance', 'type' => 'text', 'value' => $row['balance']],
									['label' => 'Room ID', 'name' => 'room_id', 'type' => 'select', 'options' => getRoomOptions($crud, $row['room_id'])],
									['label' => 'Monthly Rate', 'name' => 'monthly_rate', 'type' => 'text', 'value' => $row['monthly_rate']],
									['label' => 'Password', 'name' => 'password', 'type' => 'text', 'value' => $row['password']]
								];
								include('../../components/modal.php');

								// Delete modal
								$modalId = 'delete'.$row['id'];
								$modalTitle = 'Delete Tenant';
								$formAction = '../../actions/tenantsAction.php?id='.$row['id'];
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
$modalTitle = 'Add Tenant';
$formAction = '../../actions/tenantsAction.php';
$submitBtnName = 'add';
$submitBtnText = 'Save';
$formFields = [
    ['label' => 'First Name', 'name' => 'first_name', 'type' => 'text'],
    ['label' => 'Last Name', 'name' => 'last_name', 'type' => 'text'],
    ['label' => 'Email', 'name' => 'email', 'type' => 'text'],
    ['label' => 'Phone Number', 'name' => 'phone_number', 'type' => 'text'],
    ['label' => 'Move In Date', 'name' => 'move_in_date', 'type' => 'date'],
    ['label' => 'Balance', 'name' => 'balance', 'type' => 'text'],
    ['label' => 'Room ID', 'name' => 'room_id', 'type' => 'select', 'options' => getRoomOptions($crud)],
    ['label' => 'Monthly Rate', 'name' => 'monthly_rate', 'type' => 'text'],
    ['label' => 'Password', 'name' => 'password', 'type' => 'text']
];
include('../../components/modal.php');

// Function to get room options
function getRoomOptions($crud, $selectedRoomId = null) {
    $sql = "SELECT id FROM rooms";
    $rooms = $crud->read($sql);

    $options = '<option value="">Select Room</option>';
    foreach ($rooms as $room) {
        $selected = ($selectedRoomId == $room['id']) ? 'selected' : '';
        $options .= '<option value="' . $room['id'] . '" ' . $selected . '>' . $room['id'] . '</option>';
    }

    return $options;
}

	?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>