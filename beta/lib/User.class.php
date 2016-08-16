<?php

/**
 * Created by PhpStorm.
 * User: LiteKangel
 * Date: 27/07/2016
 * Time: 21:41
 */
class User
{

    protected $username, $password, $user_id, $avatar;

    public function __construct($valeurs = array())
    {
        if (!empty($valeurs))
            $this->hydrate($valeurs);
    }

    /**
     * M�thode assignant les valeurs spécifiées aux attributs correspondant
     * @param $donnees array Les données à assigner
     * @return void
     */
    public function hydrate($donnees)
    {
        foreach ($donnees as $attribut => $valeur)
        {
            $methode = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribut)));

            if (is_callable(array($this, $methode)))
            {
                $this->$methode($valeur);
            }
        }
    }

    public public function getAvatar()
    {
        return $this->avatar;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getUserId()
    {
        return $this->user_id;
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