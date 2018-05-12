<?php
class Session {

    public static function exists($name) {
        return (isset($_SESSION[$name])) ? true : false;
    }

    // return value(token) of the session
    public static function put($name, $value) {
        return $_SESSION[$name] = $value;
    }

    // ability to get token name
    public static function get($name) {
        return $_SESSION[$name];
    }

    // delete session, if self (cause static) exists, otherwise do nothing
    public static function delete($name) {

        if (self::exists($name)) {
            unset($_SESSION[$name]);
        }
    }

    // creating name of the flash data and message' give ability to show it on screen and delete after refreshing page
    // for example: name = 'success', message = 'You have been registered successfully!' , this message appear a once
    // call flash by session name like flash('success');
    public static function flash($name, $message = '') {

        // if session does exists set the value to return, otherwise set a data (session: name, value)
        if (self::exists($name)) {
            $session = self::get($name);
            self::delete($name);
            return $session;
        } else {
            self::put($name, $message);
        }
    }


}