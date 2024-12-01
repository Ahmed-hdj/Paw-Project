<?php
// Start the session
session_start();

// Database connection details
$db_server = "localhost";
$db_name = "projetpaw";
$db_user = "root";
$db_password = "";

// Connect to the database
$connection = new mysqli($db_server, $db_user, $db_password, $db_name);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Handle status update
if (isset($_POST['update_status'])) {
    $user_id = intval($_POST['user_id']);
    $new_status = isset($_POST['new_status']) ? trim($_POST['new_status']) : '';

    if (!empty($new_status)) {
        $update_query = "UPDATE users SET status = '$new_status' WHERE id = $user_id";
        if ($connection->query($update_query)) {
            echo "<script>alert('Status updated successfully!'); window.location.href = 'adminiscrit.php';</script>";
        } else {
            echo "<script>alert('Error updating status: " . $connection->error . "');</script>";
        }
    }
}

// Handle user deletion
if (isset($_POST['delete_user'])) {
    $user_id = intval($_POST['user_id']);
    $delete_query = "DELETE FROM users WHERE id = $user_id";

    if ($connection->query($delete_query)) {
        echo "<script>alert('User deleted successfully!'); window.location.reload();</script>";
    } else {
        echo "<script>alert('Error deleting user: " . $connection->error . "');</script>";
    }
}

// Fetch students who are not approved
$query = "SELECT id, first_name, last_name, status FROM users WHERE LOWER(TRIM(role)) = 'student' AND LOWER(TRIM(status)) != 'approved'";
$result = $connection->query($query);

if (!$result) {
    die("Query failed: " . $connection->error);
}

$students_found = $result->num_rows > 0;
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:ital,wght@0,400;0,600;1,400;1,600&family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap"
        rel="stylesheet">


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
            <li class="p-2 text-cblue rounded-md cursor-pointer duration-300 pl-13p mb-0p hover:bg-cgr max-lg:text-sm bg-cgr"
                title="Settigns">
                <a href="admininscrit.php"><i class="fa-solid fa-circle-user mr-2"></i>
                    <span class="max-md:hidden">Demande D'inscrit</span> </a>
            </li>

            <li class="p-2 text-cblue rounded-md cursor-pointer duration-300 pl-13p mb-0p hover:bg-cgr max-lg:text-sm"
                title="Ajouter Evenement">
                <a href="adminevent.php"><i class="fa-solid fa-school mr-2"></i>
                    <span class="max-md:hidden">Ajouter Evenement</span> </a>
            </li>

            </li>
            <li class="p-2 text-cblue rounded-md cursor-pointer duration-300 pl-13p mb-0p hover:bg-cgr max-lg:text-sm"
                title="Email Des Profs">
                <a href=""><i class="fa-solid fa-envelope mr-2"></i> <span class="max-md:hidden">Email Des Profs</span>
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
                class="relative text-5xl mt-4 font-semibold text-cblue tracking-widest font-math inline-block pb-2 mb-5 before:absolute before:content-[''] before:bottom-0 before:left-0 before:w-[40%] before:h-[5px] before:bg-[#1a4185] after:absolute after:content-[''] after:bottom-0 after:left-[40%] after:w-[60%] after:h-[5px] after:bg-white">Demandes
                D'inscrit</span>

            <div class="overflow-auto max-h-[680px] scrollbar-track-sp scrollbar scrollbar-thumb-cgr">

                <table class="border-spacing-0 w-full bg-white border-collapse">

                    <thead class="sticky top-0 bg-white">
                        <tr>
                            <th class="border py-[8px] px-[6px] text-cblue">Matricule</th>
                            <th class="border py-[8px] px-[6px] text-cblue">Nom</th>
                            <th class="border py-[8px] px-[6px] text-cblue">Prenom</th>
                            <th class="border py-[8px] px-[6px] text-cblue">Validation</th>
                            <th class="border py-[8px] px-[6px] text-cblue">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if ($students_found): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td class="border py-[8px] px-[6px]"><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td class="border py-[8px] px-[6px]"><?php echo htmlspecialchars($row['first_name']); ?>
                                    </td>
                                    <td class="border py-[8px] px-[6px]"><?php echo htmlspecialchars($row['last_name']); ?></td>
                                    <td class="border py-[8px] px-[6px] bg-yellow-100 text-yellow-700 font-semibold ">
                                        <?php echo htmlspecialchars($row['status']); ?>
                                    </td>
                                    <td class="border py-[8px] px-[6px] text-center">
                                        <!-- Form to update status to approved -->
                                        <form method="POST" action="" style="display: inline;">
                                            <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                            <input type="hidden" name="new_status" value="approved">
                                            <button type="submit" name="update_status" class="status-btn">
                                                <i class="fa-solid fa-circle-check text-green-600 text-xl ml-1"></i>
                                            </button>
                                        </form>
                                        <!-- Form to delete user -->
                                        <form method="POST" action="" style="display: inline;">
                                            <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" name="delete_user" class="delete-btn">
                                                <i class="fa-solid fa-circle-xmark text-red-800 text-xl"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>


                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center;">No students found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>

                </table>

            </div>






        </div>





    </div>
</body>

</html>