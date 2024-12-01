<?php
// Include necessary class files
require_once __DIR__ . "/classes/Database.php";
require_once __DIR__ . "/classes/AdminEvent.php";

$db = new Database('localhost', 'root', '', 'projetpaw');

// Handle form submission for event creation
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    // Initialize AdminEvent class and handle event submission
    $adminEvent = new AdminEvent($db);
    $message = $adminEvent->createEvent($title, $content);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Add Event</title>
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
            margin: 0;
            padding: 0;
            font-family: "Open Sans", sans-serif;
        }
    </style>
</head>

<body class="flex min-h-screen">
    <!-- Sidebar -->
    <div class="max-md:!w-[70px] max-lg:w-60 border-r p-6 shadow-lightsh relative w-64 max-md:px-[10px]">
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

            <li class="p-2 text-cblue rounded-md cursor-pointer duration-300 pl-13p mb-0p hover:bg-cgr bg-cgr max-lg:text-sm"
                title="Ajouter Evenement">
                <a href="adminevent.php"><i class="fa-solid fa-school mr-2"></i>
                    <span class="max-md:hidden">Ajouter Evenement</span> </a>
            </li>

            </li>
            <li class="p-2 text-cblue rounded-md cursor-pointer duration-300 pl-13p mb-0p hover:bg-cgr max-lg:text-sm"
                title="Email Des Profs">
                <a href="adminemail.php"><i class="fa-solid fa-envelope mr-2"></i> <span class="max-md:hidden">Email
                        Des Profs</span>
                </a>

            </li>

        </ul>
    </div>

    <!-- Main content -->
    <div class="bg-cgr flex-grow">
        <div class="bg-white flex justify-between py-1 pl-6 pr-10">
            <img src="avatar.avif" alt="" class="w-14">
            <a href="dzprogress1@gmail.com" class="self-center text-2xl"><i class="fa-regular fa-bell"></i></a>
        </div>

        <div class="p-6 pr-10">



            <div class="bg-white p-6 rounded-xl shadow-lg">
                <?php if ($message): ?>
                    <p style="color: green;"><?= htmlspecialchars($message) ?></p>
                <?php endif; ?>

                <!-- Event form -->
                <form action="" method="POST">
                    <div class="mb-6">
                        <label for="tit" class="block text-lg font-medium text-cblue mb-2">Titre D'événement :</label>
                        <input type="text" id="tit" name="title" placeholder="Entrer Le Titre D'événement"
                            class="w-full border border-gray-300 rounded-md p-3">
                    </div>
                    <div class="mb-6">
                        <label for="are" class="block text-lg font-medium text-cblue mb-2">Contenu D'événement :</label>
                        <textarea id="are" name="content" rows="5" placeholder="Entrer Le Contenu D'événement"
                            class="w-full border border-gray-300 rounded-md p-3"></textarea>
                    </div>
                    <div class="text-right">
                        <button type="submit" class="bg-cblue text-white py-2 px-6 rounded-md shadow">Submit</button>
                    </div>
                </form>
            </div>

            <div class="text-center my-[25px]">
                <span
                    class="mx-auto relative before:content-[''] before:absolute before:h-[2px] before:bg-cblue before:top-1/2 before:-translate-y-1/2 before:w-28 before:-left-32 
                after:content-[''] after:absolute after:h-[2px] after:bg-cblue after:top-1/2 after:-translate-y-1/2 after:w-28 after:-right-32 font-semibold text-lg text-cblue tracking-[1px]">
                    Listes D'evenement</span>
            </div>

            <div class="max-h-56 overflow-y-auto">
                <?php
                // Initialize AdminEvent class and get events list
                $adminEvent = new AdminEvent($db);
                $events = $adminEvent->getEvents();

                if (count($events) > 0) {
                    foreach ($events as $event) {
                        echo "<div class='bg-white rounded-md shadow-md p-5 mb-4'>";
                        echo "<h1 class='underline text-cblue uppercase text-xl font-semibold mb-5'>" . htmlspecialchars($event['event_title']) . "</h1>";
                        echo "<p>" . htmlspecialchars($event['event_description']) . "</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No events found.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>