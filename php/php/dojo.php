<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Techniques du Dojo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f5f5f5;
        }
        .titre-dojo {
            display: flex;
            align-items: center;
            gap: 0.7em;
            font-size: 2.3rem;
            margin-bottom: 1.5rem;
        }
        .titre-dojo span {
            text-decoration: underline;
        }
        .fiche-card {
            background: #222;
            color: #fff;
            border-radius: 8px;
            padding: 1.5rem 2rem;
            margin-bottom: 2rem;
        }
        .fiche-card strong { 
            color: #fff; 
        }
        .sorts-list {
            list-style: none;
            padding-left: 0;
            margin-bottom: 0;
        }
        .sorts-list li {
            display: flex;
            align-items: center;
            font-size: 1.1em;
            margin-bottom: 0.3em;
        }
        .sorts-list .icon {
            color: #f7c948;
            margin-right: 0.5em;
            font-size: 1.2em;
        }
        .table-sort {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .table-sort thead tr {
            background: #0062ff;
            color: #fff;
        }
        .table-sort th,
        .table-sort td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .table-sort tbody tr:nth-child(even) {
            background: #f2f2f2;
        }
        .table-sort tbody tr:hover {
            background: #e6f3ff;
        }
        .btn-apprendre {
            background: #198754;
            color: #fff;
            border: none;
            padding: 0.35em 1.2em;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }
        .btn-apprendre:disabled,
        .btn-apprendre[disabled] {
            background: #aaa;
            color: #fff;
            cursor: not-allowed;
        }
        .badge-connu {
            background: #198754;
            color: #fff;
            font-size: 0.95em;
            padding: 0.4em 0.8em;
            border-radius: 5px;
        }
        .badge-warning {
            background: #ffc107;
            color: #222;
            font-size: 0.95em;
            padding: 0.4em 0.8em;
            border-radius: 5px;
        }
        .badge-danger {
            background: #dc3545;
            color: #fff;
            font-size: 0.95em;
            padding: 0.4em 0.8em;
            border-radius: 5px;
        }
        .bandeau-sort {
            font-weight: bold;
            background: #0062ff;
            color: #fff;
            border-radius: 8px 8px 0 0;
            padding: 0.7em 1em;
            margin-bottom: 0;
            font-size: 1.15rem;
        }
        @media (max-width: 900px) {
            .fiche-card { 
                padding: 1rem; 
            }
            .table-sort {
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>
    <div class="titre-dojo">
        🥋 <span>Techniques du Dojo</span>
    </div>
    
    <div class="fiche-card">
        <strong>Manuel des Arts Martiaux</strong><br>
        Maîtrisez les techniques ancestrales du dojo et perfectionnez votre art du combat.
        <div style="margin-top: 1rem; font-size: 1.2em;">
            💰 <strong>Pièces d'Or disponibles: <span id="po-count">50</span> PO</strong>
            <button onclick="addGold()" style="margin-left: 1rem; padding: 0.3em 0.8em; background: #ffc107; border: none; border-radius: 4px; cursor: pointer;">+10 PO</button>
        </div>
    </div>

    <div class="bandeau-sort">Répertoire des Techniques</div>
    
    <table class="table-sort">
        <thead>
            <tr>
                <th>Nom de la technique</th>
                <th>Niveau min</th>
                <th>Prix (PO)</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr id="technique-0">
                <td>Poing de tonnerre</td>
                <td>1</td>
                <td>5</td>
                <td>Coup puissant infligeant +2 dégâts</td>
                <td><button class="btn-apprendre" onclick="buyTechnique(0, 5, 'Poing de tonnerre')">Apprendre</button></td>
            </tr>
            <tr id="technique-1">
                <td>Esquive éclair</td>
                <td>1</td>
                <td>8</td>
                <td>Permet d'attaquer immédiatement après une parade</td>
                <td><button class="btn-apprendre" onclick="buyTechnique(1, 8, 'Esquive éclair')">Apprendre</button></td>
            </tr>
            <tr id="technique-2">
                <td>Coup du dragon</td>
                <td>1</td>
                <td>6</td>
                <td>Peut étourdir l'ennemi pendant 1 tour</td>
                <td><button class="btn-apprendre" onclick="buyTechnique(2, 6, 'Coup du dragon')">Apprendre</button></td>
            </tr>
            <tr id="technique-3">
                <td>Parade du tigre</td>
                <td>2</td>
                <td>10</td>
                <td>Ignore l'armure sur un jet critique</td>
                <td><button class="btn-apprendre" onclick="buyTechnique(3, 10, 'Parade du tigre')">Apprendre</button></td>
            </tr>
            <tr id="technique-4">
                <td>Frappe tourbillon</td>
                <td>2</td>
                <td>12</td>
                <td>Frappe tous les ennemis autour</td>
                <td><button class="btn-apprendre" onclick="buyTechnique(4, 12, 'Frappe tourbillon')">Apprendre</button></td>
            </tr>
            <tr id="technique-5">
                <td>Attaque du cobra</td>
                <td>1</td>
                <td>9</td>
                <td>Bonus de +2 au jet d'attaque</td>
                <td><button class="btn-apprendre" onclick="buyTechnique(5, 9, 'Attaque du cobra')">Apprendre</button></td>
            </tr>
            <tr id="technique-6">
                <td>Coup du phénix</td>
                <td>2</td>
                <td>11</td>
                <td>Fait tomber l'ennemi au sol sur un succès</td>
                <td><button class="btn-apprendre" onclick="buyTechnique(6, 11, 'Coup du phénix')">Apprendre</button></td>
            </tr>
            <tr id="technique-7">
                <td>Mille poings</td>
                <td>3</td>
                <td>15</td>
                <td>Double les dégâts avec une arme lourde</td>
                <td><button class="btn-apprendre" onclick="buyTechnique(7, 15, 'Mille poings')">Apprendre</button></td>
            </tr>
            <tr id="technique-8">
                <td>Fureur du guerrier</td>
                <td>3</td>
                <td>18</td>
                <td>Permet deux attaques consécutives</td>
                <td><button class="btn-apprendre" onclick="buyTechnique(8, 18, 'Fureur du guerrier')">Apprendre</button></td>
            </tr>
            <tr id="technique-9">
                <td>Jet de kunai</td>
                <td>1</td>
                <td>5</td>
                <td>Attaque à distance avec une arme légère</td>
                <td><button class="btn-apprendre" onclick="buyTechnique(9, 5, 'Jet de kunai')">Apprendre</button></td>
            </tr>
            <tr id="technique-10">
                <td>Pas de l'ombre</td>
                <td>2</td>
                <td>10</td>
                <td>Ignore bonus de DEX à la CA</td>
                <td><button class="btn-apprendre" onclick="buyTechnique(10, 10, 'Pas de l\'ombre')">Apprendre</button></td>
            </tr>
            <tr id="technique-11">
                <td>Riposte du maître</td>
                <td>2</td>
                <td>12</td>
                <td>Riposte automatique sur échec de l'adversaire</td>
                <td><button class="btn-apprendre" onclick="buyTechnique(11, 12, 'Riposte du maître')">Apprendre</button></td>
            </tr>
            <tr id="technique-12">
                <td>Coup du genou</td>
                <td>1</td>
                <td>4</td>
                <td>Frappe à courte portée, désoriente</td>
                <td><button class="btn-apprendre" onclick="buyTechnique(12, 4, 'Coup du genou')">Apprendre</button></td>
            </tr>
            <tr id="technique-13">
                <td>Frappe du lion</td>
                <td>3</td>
                <td>20</td>
                <td>Dégâts x1,5 si PV < 50 %</td>
                <td><button class="btn-apprendre" onclick="buyTechnique(13, 20, 'Frappe du lion')">Apprendre</button></td>
            </tr>
            <tr id="technique-14">
                <td>Garde parfaite</td>
                <td>2</td>
                <td>14</td>
                <td>Annule les dégâts une fois par combat</td>
                <td><button class="btn-apprendre" onclick="buyTechnique(14, 14, 'Garde parfaite')">Apprendre</button></td>
            </tr>
            <tr id="technique-15">
                <td>Charge du sanglier</td>
                <td>3</td>
                <td>16</td>
                <td>Dégâts + jet de Force pour repousser</td>
                <td><button class="btn-apprendre" onclick="buyTechnique(15, 16, 'Charge du sanglier')">Apprendre</button></td>
            </tr>
            <tr id="technique-16">
                <td>Technique circulaire</td>
                <td>4</td>
                <td>22</td>
                <td>Frappe tous les ennemis dans un cône de 3 cases</td>
                <td><button class="btn-apprendre" onclick="buyTechnique(16, 22, 'Technique circulaire')">Apprendre</button></td>
            </tr>
            <tr id="technique-17">
                <td>Frappe critique renforcée</td>
                <td>4</td>
                <td>25</td>
                <td>Critique sur 19-20 au lieu de 20</td>
                <td><button class="btn-apprendre" onclick="buyTechnique(17, 25, 'Frappe critique renforcée')">Apprendre</button></td>
            </tr>
            <tr id="technique-18">
                <td>Art du silence</td>
                <td>2</td>
                <td>13</td>
                <td>Ne déclenche pas d'alerte lors d'un combat furtif</td>
                <td><button class="btn-apprendre" onclick="buyTechnique(18, 13, 'Art du silence')">Apprendre</button></td>
            </tr>
            <tr id="technique-19">
                <td>Désarmer</td>
                <td>3</td>
                <td>15</td>
                <td>Force l'ennemi à lâcher son arme sur réussite</td>
                <td><button class="btn-apprendre" onclick="buyTechnique(19, 15, 'Désarmer')">Apprendre</button></td>
            </tr>
        </tbody>
    </table>

    <div style="margin-top: 2rem; text-align: center; color: #666;">
        <p><em>🏯 Honorez les traditions du dojo et perfectionnez votre art martial 🏯</em></p>
    </div>

    <script>
        let goldCount = 50;
        let learnedTechniques = [];

        function updateGoldDisplay() {
            document.getElementById('po-count').textContent = goldCount;
            
            // Met à jour l'état des boutons
            const buttons = document.querySelectorAll('.btn-apprendre');
            buttons.forEach((button, index) => {
                if (!learnedTechniques.includes(index)) {
                    const cost = parseInt(button.getAttribute('onclick').match(/\d+/)[0]);
                    if (goldCount < cost) {
                        button.disabled = true;
                        button.textContent = 'Pas assez de PO';
                        button.style.background = '#dc3545';
                    } else {
                        button.disabled = false;
                        button.textContent = 'Apprendre';
                        button.style.background = '#198754';
                    }
                }
            });
        }

        function addGold() {
            goldCount += 10;
            updateGoldDisplay();
        }

        function buyTechnique(id, cost, name) {
            if (goldCount >= cost && !learnedTechniques.includes(id)) {
                goldCount -= cost;
                learnedTechniques.push(id);
                
                // Met à jour l'affichage
                const button = document.querySelector(`#technique-${id} .btn-apprendre`);
                button.textContent = '✓ Maîtrisée';
                button.disabled = true;
                button.style.background = '#28a745';
                button.style.color = '#fff';
                
                // Change la couleur de la ligne
                const row = document.getElementById(`technique-${id}`);
                row.style.background = '#d4edda';
                row.style.borderLeft = '4px solid #28a745';
                
                updateGoldDisplay();
                
                // Message de confirmation
                showMessage(`✨ Vous avez appris la technique "${name}" ! (-${cost} PO)`, 'success');
            } else if (learnedTechniques.includes(id)) {
                showMessage('Vous maîtrisez déjà cette technique !', 'info');
            } else {
                showMessage(`Pas assez de PO ! Il vous faut ${cost} PO pour apprendre cette technique.`, 'error');
            }
        }

        function showMessage(text, type) {
            // Supprime l'ancien message s'il existe
            const oldMessage = document.getElementById('message');
            if (oldMessage) {
                oldMessage.remove();
            }

            // Crée le nouveau message
            const message = document.createElement('div');
            message.id = 'message';
            message.textContent = text;
            message.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 1rem 1.5rem;
                border-radius: 8px;
                color: white;
                font-weight: bold;
                z-index: 1000;
                animation: slideIn 0.3s ease-out;
                max-width: 300px;
            `;

            // Couleurs selon le type
            if (type === 'success') {
                message.style.background = '#28a745';
            } else if (type === 'error') {
                message.style.background = '#dc3545';
            } else {
                message.style.background = '#17a2b8';
            }

            document.body.appendChild(message);

            // Supprime le message après 3 secondes
            setTimeout(() => {
                if (message) {
                    message.style.animation = 'slideOut 0.3s ease-in';
                    setTimeout(() => message.remove(), 300);
                }
            }, 3000);
        }

        // Animation CSS
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);

        // Initialise l'affichage
        updateGoldDisplay();
    </script>
</body>
</html>