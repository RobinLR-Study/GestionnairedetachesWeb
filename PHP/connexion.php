<!DOCTYPE html>

<html lang="fr">

	<head>
		<meta charset="utf-8" />
		<title>Connexion</title>
		<link rel="stylesheet" href="../CSS/connexion.css"/>
	</head>

	<body>
    <div>
		<h1>Bonjour !</h1>
		<h2>Connectez-vous:</h2>
		<form method="post" action="connexion.php">
			<p>Nom d'utilisateur: <input type='text' name="nom"/></p>
			<p>Mot de Passe: <input type='text' name="password"/></p>
			<input class='login' type='submit' value="Connexion"/>
			<input class='reset' type='reset' value="Réinitialiser les champs"/>
		</form>
		<div class="signup">
			<p>Vous n'avez pas encore de compte ? <a href ='../HTML/inscription.html'>Inscrivez vous !</a></p>
		</div>
    </div>
     <?php
if ((!empty($_POST['nom'])) && !empty($_POST['password'])) {
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
        //Requête de recherche d'une colonne dans la table users en fonction du nom d'utilisateur et du mot de passe
        $usercheck = "SELECT username, pswd FROM users WHERE username='$username' AND pswd='$password'";
        //Envoie de la requête et stockage du résultat
        $usercheckresult = mysqli_query($connect, $usercheck);
        if (mysqli_connect_errno()) {
            //Message d'erreur de connexion
            echo "<p>Échec de la connexion MySQL: " . mysqli_connect_error() . "</p>";
            exit();
        } else {
            $usernmbcheck = mysqli_num_rows($usercheckresult);
            if ($usernmbcheck <1) {
                echo "<div class='resultmessage'><p>Veuillez écrire un nom d'utilisateur et un mot de passe valide</p></div>";
                //Fermeture de la connexion
                mysqli_close($connect);
            } else {
				//Message de bienvenue
                $resarray = mysqli_fetch_array($usercheckresult);
                //Fermeture de la connexion
				mysqli_close($connect);
				//Création de cookies pour maintenir l'utilisateur connectés entre les différentes pages
				setcookie("usernamecookie", $username, time() + (3600 * 24), "/");
				setcookie("passwordcookie", $username, time() + (3600 * 24), "/"); 
				//Renvoie vers la liste des taches
				header("Location: taches.php");
            }
        }
    }
} else {
	//Message d'erreur si le nom d'utilisateur et/ou le mot de passe ne sont pas entrés
    echo "<div class='resultmessage'><p>Veuillez écrire votre nom d'utilisateur et un mot de passe</p></div>";
}
?>

	</body>
</html>

