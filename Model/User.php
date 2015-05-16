<?php
namespace Model;

/**
 * Class User
 *
 * @author    Andriy Oblivantsev <eslider@gmail.com>
 */
class User
{
    protected $name;
    protected $password;

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

}


//class FtpUser extends User{
//    public function setServerName()
//    {
//        $userName = $this->name;
//    }
//}
//
//
//$ftpUser = new FtpUser();
