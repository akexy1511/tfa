<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="css/index.css">
    <?php include 'include/link.php'; ?>
</head>
<body>
    <?php include 'include/navbar.php'; ?>
    <?php
    include 'db.php';
    // Exemples de stats
    $total_pj = $pdo->query("SELECT COUNT(*) FROM personnage WHERE jouable='1'")->fetchColumn();
    $total_pnj = $pdo->query("SELECT COUNT(*) FROM personnage WHERE jouable='0'")->fetchColumn();
    $moy_age = 0; // Ajoute un champ age si besoin
    $plus_xp = $pdo->query("SELECT nom, xp FROM personnage ORDER BY xp DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
    // etc.
    ?>
    <div class="container my-5">
        <h1 class="mb-4">Statistiques du monde</h1>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="stat-card bg-light">
                    <strong>👥 Nombre de PJ / PNJ :</strong><br>
                    <?= $total_pj ?> PJ / <?= $total_pnj ?> PNJ
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card bg-light">
                    <strong>🎂 Moyenne d’âge :</strong><br>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card bg-light">
                    <strong>🎭 Nombre d’ennemis vs alliés :</strong><br>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card bg-light">
                    <strong>💪 Classe avec le plus de PV moyen :</strong><br>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card bg-light">
                    <strong>🧭 Répartition des alignements :</strong><br>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card bg-light">
                    <strong>📜 Quêtes en cours / terminées :</strong><br>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card bg-light">
                    <strong>🎒 Moyenne d’objets par personnage :</strong><br>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card bg-light">
                    <strong>🥇 le Nombre d'xp le plus élévé de la base de données:</strong><br>
                    <?= htmlspecialchars($plus_xp['nom']) ?> (<?= $plus_xp['xp'] ?> XP)
                </div>
            </div>
            <div class="col-md-12">
                <div class="stat-card bg-light">
                    <strong>📊 Répartition des alignements (graphique) :</strong><br>
                </div>
            </div>
        </div>
    </div>
</body>
</html>