<?php
$recipes = [
    [
        'title' => 'Cassoulet',
        'recipe' => 'Etape 1 : des flageolets !',
        'author' => 'mickael.andrieu@exemple.com',
        'is_enabled' => true,
    ],
    [
        'title' => 'Couscous',
        'recipe' => 'Etape 1 : de la semoule',
        'author' => 'mickael.andrieu@exemple.com',
        'is_enabled' => true,
    ],
];

?>

 <!DOCTYPE html>
 <html>
 <head>
    <title>Affichage des recettes</title>
</head>
    <h2>Affichage des recettes</h2>

<?php foreach ($recipes as $recipe): ?>
    <?php if ($recipe['is_enabled'] === true): ?>
        <article>
            <h3><?php echo $recipe['title']; ?></h3>
            <p><?php echo $recipe['recipe']; ?></p>
            <i><?php echo $recipe['author']; ?></i>
        </article>
    <?php endif; ?>
<?php endforeach; ?>
</body>
 </html>