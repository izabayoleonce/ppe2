<?php
namespace model;

use classes\dbConnect;

class Manager
{
    private $_dsn = 'mysql:host=localhost;dbname=ppe2_leonce';
    private $_login = 'leonce';
    private $_password = 'z3nwbHdJy';

    /**
     * Attribut contenant l'instance PDO
     */
    protected $manager;


    public function __construct()
    {
        $this->manager = dbConnect::getDb($this->_dsn, $this->_login, $this->_password );
    }

}
