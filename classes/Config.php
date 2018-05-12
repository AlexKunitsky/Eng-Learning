<?php

class Config {

    public static function get($path = null) {
        if (isset($path)) {

            $config = $GLOBALS['config'];
            $path = explode('/',$path);

            // In this way we can get last value in GLOBALS, example:
            // array = 'config'[array] => 'mysql'[array] => 'host' => 'localhost'
            
            foreach ($path as $bit) {
                if (isset($config[$bit])) {
                    $config = $config[$bit];
                }
            }

            return $config;
        }

        return false;
    }


}