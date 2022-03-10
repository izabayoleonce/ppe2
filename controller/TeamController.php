<?php

namespace controller;

use model\Team;
use model\TeamManager;
use ppe2\model\TeamsManager;

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