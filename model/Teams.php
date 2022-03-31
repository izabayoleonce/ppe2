<?php
namespace model;

use PDO;

class Teams 
{
    private $_id,
            $_nomEntreneur,
            $_prenomEntreneur,
            $_logo,
            $_nomEquipe,
            $_infoTeam;
    
    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }
    
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) 
        {
            $method ='set'.ucfirst($key);
            if (method_exists($this, $method)) 
            {
                $this->$method($value);
            }

        }
    }

    public function setId($id)
    {
        $id = (int) $id;

        if ($id > 0) 
        {
            $this->_id = $id;
        }
    }

    public function setLogo($logo)
    {
        if (is_string($logo)) {
            $this->_logo =$logo;
        }
    }
    public function setNomEntreneur($nomEntreneur)
    {
        if (is_string($nomEntreneur)) {
            $this->_nomEntreneur = $nomEntreneur;
        }
    }
    public function setPrenomEntreneur($prenomEntreneur)
    {
        if (is_string($prenomEntreneur)) {
            $this->_prenomEntreneur = $prenomEntreneur;
        }
    }
    public function setNomEquipe($nomEquipe)
    {
        if (is_string($nomEquipe)) {
            $this->_nomEquipe =$nomEquipe;
        }
    }

    public function setInfoTeam($infoTeam)
    {
        if (is_string($infoTeam)) {
            $this->_infoTeam =$infoTeam;
        }
    }
    

    public function getId()
    {
      return $this->_id;
    }

    public function getLogo()
    {
      return $this->_logo;
    }

    public function getNomEntreneur()
    {
        return $this->_nomEntreneur;
    }

    public function getPrenomEntreneur()
    {
        return $this->_prenomEntreneur;
    }

    public function getNomEquipe()
    {
      return $this->_nomEquipe;
    }

    public function getInfoTeam()
    {
        return $this->_infoTeam;
    }

    

} 
?>