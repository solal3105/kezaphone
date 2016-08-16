<?php
    require 'lib/autoload.inc.php';
    
    $db = DBFactory::getMysqlConnexionWithPDO();
    $manager = new PhoneManager_PDO($db);

    include 'haut.php';
?>
<?php
    if (isset ($_GET['id']))
    {
        $phone = $manager->getUnique((int) $_GET['id']);
        
        echo '<p>Par <em>', $phone->auteur(), '</em>, ', $phone->date_ajout(), '</p>', "\n",
             '<h2>', $phone->titre(), '</h2>', "\n",
             '<p>', nl2br($phone->contenu()), '</p>', "\n";
        
        if ($phone->date_ajout() != $phone->date_modif())
            echo '<p style="text-align: right;"><small><em>Modifiée ', $phone->date_modif(), '</em></small></p>';
    }
    
    else
    {
        echo '<h2 style="text-align:center">Liste des 5 derniers téléphones</h2>';
        foreach ($manager->getList(0, 5) as $phone)
        {
            echo '<h3><a href="?id=', $phone->id(), '">',$manager->getMarque($phone->id_marque())->marque(),' ', $phone->modele(), '</a></h3>';
        }
    }
echo '<br/><br/>';
echo '<div id="bloc"><p><a href="admin.php"><strong>Accéder à l\'espace réservé</strong></a></p></div>';

    include 'bas.php';
