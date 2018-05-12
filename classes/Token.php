<?php
class Token {
    // For security, were methods intended to defense from attacking/injection!
    // generate unique token to the user every time page load
    public static function generate() {
        return Session::put(Config::get('session/token_name'), md5(uniqid()));
    }

    // check status of session and token, if token equals to session
    public static function check($token) {
        $tokenName = Config::get('session/token_name');

        // primary condition check token(if exists) been set and token supplied matches to the token name
        if(Session::exists($tokenName) && $token === Session::get($tokenName)) {
            Session::delete($tokenName);
            return true;
        }

        return false;
    }


}