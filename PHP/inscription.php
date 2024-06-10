<!DOCTYPE html>

<html lang="fr">

	<head>
		<meta charset="utf-8" />
		<title>Inscription</title>
		<link rel="stylesheet" href="../CSS/connexion.css"/>
	</head>

	<body>
    <div>
		<h1>Bienvenue !</h1>
		<h2>Inscrivez vous:</h2>
		<form method="post" action="inscription.php">
			<p>Nom d'utilisateur: <input type='text' name="nom"/></p>
			<p>Mot de Passe: <input type='text' name="password"/></p>
			<input class='login' type='submit' value="S'inscrire"/>
			<input class='reset' type='reset' value="Réinitialiser les champs"/>
		</form>
		<div class="signup">
			<p>Vous avez déjà un compte ? <a href ='../HTML/connexion.html'>Connectez vous !</a></p>
		</div>
    </div>
    
    <?php
	if((!empty($_POST['nom'])) && !empty($_POST['password'])){
		//Données du formulaire récupérer dans plusieurs variables
		$username = $_POST['nom'];
		$password = $_POST['password'];
		//Recherche d'espace dans le nom d'utilisateur
		//Création d'un tableau avec toutes les chaînes de caractères entre chaque espaces
		$userspacecheck = explode(" ", $username);
		//Création d'un compteur pour compter chaque élément du tableau $userspacecheck
		$userspacecount = count($userspacecheck);
		if ($userspacecount != 1) {
			//Message d'erreur si plus d'un élément sont trouvés
			echo "<div class='resultmessage'><p>Vous ne pouvez pas mettre d'espace dans votre nom d'utilisateur</p></div>";
		} else {
			//Connexion à la base de données
			$connect = mysqli_connect("localhost", "lovinrob", "JuinCerber", "taskmanager");	
			//Requête d'ajout d'une colonne dans la table users
			$signup = "INSERT INTO users (username, pswd) VALUES ('$username','$password')";
			//Requête de vérification de colonne déjà existante
			$usercheck = "SELECT username FROM users WHERE username= '$username'";
			//Envoie de la requête de vérification
			$usercheckresult = mysqli_query($connect, $usercheck);
			//Message d'erreur en cas d'erreur de communication avec la base de données
			if (mysqli_connect_errno()) {
				echo "<div class='resultmessage'><p>Échec de la connexion MySQL: " . mysqli_connect_error() . "</p></div>";
				exit();
		}
		if ($usercheckresult) {
			if (mysqli_num_rows($usercheckresult) > 0) {
				//Message si le nom d'utilisateur est déjà enregistré
				echo "<div class='resultmessage'><p>Nom d'utilisateur déjà utilisé, veuillez en entrer un autre.</p></div>";
			} else {
				if (mysqli_query($connect, $signup)) {
					//Message avec lien de connexion si 
					//-le nom d'utilisateur n'a pas encore été utilisé 
					//-la requête a bien aboutie.
					echo "<div class='resultmessage'><p>Inscription réussie. <a href ='connexion.html'>Connectez vous !</a></p></div>";
				} else {
					//Message d'erreur si un problème est survenue lors de l'envoie de la requête
					echo "<div class='resultmessage'><p>Erreur d'insertion : " . $signup . "<br>" . mysqli_error($connect) . "</p></div>";
				}
			}
		}
		//Fermeture de la connexion
		mysqli_close($connect);
		}
	} else {
		//Message d'erreur si le nom d'utilisateur et/ou le mot de passe n'ont été entrées.
		echo "<div class='resultmessage'><p>Veuillez écrire un nom d'utilisateur et un mot de passe</p></div>";
	}
?>
	</body>
	

</html>
