<?php
// on prend les données de mon fichier donnee.php
require 'donnee.php';

$marques = $pdo /* requete qui recupere les infos modele de chaque marque */
    ->query("SELECT id_marque, nom FROM marque ORDER BY nom")
    ->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAE 203</title>
    <link rel="stylesheet" href="styles/style.css"> <!-- lien vers mon style -->
    <link rel="icon" href="img/floguicar2.png"> <!-- Icône d'onglet du navigateur -->

</head>

<body>

    <header>
        <div class="gauche">
            <a href="filtre.php">Toutes les marques ▼</a> <!-- lien vers ma page de filtre -->
            <div class="menu">
                <div class="gap"><a href="modele.php?marque_id=1">Ferrari</a></div> <!-- menu deroulant avec toute les marques dispo -->
                <div class="gap"><a href="modele.php?marque_id=2">Porsche</a></div>
                <div class="gap"><a href="modele.php?marque_id=3">Bugatti</a></div>
                <div class="gap"><a href="modele.php?marque_id=4">Lamborghini</a></div>
            </div>
        </div>

        <div class="centre">
            <a href="index.php"> <!-- mon titre renvoie à la page d'acceuil  -->
                <h1>Supercars</h1>
            </a>
        </div>

        <div class="tt">
            <div><a href="commande.php">Les commandes en cours</a></div> <!-- lien vers ma page de commande -->
        </div>

    </header>

    <main>
        <div class="tout">
            <div class="video-background">
                <video autoplay muted loop playsinline>
                    <source src="video/background.mov" type="video/mp4"> <!-- video d'arriere plan -->
                    Ton navigateur ne supporte pas la vidéo.
                </video>
            </div>
            <a href="formulaire.php"> <!-- lien qui renvoie sur ma page pour commander une nouvelle supercars -->
                <h2>Commande ta nouvelle SuperCars</h2>
            </a>
        </div>

        <div class="floguitaille"> <!-- ptit fun fact avec florian -->
            <div class="floguimax"><a target="_blank" href="https://linktr.ee/Florian.seiller"><img src="img/floguicar2.png" alt="Logo"></a></div>
        </div>
    </main>

    <footer>

    </footer>

    <?php
    if (!empty($_GET['marque_id'])) { /* php pour si on clic sur un des modeles de mon menu deroulant */
        require 'affiche_modeles.php';
    }
    ?>
</body>

</html>