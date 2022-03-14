<?php

namespace controller;

use model\Team;
use model\TeamManager;
use model\TeamsManager;

class TeamController extends Controller
{
    

    public function __construct()
    {        
        $this->userManager = new TeamsManager();
        parent::__construct();


    }

    public function defaultAction()
    {
        $data = ['test' => 'marche'];
        $this->render('home', $data);
    }
}