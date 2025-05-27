<?php
/* page 2 du formulaire avec les modele de la marque choisi */
if (empty($_POST['nom']) || empty($_POST['prenom']) || empty($_POST['marque'])) { /* verification des donnee demander avant */
  header('Location: formulaire.php'); /* si une donnee est manquante retour à la page 1 */
  exit;
}
/* recuperation des donnees de la page 1 */
$nom    = $_POST['nom'];
$prenom = $_POST['prenom'];
$marque = $_POST['marque'];

/* on prend les données de mon fichier donnee.php */
require 'donnee.php';

/* requete pour les modèles liés à la marque selectionner */
$stmt = $pdo->prepare("
  SELECT id_modele, nom
    FROM modele
   WHERE id_marque = (
     SELECT id_marque FROM marque WHERE nom = ?
   )
   ORDER BY nom
");
$stmt->execute([$marque]); /* execution de la requete avec la marque prise en compte */
$modeles = $stmt->fetchAll(PDO::FETCH_ASSOC); /* recuperation des differents modeles  */
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>SAE 203 – Étape 2</title>
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
      <a href="index.php">
        <h1>Supercars</h1>
      </a>
    </div>
    <div class="tt">
      <div><a href="commande.php">Les commandes en cours</a></div>
    </div>
  </header>

  <main>
    <div class="resultat">
      <p>
        <strong>Client :</strong> <?= "$nom $prenom" ?><br> <!-- affichage des renseignement demander à la page 1 -->
        <strong>Marque :</strong> <?= $marque ?>
      </p>

      <form action="commande.php" method="post"> <!-- donnee à afficher dans commande en cours -->
        <input type="hidden" name="nom" value="<?= $nom ?>"> 
        <input type="hidden" name="prenom" value="<?= $prenom ?>">
        <input type="hidden" name="marque" value="<?= $marque ?>">

        <label class="form_elt">
          <span>Modèle disponible :</span> 
          <select name="modele" required> <!-- case choisir le modele -->
            <option value=""></option> <!-- vide par defaut -->
            <?php foreach ($modeles as $m): ?>
              <option value="<?= $m['nom'] ?>">
                <?= $m['nom'] ?>
              </option>
            <?php endforeach ?>
          </select>
        </label>

        <button class="valid" type="submit">Valider ma commande</button> <!-- bouton de validation -->
      </form>
    </div>
  </main>
</body>

</html>