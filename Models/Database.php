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
    function createRoomQueue($roomName, $creationDate)
    {

        $prep = $this->pdo->prepare("INSERT INTO QueueRoom (name, creationdate)
                                     VALUES (:name, :creationdate)");
        $prep->execute([
            "name" => $roomName,
            "creationdate" => $creationDate
        ]);
        return $this->pdo->lastInsertId();

    }
    function getGivenNameByUsername($username)
{
    $prep = $this->pdo->prepare("SELECT givenname FROM UserDetails WHERE user_id = 
    (SELECT id FROM users WHERE username = :username)");
    $prep->execute(["username" => $username]);
    $result = $prep->fetch(PDO::FETCH_ASSOC);
    return $result['givenname'];
}


    function addUser($givenname, $street, $city, $zip, $accountrole, $user_id)
    {

        $prep = $this->pdo->prepare("INSERT INTO UserDetails (givenname, street, city, zip, accountrole, user_id)
                                     VALUES (:givenname, :street, :city, :zip, :accountrole, :user_id)");
        $prep->execute([
            "givenname" => $givenname,
            "street" => $street,
            "city" => $city,
            "zip" => $zip,
            "accountrole" => $accountrole,
            "user_id" => $user_id
        ]);
        return $this->pdo->lastInsertId();

    }

    function initIfNotInitialized()
    {
        if ($this->initialized) {
            return;
        }

        $sql = "CREATE TABLE IF NOT EXISTS `UserDetails` (
            `id` int NOT NULL AUTO_INCREMENT,
            `givenname` varchar(50) NOT NULL,
            `street` varchar(50) NOT NULL,
            `city` varchar(50) NOT NULL,
            `zip` varchar(10) NOT NULL,
            `accountrole` varchar(10) NOT NULL,
            `user_id` int(10) unsigned NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
            ) ENGINE=MyISAM";

        $this->pdo->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `QueueRoom` (
            `id` int NOT NULL AUTO_INCREMENT,
            `name` varchar(50) NOT NULL,
            `creationdate` datetime NOT NULL,
            PRIMARY KEY (`id`)
        )";

        $this->pdo->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `QueuePosition` (
            `id` int NOT NULL AUTO_INCREMENT,
            `date` datetime NOT NULL,
            `active` boolean NOT NULL,
            `queueroom_id` int NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`queueroom_id`) REFERENCES `QueueRoom` (`id`)
        )";

        $this->pdo->exec($sql);


        $this->usersDatabase->setupUsers();
        $this->initialized = true;
    }
}


?>