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

// Ανάκτηση του user_id
$username = $_SESSION['username'];
$sql = "SELECT id FROM users WHERE username='$username'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$user_id = $row['id'];

// Δημιουργία XML
header('Content-Type: text/xml');
$xml = new SimpleXMLElement('<task_lists/>');

// Ανάκτηση λιστών εργασιών του χρήστη
$sql = "SELECT * FROM task_lists WHERE user_id='$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($list_row = $result->fetch_assoc()) {
        $list = $xml->addChild('list');
        $list->addChild('list_name', $list_row['list_name']);
        $list->addChild('created_at', $list_row['created_at']);

        // Ανάκτηση των εργασιών για κάθε λίστα
        $sql_tasks = "SELECT task_title, status, created_at FROM tasks WHERE list_id='" . $list_row['id'] . "'";
        $result_tasks = $conn->query($sql_tasks);

        if ($result_tasks->num_rows > 0) {
            $tasks = $list->addChild('tasks');
            while($task_row = $result_tasks->fetch_assoc()) {
                $task = $tasks->addChild('task');
                $task->addChild('task_title', $task_row['task_title']);
                $task->addChild('status', $task_row['status']);
                $task->addChild('created_at', $task_row['created_at']);
            }
        }
    }
}

// Εκτύπωση του XML
echo $xml->asXML();

// Κλείσιμο της σύνδεσης
$conn->close();
?>
