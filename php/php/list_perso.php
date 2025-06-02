<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des personnages</title>
    <?php include 'include/link.php'; ?>
</head>
<body>
    <?php
    include 'include/navbar.php';
    include 'db.php';
    $personnages = get_personnages();

    ?>

    <div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Liste des personnages</h1>
        <a href="ajouter_perso.php" class="btn btn-success">+ Ajouter un personnage</a>
    </div>

        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Nom</th>
                    <th>Race</th>
                    <th>Classe</th>
                    <th>Alignement</th>
                    <th>Niveau</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($personnages)): ?>
                    <?php foreach ($personnages as $perso): ?>
                        <tr>
                            <td><?= htmlspecialchars($perso['nom']) ?></td>
                            <td><?= htmlspecialchars($perso['race']) ?></td>
                            <td><?= htmlspecialchars($perso['classe']) ?></td>
                            <td><?= htmlspecialchars($perso['alignement']) ?></td>
                            <td><?= htmlspecialchars($perso['niveau']) ?></td>
                            <td><?= $perso['jouable'] == '1' ? 'PJ' : 'PNJ' ?></td>
                            <td>
                                <a href="voir_perso.php?id=<?= $perso['id_personnage'] ?>" class="btn btn-sm btn-outline-secondary" title="Voir">🔍</a>
                                <a href="editer_perso.php?id=<?= $perso['id_personnage'] ?>" class="btn btn-sm btn-outline-primary" title="Éditer">✏️</a>
                                <a href="equipement.php?id=<?= $perso['id_personnage'] ?>" class="btn btn-sm btn-outline-warning" title="Équipement">🛒</a>
                                <a href="ecole.php?id=<?= $perso['id_personnage'] ?>" class="btn btn-sm btn-outline-info" title="École">🪄</a>
                                <a href="supprimer_perso.php?id=<?= $perso['id_personnage'] ?>" class="btn btn-sm btn-outline-danger" title="Supprimer" onclick="return confirm('Supprimer ce personnage ?')">❌</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center">Aucun personnage trouvé.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>