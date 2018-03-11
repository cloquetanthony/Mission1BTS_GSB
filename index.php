<?php 
//Initialise la session
session_start();


//Debut REQUIS
require 'configuration/bdd.php';
//Fin REQUIS

//Si Connecté affiche le site
if(isset($_SESSION['id']) AND !empty($_SESSION['id'])) {

//Si recherche prepare/execute la requete du tableau
if(isset($_POST['rechercher'])){
$depense = $bdd->prepare('SELECT idVisiteur, (Montant * quantite) AS montantTotal FROM lignefraisforfait INNER JOIN fraisforfait ON idfraisforfait = id WHERE mois = ? and idFraisForfait = ?');
$depense->execute(array($_POST['dates'],$_POST['type_frais']));
}
//Fin Si

//Début SELECT (Listes deroulantes)
$types = $bdd->query('SELECT id FROM fraisforfait ORDER BY id');
$dates = $bdd->query('SELECT DISTINCT mois FROM lignefraisforfait ORDER BY mois');
//Fin SELECT (Listes deroulantes)

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
		<li><a href="index.php">Accueil</a></li>
		<li><a href="deconnexion.php">Déconnexion</a></li>
		<br/><br/>
		<p><b>Bienvenue</b>,<br/> <?php echo $_SESSION['nom']." ".$_SESSION['prenom']; ?></p>
	</ul>
	</div>
	<div class="alignement">
		<div class="titre">
			<h1>Etat de tous les frais par mois</h1>
		</div>
		<div class="body">
			<h1>Periode</h1>
			<form method="POST">
			<label for="dates">Mois/Années:</label>
				<select id="dates" name="dates">
								<?php while($moisAnnee = $dates->fetch()) { ?>
									<option><?= $moisAnnee['mois'] ?></option>
								<?php } ?>
				</select>
			<label for="type_frais">Type de frais:</label>
				<select id="type_frais" name="type_frais">
								<?php while($typeFrais = $types->fetch()) { ?>
									<option><?= $typeFrais['id'] ?></option>
								<?php } ?>
				</select>
			<input type="submit" name="rechercher" value="Rechercher">
			</form>
			<br/>
			<h1>Frais au forfait</h1>
			<table border="1px">
				<tr>
					<th>Numéro de visiteur</th>
					<th>Montant</th>
				</tr>

				<?php
				//Si Recherche 
				if(isset($_POST['rechercher'])){
				//Initialise le tableau
				while($afficheTableau = $depense->fetch()) { ?>
				<tr>
					<td><?php echo $afficheTableau['idVisiteur']; ?></td>
					<td><?php echo $afficheTableau['montantTotal']; ?></td>
					</tr>
				<?php
				//Fin du tableau
				 }
				 //Fin Recherche
				}
				?>
			</table>
		</div>
	</div>
</body>
</html>
<?php 
//Sinon redirige vers connexion
} else {
	header("Location: connexion.php");
}
//Fin Sinon

?>