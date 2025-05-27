<?php
/* on prend les données de mon fichier donnee.php */
require 'donnee.php';

/* recuperation de la iste des marques */
$marques = $pdo
    ->query("SELECT nom FROM marque ORDER BY nom")
    ->fetchAll(PDO::FETCH_COLUMN); /* "tableau" qui retourne juste la donnee demander */

/* requete de recuperation de tous les modèles et leur marque */
$modeles = $pdo
    ->query("
      SELECT 
        m.nom         AS modele_nom,
        m.annee,
        m.motorisation,
        m.puissance,
        m.vitesse_max,
        m.prix,
        mar.nom       AS marque_nom
      FROM modele m
      JOIN marque mar USING(id_marque)
      ORDER BY mar.nom, m.nom
    ")
    ->fetchAll(PDO::FETCH_ASSOC);
