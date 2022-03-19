<?php

namespace model;
use PDO;

class TeamsManager extends Manager
{
    public $_teamData;


    public function getAllTeams()
    {
        
        $q = $this->manager
                  ->db
                  ->prepare( 'SELECT * FROM Teams' );
        $q->execute();
        $listRes = $q->fetchAll(PDO::FETCH_ASSOC);
 
        return $listRes;
    }
} 
?>