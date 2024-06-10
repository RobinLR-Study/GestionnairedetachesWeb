<?php
	//Suppression des cookies de connexion créer dans connexion.php
	setcookie("usernamecookie", $username, time() - (3600 * 24), "/");
    setcookie("passwordcookie", $username, time() - (3600 * 24), "/"); 
    //Renvoie à la page de connexion
    header("Location: ../HTML/connexion.html");
?>
