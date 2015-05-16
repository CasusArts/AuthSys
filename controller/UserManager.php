<?php
/**
 *
 * @author    Andriy Oblivantsev <eslider@gmail.com>
 * @copyright 16.05.2015 by WhereGroup GmbH & Co. KG
 */
namespace Controller;

use Model\User;

/**
 *
 * @author    Andriy Oblivantsev <eslider@gmail.com>
 * @copyright 15.05.2015 by WhereGroup GmbH & Co. KG
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

    }

    public function getAll()
    {
    }

    /**
     * @param $userName
     * @param $password
     * @return User
     * @internal param $user
     */
    public function registration($userName, $password)
    {
        $user = new User();
        $user->setName($userName);
        $user->setPassword($password);

        //TODO: save user into DB

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
            "name" => $user->getName()
        );
    }
}