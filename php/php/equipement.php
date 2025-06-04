<?php
include 'db.php';
include 'include/link.php';
include 'include/navbar.php';

$id = $_GET['id'] ?? 0;

// Récupère le personnage
$stmt = $pdo->prepare("SELECT p.*, c.nom AS nom_classe, r.nom AS nom_race FROM personnage p
    JOIN classe c ON p.id_classe = c.id_classe
    JOIN race r ON p.id_race = r.id_race
    WHERE p.id_personnage = ?");
$stmt->execute([$id]);
$perso = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$perso) {
    echo "<div class='alert alert-danger'>Personnage introuvable.</div>";
    exit;
}

// Récupère l'inventaire actuel
$inv_stmt = $pdo->prepare("SELECT i.nom, i.type, inv.quantite FROM inventaire inv JOIN item i ON inv.id_item = i.id_item WHERE inv.id_personnage = ?");
$inv_stmt->execute([$id]);
$inventaire = $inv_stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupère tous les objets disponibles
$items = $pdo->query("SELECT * FROM item ORDER BY niveau_requis, nom")->fetchAll(PDO::FETCH_ASSOC);

// Traitement achat
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acheter'])) {
    $id_item = (int)$_POST['acheter'];
    // Récupère l'objet
    $item = $pdo->prepare("SELECT * FROM item WHERE id_item = ?");
    $item->execute([$id_item]);
    $item = $item->fetch(PDO::FETCH_ASSOC);

    if ($item && $perso['niveau'] >= $item['niveau_requis'] && $perso['or'] >= $item['prix']) {
        // Déduit l'or
        $pdo->prepare("UPDATE personnage SET `or` = `or` - ? WHERE id_personnage = ?")->execute([$item['prix'], $id]);
        // Ajoute l'objet à l'inventaire (si déjà présent, incrémente)
        $check = $pdo->prepare("SELECT quantite FROM inventaire WHERE id_personnage = ? AND id_item = ?");
        $check->execute([$id, $id_item]);
        $exist = $check->fetchColumn();
        if ($exist) {
            $pdo->prepare("UPDATE inventaire SET quantite = quantite + 1 WHERE id_personnage = ? AND id_item = ?")->execute([$id, $id_item]);
        } else {
            $pdo->prepare("INSERT INTO inventaire (id_personnage, id_item, quantite) VALUES (?, ?, 1)")->execute([$id, $id_item]);
        }
        // Rafraîchit la page pour afficher l'achat
        header("Location: equipement.php?id=$id");
        exit;
    }
    // Sinon, rien ne se passe (sécurité)
}

// Rafraîchit les données après achat
$stmt->execute([$id]);
$perso = $stmt->fetch(PDO::FETCH_ASSOC);
$inv_stmt->execute([$id]);
$inventaire = $inv_stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Marchand – Équipement du personnage</title>
    <link rel="stylesheet" href="css/creer.css">
</head>
<body>
<div class="container my-5">
    <h1 class="mb-4">🛒 Marchand – Équipement du personnage</h1>
    <!-- Section personnage -->
    <div class="card mb-4">
        <div class="card-header bg-dark text-white">
            🎲 Informations du personnage
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-3"><strong>Nom :</strong> <?= htmlspecialchars($perso['nom']) ?></div>
                <div class="col-md-3"><strong>Classe :</strong> <?= htmlspecialchars($perso['nom_classe']) ?></div>
                <div class="col-md-2"><strong>Race :</strong> <?= htmlspecialchars($perso['nom_race']) ?></div>
                <div class="col-md-2"><strong>Niveau :</strong> <?= $perso['niveau'] ?></div>
                <div class="col-md-2"><strong>XP :</strong> <?= $perso['xp'] ?></div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <strong>Pièces d’or :</strong>
                    <span class="fw-bold text-success"><?= $perso['or'] ?> PO</span>
                </div>
                <div class="col-md-9">
                    <strong>Inventaire actuel :</strong>
                    <?php if ($inventaire): ?>
                        <ul class="list-unstyled mb-0">
                            <?php foreach ($inventaire as $obj): ?>
                                <li>
                                    <span class="me-1">🛡️</span>
                                    <strong><?= htmlspecialchars($obj['nom']) ?></strong>
                                    <?= $obj['quantite'] > 1 ? ' ×'.$obj['quantite'] : '' ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <span>Aucun objet</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Section objets -->
    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">
            📦 Objets disponibles
        </div>
        <div class="card-body p-0">
            <form method="post" class="mb-0">
            <table class="table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nom</th>
                        <th>Type</th>
                        <th>Prix</th>
                        <th>Effet</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($items as $item):
                    $niveau_ok = $perso['niveau'] >= $item['niveau_requis'];
                    $or_ok = $perso['or'] >= $item['prix'];
                    $disabled = !$niveau_ok || !$or_ok;
                ?>
                    <tr<?= $disabled ? ' class="table-secondary"' : '' ?>>
                        <td><strong><?= htmlspecialchars($item['nom']) ?></strong></td>
                        <td><?= htmlspecialchars($item['type']) ?></td>
                        <td><?= $item['prix'] ?> PO</td>
                        <td><?= htmlspecialchars($item['effet']) ?></td>
                        <td>
                            <?php if (!$niveau_ok): ?>
                                <span class="badge bg-secondary fs-6">Niveau insuffisant</span>
                            <?php elseif (!$or_ok): ?>
                                <span class="badge bg-secondary fs-6">Pas assez d'or</span>
                            <?php else: ?>
                                <button type="submit" name="acheter" value="<?= $item['id_item'] ?>" class="btn btn-primary btn-sm">Acheter</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            </form>
        </div>
    </div>
    <div class="text-end">
        <a href="voir_perso.php?id=<?= $id ?>" class="btn btn-secondary">Retour fiche personnage</a>
    </div>
</div>
</body>
</html>