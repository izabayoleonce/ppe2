<?php
//  echo 'test' .' '. 'test'.' '. sodium_crypto_pwhash_str('test', SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE, SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE).'</br>';
//  echo 'jahow'.' '. '0000'.'  '. sodium_crypto_pwhash_str('2000', SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE, SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE).'</br>';
//  echo 'caxag'.' '. '1234'.'  '. sodium_crypto_pwhash_str('1234',SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE, SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE).'</br>';
//  echo 'john' .' '. '0000'.'  '. sodium_crypto_pwhash_str('0000', SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE, SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE).'</br>';
//  echo 'Maikay'.' '. '2512'.'  '. sodium_crypto_pwhash_str('2512', SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE, SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE).'</br>';
//  echo 'james'.' '. '5000'.'  '. sodium_crypto_pwhash_str('5000', SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE, SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE).'</br>';
//  echo 'gazo'.' '. '8520'.'  '. sodium_crypto_pwhash_str('8520', SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE, SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE).'</br>';
//  echo 'chira'.' '. '0203'.'  '. sodium_crypto_pwhash_str('0203', SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE, SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE).'</br>';
//  echo 'brent'.' '. '2022'.'  '. sodium_crypto_pwhash_str('2022', SODIUM_CRYPTO_PWHASH_OPSLIMIT_INTERACTIVE, SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE).'</br>';
// die;

// setcookie("connction", 'Leonce', time()+(60*60*24));
// setcookie("admin", 'izabayo', time()+(60*60*24));
session_start(); // On appelle session_start() APRÈS avoir enregistré l'autoload.
require 'autoload.php';
require_once 'vendor/autoload.php';

//uniquement en debbugging
ini_set( 'display_errors', 1 );
error_reporting( E_ALL );




//use combats\model\Personnage;
//use combats\model\PersonnagesManager;

/*
 $loader = new \Twig\Loader\FilesystemLoader('view');
 $twig = new \Twig\Environment($loader);

 $monTableau = ['nom=>Frati, prenom=>Fred'];
 $data=[
   'title' => 'Mon super blog',
   'monTableau' =>$monTableau
 ];
 echo $twig->render('test.twig', $data);
 die;
 */



$controllerPath = 'controller';

if( isset( $_GET['controller'] ) ) {
  $controllerName = ucfirst($_GET['controller']);
} else {
  $controllerName = 'Home';
}
$fileName = 'controller/' . $controllerName . 'Controller.php';
$className = $controllerPath . '\\' . $controllerName . 'Controller';



if( file_exists( $fileName) ) {
  if( class_exists( $className ) ) {
    $controller = new $className();
  } else {
    exit( "Error : Class not found!" );
  }
} else {
  exit( "Error 404 : not found!" );
}








// if (isset($_POST['creer']) && isset($_POST['nom'])) // Si on a voulu créer un personnage.
// {
//   $perso = new Personnage(['nom' => $_POST['nom']]); // On crée un nouveau personnage.

//   if (!$perso->nomValide())
//   {
//     $message = 'Le nom choisi est invalide.';
//     unset($perso);
//   }
//   elseif ($manager->exists($perso->getNom()))
//   {
//     $message = 'Le nom du personnage est déjà pris.';
//     unset($perso);
//   }
//   else
//   {
//     $manager->add($perso);
//   }
// }

// elseif (isset($_GET['utiliser']) && isset($_GET['nom'])) // Si on a voulu utiliser un personnage.
// {
//   if ($manager->exists((int)$_GET['utiliser'])) // Si celui-ci existe.
//   {
//     $perso = $manager->get((int)$_GET['utiliser']);
//   }
//   else
//   {
//     $message = 'Ce personnage n\'existe pas !'; // S'il n'existe pas, on affichera ce message.
//   }
// }

// elseif (isset($_GET['frapper'])) // Si on a cliqué sur un personnage pour le frapper.
// {
//   if (!isset($perso))
//   {
//     $message = 'Merci de créer un personnage ou de vous identifier.';
//   }
  
//   else
//   {
//     if (!$manager->exists((int) $_GET['frapper']))
//     {
//       $message = 'Le personnage que vous voulez frapper n\'existe pas !';
//     }
    
//     else
//     {
//       $persoAFrapper = $manager->get((int) $_GET['frapper']);
      
//       $retour = $perso->frapper($persoAFrapper); // On stocke dans $retour les éventuelles erreurs ou messages que renvoie la méthode frapper.
      
//       switch ($retour)
//       {
//         case Personnage::CEST_MOI :
//           $message = 'Mais... pourquoi voulez-vous vous frapper ???';
//           break;
        
//         case Personnage::PERSONNAGE_FRAPPE :
//           $message = 'Le personnage a bien été frappé !';

//           $perso->gagnerExperience();

//           $manager->update($perso);
//           $manager->update($persoAFrapper);
          
//           break;
        
//         case Personnage::PERSONNAGE_TUE :
//           $message = 'Vous avez tué ce personnage !';
          
//           $manager->update($perso);
//           $manager->delete($persoAFrapper);
          
//           break;
//       }
// }
  // }
// }


?>






