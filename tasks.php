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
    die("Connection failed: " . $conn->connect_error);
}

// Έλεγχος αν ο χρήστης είναι συνδεδεμένος
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ανάκτηση του list_id από τη διεύθυνση URL
$list_id = $_GET['list_id'];

// Δημιουργία νέας εργασίας αν έχει υποβληθεί φόρμα
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task_title'])) {
    $task_title = $_POST['task_title'];
    $status = $_POST['status'];

    $sql = "INSERT INTO tasks (list_id, task_title, status) VALUES ('$list_id', '$task_title', '$status')";
    $conn->query($sql);
}

// Ανάκτηση των εργασιών για αυτή τη λίστα
$sql = "SELECT task_title, status FROM tasks WHERE list_id='$list_id'";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasks</title>
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
        .task {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .task-title {
            font-weight: bold;
        }
        .task-status {
            color: gray;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label, input, select {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php include 'menu.php'; ?>
    
    <div class="container">
        <h1>Tasks</h1>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='task'>";
                echo "<div class='task-title'>" . $row["task_title"] . "</div>";
                echo "<div class='task-status'>Status: " . $row["status"] . "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No tasks found for this list</p>";
        }
        ?>

        <!-- Φόρμα για προσθήκη νέας εργασίας -->
        <h2>Add a New Task</h2>
        <form action="tasks.php?list_id=<?php echo $list_id; ?>" method="post">
            <label for="task_title">Task Title:</label>
            <input type="text" id="task_title" name="task_title" required>

            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>

            <input type="submit" value="Add Task">
        </form>
    </div>
</body>
</html>
