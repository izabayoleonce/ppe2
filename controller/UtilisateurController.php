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
        $data = ['test' => 'marche'];
        $this->render('home', $data);
    }

    public function connectAction()
    {
        if (isset($_POST['login']) && !empty($_POST['login']) && isset($_POST['password']) && !empty($_POST['password'])) {
            $userManager = new UtilisateursManager();
            $userData=[];
            $userData = $userManager ->getUsers($_POST['login']);
            $conteur = $userManager ->getUsersNb($_POST['login']);
            $verifepassword = sodium_crypto_pwhash_str_verify($userData['password'], $_POST['password'] );
            $isadmin = $userData['isadmin'];
            $re = $userData['actif'];
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
                    ];
                
                $this->render('adminHome', $data);
                } 
                elseif($isadmin == 0 && $re == 1 ){

                    $tabscore = $this->ResultatManager->getAllResultats();
                    $_SESSION['login']    = $userData['login'];
                    $_SESSION['password'] = $userData['password'];
                
                    $data=[
                        'login'         =>$_SESSION['login'],
                        'password'      =>$_SESSION['password'],
                        'scores'        =>$tabscore,
                    ];
                    $this->render('userHome', $data);
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
            $data = ['test' => 'marche'];
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
            if (isset($_POST['nom']) && !empty($_POST['nom']) 
            && isset($_POST['prenom']) && !empty($_POST['prenom']) 
            && isset($_POST['login']) && !empty($_POST['login']) 
            && isset($_POST['password']) && !empty($_POST['password']))
            {
                $getpassword=sodium_crypto_pwhash_str($_POST['password'], SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE, SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE);
                $Data=[
                    'nom'       =>$_POST['nom'],
                    'prenom'    =>$_POST['prenom'],
                    'login'     =>$_POST['login'], 
                    'password'  =>$getpassword];
                $Users = new Utilisateurs($Data);
                $userManager = new UtilisateursManager();
                $userData = $userManager ->getUsers($_POST['login']);
                $conteur = $userManager -> getUsersNb($_POST['login']);
                $verifepassword = sodium_crypto_pwhash_str_verify($userData['password'], $_POST['password'] );
             
            
                if($verifepassword == FALSE)
                {
                    $this->userManager->add($Users);
                    
                    
                    $_SESSION['login'] = $Users['login'];
                    $_SESSION['password'] = $verifepassword;
                    $data = [
                        'login'=>$_SESSION['login'],
                        'password'=>$_SESSION['password'],
                    ];
                    $this->render('nActive', $data);  
                }
                else{
                    die;
                    $data = [];
                    $this->render('userExiste', $data);
                }
                
                
            }
        }
        else{
            $data = [];
            $this->render('createUser', $data);
        }

    }

    public function listUsersAction(){
        $listUser = $this->userManager->getAllUser();

        $data = [
            'listUsers'      => $listUser
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
             $this->_listUser = $this->userManager->getAllUser();
             $data = [
                 'listusers'      => $this->_listUser,
                 'message'           => $message,
             ];
             $this->render('listUser', $data );
        }
    }

    public function update()
    {
        
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
