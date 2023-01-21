<?php
$content = <<<EOT
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donde</title>
    <link rel="stylesheet" href="./resources/style.css">
</head>
<body>
    <div class="gridContainer">
        <nav>
            <ul> 
                <li><button id="linkIndex">¿Donde?</button></li>
                <li><button id="linkMap">Mapa</button></li>
                <li><button id="linkSearch">Szukaj</button></li>
            </ul>
        </nav>
        <main>
EOT;
        </main>
        <footer>
            <img src="./resources/logoZUT.webp" alt="logo ZUT">
            <p>&copy 2023 Zachodniopomorski Uniwersytet Technologiczny</p>
            <button id="linkAdminPanel">Admin Panel</button>
        </footer>
    </div>
    <script src="./scripts/default.js" defer></script>
</body>
</html>
EOT;