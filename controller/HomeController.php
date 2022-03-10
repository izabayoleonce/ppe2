<?php

namespace controller;


class HomeController extends Controller
{


    public function __construct()
    {
        parent::__construct();
        //$this->defaultAction();
    }


    public function defaultAction()
    {

         $data = ['test' => 'marche'];
         $this->render('home', $data);
    }




}
