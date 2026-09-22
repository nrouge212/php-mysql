<?php
session_start();
include_once('mysql.php');

if (!isset($_SESSION['LOGGED_USER'])) {
    header('Location: index.php');
    exit();
}

$getData = $_GET;
if (!isset($getData['id']) || !is_numeric($getData['id'])) {
    echo('Il faut un identifiant de recette valide pour la modifier.');
    return;
}

$retrieveRecipeStatement = $db->prepare('SELECT * FROM recipes WHERE recipe_id = :id');
$retrieveRecipeStatement->execute(['id' => $getData['id']]);
$recipe = $retrieveRecipeStatement->fetch();

// Vérification de la sécurité : l'utilisateur connecté doit être l'auteur
if (!$recipe || $recipe['author'] !== $_SESSION['LOGGED_USER']) {
    echo('Vous n\'avez pas les droits pour modifier cette recette.');
    return;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de recettes - Édition de recette</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">
        <?php include_once('header.php'); ?>
        
        <h1>Mettre à jour la recette</h1>
        
        <form action="post_update_recipe.php" method="POST">
            <input type="hidden" name="id" value="<?php echo($recipe['recipe_id']); ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Titre de la recette</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($recipe['title']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="recipe" class="form-label">Description de la recette</label>
                <textarea class="form-control" id="recipe" name="recipe" style="height: 150px" required><?php echo htmlspecialchars($recipe['recipe']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
    </div>
    <?php include_once('footer.php'); ?>
</body>
</html>