<?php
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

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and collect the form data
    $prof_name = $_POST['prof_name'];
    $module = $_POST['module'];
    $email = $_POST['email'];

    // Call the addProfessor method to add the professor to the database
    $result = $professor->addProfessor($prof_name, $module, $email);
    if ($result === true) {
        // Successful insertion
        echo "";
    } else {
        // Error occurred
        echo "Error: " . $result;
    }
}

// Fetch the list of professors
$professors = $professor->getProfessors();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="dist/style.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:ital,wght@0,400;0,600;1,400;1,600&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            padding: 0;
            margin: 0;
            font-family: "Open sans", sans-serif;
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
            <li class="p-2 text-cblue rounded-md cursor-pointer duration-300 pl-13p mb-0p hover:bg-cgr  max-lg:text-sm"
                title="General">
                <a href="admin.php"><i class="fa-solid fa-file-signature mr-2"></i><span
                        class="max-md:hidden">General</span></a>
            </li>
            <li class="p-2 text-cblue rounded-md cursor-pointer duration-300 pl-13p mb-0p hover:bg-cgr max-lg:text-sm"
                title="Settigns">
                <a href="admininscrit.php"><i class="fa-solid fa-circle-user mr-2"></i>
                    <span class="max-md:hidden">Demande D'inscrit</span> </a>
            </li>

            <li class="p-2 text-cblue rounded-md cursor-pointer duration-300 pl-13p mb-0p hover:bg-cgr  max-lg:text-sm"
                title="Ajouter Evenement">
                <a href="adminevent.php"><i class="fa-solid fa-school mr-2"></i>
                    <span class="max-md:hidden">Ajouter Evenement</span> </a>
            </li>

            </li>
            <li class="p-2 text-cblue rounded-md cursor-pointer duration-300 pl-13p mb-0p hover:bg-cgr  max-lg:text-sm"
                title="Email Des Profs">
                <a href="adminemail.php"><i class="fa-solid fa-envelope mr-2"></i> <span class="max-md:hidden">Email
                        Des Profs</span>
                </a>

            </li>

        </ul>
    </div>

    <div class="bg-cgr flex-grow">
        <div class="bg-white flex justify-between py-1 pl-6 pr-10">
            <img src="avatar.avif" alt="" class="w-14">
            <a href="dzprogress1@gmail.com" class="self-center text-2xl"><i class="fa-regular fa-bell "></i></a>
        </div>

        <div class="p-6 pr-10">
            <span
                class="relative text-5xl font-semibold text-cblue tracking-widest font-math inline-block pb-2 mb-5 before:absolute before:content-[''] before:bottom-0 before:left-0 before:w-[40%] before:h-[5px] before:bg-[#1a4185] after:absolute after:content-[''] after:bottom-0 after:left-[40%] after:w-[60%] after:h-[5px] after:bg-white">
                Email</span>

            <div class="bg-white p-6 rounded-xl shadow-lg">
                <form method="POST">
                    <!-- Title Label and Input -->
                    <div class="mb-6">
                        <label for="prof_name" class="block text-lg font-medium text-cblue mb-2">
                            Full Name :
                        </label>
                        <input type="text" id="prof_name" name="prof_name" placeholder="Enter professor name"
                            class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-sp focus:outline-none caret-sp"
                            required>
                    </div>

                    <div class="mb-6">
                        <label for="module" class="block text-lg font-medium text-cblue mb-2">
                            Matiere :
                        </label>
                        <input type="text" id="module" name="module" placeholder="Module"
                            class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-sp focus:outline-none caret-sp"
                            required>
                    </div>

                    <div class="mb-6">
                        <label for="email" class="block text-lg font-medium text-cblue mb-2">
                            Email Du Prof :
                        </label>
                        <input type="email" id="email" name="email" placeholder="Professor email"
                            class="w-full border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-sp focus:outline-none caret-sp"
                            required>
                    </div>

                    <div class="text-right">
                        <button type="submit"
                            class="bg-cblue text-white py-2 px-6 rounded-md shadow hover:bg-cblue-dark focus:ring-2 focus:ring-offset-2 focus:ring-cblue-dark hover:opacity-80">
                            Submit
                        </button>
                    </div>
                </form>
            </div>

            <div class="text-center my-[25px]">
                <span
                    class="mx-auto relative before:content-[''] before:absolute before:h-[2px] before:bg-cblue before:top-1/2 before:-translate-y-1/2 before:w-28 before:-left-32 
                after:content-[''] after:absolute after:h-[2px] after:bg-cblue after:top-1/2 after:-translate-y-1/2 after:w-28 after:-right-32 font-semibold text-lg text-cblue tracking-[1px]">
                    Listes D'email</span>
            </div>

            <div class="max-h-[215px] overflow-y-auto scrollbar-track-sp scrollbar rounded-md scrollbar-thumb-cgr">
                <?php
                // Loop through professors array
                if (count($professors) > 0) {
                    foreach ($professors as $professor) {
                        echo '<div class="bg-white rounded-md shadow-md p-5 tracking-[1px] mb-4">';
                        echo '<h1 class="underline underline-offset-4 text-cblue uppercase text-xl font-semibold mb-5">' . $professor['prof_name'] . '</h1>';
                        echo '<p class="text-gray-900 font-medium">- Module : ' . $professor['module'] . '</p>';
                        echo '<p class="text-gray-900 font-medium">- Email : ' . $professor['email'] . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p class="text-center text-gray-500">No professors found.</p>';
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>