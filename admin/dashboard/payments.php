<?php
session_start();
include_once('../../conn/Crud.php');

$crud = new Crud();

function getTenantOptions($crud, $selectedTenantId = null) {
    $sql = "SELECT id, CONCAT(first_name, ' ', last_name) AS tenant_name FROM tenants";
    $tenants = $crud->read($sql);

    $options = '<option value="">Select Tenant</option>';
    foreach ($tenants as $tenant) {
        $selected = ($selectedTenantId == $tenant['id']) ? 'selected' : '';
        $options .= '<option value="' . $tenant['id'] . '" ' . $selected . '>' . $tenant['tenant_name'] . '</option>';
    }

    return $options;
}

function getInvoiceOptions($crud, $selectedInvoiceId = null) {
    $sql = "SELECT id FROM invoices";
    $invoices = $crud->read($sql);

    $options = '<option value="">Select Invoice</option>';
    foreach ($invoices as $invoice) {
        $selected = ($selectedInvoiceId == $invoice['id']) ? 'selected' : '';
        $options .= '<option value="' . $invoice['id'] . '" ' . $selected . '>' . $invoice['id'] . '</option>';
    }

    return $options;
}

$sql = "SELECT p.*, CONCAT(t.first_name, ' ', t.last_name) AS tenant_name, i.id AS invoice_id 
        FROM payments p 
        LEFT JOIN tenants t ON p.tenant_id = t.id 
        LEFT JOIN invoices i ON p.invoice_id = i.id";
$result = $crud->read($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Payments</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1 class="page-header text-center">Payments</h1>
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
                            <th>Invoice ID</th>
                            <th>Amount Paid</th>
                            <th>Payment Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($result as $row): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['tenant_name']; ?></td>
                            <td><?php echo $row['invoice_id']; ?></td>
                            <td><?php echo $row['amount_paid']; ?></td>
                            <td><?php echo $row['payment_date']; ?></td>
                            <td>
                                <a href="#edit<?php echo $row['id']; ?>" data-toggle="modal"
                                    class="btn btn-success">Edit</a> |
                                <a href="#delete<?php echo $row['id']; ?>" data-toggle="modal"
                                    class="btn btn-danger">Delete</a>
                            </td>

                            <?php
                                $modalId = 'edit'.$row['id'];
                                $modalTitle = 'Edit Payment';
                                $formAction = '../../actions/paymentsAction.php?id='.$row['id'];
                                $submitBtnName = 'edit';
                                $submitBtnText = 'Save';
                                $formFields = [
                                    ['label' => 'ID', 'name' => 'id', 'type' => 'text', 'value' => $row['id']],
                                    ['label' => 'Tenant', 'name' => 'tenant_id', 'type' => 'select', 'options' => getTenantOptions($crud, $row['tenant_id'])],
                                    ['label' => 'Invoice ID', 'name' => 'invoice_id', 'type' => 'select', 'options' => getInvoiceOptions($crud, $row['invoice_id'])],
                                    ['label' => 'Amount Paid', 'name' => 'amount_paid', 'type' => 'text', 'value' => $row['amount_paid']],
                                    ['label' => 'Payment Date', 'name' => 'payment_date', 'type' => 'date', 'value' => $row['payment_date']],
                                ];
                                include('../../components/modal.php');


                                $modalId = 'delete'.$row['id'];
                                $modalTitle = 'Delete Payment';
                                $formAction = '../../actions/paymentsAction.php?id='.$row['id'];
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
    $modalTitle = 'Add Payment';
    $formAction = '../../actions/paymentsAction.php';
    $submitBtnName = 'add';
    $submitBtnText = 'Save';
    $formFields = [
        ['label' => 'Tenant', 'name' => 'tenant_id', 'type' => 'select', 'options' => getTenantOptions($crud)],
        ['label' => 'Invoice ID', 'name' => 'invoice_id', 'type' => 'select', 'options' => getInvoiceOptions($crud)],
        ['label' => 'Amount Paid', 'name' => 'amount_paid', 'type' => 'text'],
        ['label' => 'Payment Date', 'name' => 'payment_date', 'type' => 'date'],
    ];
    include('../../components/modal.php');
    ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>