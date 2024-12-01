<?php
// Include necessary class files

// Include the necessary class files
require_once 'classes/Database.php';
require_once 'classes/ProfAdmin.php';  // Assuming you are using the correct file for the Professor class

// Database credentials
$servername = "localhost";
$username = "root";
$password = ""; // your password if applicable
$dbname = "projetpaw";

// Instantiate the Database class with the required parameters
$db = new Database($servername, $username, $password, $dbname);

// Instantiate the Professor class and pass the Database object
$professor = new Professor($db);
$professorManager = new Professor($db);

$professors = $professorManager->getProfessors();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="dist/style.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:ital,wght@0,400;0,600;1,400;1,600&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <style>
        * {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
            font-family: "Open Sans", sans-serif;
        }
    </style>
</head>

<body class="flex min-h-screen">
    <div class=" max-md:!w-[70px] max-lg:w-60 border-r p-6 shadow-lightsh relative w-64 max-md:px-[10px] ">
        <img src="Fauget Class.png" alt="logo"
            class="-mt-14 mx-auto max-lg:w-44 max-md:-m-5 max-md:mx-auto max-md:-mb-[2px]">
        <ul
            class="relative font-semibold pt-3 max-lg:w-fit max-md:before:hidden max-md:after:hidden
        before:content-[''] before:w-[70%] before:h-1 before:absolute before:left-[15%] before:-top-5 before:bg-cblue
        after:content-[''] after:absolute after:rounded-full after:w-5 after:h-5 after:bg-white after:left-1/2 after:border-4 after:border-cblue after:-translate-x-1/2 after:-top-7">
            <li class="p-2 text-cblue rounded-md cursor-pointer duration-300 pl-13p mb-0p hover:bg-cgr max-lg:text-sm"
                title="General">
                <a href="etudiant.php"><i class="fa-solid fa-file-signature mr-2"></i><span
                        class="max-md:hidden">General</span></a>
            </li>
            <li class="p-2 text-cblue rounded-md cursor-pointer duration-300 pl-13p mb-0p hover:bg-cgr  max-lg:text-sm"
                title="Settigns">
                <a href="etudiantdemande.php"><i class="fa-regular fa-file-lines mr-2"></i>
                    <span class="max-md:hidden">Faire Demande</span> </a>
            </li>

            <li class="p-2 text-cblue rounded-md cursor-pointer duration-300 pl-13p mb-0p hover:bg-cgr   max-lg:text-sm"
                title="Ajouter Evenement">
                <a href="etudiantevent.php"><i class="fa-solid fa-school mr-2"></i>
                    <span class="max-md:hidden">Evenement</span> </a>
            </li>

            <li class="p-2 text-cblue rounded-md cursor-pointer duration-300 pl-13p mb-0p hover:bg-cgr bg-cgr  max-lg:text-sm"
                title="Email Des Profs">
                <a href="etudianemail.php"><i class="fa-solid fa-envelope mr-2"></i> <span class="max-md:hidden">Email
                        Des Profs</span>
                </a>
            </li>
        </ul>
    </div>

    <div class="bg-cgr flex-grow">
        <div class="bg-white flex justify-between py-1 pl-6 pr-10">
            <img src="avatar.avif" alt="" class="w-14">
            <a href="mailto:dzprogress1@gmail.com" class="self-center text-2xl"><i
                    class="fa-regular fa-paper-plane"></i></a>
        </div>

        <div class="p-6 pr-10">
            <span
                class="relative text-5xl font-semibold text-cblue tracking-widest font-math inline-block pb-2 mb-6 before:absolute before:content-[''] before:bottom-0 before:left-0 before:w-[40%] before:h-[5px] before:bg-[#1a4185] after:absolute after:content-[''] after:bottom-0 after:left-[40%] after:w-[60%] after:h-[5px] after:bg-white">Emails</span>

            <div class="max-h-[700px] overflow-y-auto">
                <?php if (!empty($professors)): ?>
                    <?php foreach ($professors as $professor): ?>
                        <div class="bg-white rounded-md shadow-md p-5 tracking-[1px] mb-4">
                            <h1 class="underline underline-offset-4 text-cblue uppercase text-xl font-semibold mb-5">
                                <?= htmlspecialchars($professor['prof_name']) ?>
                            </h1>
                            <p class="text-gray-900 font-medium">Module: <?= htmlspecialchars($professor['module']) ?></p>
                            <p class="text-gray-900 font-medium">Email: <?= htmlspecialchars($professor['email']) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-gray-900 font-medium">No data found</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>