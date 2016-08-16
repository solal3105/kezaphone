<?php

/**
 * Created by PhpStorm.
 * User: LiteKangel
 * Date: 25/07/2016
 * Time: 11:52
 */
class Marque
{
    protected $id_marque, $marque, $siege;

    public function __construct($valeurs = array())
    {
        if (!empty($valeurs))
            $this->hydrate($valeurs);
    }

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
    public function setIdMarque($id_marque)
    {
        $this->id_marque = $id_marque;
    }
    public function setMarque($marque)
    {
        $this->marque = $marque;
    }
    public function setSiege($siege)
    {
        $this->siege = $siege;
    }
    public function id_marque()
    {
        return $this->id_marque;
    }
    public function marque()
    {
        return $this->marque;
    }
    public function siege()
    {
        return $this->siege;
    }
}