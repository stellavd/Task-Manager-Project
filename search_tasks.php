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

// Έλεγχος αν υποβλήθηκε φόρμα αναζήτησης
$search_results = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search_query = $_POST['search_query'];
    $status_filter = $_POST['status_filter'];

    // SQL ερώτημα για αναζήτηση εργασιών βάσει τίτλου και κατάστασης
    $sql = "SELECT * FROM tasks WHERE task_title LIKE '%$search_query%'";

    if ($status_filter != '') {
        $sql .= " AND status='$status_filter'";
    }

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $search_results[] = $row;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Αναζήτηση Εργασιών</title>
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
        label, input, select {
            margin-bottom: 10px;
        }
        .task {
            margin-top: 20px;
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
        <h1>Αναζήτηση Εργασιών</h1>
        <button class="theme-toggle" onclick="toggleTheme()">Εναλλαγή Θέματος</button>
        <form action="search_tasks.php" method="post">
            <label for="search_query">Αναζήτηση με Τίτλο:</label>
            <input type="text" id="search_query" name="search_query" required>

            <label for="status_filter">Φίλτρο κατά Κατάσταση:</label>
            <select id="status_filter" name="status_filter">
                <option value="">Όλες</option>
                <option value="pending">Εκκρεμής</option>
                <option value="in_progress">Σε εξέλιξη</option>
                <option value="completed">Ολοκληρωμένη</option>
            </select>

            <input type="submit" value="Αναζήτηση">
        </form>

        <div class="task">
            <h2>Αποτελέσματα Αναζήτησης</h2>
            <?php
            if (!empty($search_results)) {
                foreach($search_results as $row) {
                    echo "<p>" . $row["task_title"] . " - " . $row["status"] . "</p>";
                }
            } else {
                echo "<p>Δε βρέθηκαν εργασίες</p>";
            }
            ?>
        </div>
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
