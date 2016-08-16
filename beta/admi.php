<?php
    require 'lib/autoload.inc.php';
    
    $db = DBFactory::getMysqlConnexionWithPDO();
    $manager = new PhoneManager_PDO($db);
    
    if (isset ($_GET['modifier']))
        $phone = $manager->getUnique ((int) $_GET['modifier']);
    
    if (isset ($_GET['supprimer']))
    {
        $manager->delete((int) $_GET['supprimer']);
        $message = 'La phone a bien �t� supprim�e !';
    }
    
    if (isset ($_POST['auteur']))
    {
        $phone = new Phone (
            array (
                'auteur' => $_POST['auteur'],
                'titre' => $_POST['titre'],
                'contenu' => $_POST['contenu']
            )
        );
        
        if (isset ($_POST['id']))
            $phone->setId($_POST['id']);
        
        if ($phone->isValid())
        {
            $manager->save($phone);
            
            $message = $phone->isNew() ? 'La phone a bien �t� ajout�e !' : 'La phone a bien �t� modifi�e !';
        }
        else
            $erreurs = $phone->erreurs();
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
    <head>
        <title>Administration</title>
        <meta http-equiv="Content-type" content="text/html; charset=iso-8859-1" />
        
        <style type="text/css">
            table, td {
                border: 1px solid black;
            }
            
            table {
                margin:auto;
                text-align: center;
                border-collapse: collapse;
            }
            
            td {
                padding: 3px;
            }
        </style>
    </head>
    
    <body>
        <p><a href=".">Acc�der � l'accueil du site</a></p>
        
        <form action="admin.php" method="post">
            <p style="text-align: center">
<?php
    if (isset ($message))
        echo $message, '<br />';
?>
                <?php if (isset($erreurs) && in_array(Phone::AUTEUR_INVALIDE, $erreurs)) echo 'L\'auteur est invalide.<br />'; ?>
                Auteur : <input type="text" name="auteur" value="<?php if (isset($phone)) echo $phone->auteur(); ?>" /><br />
                
                <?php if (isset($erreurs) && in_array(Phone::TITRE_INVALIDE, $erreurs)) echo 'Le titre est invalide.<br />'; ?>
                Titre : <input type="text" name="titre" value="<?php if (isset($phone)) echo $phone->titre(); ?>" /><br />
                
                <?php if (isset($erreurs) && in_array(Phone::CONTENU_INVALIDE, $erreurs)) echo 'Le contenu est invalide.<br />'; ?>
                Contenu :<br /><textarea rows="8" cols="60" name="contenu"><?php if (isset($phone)) echo $phone->contenu(); ?></textarea><br />
<?php
    if(isset($phone) && !$phone->isNew())
    {
?>
                <input type="hidden" name="id" value="<?php echo $phone->id(); ?>" />
                <input type="submit" value="Modifier" name="modifier" />
<?php
    }
    else
    {
?>
                <input type="submit" value="Ajouter" />
<?php
    }
?>
            </p>
        </form>
        
        <p style="text-align: center">Il y a actuellement <?php echo $manager->count(); ?> phone. En voici la liste :</p>
        
        <table>
            <tr><th>Auteur</th><th>Titre</th><th>Date d'ajout</th><th>Derni�re modification</th><th>Action</th></tr>
<?php
    foreach ($manager->getList() as $phone)
        echo '<tr><td>', $phone->auteur(), '</td><td>', $phone->titre(), '</td><td>', $phone->date_ajout(), '</td><td>', ($phone->date_ajout() == $phone->date_modif() ? '-' : $phone->date_modif()), '</td><td><a href="?modifier=', $phone->id(), '">Modifier</a> | <a href="?supprimer=', $phone->id(), '">Supprimer</a></td></tr>', "\n";
?>
        </table>
    </body>
</html>
