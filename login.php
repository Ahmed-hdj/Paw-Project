<?php
session_start();

class Database {
    private $connection;
    
    public function __construct($server, $username, $password, $dbname) {
        $this->connection = new mysqli($server, $username, $password, $dbname);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }
    
    public function getConnection() {
        return $this->connection;
    }
}

class User {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function authenticate($matricule, $password) {
        $stmt = $this->db->getConnection()->prepare("SELECT password, status FROM users WHERE id = ?");
        $stmt->bind_param("s", $matricule);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['status'] == 'pending') {
                return "Your account is pending approval.";
            } elseif (password_verify($password, $row['password'])) {
                $_SESSION['loggedin'] = true;
                $_SESSION['matricule'] = $matricule;
                return true;
            } else {
                return "Incorrect password.";
            }
        } else {
            return "Matricule not found.";
        }
    }
}

// Database credentials
$db_server = "localhost";
$db_name = "projetpaw";
$db_user = "root";
$db_password = "";

// Create Database object
$db = new Database($db_server, $db_user, $db_password, $db_name);
$user = new User($db);

$error_message = "";
$matricule = $password = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matricule = trim($_POST['matricule']);
    $password = trim($_POST['password']);

    if (empty($matricule)) {
        $error_message = "Matricule is required.";
    } elseif (empty($password)) {
        $error_message = "Password is required.";
    } else {
        $result = $user->authenticate($matricule, $password);
        if ($result === true) {
            header("Location: dashboard.php");
            exit;
        } else {
            $error_message = $result;  // Assign the specific error message from the authentication
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
    <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:ital,wght@0,400;0,600;1,400;1,600&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
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

        .error-message {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }

        input {
            border-color: #3f3d3d;
            caret-color: #001740;
        }

        label {
            margin-bottom: 2px;
            color: #555353;
        }

        input[type="submit"] {
            background-color: #001740;
        }

        input[type="submit"]:hover {
            opacity: 0.87;
        }

        @media (max-width:860px) {
            body>div:first-child {
                display: none;
            }

            body>div:last-child {
                width: 100%;
                padding-top: 95px;
            }
        }
    </style>
</head>
<body class="min-h-screen flex justify-center">
    <div class="w-3/6 flex flex-col pt-32 flex-wrap items-center relative m-2.5">
        <form action="" method="POST" class="flex flex-col relative">
            <label for="mat" class="text-xl font-semibold relative">Matricule:</label>
            <input type="text" id="mat" name="matricule" value="<?php echo htmlspecialchars($matricule); ?>" class="p-1 pl-9 mb-5 w-72 border-solid border-2 rounded-md outline-none">

            <label for="password" class="text-xl font-semibold relative">Password:</label>
            <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($password); ?>" class="p-1 pl-9 w-72 border-solid border-2 rounded-md outline-none">

            <input type="submit" value="Sign in" class="p-1 w-72 border-solid border-2 rounded-md cursor-pointer font-extrabold text-white bg-blue-600">

            <!-- Display the error message in a span -->
            <?php if ($error_message): ?>
                <span class="error-message"><?php echo $error_message; ?></span>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
