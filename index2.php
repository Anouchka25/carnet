<!DOCTYPE html>
<html>
<head>
<title>Exemple</title>
</head>
<body>
<h1>Bienvenue sur notre formulaire de recherche de contact</h1>
<form method = "post" action="index2.php">
   <fieldset>
       <legend>Recherche des contacts dans le carnet</legend>
       <label>Nom</label>
       <input type="text" name="nom"><br/><br/>

       <input type="submit" value="envoyer">

   </fieldset>
</form>

<?php 
// Etape 0 : Créer la base de données

//Etape 1: Inclusion des paramètres de connexion
include_once('myparam.inc.php');

//Etape 2: Connexion au serveur de base de données MySQL
$idcom = new mysqli(MYHOST, MYUSER, MYPASS, "carnet");

//Etape 3: Test de la connexion
if(!$idcom){
    echo "Connexion impossible";
    exit(); //On arrete tout, on sort du script
}

//Etape 4 La connexion s'est faite ! Alors on vérifie que les champs du formulaire ne sont pas vides
if(!empty($_POST['nom'])){

    //Etape 5: La fonction escape_string permet d'échaper tous les caractères spéciaux que pourra saisir l'utilisateur
    $nom = $idcom->escape_string($_POST['nom']);

    //Etape 6: Ecrire la requête
    $requete = " SELECT nom, prenom, naissance, ville FROM carnet WHERE nom LIKE '$nom%'";

    //Etape 7: Envoyer la requete au serveur en utilisant la fonction query de la classe mysqli
    $result = $idcom->query($requete);

    echo "<table border>
        <tr>
        <td>Nom</td>
        <td>Prénom</td>
        <td>Date de naissance</td>
        <td>Ville</td>
        </tr>";
    
    //Etape 8: on récupère les données
    //print_r($result->fetch_array());
    while($row = $result->fetch_array(MYSQLI_ASSOC)){
            echo "<tr>
            <td>".$row['nom']."</td>
            <td>".$row['prenom']."</td>
            <td>".$row['naissance']."</td>
            <td>".$row['ville']."</td>
            </tr>";
    }

    //Etape 9 et dernière étape: On ferme la connexion
    $idcom->close();
}
else {echo "Veuillez remplir la formulaire"; }

echo "</table>";


?>

</body>
</html>