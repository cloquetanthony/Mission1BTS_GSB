<?php 
session_start();

require 'configuration/bdd.php';

if(isset($_POST['connexion']))
{
	$identifiant = htmlspecialchars($_POST['identifiant']);
	$motdepasse = htmlspecialchars($_POST['motdepasse']);
	if(!empty($identifiant) AND !empty($motdepasse))
	{
		$requete = $bdd->prepare("SELECT * FROM visiteur WHERE login = ? AND mdp = ?");
		$requete->execute(array($identifiant, $motdepasse));
		$visiteurexiste = $requete->rowCount();
		if($visiteurexiste == 1)
		{
			$visiteur = $requete->Fetch();
			$_SESSION['id'] = $visiteur['id'];
			$_SESSION['nom'] = $visiteur['nom'];
			$_SESSION['prenom'] = $visiteur['prenom'];

			$message="Connexion en cours...";
			header('Refresh: 2; url=index.php');

		} else {
			$message="Identifiants de connexion incorrects.";
		}

	} else {
		$message = "Tous les champs doivent être complétés.";
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>GSB</title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<img src="img/logo.jpg">

	<div class="menu">
	<ul>
		<li><a href="connexion.php">Connexion</a></li>
	</ul>
	</div>
	<div class="alignement">
		<div class="titre">
			<h1>Connexion à GSB</h1>
		</div>
		<div class="body">
		<form method="POST">
			<h2>Veuillez saisir vos identifiant</h2>
			<?php if(isset($message)){ echo "<hr>".$message."<hr><br/>";} ?>
			<label for="identifiant">Identifiant:</label>
				<input type="text" name="identifiant">
			<br/>
			<label for="motdepasse">Mot de passe:</label>
				<input type="password" name="motdepasse">
			<br/>
			<input type="submit" name="connexion" value="Connexion">
		</form>
		</div>
	</div>
</body>
</html>