<?php

namespace controller;
use model\TeamsManager;
use model\Teams;

class TeamController extends Controller
{
    

    public function __construct()
    {        
        $this->teamsManager = new TeamsManager();
        parent::__construct();


    }

    public function defaultAction()
    {
        $data = ['test' => 'marche'];
        $this->render('home', $data);
    }

    public function infoTeamAction()
    {
        $infoTeams = $this->teamsManager->getAllTeams();
        
        $data=[
            'info'  => $infoTeams
        ];

        $this->render('infoTeam',$data);


    }

   public function listTeamAction()
   {
       $lstTeam = $this->teamsManager->getAllTeams();
       $data=[
            'liste'  => $lstTeam,
        ];

        $this->render('listeTeam',$data);
   }
   
   public function updateAction()
   {
       $chan = $this->teamsManager->getTeam($_POST['nom']);
       $data = [ 
        'changer'     =>$chan
       ];

       $this->render('update', $data);
   }

   public function updateValidAction()
    {   
        if (isset($_POST['nomEntreneur']) && isset($_POST['prenomEntreneur'])&& isset($_POST['logo']) && isset($_POST['nomEquipe']) && isset($_POST['info'])  
        && !empty($_POST['nomEntreneur']) &&  !empty($_POST['prenomEntreneur']) && !empty($_POST['logo']) && !empty($_POST['nomEquipe']) && !empty($_POST['info']))
        {
            
            $Data = [
                'nomEntreneur'              => $_POST['nomEntreneur'],
                'prenomEntreneur'           => $_POST['prenomEntreneur'],
                'logo'                      => $_POST['logo'],
                'nomEquipe'                 => $_POST['nomEquipe'],
                'info'                      => $_POST['info'],
             ];

            $DataAdv = [
                'logo'                      => $_POST['logo'],
                'nomEquipe'                 => $_POST['nomEquipe'],
            ];
 
            $team = new Teams($Data);
            $teamAdv = new Teams($DataAdv);
            $this->teamsManager->updateTeam($team);
            $this->teamsManager->updateTeamadv($teamAdv);
            $chooseEvene = $this->EvenManager->getChooseEvenement();
            $data = [
                'choisirEvenement'    => $chooseEvene
            ];
            $this->render('gestion', $data);

        }
        else{
            $changeEven = $this->EvenManager->getEvenements($_POST['id']);
            $responsable = $this->EvenManager->getResponsable();
            $data=[
                'changer'     =>$changeEven,
                'responsable' =>$responsable,
            ];
            $this->render('update', $data);
        }    

    }

    public function deleteAction()
    {
        if(isset( $_POST['nom'])){
            $teamData   = $this->teamsManager->getTeams($_POST['nom']);
            $deleteTeam = $this->teamsManager->deleteTeam($teamData);
            $deleteTeamadv = $this->teamsManager->deleteTeamadv($teamData);
                
             if ($deleteRef == TRUE) {

                 $message = "L'utilisateur <b>" . $teamData->getNom() . '</b> a été supprimé.';
             }else{
                    $message = "l'utilisateur a bien été remplacer";
             }
             $this->_listteams = $this->teamsManager->getAllteamss();
             $this->_listRef = $this->teamsManager->getAllteames();

             $data = [
                 'listteamss'         => $this->_listUser,
                 'listRef'           => $this->_listRef,
                 'message'           => $message,
             ];
    }
}