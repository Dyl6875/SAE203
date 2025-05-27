<?php
/* on prend les données de mon fichier donnee.php */
require 'donnee.php';
$stmt    = $pdo->query("SELECT nom FROM marque ORDER BY nom"); /* recuperation des marques */
$marques = $stmt->fetchAll(PDO::FETCH_COLUMN);

/* recuperation de toute les infos de chaque modele avec la marque */
$sql     = "
    SELECT 
      m.nom        AS modele_nom,
      m.annee,
      m.motorisation,
      m.puissance,
      m.vitesse_max,
      m.prix,
      mar.nom      AS marque_nom
    FROM modele m
    JOIN marque mar ON m.id_marque = mar.id_marque
    ORDER BY mar.nom, m.nom
";
$modeles = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC); 

/* lecture du filtre */
$filtre = isset($_GET['marque']) ? $_GET['marque'] : 'Toutes';

/* creation du resultat en liste */
$resultat  = '<div id="liste-modeles">';
foreach ($modeles as $m) {
    if ($filtre === 'Toutes' || $m['marque_nom'] === $filtre) { /* affichage de la selection choisi */
        $resultat .= '<div class="vu">';
        $resultat .= '<div>' . $m['modele_nom'] . ' (' . $m['annee'] . ')</div>'; /* affichage modele, annee */
        $resultat .= '<div>Motorisation : ' . $m['motorisation'] . '</div>'; 
        $resultat .= '<div>Puissance : ' . $m['puissance']   . ' ch</div>';
        $resultat .= '<div>Vitesse max : ' . $m['vitesse_max'] . ' km/h</div>';
        $resultat .= '<div>Prix : ' . number_format($m['prix'], 0, ',', ' ') . ' €</div>';
        $resultat .= '</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Filtrer les modèles</title>
  <link rel="stylesheet" href="styles/style.css">
</head>
<body>

  <header>
    <!-- Ton header existant -->
    <div class="gauche">
      <a href="filtre.php">Toutes les marques ▼</a>
      <div class="menu">
        <div class="gap"><a href="modele.php?marque_id=1">Ferrari</a></div>
        <div class="gap"><a href="modele.php?marque_id=2">Porsche</a></div>
        <div class="gap"><a href="modele.php?marque_id=3">Bugatti</a></div>
        <div class="gap"><a href="modele.php?marque_id=4">Lamborghini</a></div>
      </div>
    </div>
    <div class="centre"><a href="index.php"><h1>Supercars</h1></a></div>
    <div class="tt"><div><a href="commande.php">Les commandes en cours</a></div></div>
  </header>

  <main>
    <!-- Formulaire de filtre -->
    <form method="get" action="filtre.php">
      <label>
        Choisir une marque :
        <select name="marque">
          <option value="Toutes"<?php if ($filtre === 'Toutes') echo ' selected'; ?>>Toutes</option> <!-- affichage de toute les marques option par défaut reste au rechargement de la page -->
          <?php foreach ($marques as $mar): ?>
            <option value="<?php echo $mar; ?>"<?php if ($filtre === $mar) echo ' selected'; ?>> <!-- affichage de la marque selectionner et ces modeles reste au rechargement de la page -->
              <?php echo $mar; ?> 
            </option>
          <?php endforeach; ?>
        </select>
      </label>
      <button type="submit">Filtrer</button>
    </form>

    <!-- Affichage des résultats -->
    <?php echo $resultat; ?>
  </main>

</body>
</html>
