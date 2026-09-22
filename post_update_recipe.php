<?php
session_start();
include_once('mysql.php');

if (!isset($_SESSION['LOGGED_USER'])) {
    echo('Vous devez être connecté pour effectuer cette action.');
    return;
}

$postData = $_POST;

if (
    empty($postData['id']) ||
    empty($postData['title']) ||
    empty($postData['recipe'])
) {
    echo('Les données du formulaire sont incomplètes.');
    return;
}

$id = $postData['id'];
$title = $postData['title'];
$recipe = $postData['recipe'];

// Double vérification de sécurité avant la mise à jour
$retrieveRecipeStatement = $db->prepare('SELECT * FROM recipes WHERE recipe_id = :id');
$retrieveRecipeStatement->execute(['id' => $id]);
$recipeData = $retrieveRecipeStatement->fetch();

if (!$recipeData || $recipeData['author'] !== $_SESSION['LOGGED_USER']) {
    echo('Action non autorisée.');
    return;
}

// Requête SQL UPDATE
$updateRecipeStatement = $db->prepare('UPDATE recipes SET title = :title, recipe = :recipe WHERE recipe_id = :id');
$updateRecipeStatement->execute([
    'title' => $title,
    'recipe' => $recipe,
    'id' => $id,
]);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Site de recettes - Recette modifiée</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">
        <?php include_once('header.php'); ?>
        
        <h1>Recette modifiée avec succès !</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($title); ?></h5>
                <p class="card-text"><b>Recette</b> : <?php echo htmlspecialchars($recipe); ?></p>
            </div>
        </div>
    </div>
    <?php include_once('footer.php'); ?>
</body>
</html>