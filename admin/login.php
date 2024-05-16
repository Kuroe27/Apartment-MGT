<?php
session_start();
include_once ('../conn/Crud.php');

if (isset($_SESSION['admin_id'])) {
    header("Location: ./dashboard/");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $crud = new Crud();
    $sql = "SELECT * FROM Admin WHERE email = '$email'";
    $result = $crud->read($sql);

    if ($result && count($result) == 1) {
        $storedPassword = $result[0]['password'];

        if ($password == $storedPassword) {
            $_SESSION['admin_id'] = $result[0]['id'];
            header("Location: ./dashboard/");
            exit();
        }
    }

    $error_message = "Invalid email or password.";
}
?>

<html>

<head>
    <link href="../styles/output.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" />

</head>

<body class="min-h-screen  text-gray-900 flex justify-center bg-white">

    <div class="w-full m-0 sm:m-20  flex justify-center flex-1">
        <div class="w-full flex-col flex justify-center items-center p-6 sm:p-12">

            <div class="mt-12 flex flex-col items-center">
                <h1 class="text-2xl xl:text-3xl font-extrabold mb-4">
                    Login up with e-mail
                </h1>





                <div class="mx-auto max-w-xs">
                    <?php
                    if (isset($error_message)) {
                        echo '<div class="mb-4 bg-red-500 text-xl p-4 border-red-950 border text-center text-white">' . $error_message . '</div>';
                    }
                    ?>

                    <form method="post" action="">
                        <div class="form-group">
                            <input
                                class="w-full px-8 py-4 rounded-lg font-medium  border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white"
                                type="email" placeholder="Email" type="text" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <input
                                class="w-full px-8 py-4 rounded-lg font-medium  border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5"
                                type="password" placeholder="Password" class="form-control" name="password" required>
                        </div>
                        <button type="submit"
                            class="mt-5 tracking-wide font-semibold bg-pallete-700 text-gray-100 w-full py-4 rounded-lg hover:bg-pallete-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">

                            <span>
                                Login
                            </span>
                        </button>
                        <p class="mt-6 text-xs text-gray-600 text-center">
                            I consent to adhere to the Terms of Service and Privacy Policy of Apartment Management
                            System.
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="flex-1 bg-pallete-300 text-center hidden lg:flex">
        <div class="m-12 xl:m-16 w-full bg-contain bg-center bg-no-repeat"
            style="background-image: url('../images/bgs.svg');">
        </div>
    </div>
    </div>

</body>

</html>