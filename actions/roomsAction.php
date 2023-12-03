<?php
session_start();
include_once('../conn/Crud.php');

$crud = new Crud();

if(isset($_POST['add'])) {
    $rent = $crud->escape_string($_POST['rent']);
    $status = $crud->escape_string($_POST['status']);

    $sql = "INSERT INTO `rooms`(`rent`, `status`) VALUES ('$rent','$status')";

    if($crud->execute($sql)) {
        $_SESSION['message'] = 'Room added successfully';
    } else {
        $_SESSION['message'] = 'Cannot add room';
    }

    header('location: ../admin/dashboard/rooms.php');
} elseif(isset($_POST['edit'])) {
    $id = $crud->escape_string($_POST['id']);
   $rent = $crud->escape_string($_POST['rent']);
    $status = $crud->escape_string($_POST['status']);

    $sql = "UPDATE rooms SET rent = '$rent', status = '$status' WHERE id = '$id'";

    if($crud->execute($sql)) {
        $_SESSION['message'] = 'Room updated successfully';
    } else {
        $_SESSION['message'] = 'Cannot update room';
    }

    header('location: ../admin/dashboard/rooms.php');
} elseif(isset($_POST['delete'])) {
    $id = $crud->escape_string($_POST['id']);
    $sql = "DELETE FROM rooms WHERE id = '$id'";

    if($crud->execute($sql)) {
        $_SESSION['message'] = 'Room deleted successfully';
    } else {
        $_SESSION['message'] = 'Cannot delete room';
    }

    header('location: ../admin/dashboard/rooms.php');
} else {
    $_SESSION['message'] = 'Invalid action';
    header('location: ');
}
?>