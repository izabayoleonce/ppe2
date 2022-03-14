<?php
namespace ppe2\model;

use PDO;

class Teams 
{
    private $_id,
            $_logo,
            $_nomEquipe;
    
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
    
    public function setNomEquipe($nomEquipe)
    {
        if (is_string($nomEquipe)) {
            $this->_nomEquipe =$nomEquipe;
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

    public function getNomEquipe()
    {
      return $this->_nomEquipe;
    }

    

} 
?>