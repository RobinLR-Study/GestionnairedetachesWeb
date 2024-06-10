<?php 
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

//Vérification si l'ID est existant et si le formulaire a été rempli
if(isset($_GET['id']) && isset($_POST['TaskName']) && isset($_POST['Description']) && isset($_POST['status']) && isset($_POST['TaskDate'])) {
	//Récupération de l'ID de la tâche à modifier
	$id = $_GET['id'];
	//Récuperation du nom, de la description, de la date et du status de la tâche à modifier
	$taskname = $_POST['TaskName'];
	$description = $_POST['Description'];
	$status = $_POST['status'];
	$date = $_POST['TaskDate'];
	//Connexion à la base de données
	$connect = mysqli_connect("localhost", "nom", "motdepasse", "basededonnées");
	//Déclaration de la requête de modification de la colonne
	$editquery = "UPDATE tasks SET TaskName = '$taskname', 
	TaskDescription = '$description', 
	TaskDate = '$date', 
	TaskStatus = '$status' WHERE TaskID = $id;";
	//Envoie de la requête
	$edit = mysqli_query($connect, $editquery);
	//Fermeture de la connexion
	mysqli_close($connect);
	//Renvoie à la liste des tâches enregistrées
	header("Location: taches.php");
	//Fermeture de la connexion
    mysqli_close($connect);
} else {
	//Erreur si le formulaire n'a pas été entièrement rempli.
	echo "<p>Erreur du formulaire</p>";
}
?>
