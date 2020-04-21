<?php

namespace App\SQL;

use Exception;
use PDO;

/**
 * Sets up the ability to use SQL using PDO (through PDOWrapper).
 */
class SQL
{
    /**
     * Sets up the PDO object using the given environment values
     *
     * @param string $name Name of the database
     *
     * @return PDOWrapper
     */
    public function set($name)
    {
        $this->checkDSNValues($name);

        return $this->buildPDO([
            'host' => $_ENV['DB_'.$name.'_Host'],
            'user' => $_ENV['DB_'.$name.'_User'],
            'pass' => $_ENV['DB_'.$name.'_Pass'],
            'dbname' => $_ENV['DB_'.$name.'_DBName'],
        ]);
    }

    public function arrayToInList(array $array)
    {
        return "'".implode("','", $array)."'";
    }

    /**
     * Checks the given DSN values to see if they are all there.
     *
     * @param  string $name Name of the database, used as a reference
     */
    private function checkDSNValues($name)
    {
        // Check if the DB data exists at all
        if (!isset($_ENV['DB_'.$name.'_Host']) &&
            !isset($_ENV['DB_'.$name.'_User']) &&
            !isset($_ENV['DB_'.$name.'_Pass']) &&
            !isset($_ENV['DB_'.$name.'_DBName'])
        ) {
            throw new Exception("The database info you chose doesn't exist.
Please check your '.env.local' file.", 1);
        }

        // Check if the four values are set
        if (!isset($_ENV['DB_'.$name.'_Host'])) {
            throw new Exception("You're missing the 'Host' value for setting up the DB.
Please check your '.env.local' file.", 1);
        }

        if (!isset($_ENV['DB_'.$name.'_User'])) {
            throw new Exception("You're missing the 'User' value for setting up the DB.
Please check your '.env.local' file.", 1);
        }

        if (!isset($_ENV['DB_'.$name.'_Pass'])) {
            throw new Exception("You're missing the 'Pass' value for setting up the DB.
Please check your '.env.local' file.", 1);
        }

        if (!isset($_ENV['DB_'.$name.'_DBName'])) {
            throw new Exception("You're missing the 'DBName' value for setting up the DB.
Please check your '.env.local' file.", 1);
        }

        // Check if the the required values have data
        if (empty($_ENV['DB_'.$name.'_Host'])) {
            throw new Exception("You're 'Host' value is empty for setting up the DB.
Please check your '.env.local' file.", 1);
        }

        if (empty($_ENV['DB_'.$name.'_User'])) {
            throw new Exception("You're 'User' value is empty for setting up the DB.
Please check your '.env.local' file.", 1);
        }

        if (empty($_ENV['DB_'.$name.'_DBName'])) {
            throw new Exception("You're 'DBName' value is empty for setting up the DB.
Please check your '.env.local' file.", 1);
        }
    }

    /**
     * Builds the PDO object (using PDOWrapper for some extra extensions)
     *
     * @param  array  $data     host, user, pass, dbname
     *
     * @return PDOWrapper       Set up PDO/PDOWrapper object.
     */
    private function buildPDO(array $data)
    {
        // NOTE: Dbase charset must be set to UTF-8 to enable JSON encoding
        $db = new PDOWrapper(
            "mysql:host={$data['host']};dbname={$data['dbname']};charset=utf8",
            $data['user'],
            $data['pass'],
            [
                // PDO throws exceptions
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                // fetch methods return srdClass
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                // UTF8 Encoding
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            ]
        );

        // Set MySQL timezone to be PHP's, so everything gets stored or called
        // the same way.
        $timezoneOffset = date('P');
        $db->query("SET @@global.time_zone = '${timezoneOffset}';");

        return $db;
    }
}
