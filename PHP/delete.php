<?php 
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

//Vérification de l'obtention d'un ID valide
if(isset($_GET['id'])) {
	//Récupération de l'ID dans une variable
	$id = $_GET['id'];
	//connexion à la base de données
	$connect = mysqli_connect("localhost", "lovinrob", "JuinCerber", "taskmanager");
	//Décclaration de la requête de suppression de la tâche en fonction de l'ID de la tâche
	$deletequery = "DELETE FROM tasks WHERE TaskID = $id;";
	//Envoie de la requête
	$delete = mysqli_query($connect, $deletequery);
	//Fermeture de la connexion
    mysqli_close($connect);
    //Renvoie vers la liste des tâches
	header("Location: taches.php");
} else {
	//Message d'erreur si l'ID n'est pas valide
	echo "<p>Erreur du serveur ou de la base de données</p>";
}
?>
