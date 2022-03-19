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
                  ->prepare( 'SELECT dates, logo, nomEquipe, scoresE1,scoresE2, logoAdv, nomEquipeAdv FROM resultat INNER JOIN Teams INNER JOIN Teamsadv ON resultat.id_team1=Teams.id AND resultat.id_team2=Teamsadv.id' );
        $q->execute();
        $listScore = $q->fetchAll(PDO::FETCH_ASSOC);
 
        return $listScore;
    }

}
?>