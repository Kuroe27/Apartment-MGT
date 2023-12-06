<?php
session_start();
include_once('../../conn/Crud.php');

$crud = new Crud();

function getTenantOptions($crud, $selectedTenantId = null) {
    $sql = "SELECT id, CONCAT(first_name, ' ', last_name) AS tenant_name FROM tenants";
    $tenants = $crud->read($sql);

    $options = '<option value="">Select Tenant</option>';
    foreach($tenants as $tenant) {
        $selected = ($selectedTenantId == $tenant['id']) ? 'selected' : '';
        $options .= '<option value="'.$tenant['id'].'" '.$selected.'>'.$tenant['tenant_name'].'</option>';
    }

    return $options;
}

$sql = "SELECT i.*, CONCAT(t.first_name, ' ', t.last_name) AS tenant_name FROM invoices i LEFT JOIN tenants t ON i.tenant_id = t.id";
$result = $crud->read($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoices</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1 class="page-header text-center">Invoices</h1>
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
                            <th>Tenant</th>
                            <th>Date Created</th>
                            <th>Due Date</th>
                            <th>Current Bill</th>
                            <th>Previous Bill</th>
                            <th>Total Amount</th>
                            <th>Status</th>
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
                                    <?php echo $row['tenant_name']; ?>
                                </td>
                                <td>
                                    <?php echo $row['date_created']; ?>
                                </td>
                                <td>
                                    <?php echo $row['due_date']; ?>
                                </td>
                                <td>
                                    <?php echo $row['current_bill']; ?>
                                </td>
                                <td>
                                    <?php echo $row['prev_bill']; ?>
                                </td>
                                <td>
                                    <?php echo $row['total_amount']; ?>
                                </td>
                                <td>
                                    <?php echo $row['status']; ?>
                                </td>
                                <td>
                                    <a href="#edit<?php echo $row['id']; ?>" data-toggle="modal"
                                        class="btn btn-success">Edit</a> |
                                    <a href="#delete<?php echo $row['id']; ?>" data-toggle="modal"
                                        class="btn btn-danger">Delete</a>
                                </td>

                                <?php
                                $modalId = 'edit'.$row['id'];
                                $modalTitle = 'Edit Invoice';
                                $formAction = '../../actions/invoicesAction.php?id='.$row['id'];
                                $submitBtnName = 'edit';
                                $submitBtnText = 'Save';
                                $formFields = [
                                    ['label' => 'ID', 'name' => 'id', 'type' => 'text', 'value' => $row['id']],
                                    ['label' => 'Tenant', 'name' => 'tenant_id', 'type' => 'select', 'options' => getTenantOptions($crud, $row['tenant_id'])],
                                    ['label' => 'Date Created', 'name' => 'date_created', 'type' => 'date', 'value' => $row['date_created']],
                                    ['label' => 'Due Date', 'name' => 'due_date', 'type' => 'date', 'value' => $row['due_date']],
                                    ['label' => 'Total Amount', 'name' => 'total_amount', 'type' => 'text', 'value' => $row['total_amount']],
                                    ['label' => 'Status', 'name' => 'status', 'type' => 'text', 'value' => $row['status']]
                                ];
                                include('../../components/modal.php');

                                $modalId = 'delete'.$row['id'];
                                $modalTitle = 'Delete Invoice';
                                $formAction = '../../actions/invoicesAction.php?id='.$row['id'];
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
    $modalId = 'add';
    $modalTitle = 'Add Invoice';
    $formAction = '../../actions/invoicesAction.php';
    $submitBtnName = 'add';
    $submitBtnText = 'Save';
    $formFields = [
        ['label' => 'Tenant', 'name' => 'tenant_id', 'type' => 'select', 'options' => getTenantOptions($crud)],
        ['label' => 'Date Created', 'name' => 'date_created', 'type' => 'date'],
        ['label' => 'Due Date', 'name' => 'due_date', 'type' => 'date'],
        ['label' => 'Total Amount', 'name' => 'current_bill', 'type' => 'text'],
    ];
    include('../../components/modal.php');
    ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>