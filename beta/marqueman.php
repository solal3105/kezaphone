<?php
session_start();
/**
 * Created by PhpStorm.
 * User: LiteKangel
 * Date: 22/07/2016
 * Time: 00:16
 */
require 'lib/autoload.inc.php';

$db = DBFactory::getMysqlConnexionWithPDO();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$manager = new PhoneManager_PDO($db);
include 'haut.php';
if (isset($_POST['marque']))
{
    if (!empty($_POST['marque']))
    {
        if (isset($_GET['marque'])) {
            $arr = array(
                'id_marque' => $_GET['marque'],
                'marque' => $_POST['marque'],
                'siege' => $_POST['siege']
            );
            $m = new Marque ($arr);
            $manager->upMarque($m);
            echo 'La marque a été modifiée !';
        }
        else {
            $arr = array(
                'marque' => $_POST['marque'],
                'siege' => $_POST['siege'],
            );
            $m = new Marque ($arr);

            $manager->addMarque($m);
            echo 'La marque a été ajoutée !';
        }

    }
    else
    {
        echo 'Tous les champs doivent être remplis. Veuillez réessayer.';
    }
}
else
{
    if(isset($_GET['marque'])) {
        $marque = $manager->getMarque($_GET['marque']);
        $m = $marque->marque();
        $mid = $marque->id_marque();
        $siege = $marque->siege();
    }
    else {
        $m = null;
        $mid = null;
        $siege = null;
    }
    echo '<div id="page" class="board">
        <h2>Ajouter une marque</h2>
        <div id="bloc">
        <form method="post" name="formulaire" class="formular" id="formID">';
    echo'<p><input type="text" placeholder="Nom de la marque" value="'.$m.'" name="marque" class="" id="modele" align="LEFT" /><br/>
			<input type="text" placeholder="Siege" name="siege" value="'.$siege.'" class="" id="prix" align="LEFT" /><br/>
			<input type="hidden" name="siege" value="'.$siege.'" class="" id="prix" align="LEFT" />';
    echo'<input type="submit" name="submit" value="Valider" />
	</form></div></p></div>';

}
$marques = $manager->getMarques();
echo '<div id="bloc" class="board" style="text-align:center"><table>';
foreach($marques as $marque){
    echo '<tr><td><a href="?marque='.$marque['id_marque'].'">'.$marque['marque'].'</a></td><td>'.$marque['siege'].'</td></tr>';
}
echo '</table></div>';
include 'bas.php';