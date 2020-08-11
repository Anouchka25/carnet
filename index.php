<!DOCTYPE html>
<html>
<head>
<title>Exemple</title>
</head>
<body>
<h1>Bienvenue sur notre formulaire d'Enregistrement</h1>
<form method = "post" action="index.php">
   <fieldset>
       <legend>Enregistrement des contacts dans le carnet</legend>
       <label>Nom</label>
       <input type="text" name="nom"><br/><br/>

       <label>Prénom</label>
       <input type="text" name="prenom"><br/><br/>

       <label>Date de naissance</label>
       <input type="date" name="datenaissance"><br/><br/>

       <label>Ville</label>
       <input type="text" name="ville"><br/><br/>

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
if(!empty($_POST['nom']) && (!empty($_POST['prenom'])) && (!empty($_POST['datenaissance'])) && (!empty($_POST['ville']))){

    //Etape 5: La fonction escape_string permet d'échaper tous les caractères spéciaux que pourra saisir l'utilisateur
    $nom = $idcom->escape_string($_POST['nom']);
    $prenom = $idcom->escape_string($_POST['prenom']);
    $datenaissance = $_POST['datenaissance'];
    $ville = $idcom->escape_string($_POST['ville']);

    //Etape 6: Ecrire la requête
    $requete = "INSERT INTO carnet(nom, prenom, naissance, ville) VALUES ('$nom', '$prenom', '$datenaissance', '$ville')";

    //Etape 7: Envoyer la requete au serveur en utilisant la fonction query de la classe mysqli
    $result = $idcom->query($requete);

    //Etape 8: On vérifie si la requete a bien été exécuté/recue au niveau du serveur mysql
    if($result){
        echo "Vous avez bien été enregistré au numéro :".$idcom->insert_id;
    }
    else { echo "Erreur ".$idcom->error;}

    //Etape 9 et dernière étape: On ferme la connexion
    $idcom->close();
}
else {echo "Veuillez remplir la formulaire"; }


?>

</body>
</html>