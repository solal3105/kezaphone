<?php
    class DBFactory
    {
        public static function getMysqlConnexionWithPDO()
        {
            $db = new PDO('mysql:host=db619403071.db.1and1.com;dbname=db619403071', 'dbo619403071', '1solal3105');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            return $db;
        }

        public static function getMysqlConnexionWithMySQLi()
        {
            return new MySQLi('localhost:8080', 'root', '', 'keza');
        }
    }
