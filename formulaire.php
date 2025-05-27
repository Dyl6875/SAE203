    <?php
    /* formulaire de commande */

    /* Initialisation des variables */
    $resultat = "";
    $message = "";
    $erreur = "";

    if (!empty($_POST["nom"])) /* initialisation des donnees */
        $nom = $_POST["nom"];
    else
        $nom = '';

    if (!empty($_POST["prenom"]))
        $prenom = $_POST["prenom"];
    else
        $prenom = '';

    /* Le résultat du traitement est enregistré dans $message */
    if (isset($_POST["clic"]))   /* si le formulaire a ete valide */ {

        if (!empty($nom) && !empty($prenom))
            $message .=  $nom . " " . $prenom . "<br>"; /* verification si definie */
        else
            $erreur .= "met un nom et un prenom <br>"; /* message d'erreur */
    }

    if (!empty($_POST["marque"]))
        $marque = $_POST["marque"];
    else
        $marque = '';

    if ($marque != "") {
        $message .= "Vous avez séléctionner la marque suivante : <span>$marque </span>";
    }

    /* var_dump($_POST); */
    ?>

    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SAE 203</title>
        <link rel="stylesheet" href="styles/style.css">
        <link rel="icon" href="img/ferrari-logo-750x1100-grand.png"> <!-- Icône pour l'onglet du navigateur -->

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
                <form action="formulaire2.php" method="post"> <!-- initialisation du formulaire les differente donnee a transmettre -->
                    <label class="form_elt">
                        <span>Nom</span>
                        <input type="text" name="nom" value="<?= $nom ?>">
                    </label>

                    <label class="form_elt">
                        <span>Prénom</span>
                        <input type="text" name="prenom" value="<?= $prenom ?>">
                    </label>
                    <label class="form_elt">
                        Marque disponible :
                        <select name="marque">
                            <option></option>
                            <option value="ferrari"
                                <?php
                                if ($marque == "ferrari")
                                    echo "selected";
                                ?>>Ferrari</option>
                            <option value="porsche">
                                <?php
                                if ($marque == "porsche")
                                    echo "selected";
                                ?>
                                Porsche</option>
                            <option value="bugatti">
                                <?php
                                if ($marque == "bugatti")
                                    echo "selected";
                                ?>
                                Bugatti</option>
                            <option value="lamborghini">
                                <?php
                                if ($marque == "lamborghini")
                                    echo "selected";
                                ?>
                                Lamborghini</option>
                        </select>
                    </label>
                    <button class="valid" name="clic" value="ok">→ Étape 2</button> <!-- bouton validation -->
                </form>
                <?= $resultat;

                if (empty($erreur)) /* affichage du resultat sur la page 2 */
                    echo $message;
                else
                    echo "<div class='erreur'>$erreur";
                ?>
            </div>
            <?php

            if (isset($_POST['clic']) && $erreur === '') {
                /* connexion PDO */
                require __DIR__ . '/donnee.php';

                /* préparation et exécution de l'insertion */
                $sql = "
      INSERT INTO commande (nom, prenom, marque, date)
      VALUES (:nom, :prenom, :marque, NOW())
    ";
                $garder = $pdo->prepare($sql);
                $garder->execute([
                    ':nom'    => $nom,
                    ':prenom' => $prenom,
                    ':marque' => $marque
                ]);
            }
            ?>

        </main>

        <script src="js/script.js"></script>
    </body>

    </html>