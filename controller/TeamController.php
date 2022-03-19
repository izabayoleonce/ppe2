<?php

namespace controller;
use model\TeamsManager;

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
}