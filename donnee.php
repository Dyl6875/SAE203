<?php /* connexion à la base donnee */
try {
  $pdo = new PDO(
    'mysql:host=localhost;dbname=voitures;charset=utf8mb4',
    'root',
    'root',
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
  );
} catch (Exception $e) {
  die('Erreur PDO - ' . $e->getMessage());
}
