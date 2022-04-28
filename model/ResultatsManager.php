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
                 ':score', $result->getScoreE1(),
                 ':id_team2', $result->getId_team2(),
                 ':date', $result->getDate()
             ]);

             $user->hydrate([
                 'id'=>$this->manager->db->lastInsertId()
             ]);
    }

    public function getJours()
    {
        $q = $this->manager
                  ->db
                  ->prepare('SELECT Journe FROM resultat');
        $q->execute();
    }
    public function getAllResultatsDay()
    {
        
        $q = $this->manager
                    ->db
                    ->prepare(
                        'SELECT journee, t1.logo as logo1, t2.logo as logo2, dates, 
                                t2.nomEquipe AS nomEquipeAdv, t1.nomEquipe AS nomEquipe, 
                                resultat.scoresE1, resultat.scoresE2
                         FROM resultat 
                         LEFT JOIN Teams t1 ON resultat.id_team1 = t1.id 
                         LEFT JOIN Teams t2 ON resultat.id_team2 = t2.id'
                    );

/*                  ->prepare( 'SELECT journee, logo, nomEquipe, scoresE1,scoresE2, logoAdv, nomEquipeAdv 
                                FROM resultat 
                                INNER JOIN Teams 
                                INNER JOIN Teamsadv ON resultat.id_team1=Teams.id AND resultat.id_team2=Teamsadv.id' );*/
        $q->execute();
        $listScore = $q->fetchAll(PDO::FETCH_ASSOC);
 
        return $listScore;
    }

}
?>
