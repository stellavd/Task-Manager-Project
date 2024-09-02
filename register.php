<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "task_management";

// Δημιουργία σύνδεσης
$conn = new mysqli($servername, $username, $password, $dbname);

// Έλεγχος σύνδεσης
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $simplepush_key = $_POST['simplepush_key'];

    // Προετοιμασία της SQL δήλωσης
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, username, password, email, simplepush_key) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $first_name, $last_name, $username, $password, $email, $simplepush_key);

    // Εκτέλεση της δήλωσης
    if ($stmt->execute()) {
        // Ανακατεύθυνση στη σελίδα login μετά την επιτυχή εγγραφή
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Κλείσιμο της δήλωσης
    $stmt->close();
}

// Κλείσιμο της σύνδεσης
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
        input.dark-mode {
            background-color: #333;
            color: white;
            border: 1px solid #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <button class="theme-toggle" onclick="toggleTheme()">Toggle Theme</button>
        <form action="register.php" method="post">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required>
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="simplepush_key">SimplePush Key:</label>
            <input type="text" id="simplepush_key" name="simplepush_key">
            <input type="submit" value="Register">
        </form>
    </div>

    <script>
        function toggleTheme() {
            const body = document.body;
            body.classList.toggle("dark-mode");
            const inputs = document.getElementsByTagName("input");
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].classList.toggle("dark-mode");
            }
            const currentTheme = body.classList.contains("dark-mode") ? "dark" : "light";
            document.cookie = "theme=" + currentTheme;
        }

        window.onload = function() {
            const cookies = document.cookie.split(';');
            for (let i = 0; i < cookies.length; i++) {
                const cookie = cookies[i].trim();
                if (cookie.startsWith("theme=")) {
                    const theme = cookie.split('=')[1];
                    if (theme === 'dark') {
                        document.body.classList.add("dark-mode");
                        const inputs = document.getElementsByTagName("input");
                        for (let i = 0; i < inputs.length; i++) {
                            inputs[i].classList.add("dark-mode");
                        }
                    }
                }
            }
        }
    </script>
</body>
</html>
