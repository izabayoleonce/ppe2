<?php

namespace controller;
use model\TeamsManager;
use model\Teams;
use model\UtilisateursManager;
use model\ResultatsManager;

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
       $userManager = new UtilisateursManager;
       $userData = $userManager ->getUsers($_COOKIE['connection']);
       $isadmin = $userData['isadmin'];
      
       $data = [
           'admin'     =>$isadmin,
            'liste'  => $lstTeam,
        ];

        $this->render('listeTeam',$data);
   }
   
   public function updateAction()
   {
       $chan = $this->teamsManager->getTeam($_POST['id']);
       $data = [ 
        'changer'     =>$chan
       ];

       $this->render('update', $data);
   }

    public function updateValidAction()
    {  
          
        $new = false;
        if( isset( $_REQUEST['update'] ) ) 
        {
            if( !empty( $_FILES['logo']['tmp_name'] ) ) {
                if ($_FILES['logo']['size'] <= 50000000) 
                {
                
                $infosfichier = pathinfo($_FILES['logo']['name']);
                $extension_upload = $infosfichier['extension'];
                $extension_autorisees = ['jpg', 'jpeg', 'png', 'svg'];
                if (in_array($extension_upload, $extension_autorisees)) 
                {
                    $nom=$_POST['initiale'];
                    $new =$nom."_"."logo".".".$extension_upload;
                    $enre = move_uploaded_file($_FILES['logo']['tmp_name'], 'public/images/imageDbPpe2/' . $new );
                }
                }
            } 
            else {
                $new = $_REQUEST['curLogo'];
            }
            //var_dump($new);
            $Data = [
                'id'                        => $_POST['id'],
                'nomEntreneur'              => $_POST['nomEntreneur'],
                'prenomEntreneur'           => $_POST['prenomEntreneur'],
                'logo'                      => 'public/images/imageDbPpe2/' . $new,
                'nomEquipe'                 => $_POST['nomEquipe'],
                'infoTeam'                  => $_POST['info'],
            ];
        /*
            $DataAdv = [
                'logo'                      => $_POST['logo'],
                'nomEquipe'                 => $_POST['nomEquipe'],
            ];*/
 
            $teams   = new Teams($Data);
           // $teamAdv = new Teams($DataAdv);
            $this->teamsManager->updateTeam($teams);
           // $this->teamsManager->updateTeamadv($teamAdv);
            $lstTeam = $this->teamsManager->getAllTeams();
            $data=[
                 'liste'  => $lstTeam,
             ];
     
             $this->render('listeTeam',$data);

        }
        else{
            $chan = $this->teamsManager->getTeam($_REQUEST['id']);
            $message = "Erreur de envouie";
            $data = [ 
                'changer'     =>$chan,
                'message'     =>$message
            ];

            $this->render('update', $data);
        }    

    }

    public function deleteAction()
    {
        if(isset( $_POST['nom'])){
            $this->teamsManager = new TeamsManager();
            $teamData   = $this->teamsManager->getTeam($_POST['nom']);
            $deleteTeam = $this->teamsManager->deleteTeam($teamData);
            $deleteTeamadv = $this->teamsManager->deleteTeamadv($teamData);
                
             if ($deleteTeam == TRUE) {

                 $message = "L'utilisateur <b>" . $teamData->getNom() . '</b> a été supprimé.';
             }else{
                    $message = "l'utilisateur a bien été remplacer";
             }
             $this->_listteams = $this->teamsManager->getAllTeams();
             $this->_listRef = $this->teamsManager->getAllTeams();

             $data = [
                 'listteamss'         => $this->_listUser,
                 'listRef'           => $this->_listRef,
                 'message'           => $message,
             ];
        }
    }

    public function createAction()
    {
        $userManager = new UtilisateursManager;
        $userData = $userManager ->getUsers($_COOKIE['connection']);
        $isadmin = $userData['isadmin'];
       
        $data = [
            'admin'     =>$isadmin,
        ];
        $this->render('createTeams', $data);
    }

    
}
