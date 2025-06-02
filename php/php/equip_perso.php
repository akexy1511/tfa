<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Équiper un personnage</title>
    <?php
    include 'include/link.php';
    ?>
</head>
<body>
    <?php
    include 'include/navbar.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // ...traitement de l'équipement...

        // Redirection vers la liste des personnages
        header('Location: liste_perso.php');
        exit;
    }

    // ...affichage du formulaire...
    ?>
</body>
</html>