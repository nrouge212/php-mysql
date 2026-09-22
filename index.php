<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de recettes - Page d'accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">
        <?php include_once('header.php'); ?>
        
        <?php
        include_once('mysql.php');
        include_once('variables.php');
        include_once('functions.php');
        ?>
        
        <?php include_once('login.php'); ?>
        
        <?php
        $sqlQuery = 'SELECT * FROM recipes WHERE is_enabled = 1';
        $recipesStatement = $db->prepare($sqlQuery);
        $recipesStatement->execute();
        $recipes = $recipesStatement->fetchAll();
        ?>
        
        <h1>Site de recettes</h1>
        
        <?php if(isset($_SESSION['LOGGED_USER'])): ?>
            <?php foreach ($recipes as $recipe): ?>
                <article>
                    <h3><a href="read.php?id=<?php echo $recipe['recipe_id']; ?>"><?php echo $recipe['title']; ?></a></h3>
                    <div><?php echo $recipe['recipe']; ?> </div>
                    <i><?php echo displayAuthor($recipe['author'], $users); ?></i>
                    <?php if(isset($_SESSION['LOGGED_USER']) && $recipe['author'] === $_SESSION['LOGGED_USER']): ?>
                        <p><a href="update_recipe.php?id=<?php echo $recipe['recipe_id']; ?>">Éditer la recette</a> | 
                        <a href="delete_recipe.php?id=<?php echo $recipe['recipe_id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette recette ?');">Supprimer la recette</a>
                        </p>
                    <?php endif; ?>
                </article>
            <?php endforeach ?>
        <?php endif; ?>
    </div>
    <?php include_once('footer.php'); ?>
</body>
</html>