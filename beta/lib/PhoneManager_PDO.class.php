<?php
    class PhoneManager_PDO extends PhoneManager
    {
        /**
         * Attribut contenant l'instance représentant la BDD
         * @type PDO
         */
        protected $db;

        public function __construct(PDO $db)
        {
            $this->db = $db;
        }

        public function add(Phone $phone)
        {
            try {
                $requete = $this->db->prepare('INSERT INTO phones SET modele = :modele, id_os = :id_os,
                                          puissance = :puissance, id_marque = :id_marque, autonomie = :autonomie,
                                          prix = :prix, photos = :photos, taille = :taille, sortie = :sortie  ');
                $requete->bindValue(':modele', $phone->modele());
                $requete->bindValue(':id_marque', $phone->id_marque());
                $requete->bindValue(':id_os', $phone->id_os());
                $requete->bindValue(':prix', $phone->prix());
                $requete->bindValue(':autonomie', $phone->autonomie());
                $requete->bindValue(':photos', $phone->photos());
                $requete->bindValue(':taille', $phone->taille());
                $requete->bindValue(':sortie', $phone->sortie());
                $requete->bindValue(':puissance', $phone->puissance());
                $requete->execute();
            }
            catch (PDOException $err) {
                // Catch Expcetions from the above code for our Exception Handling
                $trace = '<table border="0">';
                foreach ($err->getTrace() as $a => $b) {
                    foreach ($b as $c => $d) {
                        if ($c == 'args') {
                            foreach ($d as $e => $f) {
                                $trace .= '<tr><td><b>' . strval($a) . '#</b></td><td align="right"><u>args:</u></td> <td><u>' . $e . '</u>:</td><td><i>' . $f . '</i></td></tr>';
                            }
                        } else {
                            $trace .= '<tr><td><b>' . strval($a) . '#</b></td><td align="right"><u>' . $c . '</u>:</td><td></td><td><i>' . $d . '</i></td>';
                        }
                    }
                }
                $trace .= '</table>';
                echo '<br /><br /><br /><font face="Verdana"><center><fieldset style="width: 100%; border: 4px solid white; background: black;"><legend><b>[</b>PHP PDO Error ' . strval($err->getCode()) . '<b>]</b></legend> <table border="0"><tr><td align="right"><b><u>Message:</u></b></td><td><i>' . $err->getMessage() . '</i></td></tr><tr><td align="right"><b><u>Code:</u></b></td><td><i>' . strval($err->getCode()) . '</i></td></tr><tr><td align="right"><b><u>File:</u></b></td><td><i>' . $err->getFile() . '</i></td></tr><tr><td align="right"><b><u>Line:</u></b></td><td><i>' . strval($err->getLine()) . '</i></td></tr><tr><td align="right"><b><u>Trace:</u></b></td><td><br /><br />' . $trace . '</td></tr></table></fieldset></center></font>';
            }

        }
        public function addMarque(Marque $m)
        {
            $req = $this->db->prepare('INSERT INTO marques SET marque=:marque, siege=:siege');
            $req->bindValue(':marque', $m->marque());
            $req->bindValue(':siege', $m->siege());
            $req->execute();
        }
        public function upMarque(Marque $m)
        {
            $req = $this->db->prepare('UPDATE marques SET marque=:marque, siege=:siege WHERE id_marque = :mid');
            $req->bindValue(':marque', $m->marque());
            $req->bindValue(':siege', $m->siege());
            $req->bindValue(':mid', $m->id_marque());
            $req->execute();
        }
        /**
         * @see PhoneManager::count()
         */
        public function count()
        {
            return $this->db->query('SELECT COUNT(*) FROM phones')->fetchColumn();
        }
        
        /**
         * @see PhoneManager::delete()
         */
        public function delete($id)
        {
            $this->db->exec('DELETE FROM phones WHERE id = '.(int) $id);
        }
        
        /**
         * @see PhoneManager::getList()
         */
        public function getList($debut = -1, $limite = -1)
        {
            $listePhone = array();
            
            $sql = 'SELECT id, modele, id_marque, autonomie, DATE_FORMAT (sortie, \'le %d/%m/%Y � %Hh%i\') AS sortie FROM phones ORDER BY id DESC';
            
            if ($debut != -1 || $limite != -1)
            {
                $sql .= ' LIMIT '.(int) $limite.' OFFSET '.(int) $debut;
            }
            
            $requete = $this->db->query($sql);
            
            while ($phone = $requete->fetch(PDO::FETCH_ASSOC))
            {
                $listePhone[] = new Phone($phone);
            }
            
            $requete->closeCursor();
            
            return $listePhone;
        }
        
        /**
         * @see PhoneManager::getUnique()
         */
        public function getUnique($id)
        {
            $requete = $this->db->prepare('SELECT id, modele, id_marque, autonomie, puissance, taille, photos, prix, id_os FROM phones WHERE id = :id');
            $requete->bindValue(':id', (int) $id, PDO::PARAM_INT);
            $requete->execute();
            
            return new Phone($requete->fetch(PDO::FETCH_ASSOC));
        }

        /**
         * @param $id_marque
         * @return mixed
         */
        public function getMarque($id_marque)
        {
            $q = $this->db->prepare('SELECT id_marque, marque, siege from marques WHERE id_marque = :id_marque');
            $q->bindValue(':id_marque', $id_marque);
            $q->execute();
            return new Marque($q->fetch(PDO::FETCH_ASSOC));
        }
        public function pExist($pid)
        {
            $q = $this->db->prepare('SELECT id from phones WHERE id = :id');
            $q->bindValue(':id', $pid);
            $q->execute();
            $r = $q->fetch(PDO::FETCH_ASSOC);
            if(isset($r['id']) and !empty($r['id']))
                return True;
            else
                return False;
        }
        public function getMarques()
        {
            $q = $this->db->query('SELECT id_marque, marque, siege from marques');
            $r = $q->fetchAll();
            return $r;
        }
        public function getOss()
        {
            $q = $this->db->query('SELECT id_os, os from os');
            $r = $q->fetchAll();
            return $r;
        }
        /**
         * @see PhoneManager::update()
         */
        protected function update(Phone $phone)
        {
            $requete = $this->db->prepare('UPDATE phones SET modele = :modele, id_marque = :id_marque, autonomie = :autonomie, prix = :prix, photos = :photos, ecran = :ecran, sortie = :sortie WHERE id = :id');
            $requete->bindValue(':modele', $phone->modele());
            $requete->bindValue(':id_marque', $phone->id_marque());
            $requete->bindValue(':os', $phone->os());
            $requete->bindValue(':prix', $phone->prix());
            $requete->bindValue(':autonomie', $phone->autonomie());
            $requete->bindValue(':photos', $phone->photos());
            $requete->bindValue(':ecran', $phone->ecran());
            $requete->bindValue(':sortie', $phone->sortie());
            $requete->bindValue(':id', $phone->id(), PDO::PARAM_INT);
            
            $requete->execute();
        }
    }
