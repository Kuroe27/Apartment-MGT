<?php
session_start();
include_once('../conn/Crud.php');

// Check if the user is already logged in, redirect to the main page if true
if(isset($_SESSION['tenant_id'])) {
    header("Location: ./dashboard/");
    exit();
}

// Handle login logic
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $crud = new Crud();
    $sql = "SELECT * FROM tenants WHERE email = '$email'";
    $result = $crud->read($sql);

    if($result && count($result) == 1) {
        $hashedPassword = $result[0]['password'];

        // Verify the entered password against the hashed password
        if(password_verify($password, $hashedPassword)) {
            // Valid login, set session variables and redirect to the main page
            $_SESSION['tenant_id'] = $result[0]['id'];
            header("Location: ./dashboard/");
            exit();
        }
    }

    // Invalid login, display an error message
    $error_message = "Invalid email or password.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login Page</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1 class="page-header text-center">Tenants Login</h1>
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
                <?php
                if(isset($error_message)) {
                    echo '<div class="alert alert-danger text-center">'.$error_message.'</div>';
                }
                ?>

                <form method="post" action="">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>