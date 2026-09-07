<?php
 
$users = [
    [
        'full_name' => 'John Doe',
        'email' => 'john.doe@gmail.com',
        'age' => '35'
    ],
    [
        'full_name' => 'Jane Doe',
        'email' => 'jane.doe@gmail.com',
        'age' => '54'
    ],
    [
        'full_name' => 'mickael andrieu',
        'email' => 'mickael.andrieu@exemple.com',
        'age' => '15'
    ],
];
 
$recipes = [
    [
        'title' => 'Cassoulet',
        'recipe' => 'Etape 1 Flageolait',
        'author' => 'mickael.andrieu@exemple.com',
        'enabled' => true
    ],
    [
        'title' => 'Couscous',
        'recipe' => 'Etape 1 Semoule',
        'author' => 'mickael.andrieu@exemple.com',
        'enabled' => false
    ],
    [
        'title' => 'Frite',
        'recipe' => 'Etape 1 Pomme de Terre',
        'author' => 'mickael.andrieu@exemple.com',
        'enabled' => true
    ],
];
 
function isValidRecipe(array $recipe): bool {
    return $recipe['enabled'] === true;
}
 
function getRecipes(array $recipes): array {
    $validRecipes = [];
 
    foreach ($recipes as $recipe) {
        if (isValidRecipe($recipe)) {
            $validRecipes[] = $recipe;
        }
    }
 
    return $validRecipes;
}
 
function displayAuthor(string $authorEmail, array $users): string {
    for ($i = 0; $i < count($users); $i++) {
        $author = $users[$i];
 
        if ($authorEmail === $author['email']) {
            return $author['full_name'] . ' (' . $author['age'] . ' ans)';
        }
    }
 
    return 'Auteur inconnu';
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css">
    <title>Affichage des recettes</title>
</head>
<body>
<?php foreach (getRecipes($recipes) as $recipe): ?>
<article>
    <h1><?php echo $recipe['title']; ?></h1>
    <h2><?php echo $recipe['recipe']; ?></h2>
    <i><?php echo displayAuthor($recipe['author'], $users); ?></i>
</article>
<?php endforeach; ?>
 
</body>
</html>