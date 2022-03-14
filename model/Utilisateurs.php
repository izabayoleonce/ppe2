<?php

namespace model;

class Utilisateurs
{
    private $_id,
            $_nom,
            $_prenom,
            $_email,
            $_login,
            $_password,
            $_isadmin,
            $_observation,
            $_active;
    
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

    public function setNom($nom)
    {
        if (is_string($nom)) {
            $this->_nom =$nom;
        }
    }
    
    public function setPrenom($prenom)
    {
        if (is_string($prenom)) {
            $this->_prenom =$prenom;
        }
    }
    
    public function setemail($email)
    {
        if (is_string($email)) {
            $this->_email =$email;
        }
    }
    
    public function setlogin($login)
    {
        if (is_string($login)) 
        {
            $this->_login =$login;
        }
    }
    
    public function setPassword($password)
    {
        if (is_string($password)) {
            $this->_password =$password;
        }
    }
    
    public function setObservation($observation)
    {
        if (is_string($observation)) {
            $this->_observation =$observation;
        }
    }
    
    public function setIsAdmin($isadmin)
    {
        if($isadmin != null)
        {
            $this->_isadmin = $isadmin;
        } else {
            $this->_isadmin = 0;
        }
    }
    
    public function setActive($active)
    {
      if($active != null)
      {
          $this->_active = $active;
      } else {
          $this->_active = 0;
      }
    }

    public function getId()
    {
      return $this->_id;
    }

    public function getNom()
    {
      return htmlentities($this->_nom);
    }

    public function getPrenom()
    {
      return htmlentities($this->_prenom);
    }

    public function getEmail()
    {
      return htmlentities($this->_email);
    }

    public function getLogin()
    {
      return htmlentities($this->_login);
    }public function getPassword()
    {
      return htmlentities($this->_password);
    }public function getObservation()
    {
      return htmlentities($this->_observation);
    }

    public function getActive()
    {
      return $this->_active;
    }
    public function getIsadmin()
    {
      return $this->_isadmin;
    }

    


}

?>
