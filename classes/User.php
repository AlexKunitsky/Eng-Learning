<?php
class User {

    private $_db,
            $_data,
            $_sessionName;

    // constructor for user, get instance of db
    public function __construct($user = null) {

        $this->_db = DB::getInstance();
        $this->_sessionName = Config::get('session/session_name');
    }

    // insert new user to DB
    public function create($fields = array()){
        if(!$this->_db->insert('users', $fields)){
            // if it (create user) doesn't work throw exception
            throw new Exception('There was a problem creating an account.');
        }
    }

    public function find($user = null) {
        // check if username is just numbers, set as id or username. Grab data from DB to compare with input
        if ($user) {
            $field = (is_numeric($user)) ? 'id' : 'username';
            $data = $this->_db->get('users', array($field, '=', $user));

            // return true and store just first result, _data will contains all data of the user
            if ($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    // check if values supplied exists in DB
    public function login($username = null, $password = null) {
        $user = $this->find($username);

        if ($user) {
            // checking password, need to break cause of hash and salt (reverse breaking)
            // after validation setting session, name and id of the user, return true to signalize user logged in
            if ($this->data()->password === Hash::make($password, $this->data()->salt)) {
                Session::put($this->_sessionName, $this->data()->id);
                return true;
            }
        }

        return false;
    }

    private function data() {
        return $this->_data;
    }
}