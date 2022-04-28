<?php
namespace model;

use PDO;

class Resultats
{
    private $_id,
            $_id_user,
            $_id_team1,
            $_scoreE1,
            $_pointE1,
            $_scoreE2,
            $_pointE2,
            $_id_team2,
            $_date;


    const POINT_GAGNANT = 3;
    const POINT_NULL = 1;

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

    public function gagnerPointE1()
    {
        $this->_pointE1 += self::POINT_GAGNANT;   
    }

    public function gagnerPointE2()
    {
        $this->_pointE2 += self::POINT_GAGNANT;
    }

    public function pointEquitable()
    {
        $this->_pointE1 == $this->_pointE2 += self::POINT_NULL;
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

    public function setScoreE1($scoreE1)
    {
        if (is_int($scoreE1)) {
            $this->_scoreE1 =$scoreE1;
        }
    }

    public function setScoreE2($scoreE2)
    {
        if (is_int($scoreE2)) {
            $this->_scoreE2 =$scoreE2;
        }
    }
    public function setPointE1($pointE1)
    {
        $pointE1 = (int) $pointE1;
        if ($pointE1 >= 0 && $pointE1 <= 1000) {
            $this->_pointE1 =$pointE1;
        }
    }
    public function setPointE2($pointE2)
    {
        $pointE2 = (int) $pointE2;
        
        if ($pointE2 >= 0 && $pointE2 <= 1000) {
            $this->_pointE2 =$pointE2;
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

    public function getScoreE1()
    {
        return $this->_scoreE1;
    }

    public function getScoreE2()
    {
        return $this->_scoreE2;
    }

    public function getPointE1()
    {
        return $this->_pointE1;
    }

    public function getPointE2()
    {
        return $this->_pointE2;
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

// nnombre de match =(x-1)*x==20

?>