<?php
// Database connection credentials
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'projetpaw';

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process status update actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    // Sanitize input
    $demand_id = isset($_POST['demand_id']) ? intval($_POST['demand_id']) : null;
    $document = isset($_POST['document']) ? $conn->real_escape_string($_POST['document']) : null;
    $action = isset($_POST['action']) ? $_POST['action'] : null;

    if ($demand_id && $document && in_array($action, ['accepter', 'refuser'])) {
        // Determine the new status
        $new_status = $action === 'accepter' ? 'accepted' : 'rejected';

        // Use prepared statement to update the status
        $update_query = "UPDATE demands SET status = ? WHERE id = ? AND document = ?";
        if ($stmt = $conn->prepare($update_query)) {
            $stmt->bind_param("sis", $new_status, $demand_id, $document);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "<script>alert('Status updated successfully!'); window.location.href = window.location.href;</script>";
            } else {
                echo "<script>alert('No record updated. Please check the input.');</script>";
            }

            $stmt->close();
        } else {
            echo "Error preparing the statement: " . $conn->error;
        }
    } else {
        echo "<script>alert('Invalid data provided.');</script>";
    }
}

// Fetch admin profile
$profile_query = "SELECT first_name, last_name, id FROM users WHERE id = 1";
$profile_result = $conn->query($profile_query);
$row_profile = $profile_result->fetch_assoc();

// Fetch demands with status 'encours'
$sql = "SELECT demands.id, demands.document, demands.urgency, users.first_name, users.last_name
        FROM demands
        INNER JOIN users ON demands.id = users.id 
        WHERE demands.status = 'encours'";
$result = $conn->query($sql);
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
    <!-- Sidebar -->
    <div class="max-md:!w-[70px] max-lg:w-60 border-r p-6 shadow-lightsh relative w-64 max-md:px-[10px]">
        <img src="Fauget Class.png" alt="logo"
            class="-mt-14 mx-auto max-lg:w-44 max-md:-m-5 max-md:mx-auto max-md:-mb-[2px]">
        <ul
            class="relative font-semibold pt-3 max-lg:w-fit max-md:before:hidden max-md:after:hidden
        before:content-[''] before:w-[70%] before:h-1 before:absolute before:left-[15%] before:-top-5 before:bg-cblue
        after:content-[''] after:absolute after:rounded-full after:w-5 after:h-5 after:bg-white after:left-1/2 after:border-4 after:border-cblue after:-translate-x-1/2 after:-top-7">
            <li class="p-2 text-cblue rounded-md cursor-pointer duration-300 pl-13p mb-0p hover:bg-cgr bg-cgr  max-lg:text-sm"
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

    <!-- Main Content -->
    <div class="bg-cgr flex-grow">
        <!-- Header -->
        <div class="bg-white flex justify-between py-1 pl-6 pr-10">
            <div class="flex gap-3">
                <img src="avatar.avif" alt="" class="w-14">
                <button class="text-white  bg-red-800 rounded-md self-center p-[7px] font-semibold">Log Out</button>
            </div>
            <a href="dzprogress1@gmail.com" class="self-center text-2xl"><i class="fa-regular fa-bell"></i></a>
        </div>

        <!-- Profile Section -->
        <div class="p-6 pr-10">
            <span
                class="relative text-5xl mt-4 font-semibold text-cblue tracking-widest font-math inline-block pb-2 mb-5 before:absolute before:content-[''] before:bottom-0 before:left-0 before:w-[40%] before:h-[5px] before:bg-[#1a4185] after:absolute after:content-[''] after:bottom-0 after:left-[40%] after:w-[60%] after:h-[5px] after:bg-white">Profile</span>

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
                            <p class="font-medium text-gray-600 ">Full Name :</p>
                            <p class="text-gray-800 font-semibold">
                                <?php echo $row_profile['first_name'] . ' ' . $row_profile['last_name']; ?>
                            </p>
                        </div>
                        <div class="flex justify-between">
                            <p class="font-medium text-gray-600">Matricule :</p>
                            <p class="text-gray-800 font-semibold"><?php echo $row_profile['id']; ?></p>
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="font-medium text-gray-600">Status :</p>
                            <span
                                class="inline-block bg-red-100 text-red-700 text-sm font-semibold px-2.5 py-0.5 rounded">Admin</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Demands Section -->
            <span
                class="relative text-5xl mt-4 font-semibold text-cblue tracking-widest font-math inline-block pb-2 mb-5 before:absolute before:content-[''] before:bottom-0 before:left-0 before:w-[40%] before:h-[5px] before:bg-[#1a4185] after:absolute after:content-[''] after:bottom-0 after:left-[40%] after:w-[60%] after:h-[5px] after:bg-white">Demandes</span>

            <div class="overflow-auto max-h-80 scrollbar-track-sp scrollbar scrollbar-thumb-cgr">
                <table class="border-spacing-0 w-full bg-white border-separate">
                    <thead class="sticky top-0 bg-white">
                        <tr>
                            <th class="border py-[1px] px-[6px] text-cblue">Full Name</th>
                            <th class="border py-[1px] px-[6px] text-cblue">Matricule</th>
                            <th class="border py-[1px] px-[6px] text-cblue">Categorie du Papier</th>
                            <th class="border py-[1px] px-[6px] text-cblue">Etat de demande</th>
                            <th class="border py-[1px] px-[6px] text-cblue">Validation</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td class='border p-3 font-semibold'>" . $row['first_name'] . " " . $row['last_name'] . "</td>";
                                echo "<td class='border p-3 font-semibold'>" . $row['id'] . "</td>";
                                echo "<td class='border p-3 font-semibold'>" . $row['document'] . "</td>";

                                $urgency = ($row['urgency'] == 'urgent') ? "<span class='inline-block bg-red-100 text-red-700 text-sm font-semibold px-2.5 py-0.5 rounded'>urgent</span>" : "<span class='inline-block bg-blue-100 font-bold py-1 text-blue-700 text-sm  px-2.5  rounded'>" . htmlspecialchars($row['urgency']) . "</span>";
                                echo "<td class='border p-3 font-semibold  '>$urgency</td>";

                                echo "<td class='border p-3 text-end pr-5'>
                                        <form method='POST' action='' class='inline'>
                                            <input type='hidden' name='demand_id' value='" . $row['id'] . "'>
                                            <input type='hidden' name='document' value='" . $row['document'] . "'>
                                            <button type='submit' name='action' value='accepter' class='text-green-600 text-xl ml-1' title='Accept'>
                                                <i class='fa-solid fa-circle-check'></i>
                                            </button>
                                            <button type='submit' name='action' value='refuser' class='text-red-700 text-xl ml-1' title='Reject'>
                                                <i class='fa-solid fa-circle-xmark'></i>
                                            </button>
                                        </form>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center py-3'>No demands found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>

<?php
// Close the database connection
$conn->close();
?>