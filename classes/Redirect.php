<?php
class Redirect {
    // replace 'header' function and some extra

    public static function to($location = null) {
        // check if location is been find
        if ($location) {
            // if location is number like 404 redirect to 404.php, all number errors (pages) will be here
            if (is_numeric($location)) {
                switch ($location) {
                    case 404:
                        header('HTTP/1.0 404 Not Found');
                        include 'includes/errors/404.php';
                        exit();
                    break;
                }
            }
            header('Location: ' . $location);
            exit();
        }
    }

}