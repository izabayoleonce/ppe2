<?php

namespace model;

use model\Utilisateurs;

use PDO;

class UtilisateursManager extends Manager
{   public $_userData,
           $_statut;
    public function add(Utilisateurs $user)
    {
        $q=$this->manager
             ->db
             ->prepare('INSERT INTO utilisateurs(nom,prenom,login,password,isadmin,observation,active) 
                        VALUES(:nom,:prenom,:login,:password,:isadmin,:observation,:active)');
             $user=$q->excute([
                 'id'             => $user->getId(),
                 ':nom'           => $user->getNom(),
                 ':prenom'        => $user->getPrenom(),
                 ':login'         => $user->getLogin(),
                 ':password'      => $user->getPassword(),
                 ':isadmin'       => $user->getIsadmin(),
                 ':observation'   => $user->getObservation(),
                 ':active'        => $user->getActive()
             ]);

             $user->hydrate([
                 'id'=>$this->manager
                            ->db
                            ->lastInsertId()
             ]);
    }

    public function getUsers($login)
    {
        $q=$this->manager
                ->db
                ->prepare('SELECT * FROM utilisateurs WHERE login=:login');
        $q->bindValue("login",$login, PDO::PARAM_STR_CHAR);
        $q->execute([
            'login'     =>$login
        ]);
        
        $userData = $q->fetch(PDO::FETCH_ASSOC);
        return $userData;
        
    }

    public function getUsersNb($login){
        $re=$this->manager
                  ->db
                  ->prepare('SELECT * FROM utilisateurs WHERE login=:login');
        $re->bindValue("login",$login, PDO::PARAM_STR_CHAR);
        $re->execute([
            'login'     =>$login
        ]);
        $conteur = $re->rowCount();
        return $conteur;
    }

    public function getAllUser()
    {
        
        $q = $this->manager
                  ->db
                  ->prepare( 'SELECT * FROM utilisateurs' );
        $q->execute();
        $listRes = $q->fetchAll(PDO::FETCH_ASSOC);
 
        return $listRes;
    }

    public function update(Utilisateurs $user)
    {
      $q = $this->manager
                  ->db
                  ->prepare('UPDATE utilisateurs SET
                        active = 1
                        WHERE id = :id');
      $q->bindValue('1', $user->getActive(), PDO::PARAM_INT);
      return $q->execute();
    }
    public function delete(Utilisateurs $user)
  {
    return $this->manager
                ->db
                ->exec('DELETE FROM utilisateurs WHERE id = :id'.$user->getId());
  }


  public function get($info)
  {
    if (is_int($info))
    {
    /* $q = $this->_db->query('SELECT id, nom, degats FROM personnages WHERE id = '.$info);*/
      $q = $this->manager
                ->db
                ->prepare('SELECT id, login, password FROM utilisateurs WHERE id = :id' );
       $q->execute([':id' => $info]);
       $donnees = $q->fetch(PDO::FETCH_ASSOC);
      return new Utilisateurs($donnees);
    }
    else
    {}
  }
  
}
?>
