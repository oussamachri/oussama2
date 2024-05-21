<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: authentifier.php");
    exit();
}

include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $filiere = $_POST['filiere'];
    $image = $_FILES['image']['name'];
    $target = "images/" . basename($image);

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $sql = "INSERT INTO stagiaires (nom, prenom, filiere, image) VALUES ('$nom', '$prenom', '$filiere', '$image')";
        if ($conn->query($sql) === TRUE) {
            header("Location: espaceprivee.php");
        } else {
            echo "Erreur: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Échec du téléchargement de l'image.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Stagiaire</title>
</head>
<body>
    <form method="post" action="InsererStagiaire.php" enctype="multipart/form-data">
        <label>Nom:</label><input type="text" name="nom" required><br>
        <label>Prénom:</label><input type="text" name="prenom" required><br>
        <label>Filière:</label>
        <select name="filiere" required>
            <?php
            $sql = "SELECT * FROM filieres";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($filiere = $result->fetch_assoc()) {
                    echo "<option value='{$filiere['id']}'>{$filiere['intitule']}</option>";
                }
            }
            ?>
        </select><br>
        <label>Image:</label><input type="file" name="image" required><br>
        <input type="submit" value="Ajouter">
    </form>
</body>
</html>