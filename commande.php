<?php
/* on prend les données de mon fichier donnee.php */
require 'donnee.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
  $nom    = trim($_POST['nom']    ?? ''); /* recupere toute les donnee que j'aimerai */ 
  $prenom = trim($_POST['prenom'] ?? ''); 
  $marque = trim($_POST['marque'] ?? '');
  $modele = trim($_POST['modele'] ?? '');

  if ($nom && $prenom && $marque && $modele) { /* verifie que toute les donnee sois definie  */
    /* requete pour inserer le resultat du formulaire (commande supercars) */
    $stmt = $pdo->prepare(" 
      INSERT INTO commande
        (nom, prenom, marque, modele, date)
      VALUES
        (:nom, :prenom, :marque, :modele, NOW())
    ");
    $stmt->execute([ /* execution de la requete */
      ':nom'    => $nom,
      ':prenom' => $prenom,
      ':marque' => $marque,
      ':modele' => $modele,
    ]);

   /* redirige en GET pour éviter le double-post de formulaire */
    header('Location: commande.php');
    exit;
  }
}

/* recuperation de toute les commandes en cours par date decroissante */ 
$stmt = $pdo->query(" 
  SELECT id_commande, nom, prenom, marque, modele, date
    FROM commande
   ORDER BY date DESC
");
$commandes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Les commandes en cours</title>
  <link rel="stylesheet" href="styles/style.css">
</head>

<body>

  <header>
    <div class="ttt"><a href="index.php">Accueil</a></div>
      <h1>Les commandes en cours</h1>
  </header>

  <main>
    <div class="resultat">
      <?php if (empty($commandes)): ?>
        <p>Aucune commande pour le moment.</p> <!-- si il n'y a pas de commande ce message s'affiche  -->
      <?php else: ?>
        <div class="modele"> <!-- en tete du "tableau" des commandes -->
          <div>#</div>
          <div>Nom</div>
          <div>Prénom</div>
          <div>Marque</div>
          <div>Modèle</div>
          <div>Date</div>
        </div>
        <?php foreach ($commandes as $c): ?>
          <div class="modele"> <!-- affichage des commandes avec toute les donnee -->
            <div><?= $c['id_commande'] ?></div>
            <div><?= $c['nom'] ?></div>
            <div><?= $c['prenom'] ?></div>
            <div><?= $c['marque'] ?></div>
            <div><?= $c['modele'] ?></div>
            <div><?= date('H:i d/m/Y', strtotime($c['date'])) ?></div> <!-- heure en version française et non anglaise -->
          </div>
        <?php endforeach ?>
      <?php endif ?>
    </div>
  </main>

</body>

</html>