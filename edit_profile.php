<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_management";

// Δημιουργία σύνδεσης
$conn = new mysqli($servername, $username, $password, $dbname);

// Έλεγχος σύνδεσης
if ($conn->connect_error) {
    die("Η σύνδεση απέτυχε: " . $conn->connect_error);
}

// Έλεγχος αν ο χρήστης είναι συνδεδεμένος
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ανάκτηση των στοιχείων του χρήστη
$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $email = $row['email'];
    $simplepush_key = $row['simplepush_key'];
} else {
    echo "Δεν βρέθηκε χρήστης";
    exit();
}

// Ενημέρωση του προφίλ χρήστη
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $simplepush_key = $_POST['simplepush_key'];

    $sql = "UPDATE users SET first_name=?, last_name=?, email=?, simplepush_key=? WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $first_name, $last_name, $email, $simplepush_key, $username);

    if ($stmt->execute()) {
        echo "Το προφίλ ενημερώθηκε με επιτυχία";
    } else {
        echo "Σφάλμα: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Επεξεργασία Προφίλ</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 50%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 2px 2px 12px #aaa;
        }
        h1 {
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label, input {
            margin-bottom: 10px;
        }
        .theme-toggle {
            margin: 10px 0;
            padding: 5px;
            cursor: pointer;
            background-color: #007bff;
            color: white;
            border: none;
            outline: none;
        }
        /* Dark theme styles */
        body.dark-mode {
            background-color: black;
            color: white;
        }
        .container.dark-mode {
            background-color: #333;
            border-color: #555;
        }
    </style>
</head>
<body>
    <?php include 'menu.php'; ?>
    <div class="container">
        <button class="theme-toggle" onclick="toggleTheme()">Αλλαγή Θέματος</button>
        <h1>Επεξεργασία Προφίλ</h1>
        <form action="edit_profile.php" method="post">
            <label for="first_name">Όνομα:</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo $first_name; ?>" required>
            <label for="last_name">Επίθετο:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo $last_name; ?>" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
            <label for="simplepush_key">Κλειδί SimplePush:</label>
            <input type="text" id="simplepush_key" name="simplepush_key" value="<?php echo $simplepush_key; ?>">
            <input type="submit" value="Ενημέρωση Προφίλ">
        </form>
    </div>

    <script>
        function toggleTheme() {
            const body = document.body;
            const container = document.querySelector('.container');
            body.classList.toggle("dark-mode");
            container.classList.toggle("dark-mode");
        }

        // Εφαρμογή του αποθηκευμένου θέματος
        window.onload = function() {
            const cookies = document.cookie.split(';');
            for (let i = 0; i < cookies.length; i++) {
                const cookie = cookies[i].trim();
                if (cookie.startsWith("theme=")) {
                    const theme = cookie.split('=')[1];
                    if (theme === 'dark') {
                        document.body.classList.add("dark-mode");
                        document.querySelector('.container').classList.add("dark-mode");
                    }
                }
            }
        }
    </script>
</body>
</html>
