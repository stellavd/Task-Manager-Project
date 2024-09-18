<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_management";

// Μέγιστη διάρκεια session σε δευτερόλεπτα (π.χ. 30 λεπτά)
$session_duration = 1800;

// Έλεγχος αν ο χρήστης είναι συνδεδεμένος και αν η διάρκεια του session δεν έχει λήξει
if (!isset($_SESSION['username']) || (time() - $_SESSION['last_login'] > $session_duration)) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// Ενημέρωση του τελευταίου χρόνου δραστηριότητας
$_SESSION['last_login'] = time();

// Δημιουργία σύνδεσης
$conn = new mysqli($servername, $username, $password, $dbname);

// Έλεγχος σύνδεσης
if ($conn->connect_error) {
    die("Η σύνδεση απέτυχε: " . $conn->connect_error);
}

// Ανάκτηση των στοιχείων του χρήστη από τη βάση δεδομένων
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

$conn->close();
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Προφίλ Χρήστη</title>
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
        label {
            font-weight: bold;
        }
        p {
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
        <h1>Προφίλ Χρήστη</h1>
        <p><label>Όνομα:</label> <?php echo $first_name; ?></p>
        <p><label>Επίθετο:</label> <?php echo $last_name; ?></p>
        <p><label>Email:</label> <?php echo $email; ?></p>
        <p><label>Κλειδί SimplePush:</label> <?php echo $simplepush_key; ?></p>
        <p><a href="edit_profile.php">Επεξεργασία Προφίλ</a></p>
        <p><a href="delete_profile.php">Διαγραφή Προφίλ</a></p>
    </div>

    <script>
        function toggleTheme() {
            const body = document.body;
            const container = document.querySelector('.container');
            body.classList.toggle("dark-mode");
            container.classList.toggle("dark-mode");
        }

        // Apply the saved theme
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
