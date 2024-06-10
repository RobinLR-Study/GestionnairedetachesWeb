<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//Vérification si le formulaire a bien été complété
if(isset($_POST['TaskName']) && isset($_POST['Description']) && isset($_POST['status']) && isset($_POST['TaskDate'])) {
	//Connexion à la base de données
	$connect = mysqli_connect("localhost", "nom", "motdepasse", "basededonnées");
	//Récuếration du nom d'utilisateur à partir du cookie généré lors de la connexion
	$username = $_COOKIE["usernamecookie"];
	//Création de la requête permettant d'obtenir l'ID de l'utilisateur
	$useridquery = "SELECT userid FROM users WHERE username='$username';";
	//Envoie de la requête et récupération du résultat
	$userid = mysqli_query($connect, $useridquery);
	//Récupération de la ligne du résultat
	$getuserid = mysqli_fetch_array($userid);
	//Récupération des données du formulaire précédemment entrées
	//La fonction mysqli_real_escape_string évite les erreurs que peuvent engendrés les caractères spéciaux
    $taskname = mysqli_real_escape_string($connect, $_POST['TaskName']);
    $description = mysqli_real_escape_string($connect, $_POST['Description']);
    $date = mysqli_real_escape_string($connect, $_POST['TaskDate']);
    $status = mysqli_real_escape_string($connect, $_POST['status']);
    //Création de la requête ajoutant les données dans une ligne de la table 'tasks'
    $addquery = "INSERT INTO tasks (UserID, TaskName, TaskDescription, TaskDate, TaskStatus) VALUES ('{$getuserid['userid']}', '$taskname', '$description', '$date', '$status');";
    //Envoie de la requête
    $add = mysqli_query($connect, $addquery);
    //Fermeture de la connexion
    mysqli_close($connect);
    //Renvoie à la liste des tâches
    header("Location: taches.php");
} else {
	//Message d'erreur si le formulaire n'a pas bien été complété
    echo "<p>Erreur du formulaire</p>";
}
?>
