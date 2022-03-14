<?php
namespace model;

use PDO;

class Resultats
{
    private $_id,
            $_id_user,
            $_id_team1,
            $_score,
            $_id_team2,
            $_date;

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

    public function setId_user($id_user)
    {
        if (is_int($id_user)) {
            $this->_id_user =$id_user;
        }
    }

    public function setId_team1($id_team1)
    {
        if (is_int($id_team1)) {
            $this->_id_team1 =$id_team1;
        }
    }

    public function setScore($score)
    {
        if (is_double($score)) {
            $this->_score =$score;
        }
    }

    public function setId_team2($id_team2)
    {   
        if (is_int($id_team2)) 
        {
            $this->_id_team2 =$id_team2;
        }
    }

    public function setDate($date)
    {
        if (is_int($date)) {
            $this->_date =$date;
        }
    }



    public function getId()
    {
        return $this->_id;
    }

    public function getId_user()
    {
        return $this->_id_user;
    }

    public function getId_team1()
    {   
        return $this->_id_team1;
    }

    public function getScore()
    {
        return $this->_score;
    }

    public function getId_team2()
    {
        return $this->_id_team2;
    }
    public function getDate()
    {
        return $this->_date;
    }   

}

?>