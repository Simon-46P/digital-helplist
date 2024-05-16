<?php
require_once ('Models/Customer.php');
require_once ('Models/UserDatabase.php');
require_once ("Models/QueueRoom.php");
require_once ("Models/QueuePosition.php");
require_once ("Models/roomaccess.php");
require_once ("Models/user.php");

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
    function getHelpRooms($user_id = null, $roomId = null)
    {
        $sql = "SELECT * FROM QueueRoom LEFT JOIN roomaccess ON roomaccess.queueroom_id = QueueRoom.id";
        $paramsArray = [];
        $addedWhere = false;


        if ($user_id !== null && strlen($user_id) > 0) {
            if (!$addedWhere) {
                $sql = $sql . " WHERE ";
                $addedWhere = true;
            } else {
                $sql = $sql . " AND ";

            }
            $sql .= " user_id = :user_id ";
            $sql .= " or admin_user_id = :user_id ";
            $paramsArray["user_id"] = $user_id;

        }

        if ($roomId !== null && strlen($roomId) > 0) {
            if (!$addedWhere) {
                $sql = $sql . " WHERE ";
                $addedWhere = true;
            } else {
                $sql = $sql . " AND ";
            }
            $sql = $sql . " QueueRoom.id = :roomId ";
            $paramsArray["roomId"] = $roomId;
        }

        $prep = $this->pdo->prepare($sql);
        $prep->setFetchMode(PDO::FETCH_CLASS, "QueueRoom");
        $prep->execute($paramsArray);
        return $prep->fetchAll();
    }
    function roomPermissions($roomId, $helpRooms, $user_id): bool
    {
        foreach ($helpRooms as $helpRoom) {
            if ($roomId === $helpRoom->id && $user_id === $helpRoom->user_id || $roomId === $helpRoom->id && $user_id === $helpRoom->admin_user_id) {
                return false;
            }
        }
        return true;
    }

    function createRoomQueue($roomName, $creationDate, $userId)
    {

        $prep = $this->pdo->prepare("INSERT INTO QueueRoom (name, creationdate, admin_user_id)
                                     VALUES (:name, :creationdate, :admin_user_id)");
        $prep->execute([
            "name" => $roomName,
            "creationdate" => $creationDate,
            "admin_user_id" => $userId
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
    function getRoleByUsername($username)
    {
        $prep = $this->pdo->prepare("SELECT accountrole FROM UserDetails WHERE user_id = 
    (SELECT id FROM users WHERE username = :username)");
        $prep->execute(["username" => $username]);
        $result = $prep->fetch(PDO::FETCH_ASSOC);
        return $result['accountrole'];
    }
    function getUserIdWithEmail($email)
    {
        $prep = $this->pdo->prepare("SELECT id FROM users where email = :email ");
        $prep->execute(["email" => $email]);
        $prep->setFetchMode(PDO::FETCH_CLASS, "User");
        return $prep->fetchAll();
    }

    function getRoomAccessUserId($user_id, $roomId)
    {
        $prep = $this->pdo->prepare("SELECT * FROM roomaccess where user_id = :user_id and queueroom_id = :roomId");
        $prep->setFetchMode(PDO::FETCH_CLASS, "roomaccess");
        $prep->execute(["user_id" => $user_id, "roomId" => $roomId]);
        return $prep->fetchAll();
    }

    function inviteUserToRoom($date, $user_id, $queueroom_id, $active = true)
    {
        $prep = $this->pdo->prepare("INSERT INTO roomaccess (date, active, queueroom_id, user_id)
        VALUES (:date, :active, :queueroom_id, :user_id)");
        $prep->execute([
            "date" => $date,
            "active" => $active,
            "queueroom_id" => $queueroom_id,
            "user_id" => $user_id
        ]);
        return $this->pdo->lastInsertId();
    }

    public function getUserData($userId)
    {
        $prep = $this->pdo->prepare("SELECT * FROM users WHERE id = :userId");
        $prep->bindParam(':userId', $userId);
        $prep->execute();

        $userData = $prep->fetch(PDO::FETCH_ASSOC);

        return $userData;
    }
    public function getUserDetails($userId)
    {
        $prep = $this->pdo->prepare("SELECT users.*, UserDetails.givenname, UserDetails.lastname, UserDetails.street, UserDetails.city, UserDetails.zip, UserDetails.accountrole 
                                 FROM users 
                                 LEFT JOIN UserDetails ON users.id = UserDetails.user_id 
                                 WHERE users.id = :userId");
        $prep->bindParam(':userId', $userId);
        $prep->execute();

        $userDetails = $prep->fetch(PDO::FETCH_ASSOC);

        return $userDetails;
    }



    function addUser($givenname, $lastname, $street, $city, $zip, $accountrole, $user_id)
    {

        $prep = $this->pdo->prepare("INSERT INTO UserDetails (givenname, lastname, street, city, zip, accountrole, user_id)
                                     VALUES (:givenname, :lastname, :street, :city, :zip, :accountrole, :user_id)");
        $prep->execute([
            "givenname" => $givenname,
            "lastname" => $lastname,
            "street" => $street,
            "city" => $city,
            "zip" => $zip,
            "accountrole" => $accountrole,
            "user_id" => $user_id
        ]);
        return $this->pdo->lastInsertId();

    }

    public function updateUser($userId, $givenName, $lastname, $street, $city, $zip, $accountRole)
    {
        $prep = $this->pdo->prepare("UPDATE UserDetails SET givenname = :givenname, lastname = :lastname, street = :street, city = :city, zip = :zip, accountrole = :accountrole WHERE user_id = :userId");
        $prep->execute([
            "givenname" => $givenName,
            "lastname" => $lastname,
            "street" => $street,
            "city" => $city,
            "zip" => $zip,
            "accountrole" => $accountRole,
            "userId" => $userId
        ]);
    }

    function addUserToQueue($date, $queueroom_id, $user_id, $active = true)
    {
        $prep = $this->pdo->prepare("INSERT INTO QueuePosition (date, active, queueroom_id, user_id)
        VALUES (:date, :active, :queueroom_id, :user_id)");
        $prep->execute([
            "date" => $date,
            "active" => $active,
            "queueroom_id" => $queueroom_id,
            "user_id" => $user_id,

        ]);
        return $this->pdo->lastInsertId();
    }
    function IfUserInQueue($user_id, $roomId)
    {
        $sql = "SELECT * FROM QueuePosition 
        WHERE queueroom_id = :roomId AND active = true AND user_id = :user_id;";
        $prep = $this->pdo->prepare($sql);
        $prep->setFetchMode(PDO::FETCH_CLASS, "QueuePosition");
        $prep->execute(["user_id" => $user_id, "roomId" => $roomId]);
        return $prep->fetchAll();
    }
    function removeFromQueue($user_id, $queueroom_id)
    {
        $prep = $this->pdo->prepare("UPDATE QueuePosition SET active = false WHERE user_id = :user_id AND queueroom_id = :queueroom_id");
        $prep->execute([
            "user_id" => $user_id,
            "queueroom_id" => $queueroom_id,
        ]);
    }
    function getHelpQueue($roomId)
    {
        $sql = "SELECT * FROM QueuePosition 
        JOIN userdetails On userdetails.user_id = queueposition.user_id
        WHERE queueroom_id = :roomId AND active = true ORDER BY date asc;";
        $prep = $this->pdo->prepare($sql);
        $prep->setFetchMode(PDO::FETCH_CLASS, "QueuePosition");
        $prep->execute(["roomId" => $roomId]);
        return $prep->fetchAll();

    }
    function initIfNotInitialized()
    {
        if ($this->initialized) {
            return;
        }

        $sql = "CREATE TABLE IF NOT EXISTS `UserDetails` (
            `id` int NOT NULL AUTO_INCREMENT,
            `givenname` varchar(50) NOT NULL,
            `lastname` varchar(50) NOT NULL,
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
            `admin_user_id` int(10) unsigned NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`admin_user_id`) REFERENCES `users` (`id`)
        ) ENGINE=MyISAM";

        $this->pdo->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `QueuePosition` (
            `id` int NOT NULL AUTO_INCREMENT,
            `date` datetime NOT NULL,
            `active` boolean NOT NULL,
            `queueroom_id` int NOT NULL,
            `user_id` int NOT NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`queueroom_id`) REFERENCES `QueueRoom` (`id`),
            FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
        ) ENGINE=MyISAM";

        $this->pdo->exec($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `RoomAccess` (
            -- `id` int NOT NULL AUTO_INCREMENT,
            `date` datetime NOT NULL,
            `active` boolean NOT NULL,
            `queueroom_id` int NOT NULL,
            `user_id` int NOT NULL,
            PRIMARY KEY (`queueroom_id`, `user_id`),
            FOREIGN KEY (`queueroom_id`) REFERENCES `QueueRoom` (`id`),
            FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
        ) ENGINE=MyISAM";

        $this->pdo->exec($sql);

        $this->usersDatabase->setupUsers();
        $this->initialized = true;
    }
}


?>