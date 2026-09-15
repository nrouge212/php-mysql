<?php
// On vérifie d'abord l'email et le message comme avant...
if (
    (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
    || (!isset($_POST['message']) || empty($_POST['message']))
) {
    echo('Il faut un email et un message valides pour soumettre le formulaire.');
    return;
}

// NOUVEAU : Traitement du fichier uploadé
// Testons si le fichier a bien été envoyé et s'il n'y a pas d'erreur
if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] == 0) {
    // Testons si le fichier n'est pas trop gros
    if ($_FILES['screenshot']['size'] <= 1000000) {
        // Testons si l'extension est autorisée
        $fileInfo = pathinfo($_FILES['screenshot']['name']);
        $extension = $fileInfo['extension'];
        $allowedExtensions = ['jpg', 'jpeg', 'gif', 'png'];
        
        if (in_array($extension, $allowedExtensions)) {
            
            // 1. On liste les fichiers déjà présents dans le dossier pour faire un compteur
            $fichiersExistants = glob('uploads/*');
            $compteur = count($fichiersExistants) + 1;
            
            // 2. On génère le nouveau nom (ex: "1.jpg", "2.png")
            $nouveauNom = $compteur . '.' . $extension;
            
            // 3. On sauvegarde le fichier avec ce nom propre et unique
            move_uploaded_file($_FILES['screenshot']['tmp_name'], 'uploads/' . $nouveauNom);
            
            echo "<p>L'envoi a bien été effectué sous le nom : " . htmlspecialchars($nouveauNom) . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de recettes - Contact reçu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">
        <?php include_once('header.php'); ?>
        
        <h1>Message bien reçu !</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Rappel de vos informations</h5>
                <p class="card-text"><b>Email</b> : <?php echo htmlspecialchars($_POST['email']); ?></p>
                <p class="card-text"><b>Message</b> : <?php echo htmlspecialchars($_POST['message']); ?></p>
            </div>
        </div>

    </div>
    <?php include_once('footer.php'); ?>
</body>
</html>