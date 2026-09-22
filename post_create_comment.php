<?php
session_start();
include_once('mysql.php');

if (!isset($_SESSION['LOGGED_USER'])) {
    echo('Vous devez être connecté pour écrire un commentaire.');
    return;
}

$postData = $_POST;

if (empty($postData['comment']) || empty($postData['recipe_id']) || !is_numeric($postData['recipe_id'])) {
    echo('Données manquantes ou invalides.');
    return;
}

$comment = $postData['comment'];
$recipeId = $postData['recipe_id'];

// On récupère le user_id de l'utilisateur connecté via son email
$userStatement = $db->prepare('SELECT user_id FROM users WHERE email = :email');
$userStatement->execute(['email' => $_SESSION['LOGGED_USER']]);
$user = $userStatement->fetch();

if (!$user) {
    echo('Utilisateur introuvable.');
    return;
}

$insertComment = $db->prepare('INSERT INTO comments (comment, recipe_id, user_id) VALUES (:comment, :recipe_id, :user_id)');
$insertComment->execute([
    'comment' => $comment,
    'recipe_id' => $recipeId,
    'user_id' => $user['user_id']
]);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Site de recettes - Commentaire ajouté</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">
        <?php include_once('header.php'); ?>
        
        <h1>Commentaire ajouté avec succès !</h1>
        <div class="card">
            <div class="card-body">
                <p class="card-text"><b>Votre commentaire</b> : <?php echo htmlspecialchars($comment); ?></p>
            </div>
        </div>
        <p class="mt-3"><a href="read.php?id=<?php echo $recipeId; ?>" class="btn btn-secondary">Retour à la recette</a></p>
    </div>
    <?php include_once('footer.php'); ?>
</body>
</html>