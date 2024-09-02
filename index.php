<?php
session_start();
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management Platform</title>
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
        .accordion {
            background-color: #eee;
            cursor: pointer;
            padding: 10px;
            width: 100%;
            text-align: left;
            border: none;
            outline: none;
            transition: background-color 0.4s ease;
        }
        .accordion:hover, .active {
            background-color: #ccc;
        }
        .panel {
            padding: 0 10px;
            display: none;
            background-color: white;
            overflow: hidden;
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
        /* Στυλ για τα κουμπιά Σύνδεσης και Εγγραφής */
        .register-button {
            background-color: green;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            margin-right: 10px;
            border-radius: 5px;
        }
        .login-button {
            background-color: blue;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        /* Dark theme styles */
        body.dark-mode {
            background-color: black;
            color: white;
        }
        .panel.dark-mode {
            background-color: #333;
            color: white;
        }
    </style>
</head>
<body>
    <?php include 'menu.php'; ?>
    
    <div class="container">
        <h1>Πλατφόρμα Διαχείρισης Εργασιών</h1>
        <button class="theme-toggle" onclick="toggleTheme()">Αλλαγή Θέματος</button>
        
        <button class="accordion">Τι κάνει αυτή η πλατφόρμα;</button>
        <div class="panel">
            <p>Αυτή η πλατφόρμα σας βοηθά να διαχειρίζεστε τις εργασίες σας αποτελεσματικά.</p>
        </div>

        <button class="accordion">Πώς να εγγραφώ;</button>
        <div class="panel">
            <p>Μπορείτε να εγγραφείτε κάνοντας κλικ στο κουμπί εγγραφής και συμπληρώνοντας τη φόρμα.</p>
        </div>

        <button class="accordion">Γιατί να χρησιμοποιήσετε αυτήν την πλατφόρμα;</button>
        <div class="panel">
            <p>Αυτή η πλατφόρμα προσφέρει εύκολη διαχείριση εργασιών, συνεργασία με άλλους και πολλά άλλα.</p>
        </div>

        <!-- Προσθήκη κουμπιών Σύνδεσης και Εγγραφής -->
        <div class="button-container">
            <button onclick="window.location.href='login.php'" class="login-button">Σύνδεση</button>
            <button onclick="window.location.href='register.php'" class="register-button">Εγγραφή</button>
        </div>
    </div>

    <script>
        const acc = document.getElementsByClassName("accordion");
        for (let i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active");
                const panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                    panel.style.display = "none";
                } else {
                    panel.style.display = "block";
                }
            });
        }

        function toggleTheme() {
            const body = document.body;
            body.classList.toggle("dark-mode");
            const panels = document.getElementsByClassName("panel");
            for (let i = 0; i < panels.length; i++) {
                panels[i].classList.toggle("dark-mode");
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
                        const panels = document.getElementsByClassName("panel");
                        for (let i = 0; i < panels.length; i++) {
                            panels[i].classList.add("dark-mode");
                        }
                    }
                }
            }
        }
    </script>
</body>
</html>
