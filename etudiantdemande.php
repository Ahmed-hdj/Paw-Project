<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: index.php?error=not_logged_in");
    exit();
}

// Autoload Classes
require_once 'classes/Database.php';
require_once 'classes/Demand.php';

// Initialize Classes
$db = new Database("localhost", "root", "", "projetpaw");
$conn = $db->getConnection();
$demandManager = new Demand($db);

// Mapping for document names
$documentNames = [
    'feuille1' => 'Certificat de scolarité',
    'feuille2' => 'Attestation de bonne conduite',
    'feuille3' => 'Relevé de notes'
];

// Initialize message
$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['feuille'])) {
    $studentId = $_SESSION['id'];
    $documentKey = $_POST['feuille'];
    $urgency = $_POST['transmission'];

    if (array_key_exists($documentKey, $documentNames)) {
        $documentName = $documentNames[$documentKey];

        if ($demandManager->checkExistingDemand($studentId, $documentName)) {
            $message = "Vous avez déjà demandé ce document.";
        } else {
            if ($demandManager->createDemand($studentId, $documentName, $urgency)) {
                $message = "Demande soumise avec succès!";
            } else {
                $message = "Erreur lors de la soumission de la demande.";
            }
        }
    } else {
        $message = "Document invalide.";
    }
}

$db->closeConnection();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faire Demande</title>

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
            font-family: "Open sans", sans-serif;
        }

        .message {
            padding: 10px;
            margin-top: 20px;
            background-color: #f0f8ff;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
        }

        .success {
            color: #4caf50;
        }

        .error {
            color: #f44336;
        }
    </style>

</head>

<body class="flex min-h-screen">
    <div class="max-md:!w-[70px] max-lg:w-60 border-r p-6 shadow-lightsh relative w-64 max-md:px-[10px] ">
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
            <li class="p-2 text-cblue rounded-md cursor-pointer duration-300 pl-13p mb-0p hover:bg-cgr bg-cgr max-lg:text-sm"
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

    <div class="bg-cgr flex-grow">
        <div class="bg-white flex justify-between py-1 pl-6 pr-10">
            <img src="avatar.avif" alt="" class="w-14">
            <a href="mailto:dzprogress1@gmail.com" class="self-center text-2xl"><i
                    class="fa-regular fa-paper-plane"></i></a>
        </div>

        <div class="p-6 pr-10">
            <span
                class="relative text-5xl font-semibold text-cblue tracking-widest font-math inline-block pb-2 mb-6 before:absolute before:content-[''] before:bottom-0 before:left-0 before:w-[40%] before:h-[5px] before:bg-[#1a4185] after:absolute after:content-[''] after:bottom-0 after:left-[40%] after:w-[60%] after:h-[5px] after:bg-white">Demander</span>

            <div class="bg-white p-6 rounded-lg shadow-lg w-[400px] mx-auto mt-10">
                <form action="etudiantdemande.php" method="POST">
                    <!-- Label and Select for "Choisissez une feuille" -->
                    <label for="feuille" class="font-semibold text-lg text-cblue block mb-2">
                        Choisissez un Document :
                    </label>
                    <select id="feuille" name="feuille"
                        class="w-full border-2 border-sp rounded-lg p-2 focus:outline-none focus:ring focus:ring-sp-light">
                        <option value="" disabled selected>Veuillez choisir un document</option>
                        <option value="feuille1">Certificat de scolarité</option>
                        <option value="feuille2">Attestation de bonne conduite</option>
                        <option value="feuille3">Relevé de notes</option>
                    </select>

                    <!-- Spacer -->
                    <div class="my-4"></div>

                    <!-- Label and Select for "L'état de transmission" -->
                    <label for="transmission" class="font-semibold text-lg text-cblue block mb-2">
                        L'état de transmission :
                    </label>
                    <select id="transmission" name="transmission"
                        class="w-full border-2 border-sp rounded-lg p-2 focus:outline-none focus:ring focus:ring-sp-light">
                        <option value="normal">Normal</option>
                        <option value="urgent">Urgent</option>
                    </select>

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <button type="submit"
                            class="w-full bg-sp text-white font-bold py-2 rounded-lg hover:bg-sp-dark transition hover:opacity-80">
                            Soumettre
                        </button>
                    </div>
                </form>

                <!-- Display the success/error message below the form -->
                <?php if ($message): ?>
                    <div class="message <?php echo ($message === 'Demande soumise avec succès!') ? 'success' : 'error'; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>