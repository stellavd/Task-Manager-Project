<?php
session_start();
?>

<!DOCTYPE html>
<html lang="el">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Βοήθεια - Πλατφόρμα Διαχείρισης Εργασιών</title>
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
        body.dark-theme {
            background-color: black;
            color: white;
        }
        body.dark-theme .panel {
            background-color: #333;
            color: white;
        }
        body.dark-theme .accordion {
            background-color: #555;
            color: white;
        }
        body.dark-theme .accordion:hover, body.dark-theme .active {
            background-color: #777;
        }
    </style>
</head>
<body>
    <?php include 'menu.php'; ?>
    <div class="container">
        <h1>Βοήθεια</h1>
        <button class="theme-toggle" onclick="toggleTheme()">Εναλλαγή Θέματος</button>

        <button class="accordion">Πώς να δημιουργήσετε μία εργασία;</button>
        <div class="panel">
            <p>Κάντε κλικ στο κουμπί "Δημιουργία Εργασίας" και συμπληρώστε τη φόρμα.</p>
        </div>

        <button class="accordion">Πώς να επεξεργαστείτε μία εργασία;</button>
        <div class="panel">
            <p>Κάντε κλικ στο κουμπί "Επεξεργασία" δίπλα στην εργασία που θέλετε να επεξεργαστείτε.</p>
        </div>

        <button class="accordion">Πώς να διαγράψετε μία εργασία;</button>
        <div class="panel">
            <p>Κάντε κλικ στο κουμπί "Διαγραφή" δίπλα στην εργασία που θέλετε να διαγράψετε.</p>
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
            const currentTheme = document.body.classList.contains('dark-theme') ? 'dark' : 'light';
            if (currentTheme === 'light') {
                document.body.classList.add('dark-theme');
                document.cookie = "theme=dark";
            } else {
                document.body.classList.remove('dark-theme');
                document.cookie = "theme=light";
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
                        document.body.classList.add('dark-theme');
                    }
                }
            }
        }
    </script>
</body>
</html>
