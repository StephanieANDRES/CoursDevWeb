<?php
// Détermine le répertoire contenant les fichiers HTML
$directory = __DIR__;

// Obtient la liste des fichiers HTML dans le répertoire
$files = array_filter(scandir($directory), function ($file) use ($directory) {
    return is_file($directory . '/' . $file) && pathinfo($file, PATHINFO_EXTENSION) === 'html';
});

// Récupère le fichier HTML à afficher (défaut : index.html)
$page = isset($_GET['page']) ? $_GET['page'] : 'index.html';
$pagePath = $directory . '/' . $page;

// Vérifie si le fichier demandé existe
if (!in_array($page, $files)) {
    $page = 'index.html';
    $pagePath = $directory . '/' . $page;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cours PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            padding-top: 50px;
            /* Espacement pour le menu fixe */
        }

        .navbar {
            opacity: 0.80;
            background-color: #333;
            padding: 10px;
            color: #fff;
            text-align: center;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000;
            /* Assure que le menu est au-dessus du contenu */
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            display: inline-block;
        }

        .navbar a:hover {
            background-color: #575757;
        }

        .content {
            padding: 20px;
        }

        @media (max-width: 768px) {
            .navbar a {
                flex: 1 1 100%;
                /* Les liens prennent toute la largeur en mobile */
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="navbar">
        <?php foreach ($files as $file): ?>
            <a href="?page=<?php echo urlencode($file); ?>"><?php echo htmlspecialchars(pathinfo($file, PATHINFO_FILENAME)); ?></a>
        <?php endforeach; ?>
    </div>
    <div class="content">
        <?php
        // Inclut le contenu du fichier HTML sélectionné
        if (file_exists($pagePath)) {
            include($pagePath);
        } else {
            echo '<p>Le fichier demandé est introuvable.</p>';
        }
        ?>
    </div>
</body>

</html>