<?php
function isValidRecipe($recipe) {
    return $recipe['enabled'] === true;
}

function getRecipes($recipes) {
    $validRecipes = [];
    foreach ($recipes as $recipe) {
        if (isValidRecipe($recipe)) {
            $validRecipes[] = $recipe;
        }
    }
    return $validRecipes;
}

function displayAuthor($authorEmail, $users) {
    for ($i = 0; $i < count($users); $i++) {
        $author = $users[$i];
        if ($authorEmail === $author['email']) {
            return $author['full_name'] . ' (' . $author['age'] . ' ans)';
        }
    }
    return 'Auteur inconnu';
}
?>