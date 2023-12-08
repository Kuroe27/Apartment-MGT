<?php
session_start();
include_once('../conn/Crud.php');

$crud = new Crud();

if(isset($_POST['add'])) {
    $invoice_id = $crud->escape_string($_POST['invoice_id']);
    $amount_paid = $crud->escape_string($_POST['amount_paid']);
    $payment_date = $crud->escape_string($_POST['payment_date']);

    // Fetch the tenant ID based on the selected invoice ID
    $sqlFetchTenantId = "SELECT tenant_id FROM Invoices WHERE id = '$invoice_id'";
    $result = $crud->read($sqlFetchTenantId);

    if($result && count($result) > 0) {
        $tenant_id = $result[0]['tenant_id'];

        $sql = "INSERT INTO `Payments`(`tenant_id`, `invoice_id`, `amount_paid`, `payment_date`)
                VALUES ('$tenant_id', '$invoice_id', '$amount_paid', '$payment_date')";

        if($crud->execute($sql)) {
            $_SESSION['message'] = 'Payment added successfully';
        } else {
            $_SESSION['message'] = 'Cannot add payment';
        }
    } else {
        $_SESSION['message'] = 'Unable to fetch tenant information for the selected invoice';
    }

    header('location: ../admin/dashboard/payments.php');

} elseif(isset($_POST['edit'])) {
    $id = $crud->escape_string($_POST['id']);
    $tenant_id = $crud->escape_string($_POST['tenant_id']);
    $invoice_id = $crud->escape_string($_POST['invoice_id']);
    $amount_paid = $crud->escape_string($_POST['amount_paid']);
    $payment_date = $crud->escape_string($_POST['payment_date']);

    $sql = "UPDATE Payments SET 
            tenant_id = '$tenant_id', 
            invoice_id = '$invoice_id', 
            amount_paid = '$amount_paid', 
            payment_date = '$payment_date' 
            WHERE id = '$id'";

    if($crud->execute($sql)) {
        $_SESSION['message'] = 'Payment updated successfully';
    } else {
        $_SESSION['message'] = 'Cannot update payment';
    }

    header('location: ../admin/dashboard/payments.php');
} elseif(isset($_POST['delete'])) {
    $id = $crud->escape_string($_POST['id']);
    $sql = "DELETE FROM Payments WHERE id = '$id'";

    if($crud->execute($sql)) {
        $_SESSION['message'] = 'Payment deleted successfully';
    } else {
        $_SESSION['message'] = 'Cannot delete payment';
    }

    header('location: ../admin/dashboard/payments.php');
} else {
    $_SESSION['message'] = 'Invalid action';
    header('location: ');
}
?>