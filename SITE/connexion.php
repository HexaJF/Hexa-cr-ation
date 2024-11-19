<?php
// connexion.php

// Paramètres de connexion
$host = 'localhost';
$dbname = 'nom_de_la_base';
$username = 'nom_utilisateur';
$password = 'mot_de_passe';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = $_POST['username'];
        $pass = $_POST['password'];

        // Vérification dans la base de données
        $stmt = $pdo->prepare('SELECT * FROM utilisateurs WHERE nom_utilisateur = :username AND mot_de_passe = :password');
        $stmt->execute(['username' => $user, 'password' => $pass]);
        $utilisateur = $stmt->fetch();

        if ($utilisateur) {
            echo 'Connexion réussie ! Bienvenue, ' . htmlspecialchars($user);
        } else {
            echo 'Nom d\'utilisateur ou mot de passe incorrect.';
        }
    }
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}
?>
