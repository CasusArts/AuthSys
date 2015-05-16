<?php
namespace Controller;

use Model\User;
use PDO;

/**
 *
 * @author    Andriy Oblivantsev <eslider@gmail.com>
 * @author    Fiodor Gorobet <casusarts@gmail.com>
 */
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
        return $userData;
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
     * @return User
     */
    public function registration($userName, $password)
    {
        $password = $this->encryptPassword($password);
        $user     = new User();
        $user->setName($userName);
        $user->setPassword($password);

        //TODO: save user into DB
        $db    = $this->getConnection();
        $query = $db->prepare("INSERT INTO user ('name', 'pass') VALUES (?,?)");
        $query->execute(array($userName, $password));
        return $user;
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