<?php

/**
 * Created by PhpStorm.
 * User: LiteKangel
 * Date: 27/07/2016
 * Time: 21:41
 */
class UserManager
{

    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getUser($user_id)
    {
        return $this->db;
        $q = $this->db->prepare('SELECT user_id, username, avatar FROM users WHERE user_id = :id');
        $q->bindValue(':id', $user_id);
        $q->execute();
        if($q->fetch())
            return $q->fetch(PDO::FETCH_ASSOC);
        else
            return False;
    }
    public function connect($username, $password)
    {
        $q = $this->db->prepare('SELECT user_id FROM users WHERE username = :uname and password = :pass');
        $q->bindValue(':uname', $username);
        $q->bindValue(':pass', $password);
        $q->execute();
        $r = $q->fetch(PDO::FETCH_ASSOC);
        if($r)
            return $r['user_id'];
        else
            return False;
    }
    public function getAvatar()
    {
        return $this->avatar;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getUserid()
    {
        return $this->userid;
    }

    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }
}