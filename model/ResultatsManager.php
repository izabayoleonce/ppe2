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
             ->prepare('INSERT INTO resultats(id_user, id_team1, scoreE1, scoreE2, pointE1, pointE2, id_team2, date, journee, Aller, retour) 
                        VALUES(:id_user, :id_team1, :scoreE1, :scoreE2, :pointE1, :pointE2, :id_team2, :date, :journee, :Aller, :retour)');
             $result=$q->excute([
                 ':id_user'         =>$result->getId_user(),
                 ':id_team1'        =>$result->getId_team1(),
                 ':scoreE1'         =>$result->getScoreE1(),
                 ':scoreE2'         =>$result->getScoreE1(),
                 ':pointE1'         =>$result->getPointE1(),
                 ':pointE2'         =>$result->getPointE2(),
                 ':id_team2'        =>$result->getId_team2(),
                 ':date'            =>$result->getDate(),
                 ':Aller'           =>$result->getAller(),
                 ':retour'          =>$result->getRetour(),
             ]);
        if($result){
          $result->hydrate([
             'id'=>$this->manager
                        ->db
                        ->lastInsertId()
         ]);
        }
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
                        'SELECT journee, resultat.id, t1.logo as logo1, t2.logo as logo2, dates, 
                                t2.nomEquipe AS nomEquipeAdv, t1.nomEquipe AS nomEquipe, 
                                resultat.scoresE1, resultat.scoresE2
                         FROM resultat 
                         LEFT JOIN Teams t1 ON resultat.id_team1 = t1.id 
                         LEFT JOIN Teams t2 ON resultat.id_team2 = t2.id'
                    );
        $q->execute();
        $listScore = $q->fetchAll(PDO::FETCH_ASSOC);
 
        return $listScore;
    }

    public function getResultatForDay()
    {
        $q = $this->manager
        ->db
        ->prepare(
            'SELECT journee, resultat.id, t1.logo as logo1, t2.logo as logo2, dates, 
                    t2.nomEquipe AS nomEquipeAdv, t1.nomEquipe AS nomEquipe, 
                    resultat.scoresE1, resultat.scoresE2, resultat.pointE1, resultat.pointE2
             FROM resultat 
             LEFT JOIN Teams t1 ON resultat.id_team1 = t1.id 
             LEFT JOIN Teams t2 ON resultat.id_team2 = t2.id 
             ORDER BY resultat.journee'
        );
        $q->execute();
        $listScore = $q->fetchAll(PDO::FETCH_ASSOC); 

        return $listScore;
    }

    public function updateScore(Resultats $Results)
    {
        $q = $this->manager
        ->db
        ->prepare(
            'UPDATE resultat SET id=:id, id_user=:id_user, scoresE1=:scoresE1, scoresE2=:scoresE2  WHERE id = :id'
        );
        $res = $q->execute([
            'id'                   =>$Results->getId(),
            'id_user'              =>$Results->getId_user(),
            'scoresE1'              =>$Results->getScoreE1(),
            'scoresE2'              =>$Results->getScoreE2(),
        ]);
//        echo (int)$res;die;
    }

}
?>
