<?php
session_start();
include_once('mysql.php');
if (!isset($_SESSION['LOGGED_USER'])) {
    echo('Vous devez être connecté pour effectuer cette action.');
    return;
}
$getData = $_GET;
if (!isset($getData['id']) || !is_numeric($getData['id'])) {
    echo('Il faut un identifiant de recette valide pour la supprimer.');
    return;
}
$id = $getData['id'];
$retrieveRecipeStatement = $db->prepare('SELECT * FROM recipes WHERE recipe_id = :id');
$retrieveRecipeStatement->execute(['id' => $id]);
$recipe = $retrieveRecipeStatement->fetch();
if (!$recipe || $recipe['author'] !== $_SESSION['LOGGED_USER']) {
    echo('Vous n\'avez pas les droits pour supprimer cette recette.');
    return;
}
$deleteRecipeStatement = $db->prepare('DELETE FROM recipes WHERE recipe_id = :id');
$deleteRecipeStatement->execute(['id' => $id]);
header('Location: index.php');
exit();
?>