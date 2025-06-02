<?php
include 'include/navbar.php';
include 'include/link.php';
include 'db.php';

$id = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT p.*, 
    r.nom AS nom_race, 
    c.nom AS nom_classe, 
    a.nom AS nom_alignement
    FROM personnage p
    JOIN race r ON p.id_race = r.id_race
    JOIN classe c ON p.id_classe = c.id_classe
    JOIN alignement a ON p.id_alignement = a.id_alignement
    WHERE p.id_personnage = ?");
$stmt->execute([$id]);
$perso = $stmt->fetch(PDO::FETCH_ASSOC);

// Récupération des caractéristiques
$caracs = $pdo->prepare("SELECT * FROM valeur_caracteristique 
    JOIN caracteristique USING(id_caracteristique)
    WHERE id_personnage = ?");
$caracs->execute([$id]);
$caracs = $caracs->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-5">
    <div class="card p-5">
        <h2 class="mb-4 text-center"><i class="fa-solid fa-user-astronaut me-2"></i><?= htmlspecialchars($perso['nom']) ?></h2>
        <div class="row mb-4">
            <div class="col-md-6">
                <p><strong>Race :</strong> <?= htmlspecialchars($perso['nom_race']) ?></p>
                <p><strong>Classe :</strong> <?= htmlspecialchars($perso['nom_classe']) ?></p>
                <p><strong>Alignement :</strong> <?= htmlspecialchars($perso['nom_alignement']) ?></p>
            </div>
            <div class="col-md-6">
                <p><strong><i class="fa-solid fa-mask me-2"></i>Type :</strong> <?= ( $perso['jouable'] == "0" ? "PNJ" : "PJ" ) ?></p>
                <p><strong><i class="fa-solid fa-heart me-2"></i>PV :</strong> <?= $perso['pv'] ?></p>
                <p><strong><i class="fa-solid fa-coins me-2"></i>Or :</strong> <?= $perso['or'] ?> PO</p>
                <p><strong><i class="fa-solid fa-star me-2"></i>Niveau :</strong> <?= $perso['niveau'] ?></p>
                <p><strong><i class="fa-solid fa-sparkles me-2"></i>XP :</strong> <?= $perso['xp'] ?></p>
            </div>
        </div>

        <hr>

        <h4 class="mb-3"><i class="fa-solid fa-chart-simple me-2"></i>Caractéristiques</h4>
        <div class="row">
            <?php foreach ($caracs as $carac): ?>
                <div class="col-6 col-md-4 mb-3">
                    <div class="carac-box">
                        <?= htmlspecialchars($carac['nom']) ?>
                        <span><?= $carac['valeur'] ?></span>
                        <small>Mod : <?= ($carac['modificateur'] >= 0 ? '+' : '') . $carac['modificateur'] ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="text-center mt-4">
            <a href="liste_perso.php" class="btn btn-secondary"><i class="fa-solid fa-arrow-left me-2"></i>Retour</a>
        </div>
    </div>
</div>