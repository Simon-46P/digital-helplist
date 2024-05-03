<?php
require_once ('Models/Customer.php');
require_once ('Models/UserDatabase.php');

class DBContext
{


    private $pdo;
    private $usersDatabase;
    private $initialized = false;

    function getUsersDatabase()
    {
        return $this->usersDatabase;
    }

    function __construct()
    {

        $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '../../');
        $dotenv->load();


        $host = $_ENV['host'];
        $db = $_ENV['db'];
        $user = $_ENV['user'];
        $pass = $_ENV['pass'];
        $dsn = "mysql:host=$host;dbname=$db";
        $this->pdo = new PDO($dsn, $user, $pass);
        $this->usersDatabase = new UserDatabase($this->pdo);
        $this->initIfNotInitialized();

    }

    function addUser($givenname, $street, $city, $zip, $user_id)
    {

        $prep = $this->pdo->prepare("INSERT INTO UserDetails (givenname, street, city, zip, user_id)
                                     VALUES (:givenname, :street, :city, :zip, :user_id)");
        $prep->execute([
            "givenname" => $givenname,
            "street" => $street,
            "city" => $city,
            "zip" => $zip,
            "user_id" => $user_id
        ]);
        return $this->pdo->lastInsertId();

    }

    function initIfNotInitialized()
    {
        if ($this->initialized) {
            return;
        }

        $sql1 = "CREATE TABLE IF NOT EXISTS `UserDetails` (
            `id` int NOT NULL AUTO_INCREMENT,
            `givenname` varchar(50) NOT NULL,
            `street` varchar(50) NOT NULL,
            `city` varchar(50) NOT NULL,
            `zip` varchar(10) NOT NULL,
            `user_id` int(10) unsigned NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
            ) ENGINE=MyISAM";

        $this->pdo->exec($sql1);

        $sql2 = "CREATE TABLE IF NOT EXISTS `QueueDetails` (
            `id` int NOT NULL AUTO_INCREMENT,
            `name` varchar(50) NOT NULL,
            `creationdate` datetime NOT NULL,
            PRIMARY KEY (`id`)
        )";

        $this->pdo->exec($sql2);

        $sql3 = "CREATE TABLE IF NOT EXISTS `Queue` (
            `id` int NOT NULL AUTO_INCREMENT,
            `date` datetime NOT NULL,
            `active` boolean NOT NULL,
            `queue_id` int NOT NULL,
            
            PRIMARY KEY (`id`),
            FOREIGN KEY (`queue_id`) REFERENCES `QueueDetails` (`id`)
        )";

        $this->pdo->exec($sql3);


        $this->usersDatabase->setupUsers();
        $this->initialized = true;
    }
}


?>