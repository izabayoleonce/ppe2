<?php

namespace controller;

use model\ResultatsManager;
use model\Utilisateurs;
use model\UtilisateursManager;

class ResultatController extends Controller
{
    public function __construct()
    {
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
        
        $data=[];
        $this->render('matchForDate', $data);
    }
}
?>