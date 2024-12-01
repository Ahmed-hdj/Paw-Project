<?php
session_start();

// Include class files with relative paths
include './classes/Database.php';
include  './classes/User.php';

$db_server = "localhost";
$db_name = "projetpaw";
$db_user = "root";
$db_password = "";

// Create Database object and pass connection parameters
$db = new Database($db_server, $db_user, $db_password, $db_name);

// Proceed with user authentication
$user = new User($db);

$error_message = "";
$matricule = $password = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matricule = trim($_POST['matricule']);
    $password = trim($_POST['password']);

    if (empty($matricule)) {
        $error_message = "Matricule is required.";
    } elseif (empty($password)) {
        $error_message = "Password is required.";
    } else {
        $result = $user->authenticate($matricule, $password);
        if ($result === true) {
            // Redirect based on user role
            if ($_SESSION['role'] === 'student') {
                header("Location: etudiant.php");
            } elseif ($_SESSION['role'] === 'admin') {
                header("Location: admin.php");
            } else {
                $error_message = "Invalid role.";
            }
            exit;
        } else {
            $error_message = $result;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:ital,wght@0,400;0,600;1,400;1,600&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>

    <title>Progress</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: "Open Sans", sans-serif;
        }

        input {
            border-color: #3f3d3d;
            caret-color: #001740;
        }

        label {
            margin-bottom: 2px;
            color: #555353;
        }

        body>div:first-child::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: #001740a6;
        }

        label[for="mat"]::before,
        label[for="password"]::before {
            content: "\f2c2";
            font-family: "Font awesome 5 free";
            font-weight: 800;
            position: absolute;
            left: 10px;
            bottom: -35px;
        }

        label[for="password"]::before {
            content: "\f023";
        }

        input[type="submit"] {
            background-color: #001740;
        }

        input[type="submit"]:hover {
            opacity: 0.87;
        }

        form p {
            text-decoration-style: dashed;
            text-underline-offset: 5px;
            color: #001740;
        }

        a {
            color: #001740 !important;
            text-underline-offset: 5px;
            text-decoration-style: dashed !important;
            font-weight: 800;
        }

        input:not(input[type="submit"]):focus {
            box-shadow: 0px 0px 5px 0px #005cff;
            border-color: #001740;
        }

        #k {
            font-weight: 600;
            margin-top: 13px;
            color: black;
        }
    </style>
</head>

<body class="min-h-screen flex justify-center ">

    <div class="w-3/6 relative">
        <img src="https://images.pexels.com/photos/207684/pexels-photo-207684.jpeg?cs=srgb&dl=pexels-pixabay-207684.jpg&fm=jpg"
            alt="pexels" class=" object-cover h-full ">

        <div class="absolute top-1/4 left-8 z-10 text-white max-w-xs">
            <h1 class="text-4xl font-bold">Welcome Back!</h1>
            <p class="mt-2 text-lg">Access your account and join the University Realm.</p>
        </div>

    </div>

    <div class="w-3/6 flex  flex-col pt-32 flex-wrap items-center relative m-2.5">
        <img src="Fauget Class.png" alt="" class="w-96">
        <form method="POST" action="" class="flex flex-col relative">

            <label for="mat" class="text-xl font-semibold relative">Matricule :</label>
            <input type="text" id="mat" name="matricule" class="p-1 pl-9 mb-5 w-72 border-solid border-2 rounded-md outline-none " value="<?= htmlspecialchars($matricule) ?>">
            <label for="password" class="text-xl font-semibold relative">Password :</label>
            <input type="password" id="password" name="password" class="p-1 pl-9  w-72 border-solid border-2 rounded-md outline-none ">
            <div class="error text-red-500 text-sm"><?= htmlspecialchars($error_message) ?></div>
            <p class="mb-16 underline self-end text-sm font-extrabold mt-1 cursor-pointer">Where can I find My Password?</p>
            <input type="submit" value="Sign in" class="p-1 w-72 border-solid border-2 rounded-md cursor-pointer font-extrabold text-white">
        </form>
        <p id="k">Don't Have Account? <a href="register.php" class="underline">Create One!</a> </p>
    </div>
</body>

</html>
