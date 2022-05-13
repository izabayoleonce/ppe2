<?php

namespace controller;

use model\Resultats;
use model\ResultatsManager;
use model\TeamsManager;
use model\Utilisateurs;
use model\UtilisateursManager;

class ResultatController extends Controller
{
    public function __construct()
    {
        $this->ResultatManager = new ResultatsManager();  
        parent::__construct();
    }

    public function defaultAction()
    {
        $ResultatManager = new ResultatsManager;
        $tabscore = $ResultatManager->getAllResultatsDay();
                
            $data=[
                'scores'        =>$tabscore,
                    ];
         $this->render('home', $data);
    }

    public function resultatForDaysAction()
    {
        $ResultsJour = new ResultatsManager; 
        $liste = $ResultsJour->getResultatForDay();
        $data=[
            'liste'             =>$liste,
        ];
        $this->render('matchForDate', $data);
    }
    public function ScoresAction()
    {
        $userManager = new UtilisateursManager;
        $userData = $userManager ->getUsers($_COOKIE['connection']);
        $tabscore = $this->ResultatManager->getAllResultatsDay();
        $isadmin = $userData['isadmin'];
                
            $data=[
                'scores'        =>$tabscore,
                'user'          =>$userData,
                'admin'     =>$isadmin,
            ];
         $this->render('insertScore', $data);
    }

    public function updateScoresAction()
    {
        
      if ($_POST["idScores"]) {
          $dataResult=[
              'id'              =>(int)$_POST['idScores'],
              'id_user'         =>(int)$_POST['idUser'],
              'scoreE1'         =>(int)$_POST['scoreE1'],
              'scoreE2'         =>(int)$_POST['scoreE2'],
          ];
          $Results= new Resultats($dataResult);
         // var_dump($Results);die;
          $userManager = new UtilisateursManager();
          $userData = $userManager->getUsers($_COOKIE['connection']);
          $update = $this->ResultatManager->updateScore($Results);
          $tabscore = $this->ResultatManager->getAllResultatsDay();
                
            $data=[
                'scores'        =>$tabscore,
                'user'          =>$userData,
            ];
         $this->render('insertScore', $data);

          
          
      }
    }

    public function createResultatAction()
    {
        $teamsManager = new TeamsManager;
        $lstTeam = $teamsManager->getAllTeams();
       $userManager = new UtilisateursManager;
       $userData = $userManager ->getUsers($_COOKIE['connection']);
       $isadmin = $userData['isadmin'];
      
       $data = [
            'user'          =>$userData,
            'admin'         =>$isadmin,
            'liste'        =>$lstTeam,
        ];

        $this->render('createScore',$data);
    }

    public function createValidateResultatAction()
    {
        
        if(isset($_POST['iduser']) && isset($_POST['scoreE1']) && isset($_POST['scoreE2']) && isset($_POST['idE1']) && isset($_POST['idE2']) && isset($_POST['date']) && isset($_POST['aller']) || empty($_POST['aller']) && isset($_POST['retour']) || empty($_POST['retour'])
           && !empty($_POST['iduser']) && !empty($_POST['scoreE1']) && !empty($_POST['scoreE2']) && !empty($_POST['idE1']) && !empty($_POST['idE2']) && !empty($_POST['date']) && !empty($_POST['aller']) && !empty($_POST['retour']))
           {
                if(empty($_POST['aller']) || empty($_POST['retour']))
                {
                    $_POST['aller'] = 0;
                    $_POST['retour'] = 0;  
                }
               if (isset($_POST['aller'] )|| isset($_POST['retour'])) {
                    if(empty($_POST['aller']) || empty($_POST['retour']))
                    {
                    $_POST['aller'] = 0;
                    $_POST['retour'] = 0;  
                    }
    
                    if ($_POST['scoreE1'] > $_POST['scoreE2']) 
                    {
                        $dataResult=[
                            'id_user'         =>(int)$_POST['iduser'],
                            'scoreE1'         =>(int)$_POST['scoreE1'],
                            'scoreE2'         =>(int)$_POST['scoreE2'],
                            'id_team1'        =>(int)$_POST['idE1'],
                            'id_team2'        =>(int)$_POST['idE2'],
                            'pointE1'         =>3,
                            'pointE2'         =>1,
                            'date'            =>$_POST['date'],
                            'aller'           =>$_POST['aller'],
                            'retour'          =>$_POST['retour'],
                        ];
                    }elseif($_POST['scoreE1'] < $_POST['scoreE2'])
                    {
                        $dataResult=[
                            'id_user'         =>(int)$_POST['iduser'],
                            'scoreE1'         =>(int)$_POST['scoreE1'],
                            'scoreE2'         =>(int)$_POST['scoreE2'],
                            'id_team1'        =>(int)$_POST['idE1'],
                            'id_team2'        =>(int)$_POST['idE2'],
                            'pointE1'         =>1,
                            'pointE2'         =>3,
                            'date'            =>$_POST['date'],
                            'aller'           =>$_POST['aller'],
                            'retour'          =>$_POST['retour'],
                        ];
                    }
    
                    $Results= new Resultats($dataResult);
                    var_dump($Results);
                    $insert = $this->ResultatManager->add($Results);
                    if ($insert = 1) {
                        echo "reuissi";
                    }
                    else{
                        echo "échouer";
                    }
               }else{
                    $teamsManager = new TeamsManager;
                    $lstTeam = $teamsManager->getAllTeams();
                    $userManager = new UtilisateursManager;
                    $userData = $userManager ->getUsers($_COOKIE['connection']);
                    $isadmin = $userData['isadmin'];
                    $message = "Veuiller choisir si c'est aller ou le retour";
                    
                    $data = [
                        'user'          =>$userData,
                        'admin'         =>$isadmin,
                        'liste'         =>$lstTeam,
                        'msg'           =>$message,
                    ];
                
                    $this->render('createScore',$data);
               }
               
           }

    }
}
?>
