<!DOCTYPE html>
<html>
<head>
    <style>
        table {
            border: 1px solid black;
            width: 500px;
        }

        td {
            border: 1px solid black;
            width: 100%;

        }

        td {
            height: 10px;
            width: auto;
        }
    </style>
</head>
<body>
Hello world !
<br>

<?php
echo "La date du jour est ";
$d = date("d/m/Y h:i:s") . "\n<br>";
echo $d;
echo '<br><br>';
?>


<?php
// ------------------------------------------
// definition des parametres liés à la BDD
// ------------------------------------------
define("_LOGIN_", "root");
define("_PASSWD_", "");
define("_SERVERHOST_", "localhost");
define("_BDD_", "mytransporter");

// ------------------------------------------
// Etape 1 : connexion au serveur MySQL et selection de la BDD
// ------------------------------------------
$pdo = "";
try {
    $strConnection = "mysql:host=" . _SERVERHOST_ . ";dbname=" . _BDD_;
    $arrExtraParam = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

    $pdo = new PDO($strConnection, _LOGIN_, _PASSWD_, $arrExtraParam);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch (PDOException $e) {
    $msg = '<p>ERREUR PDO a la connexion BDD: ' . $e->getMessage() . "</p>";
    die($msg);
}

// ------------------------------------------
// Etape 2 : Construction de la requete SQL
// ------------------------------------------

// variables ... par ex récupérées depuis un formulaire en $_POST ou depuis l'url en $_GET

if (isset($_POST['nom'])) {
    $nom = $_POST['nom'];
} else {
    $nom = "empty";
}
if (isset($_POST['mdp'])) {
    $mdp = $_POST['mdp'];
} else {
    $mdp = "empty";
}

if (isset($_POST['mail'])) {
    $email = $_POST['mail'];
} else {
    $email = "empty";
}
if (isset($_POST['ville'])) {
    $ville = $_POST['ville'];
} else {
    $ville = "empty";
}

// requete de type INSERT (marche idem avec UPDATE ou DELETE)
$query = "INSERT INTO utilisateur (nomUtilisateur,emailUtilisateur,mdpUtilisateur,villeUtilisateur) VALUES (?,?,?,?)";

$select = "SELECT * from utilisateur";

$tabvaleurs = array($nom, $email, $mdp, $ville);


// ------------------------------------------
// Etape 3 : execution de la requete
// ------------------------------------------
// select
try {
    $resultSelect = $pdo->prepare($select);
    $resultSelect->execute();
} catch (PDOException $e) {
    $msg = '<p>ERREUR PDO requete insert : ' . $e->getMessage() . "</p>";
    die($msg);
}

//pas select

try {
    $resultat = $pdo->prepare($query);
    $resultat->execute($tabvaleurs);


} catch (PDOException $e) {
    $msg = '<p>ERREUR PDO requete insert : ' . $e->getMessage() . "</p>";
    die($msg);
}


// combien de lignes ont été touchées par la requete ?
// soit 1 soit 0 ! (succes ou echec de l'insertion)
$nblignes = $resultat->rowCount();


///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////


// ----------------------------------------------------------
// Etape 2 : Construction de la requete SELECT
// ----------------------------------------------------------

// variables ... par ex récupérées depuis un formulaire en $_POST en
// depuis l'url en $_GET


// construction de la requete ...
// exemple requete Select
$querySelect = "SELECT * FROM utilisateur";

$tab = array($nom, $email, $mdp, $ville);


// ----------------------------------------------------------
// Etape 3 : execution de la requete
// ----------------------------------------------------------
try {
    $result = $pdo->prepare($querySelect);
    $result->execute($tab);
} catch (PDOException $e) {
    $msg = '<p>ERREUR PDO requete Select : ' . $e->getMessage() . "</p>";
    die($msg);
}

// combien de lignes ont été retournées par la requete ?
$nblignes = $result->rowCount();


// ----------------------------------------------------------
// Etape 4 : traitement du résultat (mise en forme Html)
// ----------------------------------------------------------

// traitement des résultats
echo "<ul>";

while ($ligne = $result->fetch()) {
    echo "<li>";
    echo $ligne['nom'];
    echo " - ";
    echo $ligne['mail'];
    echo " - ";
    echo $ligne['mdp'];
    echo " - ";
    echo $ligne['ville'];
    echo "</li>";
}

echo "</ul>";
?>

<form action="./test.php" method="POST">
    <label for="col">Nb Colonnes : </label><input type="number" name="col">
    <label for="row">Nb Lignes : </label><input type="number" name="row">
    <input type="submit" name="btn">
</form>
<?php
$postCol = 0;
$postRow = 0;

if ($postCol == 0 && $postRow == 0) {
    echo '<hr>';
    echo '<p style="text-align:center;">Empty</p>';
    echo '<hr>';
} else {
    echo '<table>
 <br>';
    if (isset($_POST['col'])) {
        $postCol = $_POST['col'];
    }
    if (isset($_POST['row'])) {
        $postRow = $_POST['row'];

    }
//    $row = $_GET['row'];
//    $col = $_GET['col'];
// ?col=8&row=6 en fin d'url

    for ($i = 0; $i < $postRow; $i++) {
        echo '<tr>';
        for ($j = 0; $j < $postCol; $j++) {
            echo '<td></td>';
        }
        echo '</tr>';
    }

    echo '</table>';
}
?>

<form action="./test.php" method="post">
    <label for="nom">Nom :</label><input type="text" name="nom">
    <label for="mdp">Password :</label><input type="password" name="mdp">
    <label for="mail">Email :</label><input type="email" name="mail">
    <label for="ville">Ville :</label><input type="text" name="ville">
    <button type="submit">Soumettre</button>
</form>

<?php
while ($users = $resultSelect->fetch()) {
    $name = $users['nomUtilisateur'];
    $id = $users['idUtilisateur'];
    $mail = $users['emailUtilisateur'];
    echo '<ul>';
    echo '<li>';
    echo $id . " - " . $name . " " . $mail;
    echo '</li>';
    echo '</ul>';
}
?>

</body>
</html>