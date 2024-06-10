<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <title>Modifier une tâche</title>
    <link rel="stylesheet" href="../CSS/taches.css" />
</head>

<body>
    <?php 
        //Récupération de l'ID de la tâche à modifier
        $id = $_GET['id'];
        //Connection à la base de données
        $connect = mysqli_connect("localhost", "nom", "motdepasse", "basededonnées");
        //Création de la requête de la colonnes à afficher en fonction de TaskID
        $taskquery = "SELECT TaskName, TaskDescription, TaskDate, TaskStatus FROM tasks WHERE TaskID='$id';";
        //Envoie de la requête à la table tasks
        $task = mysqli_query($connect, $taskquery);
        //Message d'erreur si la tâche n'est pas trouvé
        if (mysqli_num_rows($task) <= 0) {
            //Message d'erreur si la tâche n'est pas trouvé
            echo "<h2>Erreur de la base de données.</h2>";
        } else {
            //Récupération de la colonne obtenue
            $gettask = mysqli_fetch_array($task);
            //Création du formulaire de modification avec les valeurs précédemment entrées avec un lien "Annuler" ramenant aux tâches
            echo "<h3>Modifier une tâche</h3>
            <form method=\"post\" action=\"edit_sent.php?id=$id\">
                <p>Nom de la tâche: <input type=\"text\" name=\"TaskName\" value='" . $gettask['TaskName'] . "'/> 
                Description: <textarea name=\"Description\" cols=\"40\">" . $gettask['TaskDescription'] . "</textarea>
                Date: <input type=\"text\" name=\"TaskDate\" value=\"" . $gettask['TaskDate'] . "\"/>
                Statut: <select name=\"status\">
                    <option value=\"En cours\">En cours</option>
                    <option value=\"terminé\">Terminé</option>
                    <option value=\"À faire\">À faire</option>
                </select>
                <input type=\"submit\" value=\"Modifier\" /></p>
                <!--Lien \"Annuler\" ramenant aux tâches -->
            </form><a class='cancel' href='taches.php'>Annuler</a>";
        }
        //Fermeture de la connexion
        mysqli_close($connect);
    ?>
</body>

</html>
