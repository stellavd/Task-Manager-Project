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

// Ανάκτηση του username
$username = $_SESSION['username'];

// Διαγραφή του χρήστη από τη βάση δεδομένων
$sql = "DELETE FROM users WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);

if ($stmt->execute()) {
    // Αν η διαγραφή ήταν επιτυχής, καταστρέφουμε το session και ανακατευθύνουμε τον χρήστη στη σελίδα εγγραφής
    session_unset();
    session_destroy();
    header("Location: register.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
