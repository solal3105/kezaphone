
<?php
    abstract class PhoneManager
    {
        /**
         * M�thode permettant d'ajouter une phone
         * @param $phone Phone La phone � ajouter
         * @return void
         */
        abstract protected function add(Phone $phone);
        
        /**
         * M�thode renvoyant le nombre de phone total
         * @return int
         */
        abstract public function count();
        
        /**
         * M�thode permettant de supprimer une phone
         * @param $id int L'identifiant de la phone � supprimer
         * @return void
         */
        abstract public function delete($id);
        
        /**
         * M�thode retournant une liste de phone demand�e
         * @param $debut int La premi�re phone � s�lectionner
         * @param $limite int Le nombre de phone � s�lectionner
         * @return array La liste des phone. Chaque entr�e est une instance de Phone.
         */
        abstract public function getList($debut = -1, $limite = -1);
        
        /**
         * M�thode retournant une phone pr�cise
         * @param $id int L'identifiant de la phone � r�cup�rer
         * @return Phone La phone demand�e
         */
        abstract public function getUnique($id);
        
        /**
         * M�thode permettant d'enregistrer une phone
         * @param $phone Phone la phone � enregistrer
         * @see self::add()
         * @see self::modify()
         * @return void
         */
        public function save(Phone $phone)
        {
            if ($phone->isValid())
            {
                $phone->isNew() ? $this->add($phone) : $this->update($phone);
            }
            else
            {
                throw new RuntimeException('La phone doit �tre valide pour �tre enregistr�e');
            }
        }
        
        /**
         * M�thode permettant de modifier une phone
         * @param $phone phone la phone � modifier
         * @return void
         */
        abstract protected function update(Phone $phone);
    }
