<?php
    /**
     * @author Kangel
     * @version 2.0
     */
    class Phone
    {
        protected $erreurs = array(),
                  $id,
                  $modele,
                  $sortie,
                  $id_os,
                  $id_marque,
                  $prix,
                  $autonomie,
                  $puissance,
                  $photos,
                  $taille, $pic;

        const AUTEUR_INVALIDE = 1;
        const TITRE_INVALIDE = 2;
        const CONTENU_INVALIDE = 3;
        
        

        public function __construct($valeurs = array())
        {
            if (!empty($valeurs)) // Si on a sp�cifi� des valeurs, alors on hydrate l'objet
                $this->hydrate($valeurs);
        }
        
        /**
         * M�thode assignant les valeurs sp�cifi�es aux attributs correspondant
         * @param $donnees array Les donn�es � assigner
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
        
        /**
         * M�thode permettant de savoir si la phone est nouvelle
         * @return bool
         */
        public function isNew()
        {
            return empty($this->id);
        }
        
        /**
         * M�thode permettant de savoir si la phone est valide
         * @return bool
         */
        public function isValid()
        {
            return !(empty($this->auteur) || empty($this->modele) || empty($this->contenu));
        }

        // SETTERS //
        
        public function setId($id)
        {
            $this->id = (int) $id;
        }
        
        public function setIdMarque($id_marque)
        {
            if (!is_string($id_marque) || empty($id_marque))
                $this->erreurs[] = self::AUTEUR_INVALIDE;
            else
                $this->id_marque = $id_marque;
        }
        public function setIdOs($id_os)
        {
            if (!is_string($id_os) || empty($id_os))
                $this->erreurs[] = self::AUTEUR_INVALIDE;
            else
                $this->id_os = $id_os;
        }
        
        public function setModele($modele)
        {
            if (!is_string($modele) || empty($modele))
                $this->erreurs[] = self::TITRE_INVALIDE;
            else
                $this->modele = $modele;
        }
        
        public function setContenu($contenu)
        {
            if (!is_string($contenu) || empty($contenu))
                $this->erreurs[] = self::CONTENU_INVALIDE;
            else
                $this->contenu = $contenu;
        }
        
        public function setAutonomie($autonomie)
        {
            $this->autonomie = $autonomie;
        }
        public function setTaille($taille)
        {
            $this->taille = $taille;
        }
        public function setPhotos($photos)
        {
            $this->photos = $photos;
        }
        public function setPrix($prix)
        {
            $this->prix = $prix;
        }
        public function setSortie($sortie)
        {
            $this->sortie = $sortie;
        }
        public function setPuissance($puissance)
        {
            $this->puissance = $puissance;
        }
        
        // GETTERS //
        
        public function erreurs()
        {
            return $this->erreurs;
        }
        
        public function id()
        {
            return $this->id;
        }
        
        public function modele()
        {
            return $this->modele;
        }
        public function id_marque()
        {
            return $this->id_marque;
        }
        public function sortie()
        {
            return $this->sortie;
        }
        public function id_os()
        {
            return $this->id_os;
        }
        public function prix()
        {
            return $this->prix;
        }
        public function photos()
        {
            return $this->photos;
        }
        public function taille()
        {
            return $this->taille;
        }
        public function autonomie()
        {
            return $this->autonomie;
        }
        public function puissance()
        {
            return $this->puissance;
        }
    }
