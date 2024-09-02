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
    die("Σφάλμα σύνδεσης: " . $conn->connect_error);
}

// Έλεγχος αν ο χρήστης είναι συνδεδεμένος
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ανάκτηση του user_id
$username = $_SESSION['username'];
$sql = "SELECT id FROM users WHERE username='$username'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$user_id = $row['id'];

// Δημιουργία λίστας εργασιών
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $list_name = $_POST['list_name'];
    $sql = "INSERT INTO task_lists (user_id, list_name) VALUES ('$user_id', '$list_name')";

    if ($conn->query($sql) === TRUE) {
        echo "Η νέα λίστα δημιουργήθηκε με επιτυχία";
    } else {
        echo "Σφάλμα: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Δημιουργία Λίστας Εργασιών</title>
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
            margin-bottom: 20px;
        }
        /* Dark theme styles */
        body.dark-mode {
            background-color: black;
            color: white;
        }
        .container.dark-mode {
            border-color: #555;
            box-shadow: 2px 2px 12px #444;
        }
    </style>
</head>
<body>

    <?php include 'menu.php'; ?>

    <div class="container">
        <h1>Δημιουργία Νέας Λίστας Εργασιών</h1>
        <button class="theme-toggle" onclick="toggleTheme()">Εναλλαγή Θέματος</button>
        <form action="create_list.php" method="post">
            <label for="list_name">Όνομα Λίστας:</label>
            <input type="text" id="list_name" name="list_name" required>
            <input type="submit" value="Δημιουργία Λίστας">
        </form>
    </div>

    <script>
        function toggleTheme() {
            const body = document.body;
            body.classList.toggle("dark-mode");
            const container = document.querySelector('.container');
            container.classList.toggle("dark-mode");
        }
    </script>
</body>
</html>
