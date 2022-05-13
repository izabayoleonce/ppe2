<?php

namespace controller;

use model\ResultatsManager;
use model\Utilisateurs;
use model\UtilisateursManager;

class UtilisateurController extends Controller
{

    private $_list;

    protected $userManager;


    public function __construct()
    {   
        $this->ResultatManager = new ResultatsManager(); 
        $this->userManager = new UtilisateursManager();
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

    public function connectAction()
    {
        if(isset($_COOKIE['connection'])){
            $userManager = new UtilisateursManager();
            $userData=[];
            $userData = $userManager ->getUsers($_COOKIE['connection']);
            $conteur = $userManager ->getUsersNb($_COOKIE['connection']);
            $isadmin = $userData['isadmin'];
            #actiive: c.-à-d que l'utilisateur a été activer comme contributeur
            $re = $userData['active'];

            if($conteur == 1 ) {
                if ($isadmin == 1){
                    $_SESSION['login'] = $userData['login'];
                    $_SESSION['password'] = $userData['password'];
                
                    $data=[
                        'login'     =>$_SESSION['login'],
                        'password'  =>$_SESSION['password'],
                        'admin'     =>$isadmin,
                    ];
                
                $this->render('adminhome', $data);
                } 
                elseif($isadmin == 0 && $re == 1 ){

                    $tabscore = $this->ResultatManager->getAllResultatsDay();
                    $_SESSION['login']    = $userData['login'];
                    $_SESSION['password'] = $userData['password'];
                    $message = "Vous n'étes pas encors administrateur";
                
                    $data=[
                        'login'         =>$_SESSION['login'],
                        'password'      =>$_SESSION['password'],
                        'scores'        =>$tabscore,
                        'message'       =>$message,
                    ];
                    $this->render('adminhome', $data);
                }
                
                elseif($isadmin == 0 && $re == 0)
                {
                    $_SESSION['login'] = $userData['login'];
                    $_SESSION['password'] = $userData['password'];
                
                    $data=[
                        'login'=>$_SESSION['login'],
                        'password'=>$_SESSION['password'],
                    ];
                    $this->render('nActive', $data);
                }  
            }
        }
        else{
            $data=[];
            $this->render("connection", $data);
        }
    }
    public function connectionValidAction()
    {
        if(isset($_POST['login']) && !empty($_POST['login']) && isset($_POST['password']) && !empty($_POST['password'])) {
            $userManager = new UtilisateursManager();
            $userData=[];
            $userData = $userManager ->getUsers($_POST['login']);
            $conteur = $userManager ->getUsersNb($_POST['login']);
            $verifepassword = sodium_crypto_pwhash_str_verify($userData['password'], $_POST['password'] );
            $isadmin = $userData['isadmin'];
            $re = $userData['active'];
            setcookie("connection", $_POST['login'], time()+(60*60*24));
            // var_dump($userData);echo '</br>';echo '</br>';
            // var_dump($conteur);echo '</br>';echo '</br>';
            // var_dump($verifepassword);echo '</br>';echo '</br>';
            // var_dump($isadmin);echo '</br>';echo '</br>';
            // var_dump($re);echo '</br>';echo '</br>';
            // die;

           
            if($conteur == 1 && $verifepassword == TRUE) {
                if ($isadmin == 1){
                    $_SESSION['login'] = $userData['login'];
                    $_SESSION['password'] = $userData['password'];
                
                    $data=[
                        'login'=>$_SESSION['login'],
                        'password'=>$_SESSION['password'],
                        'admin'     =>$isadmin,

                    ];
                
                $this->render('adminhome', $data);
                } 
                elseif($isadmin == 0 && $re == 1 ){

                    $tabscore = $this->ResultatManager->getAllResultatsDay();
                    $_SESSION['login']    = $userData['login'];
                    $_SESSION['password'] = $userData['password'];
                    $message = "Vous n'étes pas encors administrateur";
                
                    $data=[
                        'login'         =>$_SESSION['login'],
                        'password'      =>$_SESSION['password'],
                        'scores'        =>$tabscore,
                        'message'       =>$message,
                    ];
                    $this->render('adminhome', $data);
                }
                
                elseif($isadmin == 0 && $re == 0)
                {
                    $_SESSION['login'] = $userData['login'];
                    $_SESSION['password'] = $userData['password'];
                
                    $data=[
                        'login'=>$_SESSION['login'],
                        'password'=>$_SESSION['password'],
                    ];
                    $this->render('nActive', $data);
                }  
            }
            else{
                $data = ['test' => 'marche'];
                $this->render('erreur', $data);
            }
        }
        else{        
            $ResultatManager = new ResultatsManager;
            $tabscore = $ResultatManager->getAllResultatsDay();
                
            $data=[
                'scores'        =>$tabscore,
            ];
            $this->render('home', $data);
        }
    }

    public function createAction()
    {
        $data = [];
        $this->render('createUser', $data);
    }

    public function createValidAction()
    {
        if (isset($_POST['valider'])){
            if (isset($_POST['observation']) && !empty($_POST['observation'])
            && isset($_POST['nom']) && !empty($_POST['nom']) 
            && isset($_POST['prenom']) && !empty($_POST['prenom']) 
            && isset($_POST['mail']) && !empty($_POST['mail'])
            && isset($_POST['login']) && !empty($_POST['login']) 
            && isset($_POST['password']) && !empty($_POST['password'])
            && isset($_POST['passwordVerifi']) && !empty($_POST['passwordVerifi']))
            {
                if ($_POST['password']  =  $_POST['passwordVerifi']){
                    $getpassword=sodium_crypto_pwhash_str($_POST['password'], SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE, SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE);
                    $Data=[
                        'nom'               =>$_POST['nom'],
                        'prenom'            =>$_POST['prenom'],
                        'login'             =>$_POST['login'],
                        'email'             =>$_POST['mail'],
                        'observation'       =>$_POST['observation'], 
                        'password'          =>$getpassword,
                    ];
                    var_dump($Data);
                    $Users = new Utilisateurs($Data);
                    var_dump($Users);
                    $userManager = new UtilisateursManager();
                    $userData = $userManager ->getUsers($_POST['login']);
                    $conteur = $userManager -> getUsersNb($_POST['login']);
                    $verifepassword = sodium_crypto_pwhash_str_verify($userData['password'], $_POST['password'] );
                
                
                    if($verifepassword == FALSE)
                    {
                        $this->userManager->add($Users);
                        
                        
                        $_SESSION['login'] = $_POST['login'];
                        $_SESSION['password'] = $verifepassword;
                        $data = [
                            'login'=>$_SESSION['login'],
                            'password'=>$_SESSION['password'],
                        ];
                        $this->render('nActive', $data);   
                    }
                    else{
                        $data = [];
                        $this->render('userExiste', $data);
                    }
                }
                else{
                    $message = "le mot de passe n'est pas parreil dans les deux champs de mot de passe et repeter le mot de passe";
                    $data = [
                        'message'   => $message,
                    ];
                    $this->render('createUser', $data);
                }   
            }
        }
        else{
            $message = "Veillez remplir tout les champs";
            $data = [
                'msg'   => $message,
            ];
            $this->render('createUser', $data);
        }

    }

    public function listUsersAction()
    {
        $listUser = $this->userManager->getAllUser();
        $userManager = new UtilisateursManager;
        $userData = $userManager ->getUsers($_COOKIE['connection']);
        $isadmin = $userData['isadmin'];
       
        $data = [
            'admin'     =>$isadmin,
            'listUsers'      => $listUser,
        ];
        $this->render('listUser', $data );
    }

    public function editAction()
    {
        if(isset($_REQUEST['id'])) {
            $Users = $this->UtilisateursManager->get((int)$_REQUEST['id']);
        }
    }


    public function deleteAction()
    {
        if(isset( $_REQUEST['id'] ) ){
            $userData = $this->userManager->get((int)$_REQUEST['id']);
             if ($this->userManager->delete( $userData)) {
                 $message = "L'utilisateur <b>" . $userData->getLogin() . '</b> a été supprimé.';
             }else{
                    $message = "l'utilisateur a bien été remplacer";
             }
             $listUser = $this->userManager->getAllUser();
             $data = [
                 'listUsers'      => $listUser,
                 'message'           => $message,
             ];
             $this->render('listUser', $data );
        }
    }

    public function updateAction()
    {
        if(isset( $_REQUEST['id'] ) ){
            $userData = $this->userManager->get((int)$_REQUEST['id']);
             if ($this->userManager->update($userData)) {
                 $message = "L'utilisateur <b>" . $userData->getLogin() . '</b> a été activer.';
             }else{
                    $message = "l'utilisateur a bien été remplacer";
             }
             $listUser = $this->userManager->getAllUser();
             $userManager = new UtilisateursManager;
             $userData = $userManager ->getUsers($_COOKIE['connection']);
             $isadmin = $userData['isadmin'];
            
             $data = [
                 'admin'            =>$isadmin,
                 'listUsers'        => $listUser,
                 'message'          => $message,
             ];
             $this->render('listUser', $data );
        }
    }
    public function updateNonAction()
    {
        if(isset( $_REQUEST['id'] ) ){
            $userData = $this->userManager->get((int)$_REQUEST['id']);
             if ($this->userManager->updateNA($userData)) {
                 $message = "L'utilisateur <b>" . $userData->getLogin() . '</b> a été desactiver.';
             }else{
                    $message = "l'utilisateur a bien été remplacer";
             }
             $listUser = $this->userManager->getAllUser();
             $userManager = new UtilisateursManager;
             $userData = $userManager ->getUsers($_COOKIE['connection']);
             $isadmin = $userData['isadmin'];
            
             $data = [
                 'admin'            =>$isadmin,
                 'listUsers'        => $listUser,
                 'message'          => $message,
             ];
             $this->render('listUser', $data );
        }
    }

    /**
     * @Route("/logout",name="logout")
     */
    public function logout()
    {
        unset($_SESSION);
    }
}
?>
