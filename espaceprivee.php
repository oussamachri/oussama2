<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: authentifier.php");
    exit();
}

include 'db_connection.php';

$login = $_SESSION['login'];
$sql = "SELECT nom, prenom FROM administrateurs WHERE login = '$login'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$hour = date('H');
$greeting = ($hour < 18) ? 'Bonjour' : 'Bonsoir';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Privé</title>
</head>
<body>
    <h1><?php echo "$greeting, " . $row['prenom'] . " " . $row['nom']; ?></h1>
    <h2>Liste des stagiaires</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Filière</th>
            <th>Actions</th>
        </tr>
        <?php
        $sql = "SELECT * FROM stagiaires";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($stagiaire = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$stagiaire['id']}</td>
                        <td>{$stagiaire['nom']}</td>
                        <td>{$stagiaire['prenom']}</td>
                        <td>{$stagiaire['filiere']}</td>
                        <td>
                            <a href='ModifierStagiaire.php?id={$stagiaire['id']}'>Modifier</a>
                            <a href='SupprimerStagiaire.php?id={$stagiaire['id']}'>Supprimer</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Aucun stagiaire trouvé</td></tr>";
        }
        ?>
    </table>
    <a href="InsererStagiaire.php">Ajouter</a>
    <a href="deconnexion.php">Se déconnecter</a>
</body>
</html>