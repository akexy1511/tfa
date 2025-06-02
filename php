<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un personnage</title>
    <link rel="stylesheet" href="css/creer.css">
    <?php
    include 'include/link.php';
    include 'db.php';

    // Récupère les listes pour les selects
    $races = $pdo->query("SELECT * FROM race")->fetchAll(PDO::FETCH_ASSOC);
    $classes = $pdo->query("SELECT * FROM classe")->fetchAll(PDO::FETCH_ASSOC);
    $alignements = $pdo->query("SELECT * FROM alignement")->fetchAll(PDO::FETCH_ASSOC);

    function roll_4d6_drop_lowest() {
        $rolls = [];
        for ($i = 0; $i < 4; $i++) $rolls[] = rand(1, 6);
        sort($rolls);
        return array_sum(array_slice($rolls, 1));
    }
    function modificateur($score) {
        return floor(($score - 10) / 2);
    }
    function pv_initial($classe, $mod_con) {
        switch ($classe) {
            case 1: return 10 + $mod_con; // Guerrier
            case 2: return 6 + $mod_con;  // Mage
            case 3: return 8 + $mod_con;  // Voleur
            case 4: return 8 + $mod_con;  // Prêtre
            case 7: return 12 + $mod_con; // Barbare
            default: return 8 + $mod_con;
        }
    }
    function or_initial($classe) {
        switch ($classe) {
            case 1: return rand(40, 60); // Guerrier
            case 3: return rand(30, 50); // Voleur
            case 2: return rand(20, 40); // Mage
            case 4: return rand(30, 50); // Prêtre
            case 7: return rand(10, 30); // Barbare
            default: return rand(20, 40);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = $_POST['nom'] ?? '';
        $id_race = $_POST['race'] ?? '';
        $id_classe = $_POST['classe'] ?? '';
        $id_alignement = $_POST['alignement'] ?? '';
        // Correction ici : on récupère bien la valeur du select "jouable"
        $jouable = isset($_POST['jouable']) ? (int)$_POST['jouable'] : 1;
        

        // Génération des caractéristiques
        $caracs = [];
        for ($i = 1; $i <= 6; $i++) $caracs[$i] = roll_4d6_drop_lowest();

        $mod_con = modificateur($caracs[3]);
        $pv = pv_initial($id_classe, $mod_con);
        $or = or_initial($id_classe);

        // Insertion du personnage
        $stmt = $pdo->prepare("INSERT INTO personnage (nom, jouable, pv, niveau, id_alignement, id_classe, id_race, xp, `or`) VALUES (?, ?, ?, 1, ?, ?, ?, 0, ?)");
        $stmt->execute([$nom, $jouable, $pv, $id_alignement, $id_classe, $id_race, $or]);
        $id_perso = $pdo->lastInsertId();

        // Insertion des caractéristiques
        foreach ($caracs as $id_carac => $valeur) {
            $stmt = $pdo->prepare("INSERT INTO valeur_caracteristique (id_personnage, id_caracteristique, valeur, modificateur) VALUES (?, ?, ?, ?)");
            $stmt->execute([$id_perso, $id_carac, $valeur, modificateur($valeur)]);
        }

        header("Location: voir_perso.php?id=$id_perso");
        exit;
    }
    ?>
</head>
<body>
    <?php include 'include/navbar.php'; ?>

<div class="container my-5 d-flex justify-content-center">
    <div class="card p-5" style="max-width: 1000px; width: 100%;">
        <h2 class="mb-4">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" width="40" class="me-2">
            Edition personnage – <span id="perso-nom-preview">Nouveau</span>
        </h2>
        <form action="" method="post">
            <div class="row mb-4">
                <div class="col-md-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" id="nom" name="nom" class="form-control fw-bold" required oninput="document.getElementById('perso-nom-preview').textContent = this.value">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Classe</label>
                    <select name="classe" id="classe" class="form-select fw-bold" required onchange="updatePVAndGold()">
                        <option value="">-- Choisir --</option>
                        <?php foreach ($classes as $classe): ?>
                            <option value="<?= htmlspecialchars($classe['id_classe']) ?>"><?= htmlspecialchars($classe['nom']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Niveau</label>
                    <input type="number" class="form-control fw-bold" value="1" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Race</label>
                    <select name="race" id="race" class="form-select fw-bold" required>
                        <option value="">-- Choisir --</option>
                        <?php foreach ($races as $race): ?>
                            <option value="<?= htmlspecialchars($race['id_race']) ?>"><?= htmlspecialchars($race['nom']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Caractéristiques principales -->
            <div class="row mb-2 text-center">
                <?php
                $carac_labels = ['FOR', 'DEX', 'CON', 'INT', 'SAG', 'CHA'];
                $caracs = [];
                $mods = [];
                for ($i = 1; $i <= 6; $i++):
                    $val = roll_4d6_drop_lowest();
                    $caracs[$i] = $val;
                    $mod = modificateur($val);
                    $mods[$i] = $mod;
                    $modAff = $mod >= 0 ? "+$mod" : $mod;
                ?>
                <div class="col-md-2">
                    <label class="form-label fw-bold"><?= $carac_labels[$i-1] ?></label>
                    <input type="number" name="carac[<?= $i ?>]" class="form-control text-center fw-bold" min="3" max="18" value="<?= $val ?>" readonly>
                    <div id="mod<?= $i ?>" class="text-muted" style="font-size:0.95em; font-weight:bold;"><?= $modAff ?></div>
                </div>
                <?php endfor; ?>
            </div>

            <!-- Infos secondaires -->
            <div class="row mb-3 text-center" style="font-size:1.1em;">
                <div class="col-md-2"><span class="fw-bold">Sagesse passive</span><br><?= 10 + $mods[5] ?></div>
                <div class="col-md-2"><span class="fw-bold">Bonus de maîtrise</span><br>2</div>
                <div class="col-md-2"><span class="fw-bold">Classe d'armure</span><br>16</div>
                <div class="col-md-2"><span class="fw-bold">Initiative</span><br><?= ($mods[2]>=0?'+':'').$mods[2] ?></div>
                <div class="col-md-2"><span class="fw-bold">Vitesse</span><br>9m</div>
            </div>

            <!-- Alignement, or, PV, XP, type -->
            <div class="row mb-4">
                <div class="col-md-2">
                    <label class="form-label">Alignement</label>
                    <select name="alignement" id="alignement" class="form-select fw-bold" required>
                        <option value="">-- Choisir --</option>
                        <?php foreach ($alignements as $alignement): ?>
                            <option value="<?= htmlspecialchars($alignement['id_alignement']) ?>"><?= htmlspecialchars($alignement['nom']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Pièces d'or</label>
                    <input type="number" name="or" id="or" class="form-control fw-bold" min="0" value="<?= or_initial(1) ?>" readonly>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Points de vie</label>
                    <input type="number" name="pv" id="pv" class="form-control fw-bold" min="1" value="<?= pv_initial(1, $mods[3]) ?>" readonly>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Expérience</label>
                    <input type="number" class="form-control fw-bold" value="0" readonly>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Niveau</label>
                    <input type="number" class="form-control fw-bold" value="1" readonly>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Type</label>
                        <select name="jouable" class="form-select fw-bold" required>
                        <option value="1">PJ</option>
                        <option value="0">PNJ</option>
</select>
                </div>
            </div>

            <!-- Equipement et sorts -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <b>Équipement (objets possédés)</b>
                    <ul class="list-group">
                        <li class="list-group-item">–</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <b>Sorts (appris à l'école de magie)</b>
                    <ul class="list-group">
                        <li class="list-group-item">–</li>
                    </ul>
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-success px-4">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

<script>
// Met à jour dynamiquement les PV et l'or selon la classe choisie
function updatePVAndGold() {
    var classe = parseInt(document.getElementById('classe').value);
    var mods = [
        0, // index 0 inutilisé
        parseInt(document.getElementsByName('carac[1]')[0].value),
        parseInt(document.getElementsByName('carac[2]')[0].value),
        parseInt(document.getElementsByName('carac[3]')[0].value),
        parseInt(document.getElementsByName('carac[4]')[0].value),
        parseInt(document.getElementsByName('carac[5]')[0].value),
        parseInt(document.getElementsByName('carac[6]')[0].value)
    ];
    var mod_con = Math.floor((mods[3]-10)/2);
    var pv = 8 + mod_con;
    var orVal = 20;

    // Gestion pour toutes les classes (id de 1 à 10)
    switch (classe) {
        case 1: // Guerrier
            pv = 10 + mod_con;
            orVal = Math.floor(Math.random()*21)+40;
            break;
        case 2: // Mage
            pv = 6 + mod_con;
            orVal = Math.floor(Math.random()*21)+20;
            break;
        case 3: // Voleur
            pv = 8 + mod_con;
            orVal = Math.floor(Math.random()*21)+30;
            break;
        case 4: // Prêtre
            pv = 8 + mod_con;
            orVal = Math.floor(Math.random()*21)+30;
            break;
        case 5: // Paladin
            pv = 10 + mod_con;
            orVal = Math.floor(Math.random()*21)+35;
            break;
        case 6: // Rôdeur
            pv = 10 + mod_con;
            orVal = Math.floor(Math.random()*21)+30;
            break;
        case 7: // Barbare
            pv = 12 + mod_con;
            orVal = Math.floor(Math.random()*21)+10;
            break;
        case 8: // Barde
            pv = 8 + mod_con;
            orVal = Math.floor(Math.random()*21)+25;
            break;
        case 9: // Druide
            pv = 8 + mod_con;
            orVal = Math.floor(Math.random()*21)+25;
            break;
        case 10: // Sorcier
            pv = 6 + mod_con;
            orVal = Math.floor(Math.random()*21)+20;
            break;
        default:
            pv = 8 + mod_con;
            orVal = Math.floor(Math.random()*21)+20;
    }

    document.getElementById('pv').value = pv;
    document.getElementById('or').value = orVal;
}
</script>
</body>
</html>
