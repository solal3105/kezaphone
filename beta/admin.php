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
if(isset($_SESSION['user_id'])) {
    /**Pagination !**/
    $page = ((isset($_GET['page'])) ? $_GET['page'] : 1);
    echo '<div id="bloc"><a href="marqueman.php"><strong>Ajouter une marque</strong></a></div><br/>';
    if (isset($_POST['modele']) or isset($_POST['autonomie'])) {
        echo $_POST['sortie'];
        if (!empty($_POST['modele'])) {
            if (isset($_GET['pid'])) {
                //on modifie le téléphone
                $phone = new Phone (
                    array(
                        'id' => $_GET['pid'],
                        'modele' => $_POST['modele'],
                        'autonomie' => $_POST['autonomie'],
                        'puissance' => $_POST['puissance'],
                        'id_os' => $_POST['id_os'],
                        'taille' => $_POST['taille'],
                        'id_marque' => $_POST['id_marque'],
                        'photos' => $_POST['photos'],
                        'prix' => $_POST['prix'],
                        'sortie' => $_POST['sortie']
                    )
                );
                $manager->update($phone);
                echo 'Téléphone modifié';
            } else {
                //On ajoute un téléphone
                $phone = new Phone (
                    array(
                        'modele' => $_POST['modele'],
                        'autonomie' => $_POST['autonomie'],
                        'puissance' => $_POST['puissance'],
                        'id_os' => $_POST['id_os'],
                        'taille' => $_POST['taille'],
                        'id_marque' => $_POST['id_marque'],
                        'photos' => $_POST['photos'],
                        'prix' => $_POST['prix'],
                        'sortie' => $_POST['sortie']
                    )
                );
                $manager->add($phone);
                echo 'Téléphone ajouté';
            }

        } else {
            echo 'Tous les champs doivent être remplis. Veuillez réessayer.';
        }
    } else {

        if (isset($_GET['pid']) and $manager->pExist($_GET['pid'])) {
            $p = $manager->getUnique($_GET['pid']);
            $mid = $p->id_marque();
            $os = $p->id_os();
            $modele = $p->modele();
            $autonomie = $p->autonomie();
            $puissance = $p->puissance();
            $photos = $p->photos();
            $prix = $p->prix();
            $taille = $p->taille();
            $sortie = $p->sortie();
            $sub = "Modifier";
        } else {
            $m = null;
            $mid = null;
            $p = null;
            $mid = null;
            $os = null;
            $modele = null;
            $autonomie = null;
            $puissance = null;
            $photos = null;
            $prix = null;
            $taille = null;
            $sortie = null;
            $sub = "Ajouter";
        }

        echo '<div id="page" class="board">
        <h2>Ajouter un téléphone</h2>
        <div id="bloc">
        <form method="post" name="formulaire" class="formular" id="formID">';
        echo '<p><label for="id_os">Son OS</label><br/><select name="id_os">';
        $oss = $manager->getOss();
        foreach ($oss as $os) {
            echo '<option value="' . $os['id_os'] . '">' . $os['os'] . '</option>';
        }

        echo '</select></p><p><label for="id_marque">Marque du téléphone</label><br />
    <select id="id_marque" name="id_marque">';
        $marques = $manager->getMarques();
        foreach ($marques as $marque) {
            echo '<option value="' . $marque['id_marque'] . '">' . $marque['marque'] . '</option>';
        }
        echo '</select></p>';

        echo '<p><input type="text" value="' . $modele . '" title="Modèle du téléphone" placeholder="Modèle du téléphone" name="modele" class="validate[required, length[1,100]] text-input" id="modele" align="LEFT" /><br/>
			<input type="text" value="' . $prix . '" title="Prix de vente moyen" placeholder="Prix de vente moyen" name="prix" class="validate[required, length[1,100]] text-input" id="prix" align="LEFT" /><br/>
			<input type="text" value="' . $autonomie . '" title="Autonomie /10" placeholder="Autonomie /10" name="autonomie" id="autonomie" align="LEFT" /><br/>
			<input type="text" value="' . $photos . '" title="Appareil photo /10" placeholder="Appareil photo /10" name="photos" id="photos" align="LEFT" /><br/>
			<input type="text" value="' . $puissance . '" title="Puissance /10" placeholder="Puissance /10" name="puissance" id="puissance" align="LEFT" /><br/>
			<input type="text" value="' . $taille . '" title="Taille de l\'écran" placeholder="Taille de l\'écran" name="taille" id="taille"  /><br />
			<label for="modele">Date officielle de sortie</label><br />
			<input type="date" value="' . $sortie . '" id="sortie" name="sortie" /><br/>
			</p>';
        echo '<input type="submit" name="submit" value="' . $sub . '" />
	</form></div></p></div>';

    }
    $nb = 10;
    $first = ($page-1)*10+1;
    $last = $page*10;
    $total = $manager->count();
    $nb_pages = ceil($total/$nb);
    echo '<div id="bloc" class="board" style="text-align:left">';
    echo '<table><caption>Page</caption>';
    for ($i=1;$i<=$nb_pages; $i++)
    {
        if($i == $page)
            echo '<td><a href="?page='.$i.'"><strong>'.$i.'</strong></a></td>';
        else
            echo '<td><a href="?page='.$i.'">'.$i.'</a></td>';
    }
    echo '</table><br/>';
    $phones = $manager->getList($first, $nb);
    echo '<table>
<tr><th>Marque</th><th>Modèle</th><th>Action</th></tr>';
    foreach ($phones as $phone) {
        echo '<tr><td>' . $manager->getMarque($phone->id_marque())->marque() . '</td>
        <td><a href="?pid=' . $phone->id() . '">' . $phone->modele() . '</a></td>
        <td><a href="?pid='.$phone->id().'">Modifier</a> | <a href="?dpid=' . $phone->id() . '">Supprimer</a></td></tr>';
    }
    echo '</table></div>';
}
else
{
    echo '<div id="bloc">';
    $manager = new UserManager($db);

    if(isset($_POST['username']) and isset($_POST['password']))
    {
        $pass = sha1($_POST['password']);
        $username = $_POST['username'];
        $user_id = $manager->connect($username, $pass);
        if($user_id) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            echo 'Connexion effectuée...';
        }
        else
        {
            echo 'Identifiants erronés...';
        }
    }
    ?>
    <form method="post">
        <input type="text" placeholder="Nom d'utilisateur" name="username" required/><br />
        <input type="password" placeholder="Mot de Passe" name="password" required/><br />
        <input type="submit" value="Connexion" />
    </form>

    <?php
    echo '</div>';
}
include 'bas.php';