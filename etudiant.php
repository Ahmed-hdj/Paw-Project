<?php
// Start session
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: index.php?error=not_logged_in");
    exit();
}

// Autoload required classes
require_once 'classes/Database.php';
require_once 'classes/Demand.php';

// Initialize database and manager classes
try {
    $db = new Database("localhost", "root", "", "projetpaw");
    $studentManager = new Demand($db);
} catch (Exception $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get the logged-in student's ID
$student_id = $_SESSION['id'];

try {
    // Fetch the student's profile
    $profile = $studentManager->getProfile($student_id);
    if (!$profile) {
        die("User not found");
    }

    // Fetch the student's demands
    $demands = $studentManager->getDemands($student_id);
} catch (Exception $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progress</title>
    <link href="dist/style.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:ital,wght@0,400;0,600;1,400;1,600&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

</head>

<body class="flex min-h-screen">
    <!-- Sidebar -->
    <div class=" max-md:!w-[70px] max-lg:w-60 border-r p-6 shadow-lightsh relative w-64 max-md:px-[10px] ">
        <img src="Fauget Class.png" alt="logo"
            class="-mt-14 mx-auto max-lg:w-44 max-md:-m-5 max-md:mx-auto max-md:-mb-[2px]">
        <ul
            class="relative font-semibold pt-3 max-lg:w-fit max-md:before:hidden max-md:after:hidden
        before:content-[''] before:w-[70%] before:h-1 before:absolute before:left-[15%] before:-top-5 before:bg-cblue
        after:content-[''] after:absolute after:rounded-full after:w-5 after:h-5 after:bg-white after:left-1/2 after:border-4 after:border-cblue after:-translate-x-1/2 after:-top-7">
            <li class="p-2 text-cblue rounded-md cursor-pointer duration-300 pl-13p mb-0p hover:bg-cgr bg-cgr max-lg:text-sm"
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

            <li class="p-2 text-cblue rounded-md cursor-pointer duration-300 pl-13p mb-0p hover:bg-cgr  max-lg:text-sm"
                title="Email Des Profs">
                <a href="etudianemail.php"><i class="fa-solid fa-envelope mr-2"></i> <span class="max-md:hidden">Email
                        Des Profs</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- Main Content -->
    <div class="bg-cgr flex-grow">
        <!-- Header -->
        <div class="bg-white flex justify-between py-1 pl-6 pr-10">
            <div class="flex gap-3">
                <img src="avatar.avif" alt="" class="w-14">
                <button class="text-white bg-red-800 rounded-md self-center p-[7px] font-semibold">Log Out</button>
            </div>
            <a href="mailto:dzprogress1@gmail.com" class="self-center text-2xl"><i
                    class="fa-regular fa-paper-plane"></i></a>
        </div>

        <!-- Profile Section -->
        <div class="p-6 pr-10">
            <span
                class="relative text-5xl font-semibold text-cblue tracking-widest font-math inline-block pb-2 mb-6 before:absolute before:content-[''] before:bottom-0 before:left-0 before:w-[40%] before:h-[5px] before:bg-[#1a4185] after:absolute after:content-[''] after:bottom-0 after:left-[40%] after:w-[60%] after:h-[5px] after:bg-white">Profile</span>
            <div
                class="max-w-md  bg-white border border-gray-200 rounded-lg shadow-lg relative before:content-[''] before:absolute before:bottom-0 before:h-1 before:bg-sp before:w-full before:rounded-lg">
                <div class="relative h-32 bg-cover bg-center rounded-t-lg"
                    style="background-image: url('https://www.bestdegreeprograms.org/wp-content/uploads/2023/05/shutterstock_335846444-scaled.jpg');">
                    <div class="absolute inset-x-0 -bottom-10 flex justify-center">
                        <img src="avatar.avif" alt="Avatar" class="w-24 h-24 rounded-full border-4 border-white" />
                    </div>
                </div>
                <div class="pt-12 pb-6 px-6">
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <p class="font-medium text-gray-600">Full Name:</p>
                            <p class="text-gray-800 font-semibold">
                                <?= htmlspecialchars($profile['first_name'] . ' ' . $profile['last_name']); ?>
                            </p>
                        </div>
                        <div class="flex justify-between">
                            <p class="font-medium text-gray-600">Matricule:</p>
                            <p class="text-gray-800 font-semibold"><?= htmlspecialchars($profile['id']); ?></p>
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="font-medium text-gray-600">Status:</p>
                            <span
                                class="inline-block bg-green-100 text-green-700 text-sm font-semibold px-2.5 py-0.5 rounded">Etudiant</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Demands Section -->
            <span
                class="mt-6 relative text-5xl font-semibold text-cblue tracking-widest font-math inline-block pb-2 mb-6 before:absolute before:content-[''] before:bottom-0 before:left-0 before:w-[40%] before:h-[5px] before:bg-[#1a4185] after:absolute after:content-[''] after:bottom-0 after:left-[40%] after:w-[60%] after:h-[5px] after:bg-white">Vos
                Demande</span>
            <div class="overflow-auto max-h-80">
                <table class="border-spacing-0 w-full bg-white">
                    <thead>
                        <tr>
                            <th class="border py-1 px-2 text-cblue">Full Name</th>
                            <th class="border py-1 px-2 text-cblue">Matricule</th>
                            <th class="border py-1 px-2 text-cblue">Categorie du Papier</th>
                            <th class="border py-1 px-2 text-cblue">Status</th>
                            <th class="border py-1 px-2 text-cblue">État Commande</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($demands as $row): ?>
                            <tr>
                                <td class="border p-3 font-medium text-gray-700">
                                    <?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?>
                                </td>
                                <td class="border p-3 font-medium text-gray-700"><?= htmlspecialchars($row['id']); ?></td>
                                <td class="border p-3 font-medium text-gray-700"><?= htmlspecialchars($row['document']); ?>
                                </td>
                                <td class="border p-3 font-medium text-gray-700">
                                    <span
                                        class="<?= $row['status'] === 'accepted' ? 'bg-green-100 text-green-700 ' : ($row['status'] === 'encours' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700'); ?> rounded-md p-1">
                                        <?= htmlspecialchars($row['status']); ?>
                                    </span>
                                </td>
                                <td class="border p-3 font-medium">
                                    <span
                                        class="<?= $row['urgency'] === 'urgent' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700'; ?> rounded-md p-1">
                                        <?= htmlspecialchars($row['urgency']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>