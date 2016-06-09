<?php
namespace Controller;

use Model\User;
use PDO;

/**
 *
 * @author    Andriy Oblivantsev <eslider@gmail.com>
 * @author    Fiodor Gorobet <casusarts@gmail.com>
 */

// TODO: add Email check while registration. if Email exists, forbid the registration


class UserManager
{
    /**
     * @param string $user
     * @param string $pass
     *
     * @return User
     */
    public function login($user, $pass)
    {
        $connection = $this->getConnection();
        $pass       = $this->encryptPassword($pass);
        $userData   = null;

        foreach ($connection->query("SELECT * FROM user WHERE name LIKE '$user' AND pass LIKE '$pass' ") as $userData) {
            $userData = $this->export($this->create($userData));
            break;
        }

        $_SESSION["user"] = $userData;

        return $userData;
    }

    public function logout()
    {
        $_SESSION = array();
    }

    /**
     * @return bool
     */
    public function isUserLoggedIn()
    {
        return isset($_SESSION["user"]) && $_SESSION["user"] != null;
    }

    public function getLoggedUser()
    {
        return $_SESSION["user"];
    }

    /**
     * Get all users
     *
     * @return array
     */
    public function getAll()
    {
        $connection = $this->getConnection();
        $users      = array();
        foreach ($connection->query("SELECT * FROM user") as $userData) {
            $user    = $this->create($userData);
            $users[] = $this->export($user);
        }
        return $users;
    }

    /**
     * @param $userName
     * @param $password
     * @param $email
     * @return User
     * @var Array $emailCheck
     */
    public function registration($userName, $password, $email)
    {
//        $emailCheck = Array();
        $password = $this->encryptPassword($password);
        $db    = $this->getConnection();
        $query = $db->prepare("INSERT INTO user ('name', 'pass', 'email') VALUES (?, ?, ?)");
        $query->execute(array($userName, $password, $email));

  
        
        // Variant 2:
        // TODO: Redefine sql
        $sql = "SELECT email FROM name WHERE email LIKE $email";
        foreach ($db->query($sql) as $mail) {
            if ($mail == null) {
                return "Registration successful";
            } else {
                return "This user is already exists!";
            }

        }
        $db = null;


        //return null;
    }


    /**
     * Export user data as array
     *
     * @param User $user
     * @return array
     */
    public function export(User $user)
    {
        return array(
            "id"    => $user->getId(),
            "name"  => $user->getName(),
            "email" => $user->getEmail()
        );
    }

    /**
     * Connection to sqlite db file
     *
     * @return PDO
     */
    protected function getConnection()
    {
        $sqlite = new PDO('sqlite:authsys.db');
        $sqlite->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $sqlite;
    }

    /**
     * Create user by data array
     *
     * @param $userData
     * @return User
     */
    private function create($userData)
    {
        $user = new User();
        $user->setId($userData["id"]);
        $user->setName($userData["name"]);
        $user->setEmail($userData["email"]);
        $user->setPassword($userData["pass"]);
        return $user;
    }

    /**
     * @param $password
     * @return string
     */
    private function encryptPassword($password)
    {
        $password = md5(md5($password));
        return $password;
    }
}
