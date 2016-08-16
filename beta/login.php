<?php
/**
 * Created by PhpStorm.
 * User: LiteKangel
 * Date: 25/07/2016
 * Time: 21:29
 */
$db = DBFactory::getMysqlConnexionWithPDO();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);




