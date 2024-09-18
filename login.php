<?php
session_start();

// Ενεργοποίηση εμφάνισης σφαλμάτων
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_management";

// Δημιουργία σύνδεσης
$conn = new mysqli($servername, $username, $password, $dbname);

// Έλεγχος σύνδεσης
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Database connection successful";
}

echo "Checkpoint 1";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Εμφάνιση των δεδομένων που λαμβάνονται από τη φόρμα
    var_dump($_POST['username']);
    var_dump($_POST['password']);

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    echo "Checkpoint 2";

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['last_login'] = time();
            
            if (isset($_SESSION['redirect_to'])) {
                $redirect_url = $_SESSION['redirect_to'];
                unset($_SESSION['redirect_to']);
                header("Location: $redirect_url");
            } else {
                header("Location: profile.php");
            }
            exit();
        } else {
            echo "Invalid password";
        }
    } else {
        echo "No user found with that username";
    }
}

$conn->close();

echo "Checkpoint 4";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    </style>
</head>
<body>
    <?php include 'menu.php'; ?>

    <div class="container">
        <h1>Login</h1>
        <button class="theme-toggle" onclick="toggleTheme()">Toggle Theme</button>
        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Login">
        </form>
    </div>

    <script>
        function toggleTheme() {
            const currentTheme = document.body.style.backgroundColor;
            if (currentTheme === 'black') {
                document.body.style.backgroundColor = 'white';
                document.body.style.color = 'black';
                document.cookie = "theme=light";
            } else {
                document.body.style.backgroundColor = 'black';
                document.body.style.color = 'white';
                document.cookie = "theme=dark";
            }
        }

        // Εφαρμογή του αποθηκευμένου θέματος
        window.onload = function() {
            const cookies = document.cookie.split(';');
            for (let i = 0; i < cookies.length; i++) {
                const cookie = cookies[i].trim();
                if (cookie.startsWith("theme=")) {
                    const theme = cookie.split('=')[1];
                    if (theme === 'dark') {
                        document.body.style.backgroundColor = 'black';
                        document.body.style.color = 'white';
                    } else {
                        document.body.style.backgroundColor = 'white';
                        document.body.style.color = 'black';
                    }
                }
            }
        }
    </script>
</body>
</html>
