<?php
// Vérifier si le formulaire de déconnexion a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sign-out'])) {
    // Code de connexion à la base de données
    $host = 'localhost';
    $username = 'nom_utilisateur';
    $password = 'mot_de_passe';
    $dbname = 'nom_base_de_donnees';

    try {
        // Création de la connexion à la base de données
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

        // Préparer et exécuter la requête de mise à jour
        $sql = "UPDATE user SET connecter = false";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Déconnexion de la base de données
        $conn = null;

        // Rediriger vers la page de déconnexion réussie ou la page principale du jeu
        header("Location: logout-success.php");
        exit();
    } catch (PDOException $e) {
        // Gérer les erreurs de connexion à la base de données
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
    }
}
?>
