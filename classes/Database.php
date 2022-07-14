<?php
class Database {
    
    //faire $dbh = Database::connect() avant les appels de fonction qui requiert $dbh
    //faire $dbh = null lorsque plus besoin de la base de données

    public static function connect() {
        // $dsn = 'mysql:dbname=u897843953_psc;host=localhost';
        // $user = 'u897843953_root';
        // $password = 'Pipouche!host!35';
        $dsn = 'mysql:dbname=psc;host=localhost';
        $user = "root";
        $password = '';
        $dbh = null;
        try {
            $dbh = new PDO($dsn, $user, $password,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
            exit(0);
        }
        return $dbh;
    }
}


?>