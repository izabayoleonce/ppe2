<?php

namespace model;
use model\Teams;
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

    public function getTeam($info)
    {
        $q = $this->manager
                  ->db
                  ->prepare( 'SELECT * FROM Teams WHERE id = :id' );
        $q->execute([':id' => $info]);
        $donnees = $q->fetch(PDO::FETCH_ASSOC);

        return $donnees;
    }

    public function updateTeam(Teams $teams)
    {
        $q=$this->manager
                      ->db
                      ->prepare('UPDATE Teams SET nomEntreneur=:nomEntreneur, prenomEntreneur=:prenomEntreneur, logo=:logo, nomEquipe=:nomEquipe, infoTeam=:infoTeam   WHERE id=:id');
        return $q->execute([
            ':id'                      => $teams->getId(),
            ':prenomEntreneur'         => $teams->getPrenomEntreneur(),
            ':nomEntreneur'            => $teams->getNomEntreneur(),
            ':logo'                    => $teams->getLogo(),
            ':nomEquipe'               => $teams->getNomEquipe(), 
            ':infoTeam'                => $teams->getInfoTeam(),
        ]);
    }

    public function updateTeamAdv(Teams $teamAdv)
    {
        $q=$this->manager
                      ->db
                      ->prepare('UPDATE Teamsadv SET  logoAdv=:logo, nomEquipeAdv=:nomEquipe  WHERE nomEquipeAdv = :nomEquipe');
        return $q->execute([
            ':logo'                    => $teamAdv->getLogo(),
            ':nomEquipe'               => $teamAdv->getNomEquipe(),
        ]);
    }

    public function deleteTeam($info)
    {
        $q=$this->manager
                ->db
                ->prepare('DELETE FROM Teams WHERE nomEquipe = :nomEquipe');
        $q->bindValue(':nomEquipe', $info , PDO::PARAM_INT);
        return $q->execute();
    }

    public function deleteTeamAdv($info)
    {
        $q=$this->manager
                ->db
                ->prepare('DELETE FROM Teamsadv WHERE nomEquipe = :nomEquipe');
        $q->bindValue(':nomEquipe', $info , PDO::PARAM_INT);
        return $q->execute();
    }
} 
?>
