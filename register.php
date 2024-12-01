<?php
// Initialize variables
$first_name = "";
$last_name = "";
$id = "";
$email = "";
$password = "";

$first_name_error = "";
$last_name_error = "";
$id_error = "";
$email_error = "";
$password_error = "";

$error = false;

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and sanitize form data
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $id = htmlspecialchars(trim($_POST['id']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = trim($_POST['password']);

    // Validate data
    if (empty($first_name)) {
        $first_name_error = "First name is required";
        $error = true;
    }
    if (empty($last_name)) {
        $last_name_error = "Last name is required";
        $error = true;
    }
    if (empty($id)) {
        $id_error = "Matricule is required";
        $error = true;
    }
    if (empty($email)) {
        $email_error = "Email is required";
        $error = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = "Invalid email format";
        $error = true;
    }
    if (empty($password)) {
        $password_error = "Password is required";
        $error = true;
    }

    // If no validation errors, proceed to insert into database
    if (!$error) {
        // Database connection details
        $db_server = "localhost";
        $db_name = "projetpaw";
        $db_user = "root";
        $db_password = "";

        // Connect to the database
        $connection = mysqli_connect($db_server, $db_user, $db_password, $db_name);
        if (!$connection) {
            die("Could not connect: " . mysqli_connect_error());
        }

        // Check if email or ID already exists
        $check_query = $connection->prepare("SELECT id FROM users WHERE email = ? OR id = ?");
        $check_query->bind_param("ss", $email, $id);
        $check_query->execute();
        $check_query->store_result();

        if ($check_query->num_rows > 0) {
            $email_error = "Email or ID already exists";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // SQL query to insert data using prepared statements
            $stmt = $connection->prepare("INSERT INTO users (first_name, last_name, id, email, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $first_name, $last_name, $id, $email, $hashed_password);

            // Execute the query
            if ($stmt->execute()) {
                echo "<script>alert('Registration successful!');</script>";
                // Reset form fields after successful insertion
                $first_name = $last_name = $id = $email = $password = "";
            } else {
                echo "<script>alert('Error: Unable to register. Please try again later.');</script>";
            }

            // Close the statement
            $stmt->close();
        }

        // Close the database connection
        $check_query->close();
        mysqli_close($connection);
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
    <link href="dist/style.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:ital,wght@0,400;0,600;1,400;1,600&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>Register</title>
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

        input:not(input[type="submit"]):focus {
            box-shadow: 0px 0px 5px 0px #005cff;
            border-color: #001740;
        }

        input[type="submit"] {
            background-color: #001740;

        }

        input[type="submit"]:hover {
            opacity: 0.87;
        }

        label::before {
            content: "\f2c2";
            font-family: "Font awesome 5 free";
            font-weight: 800;
            position: absolute;
            left: 10px;
            bottom: -35px;

        }

        label[for="nm"]::before {
            content: "\f007";

        }

        label[for="pas"]::before {
            content: "\f023";
        }

        label[for="gm"]::before {
            content: "\f0e0";
        }

        a {
            text-decoration-style: dashed !important;
            text-underline-offset: 3px;
            color: #001740 !important;
        }

        div {
            border-color: #001740;
            background-color: white;
            opacity: 0.97;
        }

        video {
            position: absolute;
            width: 100%;
            height: 100% !important;
            object-fit: cover;
            z-index: -2;
        }

        body::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: -1;
            background-color: #00174033;
        }

        p:first-of-type:before,
        p:first-of-type:after {
            content: "";
            position: absolute;
            height: 2px;
            width: 22%;
            background-color: gray;
            left: 7px;
            top: 50%;
            transform: translateY(-50%);
        }

        p:first-of-type:after {
            left: unset;
            right: 7px;
        }
    </style>
</head>

<body class="flex justify-center items-center min-h-screen sm:h-screen relative">
    <video src="8567118-uhd_4096_2160_25fps.mp4" type="video/mp4" autoplay loop muted></video>

    <div class="border-4 flex flex-col items-center rounded-lg pb-2 m-2.5 sm:h-90vh">
        <img src="Fauget Class.png" alt="" class="w-96 rounded-2xl object-cover sm:h-28%">
        <p class="-mt-8 mb-9 relative w-full text-center sm:mb-5p sm:mt-4p">Create Your Account</p>
        <form action="" method="POST" class="flex flex-col">
            <label for="first_name" class="text-xl font-semibold relative">First Name :</label>
            <input type="text" name="first_name" id="first_name" class="p-1 pl-9 mb-6p w-72 border-solid border-2 rounded-md outline-none"
                placeholder="Enter Your First Name" value="<?= htmlspecialchars($first_name) ?>">
            <span style="color:red;"><?= $first_name_error ?></span>

            <label for="last_name" class="text-xl font-semibold relative">Last Name :</label>
            <input type="text" name="last_name" id="last_name" class="p-1 pl-9 mb-6p w-72 border-solid border-2 rounded-md outline-none"
                placeholder="Enter Your Last Name" value="<?= htmlspecialchars($last_name) ?>">
            <span style="color:red;"><?= $last_name_error ?></span>

            <label for="password" class="text-xl font-semibold relative">Password :</label>
            <input type="password" name="password" id="password"
                class="p-1 pl-9 mb-6p w-72 border-solid border-2 rounded-md outline-none"
                placeholder="Enter Your Password">
            <span style="color:red;"><?= $password_error ?></span>

            <label for="id" class="text-xl font-semibold relative">Matricule :</label>
            <input type="text" name="id" id="id"
                class="p-1 pl-9 mb-6p w-72 border-solid border-2 rounded-md outline-none"
                placeholder="Enter Your Matricule" value="<?= htmlspecialchars($id) ?>">
            <span style="color:red;"><?= $id_error ?></span>

            <label for="email" class="text-xl font-semibold relative">Email :</label>
            <input type="email" name="email" id="email"
                class="p-1 pl-9 mb-6p w-72 border-solid border-2 rounded-md outline-none"
                placeholder="Enter Your Email" value="<?= htmlspecialchars($email) ?>">
            <span style="color:red;"><?= $email_error ?></span>

            <input type="submit" value="Sign Up"
                class="p-1 w-72 border-solid border-2 rounded-md cursor-pointer font-extrabold mt-7p mb-7p text-white">
        </form>
        <p class="font-semibold">Need Help? <a href="mailto:dzprogress1@gmail.com" class="underline font-bold">Contact
                Us</a></p>
    </div>

</body>

</html>

   