<?php
session_start();

// Durée de session (en secondes)
$session_timeout = 600; // 10 minutes

// Redirige l'utilisateur vers la page de connexion s'il n'est pas connecté ou si la session est expirée
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // Vérifie si le ticket de session a expiré
    if (time() - $_SESSION['last_activity'] > $session_timeout) {
        session_unset();
        session_destroy();
        header("Location: connexion.php?expired=true");
        exit();
    } else {
        $_SESSION['last_activity'] = time(); // Met à jour le temps de dernière activité
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Utilisateurs et mots de passe en dur
    $users = [
        'sio1' => 'siopwd1',
        'sio2' => 'siopwd2'
    ];

    // Récupère les informations de connexion
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Vérifie les identifiants
    if (isset($users[$username]) && $users[$username] === $password) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username;
        $_SESSION['last_activity'] = time();

        // Redirige en fonction de l'utilisateur
        if ($username == 'sio1') {
            $_SESSION["cours"]="java";
            header("Location: index.php");
        } elseif ($username == 'sio2') {
            $_SESSION["cours"]="php";
            header("Location: index.php");
        }
        exit();
    } else {
        $error = "Identifiants incorrects";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <style>
        body { font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-color: #f4f4f4; }
        .login-container { width: 300px; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0,0,0,0.1); }
        .login-container h2 { text-align: center; }
        .login-container input { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ddd; border-radius: 5px; }
        .login-container button { width: 100%; padding: 10px; background: #4CAF50; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; }
        .login-container button:hover { background: #45a049; }
        .error { color: red; text-align: center; }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Connexion</h2>
    <?php if (isset($error)): ?>
        <p class="error"><?= $error ?></p>
    <?php endif; ?>
    <?php if (isset($_GET['expired'])): ?>
        <p class="error">Votre session a expiré. Veuillez vous reconnecter.</p>
    <?php endif; ?>
    <form method="POST" action="connexion.php">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">Se connecter</button>
    </form>
</div>

</body>
</html>
