<!DOCTYPE html>

<html lang="fr">

	<head>
		<meta charset="utf-8" />
		<title>Mes tâches</title>
		<link rel="stylesheet" href="../CSS/taches.css"/>
	</head>

	<body>
     <?php
		if (!isset($_COOKIE["usernamecookie"])) {
			//Demande de reconnection si aucun cookies de connexion n'ont été trouvés
			echo "<h2 class='user'>Votre session a expiré. <a href='../HTML/connection.html'>Veuillez vous reconnecter</a></h2>";
		} else {
			//La valeur du cookie est placé dans la variable $username
			$username = $_COOKIE["usernamecookie"];
			//Affichage d'un message de bienvenue avec le nom d'utilisateur
			echo "<h2 class='user'>Bonjour " . $username . " ! </h2>
			<!-- Bouton de déconnexion -->
			<a class='disconnect' href='disconnect.php'>Se déconnecter</a>";
		}
?>
		<div class="addtask">
			<!--Formulaire d'ajout d'une tâche renvoyant à la page "add.php" -->
			<h1>Ajouter une tâche:</h1>
			<div class="form"><form method="post" action="add.php">
				<p>Nom de la tâche: <input type="text" name="TaskName"/> 
				Description: <textarea name="Description"  cols="40"/></textarea>
				Date: <input type="text" name="TaskDate"/>
				Statut: 
				<Select name="status">
					<option value="En cours">En cours</option>
					<option value="Terminé">Terminé</option>
					<option value="À faire">À faire</option>
				</Select>
				<input class="submit" type="submit" value="Créer" /></p>
			</form></div>
			<!--Affichage des tâches et possibilité de les modifier/supprimer -->
			<div class="task"><h2>Vos tâches:</h2></div>
			<?php
				//Connection à la base de données
				$connect = mysqli_connect("localhost", "nom", "motdepasse", "basededonnées");
				//Déclaration de la requête de récupération de l'ID de l'utilisateur
				$useridquery = "SELECT userid FROM users WHERE username='$username';";
				//Envoie de la requête
				$userid = mysqli_query($connect, $useridquery);
				//Récupération de la colonne sous forme de tableau
				$getuserid = mysqli_fetch_array($userid);
				//Déclaration d'une requête pour récupérer les colonnes des tâche de l'utilisateur en fonction de son ID
				$taskquery = "SELECT TaskID, TaskName, TaskDescription, TaskDate, TaskStatus FROM tasks WHERE UserID='{$getuserid['userid']}';";
				//Envoie de la requête
				$task = mysqli_query($connect, $taskquery);
				if (mysqli_num_rows($task) <= 0) {
					//Message si aucune tâches n'a été entrées
					echo "<h2>Vous n'avez pas de tâches enregistrées.</h2>";
				} else {
					//Affichage de toute les colonnes dans un tableau
					echo "<table>
							<thead>
								<tr><th>Nom</th><th>Description</th><th>Date</th><th>Statut</th><th colspan='2'>Actions</th></tr>
							</thead>";
							$index = 0;
							while ($gettask = mysqli_fetch_assoc($task)) {
								++$index;
								$element = "element_" . $index;
								setcookie($element, $gettask['TaskID'], time() + (3600 * 24), "/");
								echo $COOKIE_['$element'];
								echo "<tr><td>" . $gettask['TaskName'] . 
								"</td><td>" . $gettask['TaskDescription'] . 
								"</td><td>" . $gettask['TaskDate'] .
								"</td><td>" . $gettask['TaskStatus'] . "</td><td>
								<a href='edit.php?id=" . $gettask['TaskID'] . "'>Modifier</a>
								<!--Lien modifier et supprimer -->
								<td><a class='delete' href ='delete.php?id=" . $gettask['TaskID'] . "'>Supprimer</a></td></tr>";
							}
							echo "</table>";
							//Fermeture de la connexion
				}
				mysqli_close($connect);

			?>
		</div>

	
	</body>
</html>

