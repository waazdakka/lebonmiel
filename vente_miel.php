<?php
require('databaseConfig.php');

try {
    // Vérification si les données du formulaire ont été envoyées
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupération des données du formulaire
        $type_vente = filter_var($_POST['type_vente'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $acheteur = filter_var($_POST['acheteur'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $vendeur = filter_var($_POST['vendeur'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $nb_pots = filter_var($_POST['nombre_pots'],FILTER_SANITIZE_NUMBER_INT);
        $stock_id = filter_var($_POST['stock_id'], FILTER_SANITIZE_NUMBER_INT);
        $created_at = new DateTimeImmutable('now');
        $created_at = $created_at->format('Y-m-d H:i:s');
        

        // Requête SQL pour insérer les données
        $sql = "INSERT INTO vente (type_vente, nb_pots, stock_id, created_at, acheteur, vendeur) VALUES (:type_vente, :nb_pots, :stock_id, :created_at, :acheteur, :vendeur)";
        $stmt = $pdo->prepare($sql);

        // Liaison des paramètres
        $stmt->bindParam(':type_vente', $type_vente);
        $stmt->bindParam(':acheteur', $acheteur);
        $stmt->bindParam(':vendeur', $vendeur);
        $stmt->bindParam(':nb_pots', $nb_pots);
        $stmt->bindParam(':stock_id', $stock_id);
        $stmt->bindParam(':created_at', $created_at);

        // Exécution de la requête
        $stmt->execute();

    header('Location: ' . $_SERVER['HTTP_REFERER']);

    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
