<?php
session_start();
include_once('../conn/Crud.php');

$crud = new Crud();

if(isset($_POST['add'])) {
    $first_name = $crud->escape_string($_POST['first_name']);
    $last_name = $crud->escape_string($_POST['last_name']);
    $email = $crud->escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO Admin (first_name, last_name, email, password) VALUES ('$first_name', '$last_name', '$email', '$password')";

    if($crud->execute($sql)) {
        $_SESSION['message'] = 'Admin added successfully';
    } else {
        $_SESSION['message'] = 'Cannot add admin';
    }

    header('location: ../admin/dashboard/admin.php');
} elseif(isset($_POST['edit'])) {
    $id = $crud->escape_string($_POST['id']);
    $first_name = $crud->escape_string($_POST['first_name']);
    $last_name = $crud->escape_string($_POST['last_name']);
    $email = $crud->escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "UPDATE Admin SET first_name = '$first_name', last_name = '$last_name', email = '$email', password = '$password' WHERE id = '$id'";

    if($crud->execute($sql)) {
        $_SESSION['message'] = 'Admin updated successfully';
    } else {
        $_SESSION['message'] = 'Cannot update admin';
    }

    header('location: ../admin/dashboard/admin.php');
} elseif(isset($_POST['delete'])) {
    $id = $crud->escape_string($_POST['id']);

    $sql = "DELETE FROM Admin WHERE id = '$id'";

    if($crud->execute($sql)) {
        $_SESSION['message'] = 'Admin deleted successfully';
    } else {
        $_SESSION['message'] = 'Cannot delete admin';
    }

    header('location: ../admin/dashboard/admin.php');
} else {
    $_SESSION['message'] = 'Invalid action';
    header('location: ');
}
?>