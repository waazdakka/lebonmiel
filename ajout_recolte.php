<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require('databaseConfig.php');

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupération des données du formulaire
        $nombre_pots = filter_var($_POST['nombre_pots'],FILTER_SANITIZE_NUMBER_INT);
        $recolte = filter_var($_POST['recolte'], FILTER_SANITIZE_SPECIAL_CHARS);
        $created_at = new DateTimeImmutable('today');
        $created_at = $created_at->format('Y-m-d H:i:s');
        
        $sql = "INSERT INTO stock (nombre_pots, recolte, created_at) VALUES (:nombre_pots, :recolte, :created_at)";
        $stmt = $pdo->prepare($sql);

        // Liaison des paramètres
        $stmt->bindParam(':nombre_pots', $nombre_pots);
        $stmt->bindParam(':recolte', $recolte);
        $stmt->bindParam(':created_at', $created_at);

        // Exécution de la requête
        $stmt->execute();

    header('Location: ' . $_SERVER['HTTP_REFERER']);
        //echo "Données insérées avec succès.";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
