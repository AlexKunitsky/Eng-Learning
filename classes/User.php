<?php
class User {

    private $_db;

    // constructor for user, get instance of db
    public function __construct($user = null) {
        $this->_db = DB::getInstance();
    }

    // insert new user to DB
    public function create($fields = array()){
        if(!$this->_db->insert('users', $fields)){
            throw new Exception('There was a problem creating an account');
        }
    }
}