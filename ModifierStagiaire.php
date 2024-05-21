<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: authentifier.php");
    exit();
}

include 'db_connection.php';

$id = $_GET['id'];
$sql = "SELECT * FROM stagiaires WHERE id = $id";
$result = $conn->query($sql);
$stagiaire = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $filiere = $_POST['filiere'];
    $image = $stagiaire['image'];

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target = "images/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }

    $sql = "UPDATE stagiaires SET nom='$nom', prenom='$prenom', filiere='$filiere', image='$image' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: espaceprivee.php");
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Stagiaire</title>
</head>
<body>
    <form method="post" action="ModifierStagiaire.php?id=<?php echo $id