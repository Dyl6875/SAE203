<?php
/* on prend les données de mon fichier donnee.php */
require 'donnee.php';

/* vérification de marque_id si defini */
if (!isset($_GET['marque_id'])) {
    die('Marque invalide ou non spécifiée'); /* si non message d'erreur */
}
$marque_id = (int) $_GET['marque_id']; /* recuperation de la valeur */

/* Récupération du nom de la marque qui correspond à ce que l'on a choisis */
$stmt   = $pdo->prepare("SELECT nom FROM marque WHERE id_marque = ?");
$stmt->execute([$marque_id]);
$marque = $stmt->fetchColumn(); /* valeur unique */

/* requete pour les modeles */
$stmt   = $pdo->prepare("
    SELECT id_modele, nom, annee, motorisation, puissance, vitesse_max, prix
      FROM modele 
     WHERE id_marque = ? 
  ORDER BY nom
");
$stmt->execute([$marque_id]);
$modeles = $stmt->fetchAll(PDO::FETCH_ASSOC); /* recuperation de tout les resultat en "tableau" */

/* Construction du HTML */
$resultat  = '<h3>Modèles de ' . $marque . '</h3>';

if ($modeles) { 
    foreach ($modeles as $m) { /* initialisation des modeles avec toutes les donnees */
        $resultat .= '<div class="vu">';
        $resultat .=   '<div><strong>' . $m['nom'] . '</strong> (' . $m['annee'] . ')</div>';
        $resultat .=   '<div>';
        $resultat .=     '<div>- Motorisation : ' . $m['motorisation'] . '</div>';
        $resultat .=     '<div>- Puissance : '    . $m['puissance']   . ' ch</div>';
        $resultat .=     '<div>- Vitesse max : '  . $m['vitesse_max'] . ' km/h</div>';
        $resultat .=     '<div>- Prix : '         . number_format($m['prix'], 0, ',', ' ') . ' €</div>';
        $resultat .=   '</div>';
        $resultat .= '</div>';
    }
} else {
    $resultat .= '<p>Aucun modèle enregistré pour cette marque.</p>'; /* message "d'erreur" */
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modèles — <?= $marque ?></title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="icon" href="img/ferrari-logo-750x1100-grand.png">
</head>
<body>

    <header>
        <div class="gauche">
            <a href="filtre.php">Toutes les marques ▼</a>
            <div class="menu">
                <div class="gap"><a href="modele.php?marque_id=1">Ferrari</a></div>
                <div class="gap"><a href="modele.php?marque_id=2">Porsche</a></div>
                <div class="gap"><a href="modele.php?marque_id=3">Bugatti</a></div>
                <div class="gap"><a href="modele.php?marque_id=4">Lamborghini</a></div>
            </div>
        </div>
        <div class="centre">
            <a href="index.php"><h1>Supercars</h1></a>
        </div>
        <div class="tt">
            <div><a href="commande.php">Les commandes en cours</a></div>
        </div>
    </header>

    <main>
        <?php echo $resultat; ?> <!-- affichage du resultat -->
    </main>

</body>
</html>
