<?php
namespace model;

use model\Resultats;

use PDO;

class ResultatsManager extends Manager
{
    public $_userData,
           $_statut;
    public function add(Resultats $result)
    {
        $q=$this->manager
             ->db
             ->prepare('INSERT INTO resultats(id_user,id_team1,score,id_team2,date) 
                        VALUES(:id_user,:id_team1,:score,:id_team2,:date)');
             $user=$q->excute([
                 ':id_user', $result->getId_user(),
                 ':id_team1', $result->getId_user(),
                 ':score', $result->getScore(),
                 ':id_team2', $result->getId_team2(),
                 ':date', $result->getDate()
             ]);

             $user->hydrate([
                 'id'=>$this->manager->db->lastInsertId()
             ]);
    }

    public function getAllResultats()
    {
        
        $q = $this->manager
                  ->db
                  ->prepare( 'SELECT * FROM utilisateurs' );
        $q->execute();
        $listRes = $q->fetchAll(PDO::FETCH_ASSOC);
 
        return $listRes;
    }

}
?>