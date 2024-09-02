<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<nav>
    <ul>
        <li><a href="index.php">Αρχική</a></li>
        <li><a href="help.php">Βοήθεια</a></li>
        <?php if (isset($_SESSION['username'])): ?>
            <li><a href="profile.php">Προφίλ</a></li>
            <li><a href="task_lists.php">Λίστες Εργασιών</a></li>
            <li><a href="create_list.php">Δημιουργία Λίστας</a></li> <!-- Νέος σύνδεσμος -->
            <li><a href="search_tasks.php">Αναζητήσεις</a></li>
            <li><a href="export_tasks.php">Εξαγωγή δεδομένων</a></li>
            <li><a href="logout.php">Αποσύνδεση</a></li>
        <?php else: ?>
            <li><a href="login.php">Σύνδεση</a></li>
            <li><a href="register.php">Εγγραφή</a></li>
        <?php endif; ?>
    </ul>
</nav>
