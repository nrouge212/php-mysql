<?php
session_start();
include_once('mysql.php');
include_once('variables.php');
include_once('functions.php');

$getData = $_GET;

if (!isset($getData['id']) || !is_numeric($getData['id'])) {
    echo('La recette n\'existe pas.');
    return;
}

$recipeStatement = $db->prepare('SELECT * FROM recipes WHERE recipe_id = :id');
$recipeStatement->execute(['id' => $getData['id']]);
$recipe = $recipeStatement->fetch();

if (!$recipe) {
    echo('Cette recette n\'existe pas.');
    return;
}

$commentsStatement = $db->prepare('SELECT * FROM comments WHERE recipe_id = :id');
$commentsStatement->execute(['id' => $getData['id']]);
$comments = $commentsStatement->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($recipe['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">
        <?php include_once('header.php'); ?>
        
        <h1><?php echo htmlspecialchars($recipe['title']); ?></h1>
        <div class="mb-3">
            <?php echo htmlspecialchars($recipe['recipe']); ?>
        </div>
        <i><?php echo displayAuthor($recipe['author'], $users); ?></i>

        <hr>

        <h2>Commentaires</h2>
        
        <?php if ($comments): ?>
            <?php foreach($comments as $comment): ?>
                <div class="card mb-2">
                    <div class="card-body">
                        <p class="card-text"><?php echo htmlspecialchars($comment['comment']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun commentaire pour le moment.</p>
        <?php endif; ?>
        <?php if(isset($_SESSION['LOGGED_USER'])): ?>
            <form action="post_create_comment.php" method="POST" class="mt-4">
                <input type="hidden" name="recipe_id" value="<?php echo $recipe['recipe_id']; ?>">
                <div class="mb-3">
                    <label for="comment" class="form-label">Postez un commentaire</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        <?php endif; ?>
    </div>
    <?php include_once('footer.php'); ?>
</body>
</html>