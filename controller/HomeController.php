<?php

namespace controller;

use model\Resultats;
use model\ResultatsManager;


class HomeController extends Controller
{


    public function __construct()
    {
        $this->ResultatManager = new ResultatsManager(); 
        parent::__construct();
        //$this->defaultAction();
        
    }


    public function defaultAction()
    {
        $ResultatManager = new ResultatsManager;
        $tabscore = $ResultatManager->getAllResultats();
                
            $data=[
                'scores'        =>$tabscore,
                    ];
         $this->render('home', $data);
    }




}
