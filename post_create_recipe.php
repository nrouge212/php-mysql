<?php
session_start();
include_once('mysql.php');

// Vérification de la session
if (!isset($_SESSION['LOGGED_USER'])) {
    echo 'Vous devez être connecté pour effectuer cette action.';
    return;
}

if (!isset($_POST['title']) || !isset($_POST['recipe'])) {
    echo 'Il faut un titre et une recette pour soumettre le formulaire.';
    return;
}

$title = $_POST['title'];
$recipe = $_POST['recipe'];
$author = $_SESSION['LOGGED_USER']; 

$sqlQuery = 'INSERT INTO recipes (title, recipe, author, is_enabled) VALUES (:title, :recipe, :author, :is_enabled)';
$insertRecipe = $db->prepare($sqlQuery);
$insertRecipe->execute([
    'title' => $title,
    'recipe' => $recipe,
    'author' => $author,
    'is_enabled' => 1
]);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Site de recettes - Recette ajoutée</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">
        <?php include_once('header.php'); ?>
        
        <h1>Recette ajoutée avec succès !</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($title); ?></h5>
                <p class="card-text"><b>Auteur</b> : <?php echo htmlspecialchars($author); ?></p>
                <p class="card-text"><b>Recette</b> : <?php echo htmlspecialchars($recipe); ?></p>
            </div>
        </div>
    </div>
    <?php include_once('footer.php'); ?>
</body>
</html>