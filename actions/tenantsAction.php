<?php
session_start();
include_once('../conn/Crud.php');

$crud = new Crud();

if(isset($_POST['add'])) {
    $first_name = $crud->escape_string($_POST['first_name']);
    $last_name = $crud->escape_string($_POST['last_name']);
    $email = $crud->escape_string($_POST['email']);
    $phone_number = $crud->escape_string($_POST['phone_number']);
    $move_in_date = $crud->escape_string($_POST['move_in_date']);
    $balance = $crud->escape_string($_POST['balance']);
    $room_id = $crud->escape_string($_POST['room_id']);
    $monthly_rate = $crud->escape_string($_POST['monthly_rate']);
    $password = $crud->escape_string($_POST['password']);

    $sql = "INSERT INTO `Tenants`(`first_name`, `last_name`, `email`, `phone_number`, `move_in_date`, `balance`, `room_id`, `monthly_rate`, `password`)
            VALUES ('$first_name', '$last_name', '$email', '$phone_number', '$move_in_date', '$balance', '$room_id', '$monthly_rate', '$password')";

    if($crud->execute($sql)) {
        $_SESSION['message'] = 'Tenant added successfully';
    } else {
        $_SESSION['message'] = 'Cannot add tenant';
    }

    header('location: ../admin/dashboard/tenants.php');
} elseif(isset($_POST['edit'])) {
    $id = $crud->escape_string($_POST['id']);
    $first_name = $crud->escape_string($_POST['first_name']);
    $last_name = $crud->escape_string($_POST['last_name']);
    $email = $crud->escape_string($_POST['email']);
    $phone_number = $crud->escape_string($_POST['phone_number']);
    $move_in_date = $crud->escape_string($_POST['move_in_date']);
    $balance = $crud->escape_string($_POST['balance']);
    $room_id = $crud->escape_string($_POST['room_id']);
    $monthly_rate = $crud->escape_string($_POST['monthly_rate']);
    $password = $crud->escape_string($_POST['password']);

    $sql = "UPDATE Tenants SET 
            first_name = '$first_name', 
            last_name = '$last_name', 
            email = '$email', 
            phone_number = '$phone_number', 
            move_in_date = '$move_in_date', 
            balance = '$balance', 
            room_id = '$room_id', 
            monthly_rate = '$monthly_rate', 
            password = '$password' 
            WHERE id = '$id'";

    if($crud->execute($sql)) {
        $_SESSION['message'] = 'Tenant updated successfully';
    } else {
        $_SESSION['message'] = 'Cannot update tenant';
    }

    header('location: ../admin/dashboard/tenants.php');
} elseif(isset($_POST['delete'])) {
    $id = $crud->escape_string($_POST['id']);
    $sql = "DELETE FROM Tenants WHERE id = '$id'";

    if($crud->execute($sql)) {
        $_SESSION['message'] = 'Tenant deleted successfully';
    } else {
        $_SESSION['message'] = 'Cannot delete tenant';
    }

    header('location: ../admin/dashboard/tenants.php');
} else {
    $_SESSION['message'] = 'Invalid action';
    header('location: ');
}
?>