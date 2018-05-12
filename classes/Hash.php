<?php
class Hash {

    // making hash, if passwords are the same created hash will be different
    public static function make($string, $salt='') {
        return hash('sha256', $string.$salt);
    }

    // making always random salt, added to the and of password, to improve the security
    public static function salt($length) {
        //return mcrypt_create_iv($length);
        return openssl_random_pseudo_bytes($length);
    }

    // making unique hash for each one
    public static function  unique() {
        return self::make(uniqid());
    }
}